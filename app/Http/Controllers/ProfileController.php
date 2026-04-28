<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;

        if ($request->filled('password')) {
            $user->password = $request->password; // Model cast handles hashing
        }

        if ($request->filled('cropped_image')) {
            // Handle base64 cropped image
            $imageData = $request->cropped_image;
            $fileName = 'profile_images/' . uniqid() . '.jpg';
            
            // Delete old image
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // Decode and save
            $data = substr($imageData, strpos($imageData, ',') + 1);
            $data = base64_decode($data);
            Storage::disk('public')->put($fileName, $data);
            
            $user->profile_image = $fileName;
        } elseif ($request->hasFile('profile_image')) {
            // Fallback for standard upload
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }
            $user->profile_image = $request->file('profile_image')->store('profile_images', 'public');
        }

        $user->save();

        return back()->with('status', 'Profile updated successfully!');
    }
}
