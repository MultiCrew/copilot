<?php

namespace App\Notifications;

use App\Models\Users\User;
use Illuminate\Bus\Queueable;
use App\Channels\WebhookChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewBetaApplication extends Notification
{
    use Queueable;

    // the user who created the application
    protected $user;

    // the beta application (to use for a url)
    protected $application;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, $application)
    {
        $this->user = $user;
        $this->application = $application;
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
            'type' => 'beta_notification',
            'message' => $this->user->username . ' has just created a Beta Application. Click here to view the application: ' . route('admin.applications.show', $this->application),
        ];
    }
}
