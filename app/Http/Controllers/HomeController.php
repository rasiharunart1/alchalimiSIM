<?php

namespace App\Http\Controllers;

use App\Models\UnitUsaha;
use App\Models\Thread;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $unitUsahas = UnitUsaha::where('status', 'available')->get();
        
        // Latest threads for "Info Update Terkini"
        $recentThreads = Thread::with('user')
            ->latest()
            ->take(6)
            ->get();

        // Get Manual Instagram Links from Settings
        $igUsername = \App\Models\Setting::get('instagram_username');
        $manualItems = [];
        
        for ($i = 1; $i <= 5; $i++) {
            $link = \App\Models\Setting::get("ig_link_$i");
            if ($link) {
                // Sanitize to standard /p/CODE/ format (removes username, reel/tv prefixes to standard p)
                if (preg_match('/\/(p|reel|tv)\/([^\/?#&]+)/', $link, $matches)) {
                    $code = $matches[2];
                    $cleanLink = "https://www.instagram.com/p/$code/";
                } else {
                    $cleanLink = $link;
                }

                $manualItems[] = [
                    'permalink' => $cleanLink,
                    'is_manual' => true
                ];
            }
        }

        // Gallery Items: Manual Links prioritized, then fall back to Threads with images
        if (!empty($manualItems)) {
            $galleryItems = $manualItems;
        } else {
            $galleryItems = $recentThreads->whereNotNull('image')->take(5);
        }

        return view('welcome', compact('unitUsahas', 'recentThreads', 'galleryItems', 'igUsername'));
    }
}
