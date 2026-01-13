<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Thread;
use App\Models\User;
use App\Models\Comment;

class ThreadSeeder extends Seeder
{
    public function run()
    {
        $wali = User::where('role', 'wali_santri')->first();
        $ustadz = User::where('role', 'ustadz')->first();
        $admin = User::where('role', 'admin')->first();

        // 1. Thread Pengumuman (Admin)
        if ($admin) {
            Thread::create([
                'user_id' => $admin->id,
                'title' => 'Libur Kenaikan Kelas & Penjemputan Santri',
                'body' => "Assalamu'alaikum Warahmatullahi Wabarakatuh.\n\nDiberitahukan kepada seluruh wali santri bahwa libur kenaikan kelas akan dimulai pada tanggal 20 Desember. Penjemputan santri dapat dilakukan mulai pukul 08.00 WIB.\n\nHarap membawa kartu wali saat penjemputan.\n\nWassalamu'alaikum.",
                'category' => 'Pengumuman',
                'is_pinned' => true,
            ]);
        }

        // 2. Thread Parenting (Ustadz)
        if ($ustadz) {
            $thread = Thread::create([
                'user_id' => $ustadz->id,
                'title' => 'Tips Menjaga Hafalan Anak di Rumah',
                'body' => "Ayah Bunda yang dirahmati Allah, berikut adalah beberapa tips agar hafalan anak tetap terjaga saat liburan di rumah:\n1. Murojaah ba'da Maghrib.\n2. Setoran hafalan ke orang tua.\n3. Kurangi penggunaan gadget.",
                'category' => 'Parenting',
            ]);
            
            // Comment from Wali
            if ($wali) {
                Comment::create([
                    'user_id' => $wali->id,
                    'thread_id' => $thread->id,
                    'body' => 'Terima kasih tipsnya Ustadz, sangat bermanfaat.',
                ]);
            }
        }

        // 3. Thread Jual Beli (Wali)
        if ($wali) {
            Thread::create([
                'user_id' => $wali->id,
                'title' => 'Jual Madu Hutan Asli Sumbawa',
                'body' => "Bismillah, ready stok madu hutan asli Sumbawa. Kemasan 500ml harga 85rb. Silakan yang berminat bisa DM atau balas thread ini.",
                'category' => 'Jual Beli',
            ]);
        }
    }
}
