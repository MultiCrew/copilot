<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'role:user']);
    }

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
     * @param string id
     * @return \Illuminate\Http\Response
     */
    public function read(string $id)
    {
        $notification = auth()->user()->notifications()->find($id);
        $notification->markAsRead();
    }
}
