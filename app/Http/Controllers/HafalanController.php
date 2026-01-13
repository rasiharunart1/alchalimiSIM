<?php

namespace App\Http\Controllers;

use App\Models\Hafalan;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HafalanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Hafalan::with(['santri', 'ustadz'])->latest();

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('santri', function($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%");
            });
        }

        if ($request->has('juz')) {
            $query->where('juz', $request->juz);
        }

        $hafalans = $query->paginate(15);
        $routePrefix = Auth::user()->role === 'ustadz' ? 'ustadz.hafalan' : 'admin.hafalan';

        return view('admin.hafalan.index', compact('hafalans', 'routePrefix'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Only active santri
        $santris = Santri::aktif()->select('id', 'nama_lengkap', 'nis')->get();
        $routePrefix = Auth::user()->role === 'ustadz' ? 'ustadz.hafalan' : 'admin.hafalan';
        return view('admin.hafalan.create', compact('santris', 'routePrefix'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'juz' => 'required|integer|min:1|max:30',
            'surah' => 'required|string',
            'halaman' => 'required|integer|min:1|max:20',
            'ayat_mulai' => 'required|string',
            'ayat_selesai' => 'required|string',
            'status' => 'required|in:setoran,murajaah,lulus',
            'nilai' => 'nullable|integer|min:0|max:100',
            'catatan' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        $validated['ustadz_id'] = Auth::id(); // Current logged in user (Admin/Ustadz)

        Hafalan::create($validated);

        $route = Auth::user()->role === 'ustadz' ? 'ustadz.hafalan.index' : 'admin.hafalan.index';
        return redirect()->route($route)->with('success', 'Catatan hafalan berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hafalan $hafalan)
    {
        return view('admin.hafalan.show', compact('hafalan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hafalan $hafalan)
    {
        $santris = Santri::aktif()->select('id', 'nama_lengkap')->get();
        $routePrefix = Auth::user()->role === 'ustadz' ? 'ustadz.hafalan' : 'admin.hafalan';
        return view('admin.hafalan.edit', compact('hafalan', 'santris', 'routePrefix'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hafalan $hafalan)
    {
        $validated = $request->validate([
            'santri_id' => 'required|exists:santri,id',
            'juz' => 'required|integer|min:1|max:30',
            'surah' => 'required|string',
            'halaman' => 'required|integer|min:1|max:20',
            'ayat_mulai' => 'required|string',
            'ayat_selesai' => 'required|string',
            'status' => 'required|in:setoran,murajaah,lulus',
            'nilai' => 'nullable|integer',
            'catatan' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        $hafalan->update($validated);

        $route = Auth::user()->role === 'ustadz' ? 'ustadz.hafalan.index' : 'admin.hafalan.index';
        return redirect()->route($route)->with('success', 'Data hafalan diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hafalan $hafalan)
    {
        $hafalan->delete();
        $route = Auth::user()->role === 'ustadz' ? 'ustadz.hafalan.index' : 'admin.hafalan.index';
        return redirect()->route($route)->with('success', 'Data hafalan dihapus');
    }

    /**
     * Index for Wali Santri viewing their children's progress
     */
    public function indexWali()
    {
        $user = Auth::user();
        $santris = $user->santri()->with(['hafalan' => function($q) {
            $q->latest();
        }])->get();

        return view('wali.hafalan.index', compact('santris'));
    }
}
