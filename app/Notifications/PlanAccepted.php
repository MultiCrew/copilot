<?php

namespace App\Notifications;

use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use App\Models\Flights\Flight;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class PlanAccepted extends Notification
{
    use Queueable;

    protected $flight;

    protected $user;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, Flight $flight)
    {
        $this->user = $user;
        $this->flight = $flight;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $userNotifications = UserNotification::where('user_id', $this->user->id)->first();
        
        $channels = [];

        if($userNotifications->plan_reviewed) {
            array_push($channels, 'database', 'broadcast');
            
            if($userNotifications->plan_reviewed_push) {
                array_push($channels, 'webhook');
            }
    
            if($userNotifications->plan_reviewed_email) {
                array_push($channels, 'email');
            }
        }

        return $channels;
    }

    /**
     * Get the database representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'user' => $this->user->username,
            'plan_id' => $this->flight->plan->id,
            'text' => $this->user->username.' has just accepted your flight plan for your flight from '.$this->flight->departure.' to '.$this->flight->arrival,
            'title' => 'Flight Plan Accepted'
        ];
    }

    /**
     * Broadcast the notification
     * 
     * @param mixed $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'user' => $this->user->username,
            'plan_id' => $this->flight->plan->id,
            'text' => $this->user->username.' has just accepted your flight plan for your flight from '.$this->flight->departure.' to '.$this->flight->arrival,
            'title' => 'Flight Plan Accepted'
        ]);
    }
}
