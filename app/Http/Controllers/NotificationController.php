<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function show(Notification $notification)
    {
        if (!$notification->isRead()) {
            $notification->markAsRead();
        }

        return view('notifications.show', compact('notification'));
    }

    public function markAsRead(Notification $notification)
    {
        $notification->markAsRead();

        return back()->with('success', 'Notification marked as read');
    }

    public function markAsUnread(Notification $notification)
    {
        $notification->markAsUnread();

        return back()->with('success', 'Notification marked as unread');
    }

    public function markAllAsRead()
    {
        Auth::user()
            ->notifications()
            ->unread()
            ->update(['read_at' => now()]);

        return back()->with('success', 'All notifications marked as read');
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();

        return back()->with('success', 'Notification deleted');
    }
}