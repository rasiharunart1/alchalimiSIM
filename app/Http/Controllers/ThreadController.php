<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Comment;
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

        Thread::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'body' => $request->body,
            'category' => $request->category,
            'image' => $imagePath,
            'instagram_url' => $request->instagram_url
        ]);

        return redirect()->route('threads.index')->with('success', 'Thread berhasil dibuat!');
    }

    public function reply(Request $request, Thread $thread)
    {
        $request->validate([
            'body' => 'required'
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'thread_id' => $thread->id,
            'body' => $request->body
        ]);

        return back()->with('success', 'Balasan terkirim!');
    }
}
