<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

public function callback()
{
    $googleUser = Socialite::driver('google')->stateless()->user();

    $user = User::updateOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            'name' => $googleUser->getName(),
            'google_id' => $googleUser->getId(),
            'password' => bcrypt(str()->random(16)),
        ]
    );

    Auth::login($user);

    return redirect(route('dashboard'));

    // return dd([
    //     'googleUser'   => $googleUser,
    //     'db_user'      => $user,
    //     'auth_user'    => Auth::user(),
    //     'session_id'   => session()->getId(),
    // ]);
}

}
