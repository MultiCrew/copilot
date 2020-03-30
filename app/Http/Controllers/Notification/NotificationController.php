<?php

namespace App\Http\Controllers\Notification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users\UserNotification;
use App\Rules\RequiredNotification;
use Illuminate\Support\Facades\Auth;

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
     * @param string id
     * @return \Illuminate\Http\Response
     */
    public function read(string $id)
    {
        $notification = auth()->user()->notifications()->find($id);
        $notification->markAsRead();
    }

    /**
     * Update Notifications
     * @param \Illuminate\Http\Request $request
     */
    public function update(Request $request)
    {
        $request->validate([
            'request_accepted' => 'required'
        ]);

        $userNotification = UserNotification::where('user_id', Auth::id())->first();
        
        $userNotification->request_accepted = $request->request_accepted ? 1 : 0;
        $userNotification->request_accepted_email = $request->request_accepted_email ? 1 : 0;
        $userNotification->request_accepted_push = $request->request_accepted_push ? 1 : 0;

        $userNotification->plan_reviewed = $request->plan_reviewed ? 1 : 0;
        $userNotification->plan_reviewed_email = $request->plan_reviewed_email ? 1 : 0;
        $userNotification->plan_reviewed_push = $request->plan_reviewed_push ? 1 : 0;

        $userNotification->save();

        return;
    }
}
