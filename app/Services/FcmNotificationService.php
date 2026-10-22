<?php

namespace App\Services;

use App\Models\FcmToken;
use GuzzleHttp\Client;

class FcmNotificationService
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://fcm.googleapis.com/',
            'timeout' => 5,
        ]);
    }

    public function sendToUserIds(array $userIds, string $title, string $body, array $data = []): void
    {
        $serverKey = config('services.fcm.server_key');

        if (! $serverKey) {
            return; // Not configured
        }

        $tokens = FcmToken::whereIn('user_id', $userIds)
            ->pluck('token')
            ->all();

        if (empty($tokens)) {
            return;
        }

        $payload = [
            'registration_ids' => $tokens,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
            'data' => $data,
        ];

        $this->client->post('fcm/send', [
            'headers' => [
                'Authorization' => 'key='.$serverKey,
                'Content-Type' => 'application/json',
            ],
            'json' => $payload,
        ]);
    }
}

