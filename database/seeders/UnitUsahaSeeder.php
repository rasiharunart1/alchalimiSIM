<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UnitUsaha;

class UnitUsahaSeeder extends Seeder
{
    public function run()
    {
        UnitUsaha::create([
            'name' => 'Seragam Batik Santri',
            'description' => 'Bahan katun berkualitas, adem dan nyaman dipakai untuk kegiatan sehari-hari.',
            'price' => 85000,
            'status' => 'available',
            'contact_number' => '6281234567890',
        ]);

        UnitUsaha::create([
            'name' => 'Madu Murni Al-Chalimi',
            'description' => 'Madu hutan asli hasil ternak santri. Menjaga daya tahan tubuh.',
            'price' => 60000,
            'status' => 'available',
            'contact_number' => '6281234567890',
        ]);

        UnitUsaha::create([
            'name' => 'Kitab Kuning Lengkap',
            'description' => 'Paket kitab kuning untuk kelas Ula. Terdiri dari Jurumiyah, Safinah, dan Akhlaq Lil Banin.',
            'price' => 120000,
            'status' => 'out_of_stock',
            'contact_number' => '6281234567890',
        ]);
    }
}
