<?php

namespace App\Notifications;

use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use App\Models\Flights\Flight;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

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
            'acceptee' => $this->acceptee->username,
            'plan_id' => $this->flight->plan->id,
            'text' => $this->acceptee->username.' has just accepted your flight plan for your flight from '.$this->flight->departure.' to '.$this->flight->arrival,
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
            'acceptee' => $this->acceptee->username,
            'plan_id' => $this->flight->plan->id,
            'text' => $this->acceptee->username.' has just accepted your flight plan for your flight from '.$this->flight->departure.' to '.$this->flight->arrival,
            'title' => 'Flight Plan Accepted'
        ]);
    }
}
