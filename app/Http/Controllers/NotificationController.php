<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display a listing of the user's notifications.
     */
    public function index()
    {
        $user = Auth::user();

        // Get all notifications
        $notifications = $user->notifications()->paginate(10);

        // Mark all as read
        $user->unreadNotifications->markAsRead();

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Delete a notification
     */
    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();

        return back()->with('success', 'Értesítés törölve.');
    }
}