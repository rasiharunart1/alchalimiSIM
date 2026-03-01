<?php

namespace App\Http\Controllers;

use App\Models\AlumniToken;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AlumniTokenController extends Controller
{
    /**
     * Display a listing of the tokens.
     */
    public function index()
    {
        $tokens = AlumniToken::with('user')->latest()->paginate(10);
        return view('admin.tokens.index', compact('tokens'));
    }

    /**
     * Store a newly created token in storage.
     */
    public function store(Request $request)
    {
        // Generate a unique token
        $tokenStr = 'ALM-' . strtoupper(Str::random(6));
        
        // Ensure uniqueness manually just in case
        while (AlumniToken::where('token', $tokenStr)->exists()) {
            $tokenStr = 'ALM-' . strtoupper(Str::random(6));
        }

        AlumniToken::create([
            'token' => $tokenStr,
            'is_used' => false,
            'expires_at' => $request->expires_at, // Optional expiry
        ]);

        return back()->with('success', 'Token alumni baru berhasil dibuat: ' . $tokenStr);
    }

    /**
     * Remove the specified token from storage.
     */
    public function destroy(AlumniToken $token)
    {
        if ($token->is_used) {
            return back()->with('error', 'Token yang sudah digunakan tidak dapat dihapus.');
        }

        $token->delete();
        return back()->with('success', 'Token berhasil dihapus.');
    }
}
