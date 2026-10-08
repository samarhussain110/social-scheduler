<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\FacebookController;
use App\Http\Controllers\InstagramController;
use App\Http\Controllers\LinkedInController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialAccountController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Public / Landing Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    if (auth()->check()) {
        return redirect()->route('dashboard');
    }

    return view('welcome');

})->name('home');


/*
|--------------------------------------------------------------------------
| Privacy Policy
|--------------------------------------------------------------------------
*/

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy.policy');


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| Facebook OAuth
|--------------------------------------------------------------------------
*/

Route::get('/auth/facebook', [FacebookController::class, 'redirect'])
    ->name('facebook.redirect');

Route::get('/auth/facebook/callback', [FacebookController::class, 'callback'])
    ->name('facebook.callback');


/*
|--------------------------------------------------------------------------
| Instagram OAuth
|--------------------------------------------------------------------------
*/

Route::get('/auth/instagram', [InstagramController::class, 'redirect'])
    ->name('instagram.redirect');

Route::get('/auth/instagram/callback', [InstagramController::class, 'callback'])
    ->name('instagram.callback');


/*
|--------------------------------------------------------------------------
| LinkedIn OAuth
|--------------------------------------------------------------------------
*/

Route::get('/auth/linkedin', [LinkedInController::class, 'redirect'])
    ->name('linkedin.redirect');

Route::get('/auth/linkedin/callback', [LinkedInController::class, 'callback'])
    ->name('linkedin.callback');


/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');


    /*
    |--------------------------------------------------------------------------
    | Social Accounts
    |--------------------------------------------------------------------------
    */

    Route::get('/accounts', [SocialAccountController::class, 'index'])
        ->name('accounts.index');

    Route::delete('/accounts/{platform}', [SocialAccountController::class, 'destroy'])
        ->name('accounts.destroy');


    /*
    |--------------------------------------------------------------------------
    | Posts
    |--------------------------------------------------------------------------
    */

    Route::prefix('posts')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('posts.index');
        Route::get('/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/', [PostController::class, 'store'])->name('posts.store');
        Route::get('/{post}', [PostController::class, 'show'])->name('posts.show');
        Route::get('/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
        Route::post('/{post}/cancel', [PostController::class, 'cancel'])->name('posts.cancel');
    });


    /*
    |--------------------------------------------------------------------------
    | Notifications
    |--------------------------------------------------------------------------
    */

    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
        Route::post('/{notification}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
        Route::post('/{notification}/mark-unread', [NotificationController::class, 'markAsUnread'])->name('notifications.mark-unread');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
        Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    });


    /*
    |--------------------------------------------------------------------------
    | Activity Logs
    |--------------------------------------------------------------------------
    */

    Route::prefix('activity-logs')->group(function () {
        Route::get('/', [ActivityLogController::class, 'index'])->name('activity-logs.index');
        Route::get('/{activityLog}', [ActivityLogController::class, 'show'])->name('activity-logs.show');
        Route::delete('/{activityLog}', [ActivityLogController::class, 'destroy'])->name('activity-logs.destroy');
    });

});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';