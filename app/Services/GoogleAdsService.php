<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class GoogleAdsService
{
    public static function getSummary()
    {
        $apiUrl = env('GOOGLE_ADS_API_ENDPOINT');
        $apiKey = env('GOOGLE_ADS_API_KEY');

        if (!$apiUrl || !is_string($apiUrl)) {
            return ['error' => 'Invalid or missing API URL'];
        }

        $client = new Client();

        try {
            $response = $client->request('GET', $apiUrl, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Accept' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            return ['error' => 'API request failed: ' . $e->getMessage()];
        }
    }
}
