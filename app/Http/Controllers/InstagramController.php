<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InstagramController extends Controller
{
    /**
     * Send logged-in user to Instagram OAuth.
     */
    public function redirect()
    {
        if (!auth()->check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Please login before connecting Instagram.');
        }

        $clientId = env('INSTAGRAM_CLIENT_ID');
        $redirectUri = env('INSTAGRAM_REDIRECT_URI');

        if (!$clientId || !$redirectUri) {
            return redirect()
                ->route('accounts.index')
                ->with('error', 'Instagram OAuth settings are missing from .env.');
        }

        $url = 'https://www.instagram.com/oauth/authorize?' . http_build_query([
            'client_id' => $clientId,
            'redirect_uri' => $redirectUri,
            'response_type' => 'code',
            'scope' => 'instagram_business_basic,instagram_business_content_publish',
        ]);

        return redirect()->away($url);
    }

    /**
     * Handle Instagram OAuth callback.
     */
    public function callback(Request $request)
    {
        if (!auth()->check()) {
            return redirect()
                ->route('login')
                ->with('error', 'Your session expired. Please login and connect Instagram again.');
        }

        if ($request->has('error')) {
            return redirect()
                ->route('accounts.index')
                ->with('error', 'Instagram connection was cancelled.');
        }

        $code = $request->query('code');

        if (!$code) {
            return redirect()
                ->route('accounts.index')
                ->with('error', 'Instagram authorization code was not received.');
        }

        $clientId = env('INSTAGRAM_CLIENT_ID');
        $clientSecret = env('INSTAGRAM_CLIENT_SECRET');
        $redirectUri = env('INSTAGRAM_REDIRECT_URI');

        if (!$clientId || !$clientSecret || !$redirectUri) {
            return redirect()
                ->route('accounts.index')
                ->with('error', 'Instagram OAuth settings are missing from .env.');
        }

        /*
        |--------------------------------------------------------------------------
        | Exchange authorization code for access token
        |--------------------------------------------------------------------------
        */

        try {
            $tokenResponse = Http::asForm()->post(
                'https://api.instagram.com/oauth/access_token',
                [
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => $redirectUri,
                    'code' => $code,
                ]
            );
        } catch (\Throwable $e) {
            return redirect()
                ->route('accounts.index')
                ->with('error', 'Instagram token request failed. Please try again.');
        }

        if (!$tokenResponse->successful()) {
            return redirect()
                ->route('accounts.index')
                ->with('error', 'Instagram authorization could not be completed.');
        }

        $tokenData = $tokenResponse->json();

        $accessToken = $tokenData['access_token'] ?? null;
        $instagramUserId = $tokenData['user_id'] ?? null;

        if (!$accessToken || !$instagramUserId) {
            return redirect()
                ->route('accounts.index')
                ->with('error', 'Instagram account information was not returned.');
        }

        /*
        |--------------------------------------------------------------------------
        | Get Instagram account information
        |--------------------------------------------------------------------------
        */

        $accountResponse = Http::get(
            'https://graph.instagram.com/me',
            [
                'fields' => 'user_id,username',
                'access_token' => $accessToken,
            ]
        );

        if (!$accountResponse->successful()) {
            return redirect()
                ->route('accounts.index')
                ->with('error', 'Instagram account information could not be retrieved.');
        }

        $instagram = $accountResponse->json();

        /*
        |--------------------------------------------------------------------------
        | Save account for CURRENT Laravel user
        |--------------------------------------------------------------------------
        */

        $user = auth()->user();

        SocialAccount::updateOrCreate(
            [
                'user_id' => $user->id,
                'platform' => 'instagram',
            ],
            [
                'account_name' => $instagram['username'] ?? 'Instagram Account',
                'account_id' => $instagram['user_id'] ?? $instagramUserId,
                'access_token' => $accessToken,
                'refresh_token' => null,
                'token_expires_at' => null,
                'status' => 'connected',
            ]
        );

        return redirect()
            ->route('accounts.index')
            ->with(
                'success',
                'Instagram account connected successfully!'
            );
    }
}