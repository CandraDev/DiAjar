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

        $user = User::where('email', $googleUser->getEmail())->first();

        // Jika user sudah ada
        if ($user) {
            // Tambahkan google_id kalau belum ada
            if (!$user->google_id) {
                $user->google_id = $googleUser->getId();
            }

            // Jika user belum punya avatar, simpan avatar baru
            if (!$user->avatar) {
                $avatarUrl = $googleUser->getAvatar();
                $avatarName = Str::random(20) . '.jpg';
                $avatarContents = file_get_contents($avatarUrl);
                Storage::disk('public')->put('avatars/' . $avatarName, $avatarContents);
                $user->avatar = 'avatars/' . $avatarName;
            }

            $user->save();
        } else {
            // User baru
            $avatarUrl = $googleUser->getAvatar();
            $avatarName = Str::random(20) . '.jpg';
            $avatarContents = file_get_contents($avatarUrl);
            Storage::disk('public')->put('avatars/' . $avatarName, $avatarContents);

            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt(Str::random(16)),
                'avatar' => 'avatars/' . $avatarName,
            ]);
        }

        Auth::login($user);

        return redirect(route('dashboard'));
    }
}
