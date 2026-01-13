<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        return view('profile.edit', [
            'user' => auth()->user(),
        ]);
    }

    /**
     * Update the profile.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'photo' => ['nullable', 'image', 'max:2048'], // For direct upload if crop fails
            'cropped_photo' => ['nullable', 'string'], // Base64 string from cropper
        ]);

        // Update basic info
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        // Handle Photo Upload (Cropped)
        if ($request->filled('cropped_photo')) {
            // Delete old photo
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }

            // Decode Base64
            $image_parts = explode(";base64,", $request->cropped_photo);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);

            // Save new photo
            $filename = 'profile-photos/' . uniqid() . '.' . $image_type;
            Storage::disk('public')->put($filename, $image_base64);
            
            $user->photo = $filename;
        } 
        // Handle Normal Upload (Fallback)
        elseif ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('profile-photos', 'public');
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
