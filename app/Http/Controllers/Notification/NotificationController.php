<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Notifications\Notification;

class NotificationController extends Controller
{
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
