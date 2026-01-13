<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Santri;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Admin
        User::create([
            'name' => 'Administrator',
            'phone' => '081234567890',
            'email' => 'admin@alchalimi.com',
            'role' => 'admin',
            'password' => bcrypt('password123'),
        ]);

        // 2. Create Ustadz
        $ustadz = User::create([
            'name' => 'Ustadz Abdullah',
            'phone' => '081234567891',
            'email' => 'ustadz@alchalimi.com',
            'role' => 'ustadz',
            'password' => bcrypt('password123'),
        ]);

        // 3. Create Pengurus (Bendahara)
        User::create([
            'name' => 'Bendahara Pondok',
            'phone' => '081234567892',
            'email' => 'bendahara@alchalimi.com',
            'role' => 'pengurus',
            'password' => bcrypt('password123'),
        ]);

        // 4. Create Wali Santri
        $wali = User::create([
            'name' => 'Bpk. Budi Santoso',
            'phone' => '081234567893',
            'email' => 'wali@alchalimi.com',
            'role' => 'wali_santri',
            'password' => bcrypt('password123'),
        ]);

        // 5. Create Santri for the Wali (Linked Data)
        Santri::create([
            'wali_id' => $wali->id,
            'nis' => '2024001',
            'nama_lengkap' => 'Muhammad Fatih',
            'nama_panggilan' => 'Fatih',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => '2010-05-15',
            'alamat' => 'Jl. Merpati No. 10',
            'status' => 'aktif',
            'tanggal_masuk' => '2023-07-01',
        ]);
        
        Santri::create([
            'wali_id' => $wali->id,
            'nis' => '2024002',
            'nama_lengkap' => 'Aisyah Humaira',
            'nama_panggilan' => 'Aisyah',
            'jenis_kelamin' => 'P',
            'tempat_lahir' => 'Sidoarjo',
            'tanggal_lahir' => '2012-08-20',
            'alamat' => 'Jl. Merpati No. 10',
            'status' => 'aktif',
            'tanggal_masuk' => '2023-07-01',
        ]);
    }
}
