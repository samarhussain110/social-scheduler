<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use Laravel\Socialite\Facades\Socialite;

class LinkedInController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('linkedin-openid')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    public function callback()
    {
        $linkedInUser = Socialite::driver('linkedin-openid')->user();

        $user = auth()->user();

        if (!$user) {
            return redirect()
                ->route('login')
                ->with('error', 'Please login first before connecting LinkedIn.');
        }

        SocialAccount::updateOrCreate(
            [
                'user_id' => $user->id,
                'platform' => 'linkedin',
                'account_id' => $linkedInUser->getId(),
            ],
            [
                'account_name' => $linkedInUser->getName(),
                'access_token' => $linkedInUser->token,
                'refresh_token' => $linkedInUser->refreshToken,
                'token_expires_at' => $linkedInUser->expiresIn
                    ? now()->addSeconds($linkedInUser->expiresIn)
                    : null,
                'status' => 'connected',
            ]
        );

        return redirect()
            ->route('accounts.index')
            ->with('success', 'LinkedIn account connected successfully!');
    }
}