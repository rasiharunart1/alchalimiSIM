<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        // Get users who have chatted with current user or are potential contacts (e.g. Admins, Ustadz)
        // For simplicity, showing all users except self initially, or grouped by conversation
        $users = User::where('id', '!=', Auth::id())->get();
        
        return view('chat.index', compact('users'));
    }

    public function show(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        
        // Mark messages as read
        Message::where('sender_id', $userId)
               ->where('receiver_id', Auth::id())
               ->update(['is_read' => true]);

        $messages = Message::where(function($q) use ($userId) {
            $q->where('sender_id', Auth::id())
              ->where('receiver_id', $userId);
        })->orWhere(function($q) use ($userId) {
            $q->where('sender_id', $userId)
              ->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();

        if ($request->ajax()) {
            return view('chat.messages', compact('messages'));
        }

        return view('chat.show', compact('user', 'messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'body' => 'required'
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'body' => $request->body
        ]);

        return back();
    }
}
