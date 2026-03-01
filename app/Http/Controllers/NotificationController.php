<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAllRead(Request $request)
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi ditandai telah dibaca.');
    }

    public function markAsRead($id)
    {
        auth()->user()->unreadNotifications->where('id', $id)->markAsRead();
        return back();
    }

    public function fetch()
    {
        $user = auth()->user();
        $notifications = $user->notifications->take(5)->map(function ($n) {
            return [
                'id' => $n->id,
                'data' => $n->data,
                'read_at' => $n->read_at,
                'created_at_human' => $n->created_at->diffForHumans(),
            ];
        });

        return response()->json([
            'unreadCount' => $user->unreadNotifications->count(),
            'notifications' => $notifications
        ]);
    }
}
