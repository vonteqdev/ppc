<?php

namespace App\Services;

use GuzzleHttp\Client;

class GSCService
{
    public static function getSummary()
    {
        $client = new Client();
        $response = $client->request('GET', env('GSC_API_ENDPOINT'), [
            'headers' => [
                'Authorization' => 'Bearer ' . env('GSC_API_KEY'),
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
