<?php

namespace App\Http\Controllers\Notification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users\UserNotification;
use App\Rules\RequiredNotification;
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

    /**
     * Update Notifications
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'request_accepted_email' => [new RequiredNotification],
            'request_accepted_push' => [new RequiredNotification],
            'plan_reviewed_email' => [new RequiredNotification],
            'plan_reviewed_push' => [new RequiredNotification],
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

    /**
     * Update the new request airports
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function airport(Request $request) 
    {
        if($request->ajax()) {
            $userNotification = UserNotification::where('user_id', Auth::id())->first();

            $new_request = $userNotification->new_request;
            $new_request['airports'] = $request->data;
            $userNotification->new_request = $new_request; 

            $userNotification->save();

            return;
        }
	}
	
	/**
     * Update the new request aircrafts
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function aircraft(Request $request) 
    {
        if($request->ajax()) {
            $userNotification = UserNotification::where('user_id', Auth::id())->first();

            $new_request = $userNotification->new_request;
            $new_request['aircrafts'] = $request->data;
            $userNotification->new_request = $new_request; 

            $userNotification->save();

            return;
        }
    }
}
