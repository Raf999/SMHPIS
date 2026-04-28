<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

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

        if ($request->filled('cropped_image') || $request->hasFile('profile_image')) {
            // Configure Cloudinary
            Configuration::instance(env('CLOUDINARY_URL'));
            $uploadApi = new UploadApi();

            if ($request->filled('cropped_image')) {
                // Handle base64 cropped image
                $uploadResult = $uploadApi->upload($request->cropped_image, [
                    'folder' => 'profile_images',
                    'transformation' => [
                        'width' => 400,
                        'height' => 400,
                        'crop' => 'fill'
                    ]
                ]);
                $user->profile_image = $uploadResult['secure_url'];
            } elseif ($request->hasFile('profile_image')) {
                // Fallback for standard upload
                $uploadResult = $uploadApi->upload($request->file('profile_image')->getRealPath(), [
                    'folder' => 'profile_images',
                    'transformation' => [
                        'width' => 400,
                        'height' => 400,
                        'crop' => 'fill'
                    ]
                ]);
                $user->profile_image = $uploadResult['secure_url'];
            }
        }

        $user->save();

        return back()->with('status', 'Profile updated successfully!');
    }
}
