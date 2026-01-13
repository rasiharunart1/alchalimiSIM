<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pembayaran::with(['santri', 'recordedBy'])->latest();

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('santri', function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        if ($request->has('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        $pembayarans = $query->paginate(10);

        return view('admin.pembayaran.index', compact('pembayarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $santris = Santri::aktif()->select('id', 'nama_lengkap', 'nis')->get();
        
        $selectedSantri = null;
        $unpaidBills = collect([]);
        
        if ($request->has('santri_id')) {
            $selectedSantri = Santri::find($request->santri_id);
            if ($selectedSantri) {
                $unpaidBills = \App\Models\Tagihan::where('santri_id', $selectedSantri->id)
                    ->where('status', 'belum_lunas')
                    ->latest()
                    ->get();
            }
        }
        
        return view('pengurus.pembayaran.create', compact('santris', 'selectedSantri', 'unpaidBills'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'tagihan_id' => 'nullable|exists:tagihan,id',
            'jenis' => 'required|in:dpp,spp,seragam,lainnya',
            'jumlah' => 'required|numeric|min:0',
            'tanggal_bayar' => 'required|date',
            'metode' => 'required|in:tunai,transfer',
            'keterangan' => 'nullable|string',
            'bukti_transfer' => 'nullable|image|max:2048'
        ]);

        $validated['recorded_by'] = Auth::id();

        if ($request->hasFile('bukti_transfer')) {
            $validated['bukti_transfer'] = $request->file('bukti_transfer')->store('bukti-transfer', 'public');
        }

        Pembayaran::create($validated);

        // If tagihan IS selected, mark it as LUNAS
        if ($request->filled('tagihan_id')) {
            \App\Models\Tagihan::where('id', $request->tagihan_id)->update(['status' => 'lunas']);
        }

        return redirect()->route('admin.pembayaran.index')->with('success', 'Pembayaran berhasil dicatat');
    }

    /**
     * Store payment confirmation from Wali
     */
    public function storeWali(Request $request)
    {
        $validated = $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'tagihan_id' => 'nullable|exists:tagihan,id',
            'jenis' => 'required|in:dpp,spp,seragam,lainnya',
            'jumlah' => 'required|numeric|min:0',
            'metode' => 'required|in:transfer',
            'keterangan' => 'nullable|string',
            'bukti_transfer' => 'required|image|max:2048'
        ]);

        $validated['tanggal_bayar'] = now();
        $validated['status'] = 'pending';

        if ($request->hasFile('bukti_transfer')) {
            $validated['bukti_transfer'] = $request->file('bukti_transfer')->store('bukti-transfer', 'public');
        }

        Pembayaran::create($validated);

        return redirect()->route('wali.pembayaran')->with('success', 'Konfirmasi pembayaran berhasil dikirim. Menunggu verifikasi bendahara.');
    }

    /**
     * List pending payments for verification (Pengurus)
     */
    public function verifikasiIndex()
    {
        $pembayarans = Pembayaran::where('status', 'pending')
            ->with('santri')
            ->latest()
            ->paginate(15);
            
        return view('pengurus.pembayaran.verifikasi', compact('pembayarans'));
    }

    /**
     * Action to confirm or reject payment
     */
    public function verifikasiAction(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'action' => 'required|in:konfirmasi,ditolak',
            'keterangan_admin' => 'nullable|string'
        ]);

        if ($request->action === 'konfirmasi') {
            $pembayaran->update([
                'status' => 'konfirmasi',
                'recorded_by' => Auth::id()
            ]);

            if ($pembayaran->tagihan_id) {
                $pembayaran->tagihan->update(['status' => 'lunas']);
            }
            
            $msg = 'Pembayaran berhasil dikonfirmasi dan tagihan ditandai lunas.';
        } else {
            $pembayaran->update([
                'status' => 'ditolak',
                'keterangan' => $pembayaran->keterangan . "\n\nAlasan Penolakan: " . $request->keterangan_admin
            ]);

            if ($pembayaran->tagihan_id) {
                $pembayaran->tagihan->update(['status' => 'belum_lunas']);
            }

            $msg = 'Pembayaran ditolak.';
        }

        return redirect()->back()->with('success', $msg);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load(['santri', 'recordedBy']);
        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran $pembayaran)
    {
        // Optional: Allow editing if needed
        $santris = Santri::all();
        return view('admin.pembayaran.edit', compact('pembayaran', 'santris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        // Implementation similar to store
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();
        return redirect()->route('pembayaran.index')->with('success', 'Data pembayaran dihapus');
    }

    /**
     * Show payment history for Wali Santri
     */
    public function indexWali()
    {
        $user = Auth::user();
        // Get santri IDs belonging to this wali
        $santriIds = $user->santri->pluck('id');

        $pembayarans = Pembayaran::whereIn('santri_id', $santriIds)
            ->with('santri')
            ->latest()
            ->paginate(10);

        $unpaidBills = \App\Models\Tagihan::whereIn('santri_id', $santriIds)
            ->where('status', 'belum_lunas')
            ->with('santri')
            ->get();

        return view('wali.pembayaran.index', compact('pembayarans', 'unpaidBills'));
    }

    /**
     * Report view for Pengurus
     */
    public function laporan(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));

        // Statistics
        $pemasukan = Pembayaran::konfirmasi()
            ->whereBetween('tanggal_bayar', [$startDate, $endDate])
            ->sum('jumlah');

        $piutang = \App\Models\Tagihan::where('status', 'belum_lunas')->sum('jumlah');

        // Detailed Transactions
        $pembayarans = Pembayaran::konfirmasi()
            ->with(['santri', 'recordedBy'])
            ->whereBetween('tanggal_bayar', [$startDate, $endDate])
            ->latest()
            ->get();

        return view('pengurus.laporan', compact('pemasukan', 'piutang', 'pembayarans', 'startDate', 'endDate'));
    }
}
