<?php
namespace App\Channels;
use GuzzleHttp\Client;
use Illuminate\Log\Logger;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
class WebhookChannel
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Client $client, Logger $logger)
    {
        $this->client = $client;
        $this->logger = $logger;
    }

    /**
     * @param Notifiable $notifiable
     * @param Notification $notification
     * @throws WebHookFailedException
     */
    public function send($notifiable, Notification $notification)
    {
		$endpoint = "http://10.0.2.2:3000";
		$client = new \GuzzleHttp\Client();
		$response = $client->request('POST', $endpoint, 
		['body' => $data]);
		return ($response->getBody()->getContents());

    }
}