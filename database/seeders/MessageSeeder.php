<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\User;

class MessageSeeder extends Seeder
{
    public function run()
    {
        $wali = User::where('role', 'wali_santri')->first();
        $ustadz = User::where('role', 'ustadz')->first();

        if ($wali && $ustadz) {
            // Wali to Ustadz
            Message::create([
                'sender_id' => $wali->id,
                'receiver_id' => $ustadz->id,
                'body' => 'Assalamu\'alaikum Ustadz, bagaimana perkembangan hafalan Fatih pekan ini?',
                'is_read' => true,
            ]);

            // Ustadz to Wali
            Message::create([
                'sender_id' => $ustadz->id,
                'receiver_id' => $wali->id,
                'body' => 'Wa\'alaikumussalam Pak Budi. Alhamdulillah Fatih lancar setoran Juz 29-nya. Tinggal murojaah sedikit lagi.',
                'is_read' => false,
            ]);
        }
    }
}
