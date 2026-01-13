<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Santri;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tagihan::with('santri')->latest();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('role_search')) {
             $search = $request->role_search;
             $query->whereHas('santri', function($q) use ($search) {
                 $q->where('nama_lengkap', 'like', "%{$search}%")
                   ->orWhere('nis', 'like', "%{$search}%");
             });
        }
        
        $tagihans = $query->paginate(15);
        $totalBelumLunas = Tagihan::where('status', 'belum_lunas')->sum('jumlah');

        return view('pengurus.tagihan.index', compact('tagihans', 'totalBelumLunas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $santris = Santri::aktif()->select('id', 'nama_lengkap', 'nis')->get();
        return view('pengurus.tagihan.create', compact('santris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis' => 'required|in:spp,dpp,seragam,lainnya',
            'bulan' => 'required', // YYYY-MM
            'jumlah' => 'required|numeric|min:0',
            'target' => 'required|in:individual,all',
            'santri_id' => 'required_if:target,individual',
        ]);

        if ($request->target == 'all') {
            $santris = Santri::aktif()->get();
            $count = 0;
            foreach ($santris as $santri) {
                // Check duplicate check for SPP only
                if ($request->jenis == 'spp') {
                    $exists = Tagihan::where('santri_id', $santri->id)
                        ->where('jenis', 'spp')
                        ->where('bulan', $request->bulan)
                        ->exists();
                    if ($exists) continue;
                }

                Tagihan::create([
                    'santri_id' => $santri->id,
                    'jenis' => $request->jenis,
                    'bulan' => $request->bulan, // YYYY-MM
                    'jumlah' => $request->jumlah,
                    'status' => 'belum_lunas',
                ]);
                $count++;
            }
            return redirect()->route('tagihan.index')->with('success', "$count Tagihan massal berhasil dibuat untuk periode " . $request->bulan);

        } else {
             // Individual
             // Check duplicat
             if ($request->jenis == 'spp') {
                 $exists = Tagihan::where('santri_id', $request->santri_id)
                     ->where('jenis', 'spp')
                     ->where('bulan', $request->bulan)
                     ->exists();
                 if ($exists) {
                     return back()->with('error', 'Tagihan SPP untuk santri ini pada bulan tersebut sudah ada.');
                 }
             }

             Tagihan::create([
                 'santri_id' => $request->santri_id,
                 'jenis' => $request->jenis,
                 'bulan' => $request->bulan,
                 'jumlah' => $request->jumlah,
                 'status' => 'belum_lunas',
             ]);
             
             return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil dibuat.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tagihan $tagihan)
    {
        if($tagihan->status == 'lunas') {
             return back()->with('error', 'Tidak bisa menghapus tagihan yang sudah lunas.');
        }
        
        $tagihan->delete();
        return redirect()->route('tagihan.index')->with('success', 'Tagihan berhasil dihapus.');
    }
}
