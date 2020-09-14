<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Socialite;
use App\Models\User;
use Exception;
use Auth;

class UserAuthController extends Controller
{
    public function fbLogin() 
    {
        $redirect_url = env('FB_REDIRECT');

        return Socialite::driver('facebook')
            ->scopes(['user_friends'])
            ->redirectUrl($redirect_url)
            ->redirect();
    }

    public function fbLoginCallback() 
    {
        if (request()->error == 'access_deined') {
            throw new Excetion('授權失敗');
        }
        
        $fbUser = Socialite::driver('facebook')->stateless()->user();

        if (empty($fbUser->email)) {
            throw new Excetion('未授權取取得使用者Email');
        }

        $user = User::where('email', $fbUser->email)->first();

        if (!empty($user) && empty($user->facebook_id)) {
            $user->facebook_id = $fbUser->id;
            $user->save();
        }
        
        if (empty($user)) {
            $user = firstOrCreate(
                ['facebook_id' => $fbUser->id],
                ['facebook_id' => $fbUser->id, 'name' => $fbUser->name, 'email' => $fbUser->email, 'password' => uniqid()]
            );
        }

        Auth::login($user);

        return redirect()->route('home');
    }
}
