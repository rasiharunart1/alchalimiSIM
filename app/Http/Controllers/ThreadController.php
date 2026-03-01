<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index(Request $request)
    {
        $query = Thread::with('user')->latest();

        if ($request->has('category') && $request->category != 'All') {
            $query->where('category', $request->category);
        }

        $threads = $query->get();
        return view('threads.index', compact('threads'));
    }

    public function show(Thread $thread)
    {
        $thread->load('comments.user');
        return view('threads.show', compact('thread'));
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'category' => 'required',
            'image' => 'nullable|image|max:5120',
            'instagram_url' => 'nullable|url'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('threads', 'public');
        }

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body,
            'category' => $request->category,
            'image' => $imagePath,
            'instagram_url' => $request->instagram_url
        ]);

        // Notify all users about new thread (except author)
        $users = User::where('id', '!=', auth()->id())->get();
        foreach ($users as $recipient) {
            $recipient->notify(new GeneralNotification([
                'icon' => 'fa-users-rectangle',
                'title' => 'Thread Baru: ' . $thread->title,
                'message' => auth()->user()->name . ' membuat thread baru di kategori ' . $thread->category,
                'url' => route('threads.show', $thread),
                'category' => 'thread'
            ]));
        }

        return redirect()->route('threads.index')->with('success', 'Thread berhasil dibuat!');
    }

    public function reply(Request $request, Thread $thread)
    {
        $request->validate([
            'body' => 'required'
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'thread_id' => $thread->id,
            'body' => $request->body
        ]);

        // Notify thread author if someone else replies
        if ($thread->user_id != auth()->id()) {
            $thread->user->notify(new GeneralNotification([
                'icon' => 'fa-comment-dots',
                'title' => 'Balasan Baru',
                'message' => auth()->user()->name . ' menanggapi thread Anda: ' . $thread->title,
                'url' => route('threads.show', $thread),
                'category' => 'thread_reply'
            ]));
        }

        return back()->with('success', 'Balasan terkirim!');
    }
}
