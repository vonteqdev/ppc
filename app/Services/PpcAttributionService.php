<?php
namespace App\Services;

use App\Models\PpcAttribution;
use Carbon\Carbon;

class PpcAttributionService
{
    public function fetchPpcData()
    {
        // Example data, replace with actual API calls
        $data = [
            ['platform' => 'Google Ads', 'clicks' => 1200, 'conversions' => 60, 'cost' => 500, 'revenue' => 3000],
            ['platform' => 'Meta Ads', 'clicks' => 800, 'conversions' => 30, 'cost' => 350, 'revenue' => 1500],
            ['platform' => 'TikTok Ads', 'clicks' => 400, 'conversions' => 10, 'cost' => 200, 'revenue' => 700],
        ];

        foreach ($data as $entry) {
            PpcAttribution::updateOrCreate(
                ['platform' => $entry['platform'], 'date' => Carbon::today()],
                [
                    'clicks' => $entry['clicks'],
                    'conversions' => $entry['conversions'],
                    'cost' => $entry['cost'],
                    'revenue' => $entry['revenue'],
                    'roas' => ($entry['cost'] > 0) ? round($entry['revenue'] / $entry['cost'], 2) : 0
                ]
            );
        }
    }
}
