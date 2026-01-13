<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SantriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Santri::with('wali');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $santris = $query->latest()->paginate(10);

        return view('admin.santri.index', compact('santris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $walis = User::where('role', 'wali_santri')->get();
        return view('admin.santri.create', compact('walis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nis' => 'required|string|unique:santri,nis',
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'wali_id' => 'required|exists:users,id',
            'tanggal_masuk' => 'required|date',
            'foto' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('santri-photos', 'public');
        }

        Santri::create($validated);

        return redirect()->route('santri.index')->with('success', 'Data santri berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Santri $santri)
    {
        $santri->load(['wali', 'hafalan', 'pembayaran']);
        return view('admin.santri.show', compact('santri'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Santri $santri)
    {
        $walis = User::where('role', 'wali_santri')->get();
        return view('admin.santri.edit', compact('santri', 'walis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Santri $santri)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nis' => 'required|string|unique:santri,nis,' . $santri->id,
            'jenis_kelamin' => 'required|in:L,P',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'wali_id' => 'required|exists:users,id',
            'status' => 'required|in:aktif,alumni,keluar',
            'foto' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            if ($santri->foto) {
                Storage::disk('public')->delete($santri->foto);
            }
            $validated['foto'] = $request->file('foto')->store('santri-photos', 'public');
        }

        $santri->update($validated);

        return redirect()->route('santri.index')->with('success', 'Data santri berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Santri $santri)
    {
        if ($santri->foto) {
            Storage::disk('public')->delete($santri->foto);
        }
        
        $santri->delete();

        return redirect()->route('santri.index')->with('success', 'Data santri berhasil dihapus');
    }

    public function importForm()
    {
        return view('admin.santri.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $data = array_map('str_getcsv', file($file->getRealPath()));
        
        // Remove header row if exists (assuming first row is header)
        // array_shift($data); 

        DB::beginTransaction();
        try {
            foreach ($data as $row) {
                // Assuming CSV format: Nama, NIS, JK, Tempat Lahir, Tgl Lahir (Y-m-d), Alamat, Wali Email
                if (count($row) < 7) continue;

                $wali = User::where('email', $row[6])->first();
                if (!$wali) continue; // Skip if wali not found

                Santri::create([
                    'nama_lengkap' => $row[0],
                    'nis' => $row[1],
                    'jenis_kelamin' => $row[2],
                    'tempat_lahir' => $row[3],
                    'tanggal_lahir' => $row[4],
                    'alamat' => $row[5],
                    'wali_id' => $wali->id,
                    'tanggal_masuk' => now(),
                    'status' => 'aktif'
                ]);
            }
            DB::commit();
            return redirect()->route('santri.index')->with('success', 'Import data santri berhasil');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }


    /**
     * Mark santri as graduated (Khatam).
     */
    public function graduate(Request $request, Santri $santri)
    {
        $santri->update([
            'status' => 'alumni',
            'tahun_lulus' => $request->tahun_lulus ?? date('Y'),
        ]);

        return back()->with('success', 'Santri berhasil dinyatakan Lulus / Khatam.');
    }
}
