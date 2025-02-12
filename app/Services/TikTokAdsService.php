<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TikTokAdsService
{
    public function getSummary()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('TIKTOK_ADS_API_KEY')
            ])->get(env('TIKTOK_ADS_API_ENDPOINT'), [
                'metrics' => ['clicks', 'impressions', 'reach', 'conversions', 'cost'],
                'date_range' => 'last_7_days'
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return [
                'clicks' => [0],
                'impressions' => [0],
                'reach' => [0],
                'conversions' => [0],
                'cost' => [0],
                'dates' => []
            ];
        } catch (\Exception $e) {
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
}
