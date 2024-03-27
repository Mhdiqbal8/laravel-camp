<?php

namespace App\Http\Controllers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserController extends Controller
{
    
    public function login()
    {
        return view('auth.user.login');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
        // return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleGoogleCallback()
    {
        $socialUser = Socialite::driver('google')->user();
        $registeredUser = User::where('google_id', $socialUser->id)->first();

        if(!$registeredUser){
            $user = User::updateOrCreate([
                'google_id' => $socialUser->id,
            ], [
                'name' => $socialUser->name,
                'email' => $socialUser->email,
                'password' => Hash::make('123'),
                'google_token' => $socialUser->token,
                'google_refresh_token' => $socialUser->refreshToken,
            ]);
        
            Auth::login($user, true);    
            return redirect('/dashboard');
        }
        
        Auth::login($registeredUser);         
        return redirect()->route('home');       
    }

  

}
