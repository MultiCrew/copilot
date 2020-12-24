<?php
namespace App\Http\Traits;

use Illuminate\Support\Facades\DB;
use Spatie\WebhookServer\WebhookCall;
use App\Http\Resources\Flights\RequestResource;


trait WebhookTrait {

    /**
     * Call a webhook
     *
     * @param string $url
     * @param string $secret
     * @param string $type
     * @param object $data
     * @return void
     */
    public function requestCall(object $flightRequest, string $type)
    {
        $client = DB::table('oauth_clients')->find($flightRequest->client_id);
        WebhookCall::create()
            ->url($flightRequest->callback)
            ->payload([
                'type' => $type,
                'request' => new RequestResource($flightRequest)
            ])
            ->useSecret($client->secret)
            ->dispatch();
    }
}
