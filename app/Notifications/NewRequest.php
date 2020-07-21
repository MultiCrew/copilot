<?php

namespace App\Notifications;

use App\Models\Flights\FlightRequest;
use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewRequest extends Notification
{
    use Queueable;

    protected $requestee;

    protected $flight;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $requestee, FlightRequest $flight)
    {
        $this->requestee = $requestee;
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
            'requestee' => $this->requestee->username,
            'flight' => $this->flight,
            'text' => $this->requestee->username . ' has just created a new flight request involving one of your subscribed airports.',
            'title' => 'New Request',
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
            'acceptee' => $this->requestee->username,
            'flight' => $this->flight,
            'text' => $this->requestee->username . ' has just created a new flight request involving one of your subscribed airports.',
            'title' => 'New Request',
        ]);
    }
}
