<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TikTokAdsService
{
    public function getSummary()
    {
        try {
            $endpoint = config('services.tiktok_ads.endpoint');
            $apiKey = config('services.tiktok_ads.api_key');

            if (!$endpoint || !$apiKey) {
                throw new \Exception('TikTok API config missing. Check .env or config/services.php');
            }

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey
            ])->get($endpoint, [
                'metrics' => ['clicks', 'impressions', 'reach', 'conversions', 'cost'],
                'date_range' => 'last_7_days'
            ]);

            if ($response->successful()) {
                return $response->json();
            }

        } catch (\Exception $e) {
            // log optional: \Log::error($e->getMessage());
        }

        return [
            'clicks' => [0],
            'impressions' => [0],
            'reach' => [0],
            'conversions' => [0],
            'cost' => [0],
            'dates' => []
        ];
    }
}
