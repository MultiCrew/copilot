<?php

namespace App\Notifications;

use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use App\Models\Flights\Flight;
use App\Models\Users\UserNotification;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;

class RequestAccepted extends Notification
{
    use Queueable;

    protected $acceptee;

    protected $flight;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $acceptee, Flight $flight)
    {
        $this->acceptee = $acceptee;
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

        if($userNotifications->request_accepted) {
            array_push($channels, 'database', 'broadcast');
            
            if($userNotifications->request_accepted_push) {
                array_push($channels, 'webhook');
            }
    
            if($userNotifications->request_accepted_email) {
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
            'acceptee' => $this->acceptee->username,
            'flight' => $this->flight,
            'text' => $this->acceptee->username.' has just accepted your flight request from '.$this->flight->departure.' to '.$this->flight->arrival,
            'title' => 'Request Accepted'
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
            'acceptee' => $this->acceptee->username,
            'flight' => $this->flight,
            'text' => $this->acceptee->username.' has just accepted your flight request from '.$this->flight->departure.' to '.$this->flight->arrival,
            'title' => 'Request Accepted'
        ]);
    }
}
