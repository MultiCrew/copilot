<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Channels\WebhookChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class DiscordSendData extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $message;

    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $optional;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($type, $message, $user, $optional=null)
    {
        $this->type = $type;
        $this->message = $message;
        $this->user = $user;
        $this->optional = $optional;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WebhookChannel::class];
    }

    /**
     * Get the webhook representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\DiscordSendData
     */
    public function toWebhook($notifiable)
    {
        return [
            'type' => $this->type,
            'message' => $this->message,
            'id' => $this->user->discord_id,
            'optional' => $this->optional,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
