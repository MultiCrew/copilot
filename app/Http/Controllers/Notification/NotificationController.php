<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;

class NotificationController extends Controller
{
    /**
     * Get all unread notifications belonging to a user
     * 
     * @return \Illuminate\Notifications\Notification $notification
     */
    public function notifications()
    {
        return Auth::user()->unreadNotifications()->get()->toArray();
    }

    /**
     * Mark notification as read
     * 
     * @param \Illuminate\Notifications\Notification $notification
     * @return \Illuminate\Http\Response
     */
    public function read(Notification $notification)
    {
        $notification->markAsRead();
    }
}
