<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoogleAdsService
{
    protected $apiUrl;
    protected $apiKey;
    protected $customerId;

    public function __construct()
    {
        $this->apiUrl = rtrim(config('services.google_ads.api_endpoint'), '/');
        $this->apiKey = config('services.google_ads.api_key');
        $this->customerId = config('services.google_ads.customer_id');
    }

    public function getSummary()
    {
        if (!$this->customerId) {
            \Log::error("Google Ads API: Missing customer ID.");
            return $this->defaultSummary();
        }

        $url = "{$this->apiUrl}/v13/customers/{$this->customerId}/googleAds:search";

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Accept' => 'application/json',
            ])->get($url);

            if ($response->successful()) {
                return $response->json();
            }

            \Log::error("Google Ads API Error: " . $response->body());
            return $this->defaultSummary();
        } catch (\Exception $e) {
            \Log::error("Google Ads API Exception: " . $e->getMessage());
            return $this->defaultSummary();
        }
    }

    private function defaultSummary()
    {
        return [
            'total_budget' => 0,
            'spent' => 0,
            'remaining' => 0,
            'percentage_spent' => 0,
        ];
    }
}
