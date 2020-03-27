<?php

namespace App\Http\Controllers\Notification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users\UserNotification;
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
        $userNotification = UserNotification::where('user_id', Auth::id())->first();
        
        $userNotification->request_accepted = $request->requestAccepted ? 1 : 0;
        $userNotification->request_accepted_email = $request->requestAcceptedEmail ? 1 : 0;
        $userNotification->request_accepted_push = $request->requestAcceptedPush ? 1 : 0;

        $userNotification->plan_reviewed = $request->planReviewed ? 1 : 0;
        $userNotification->plan_reviewed_email = $request->planReviewedEmail ? 1 : 0;
        $userNotification->plan_reviewed_push = $request->planReviewedPush ? 1 : 0;

        $userNotification->save();

        return redirect()->back();
    }
}
