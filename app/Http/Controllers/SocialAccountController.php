<?php

namespace App\Http\Controllers;

use App\Models\SocialAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SocialAccountController extends Controller
{
    /**
     * Show all connected social accounts for the logged-in user.
     */
    public function index()
    {
        $user = Auth::user();

        $accounts = SocialAccount::where('user_id', $user->id)
            ->get()
            ->keyBy('platform');

        return view('accounts.index', compact('accounts'));
    }

    /**
     * Disconnect a social account.
     */
    public function destroy($platform)
    {
        $user = Auth::user();

        SocialAccount::where('user_id', $user->id)
            ->where('platform', $platform)
            ->delete();

        return redirect()
            ->route('accounts.index')
            ->with('success', ucfirst($platform) . ' account disconnected successfully.');
    }
}