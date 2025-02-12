<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MetaAdsService
{
    protected $endpoint;
    protected $apiKey;

    public function __construct()
    {
        $this->endpoint = config('services.meta_ads.endpoint');
        $this->apiKey = config('services.meta_ads.api_key');
    }

    public function getSummary()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
            ])->get("{$this->endpoint}/insights", [
                'fields' => 'clicks,impressions,spend,reach',
                'date_preset' => 'last_7_days'
            ]);

            if ($response->successful()) {
                $data = $response->json()['data'][0] ?? [];

                return [
                    'clicks' => $data['clicks'] ?? 0,
                    'impressions' => $data['impressions'] ?? 0,
                    'reach' => $data['reach'] ?? 0,
                    'spend' => $data['spend'] ?? 0,
                    'dates' => array_keys($data),
                ];
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}

