<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

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
    public function toArray($notifiable)
    {
        return [
            'id' => $this->id,
            'read_at' => null,
            'data' => [
                'user_name' => $this->acceptee->username,
                'flight' => $this->flight,
            ],
        ];
    }
}
