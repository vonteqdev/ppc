<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GSCService
{
    protected $endpoint;
    protected $apiKey;

    public function __construct()
    {
        $this->endpoint = config('services.gsc.endpoint');
        $this->apiKey = config('services.gsc.api_key');
    }

    public function getSummary()
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
            ])->get("{$this->endpoint}/searchAnalytics", [
                'dimensions' => ['date'],
                'startDate' => now()->subDays(7)->toDateString(),
                'endDate' => now()->toDateString(),
                'searchType' => 'web'
            ]);

            if ($response->successful()) {
                $data = $response->json()['rows'] ?? [];

                return [
                    'clicks' => collect($data)->sum('clicks'),
                    'impressions' => collect($data)->sum('impressions'),
                    'avg_position' => round(collect($data)->avg('position'), 2),
                    'ctr' => round(collect($data)->avg('ctr') * 100, 2),
                    'dates' => collect($data)->pluck('date')->toArray(),
                    'top_queries' => collect($data)->take(10)->toArray(),
                ];
            }

            return null;
        } catch (\Exception $e) {
            return null;
        }
    }
}
