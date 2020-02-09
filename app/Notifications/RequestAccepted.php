<?php

namespace App\Notifications;

use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use App\Models\Flights\Flight;
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
        return ['database', 'broadcast'];
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
            'acceptee' => $this->acceptee,
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
            'acceptee' => $this->acceptee,
            'flight' => $this->flight,
            'text' => $this->acceptee->username.' has just accepted your flight request from '.$this->flight->departure.' to '.$this->flight->arrival,
            'title' => 'Request Accepted'
        ]);
    }
}
