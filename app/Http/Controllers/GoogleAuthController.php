<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Ambil URL avatar Google
        $avatarUrl = $googleUser->getAvatar();

        // Simpan avatar ke storage/public/avatars
        $avatarName = Str::random(20) . '.jpg'; // nama random
        $avatarContents = file_get_contents($avatarUrl); // ambil kontennya
        Storage::disk('public')->put('avatars/' . $avatarName, $avatarContents);

        $user = User::updateOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt(Str::random(16)),
                'avatar' => 'avatars/' . $avatarName, // simpan path di DB
            ]
        );

        Auth::login($user);

        return redirect(route('dashboard'));
    }
}
