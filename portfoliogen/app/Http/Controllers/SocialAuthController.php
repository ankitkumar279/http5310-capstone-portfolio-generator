<?php

namespace App\Http\Controllers;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    private function socialiteClient(): Client
    {
        return new Client([
            'verify' => env('CURL_CA_BUNDLE', env('SSL_CERT_FILE', true)),
        ]);
    }

    public function redirect(string $provider)
    {
        abort_unless(in_array($provider, ['google', 'github']), 404);

        return Socialite::driver($provider)
            ->setHttpClient($this->socialiteClient())
            ->redirect();
    }

    public function callback(string $provider)
    {
        abort_unless(in_array($provider, ['google', 'github']), 404);

        $socialUser = Socialite::driver($provider)
            ->setHttpClient($this->socialiteClient())
            ->stateless()
            ->user();

        $email = $socialUser->getEmail();
        if (!$email) {
            return redirect('/login')->with('error', 'No email returned from ' . $provider . '.');
        }

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'name'     => $socialUser->getName() ?: $socialUser->getNickname() ?: 'User',
                'password' => bcrypt(Str::random(32)),
            ]
        );

        // ✅ Ensure username exists for routes like /{username}/dashboard
        if (empty($user->username)) {
            $base = Str::slug($socialUser->getNickname() ?: $socialUser->getName() ?: 'user', '');
            if ($base === '') $base = 'user';

            $username = $base;
            $i = 1;

            while (User::where('username', $username)->exists()) {
                $username = $base . $i;
                $i++;
            }

            $user->username = $username;
            $user->save();
        }

        Auth::login($user, true);

        return redirect()->route('dashboard', ['username' => $user->username]);
    }
}