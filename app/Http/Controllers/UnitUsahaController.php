<?php

namespace App\Http\Controllers;

use App\Models\UnitUsaha;
use App\Models\User;
use App\Notifications\GeneralNotification;
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
            'image' => 'nullable|image',
            'instagram_url' => 'nullable|url'
        ]);

        $data = $request->all();
        $data['show_price'] = $request->has('show_price');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('unit_usaha', 'public');
        }

        // Sanitize Instagram URL
        if (!empty($data['instagram_url'])) {
            if (preg_match('/\\/(p|reel|tv)\\/([^\\/?#&]+)/', $data['instagram_url'], $matches)) {
                $code = $matches[2];
                $data['instagram_url'] = "https://www.instagram.com/p/$code/";
            }
        }

        $product = UnitUsaha::create($data);

        // Notify all users about new product
        $users = User::all();
        foreach ($users as $recipient) {
            $recipient->notify(new GeneralNotification([
                'icon' => 'fa-store',
                'title' => 'Produk Baru Tersedia',
                'message' => $product->name . ' telah ditambahkan ke Unit Usaha.',
                'url' => route('unit_usaha.index'),
                'category' => 'unit_usaha'
            ]));
        }

        return redirect()->route('unit_usaha.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(UnitUsaha $unitUsaha)
    {
        return view('unit_usaha.edit', compact('unitUsaha'));
    }

    public function update(Request $request, UnitUsaha $unitUsaha)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'image' => 'nullable|image',
            'instagram_url' => 'nullable|url'
        ]);

        $data = $request->except(['remove_image', 'show_price']);
        $data['show_price'] = $request->has('show_price');

        // Handle Image Deletion
        if ($request->has('remove_image') && $unitUsaha->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($unitUsaha->image);
            $data['image'] = null;
        }

        // Handle New Image Upload
        if ($request->hasFile('image')) {
            // Delete old one if exists
            if ($unitUsaha->image) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($unitUsaha->image);
            }
            $data['image'] = $request->file('image')->store('unit_usaha', 'public');
        }

        // Sanitize Instagram URL
        if (!empty($data['instagram_url'])) {
            if (preg_match('/\\/(p|reel|tv)\\/([^\\/?#&]+)/', $data['instagram_url'], $matches)) {
                $code = $matches[2];
                $data['instagram_url'] = "https://www.instagram.com/p/$code/";
            }
        }

        $unitUsaha->update($data);
        return redirect()->route('unit_usaha.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(UnitUsaha $unitUsaha)
    {
        if ($unitUsaha->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($unitUsaha->image);
        }
        $unitUsaha->delete();
        return redirect()->route('unit_usaha.index')->with('success', 'Produk berhasil dihapus');
    }
}
