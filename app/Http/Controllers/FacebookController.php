<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class FacebookController extends Controller
{
    /**
     * Send the logged-in user to Facebook.
     */
    public function redirect()
    {
        if (!auth()->check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Please login before connecting Facebook.');
        }

        return Socialite::driver('facebook')
            ->setScopes([
                'pages_show_list',
                'pages_read_engagement',
                'pages_manage_posts',
            ])
            ->redirect();
    }

    /**
     * Handle Facebook callback.
     */
    public function callback(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | User must already be logged into SocialScheduler
        |--------------------------------------------------------------------------
        */

        if (!auth()->check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Your session expired. Please login and connect Facebook again.');
        }

        /*
        |--------------------------------------------------------------------------
        | User cancelled Facebook login
        |--------------------------------------------------------------------------
        */

        if ($request->has('error')) {
            return redirect()
                ->route('accounts.index')
                ->with('error', 'Facebook connection was cancelled.');
        }

        /*
        |--------------------------------------------------------------------------
        | Get Facebook user
        |--------------------------------------------------------------------------
        */

        try {
            $facebookUser = Socialite::driver('facebook')->user();
        } catch (\Throwable $e) {
            return redirect()
                ->route('accounts.index')
                ->with(
                    'error',
                    'Facebook connection could not be completed. Please try again.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Save Facebook account for the CURRENT Laravel user
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();

        SocialAccount::updateOrCreate(
            [
                'user_id' => $user->id,
                'platform' => 'facebook',
            ],
            [
                'account_name' => $facebookUser->getName()
                    ?: 'Facebook Account',

                'account_id' => $facebookUser->getId(),

                'access_token' => $facebookUser->token,

                'refresh_token' => $facebookUser->refreshToken,

                'token_expires_at' => $facebookUser->expiresIn
                    ? now()->addSeconds($facebookUser->expiresIn)
                    : null,

                'status' => 'connected',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Back to Social Accounts page
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('accounts.index')
            ->with(
                'success',
                'Facebook account connected successfully!'
            );
    }
}