<?php

namespace App\Http\Controllers;

use App\Models\UnitUsaha;
use Illuminate\Http\Request;

class UnitUsahaController extends Controller
{
    public function index()
    {
        $products = UnitUsaha::latest()->get();
        return view('unit_usaha.index', compact('products'));
    }

    public function create()
    {
        return view('unit_usaha.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('unit_usaha', 'public');
        }

        UnitUsaha::create($data);
        return redirect()->route('unit_usaha.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(UnitUsaha $unitUsaha)
    {
        return view('unit_usaha.edit', compact('unitUsaha'));
    }

    public function update(Request $request, UnitUsaha $unitUsaha)
    {
        $data = $request->all();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('unit_usaha', 'public');
        }

        $unitUsaha->update($data);
        return redirect()->route('unit_usaha.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(UnitUsaha $unitUsaha)
    {
        $unitUsaha->delete();
        return redirect()->route('unit_usaha.index')->with('success', 'Produk berhasil dihapus');
    }
}
