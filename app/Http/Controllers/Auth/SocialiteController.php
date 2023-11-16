<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function retrieveFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        $newUser = User::updateOrCreate([
            'social_id' => $user->id
        ],
            [
                'name' => $user->name,
                'email' => $user->email,
                'password' => encrypt('pass_test'),
                'social_id' => $user->id,
                'social_type' => 'facebook',
            ]);

        Auth::login($newUser);
        return redirect(route('home'));

    }

    public function retrieveGoogleCallback()
    {
        $user = Socialite::driver('google')->user();

        $newUser = User::updateOrCreate([
            'social_id' => $user->id
        ],
        [
            'name' => $user->name,
            'email' => $user->email,
            'password' => encrypt('pass_test'),
            'social_id' => $user->id,
            'social_type' => 'google',
        ]);

        Auth::login($newUser);
        return redirect(route('home'));
    }
}
