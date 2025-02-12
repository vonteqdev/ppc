<?php
namespace App\Services;

use App\Models\PpcRecommendation;
use App\Models\PpcAttribution;
use Illuminate\Support\Facades\Log;

class PpcRecommendationService
{
    public function generateRecommendations()
    {
        $ppcData = PpcAttribution::latest()->take(50)->get(); // Fetch last 50 campaigns
        $recommendations = [];

        foreach ($ppcData as $campaign) {
            if ($campaign->roas < 1) {
                $recommendations[] = PpcRecommendation::create([
                    'platform' => $campaign->platform,
                    'ad_name' => $campaign->campaign_name,
                    'recommendation_type' => 'Pause Ad',
                    'message' => "Low ROAS detected ({$campaign->roas}). Consider pausing this ad."
                ]);
            } elseif ($campaign->roas > 5) {
                $recommendations[] = PpcRecommendation::create([
                    'platform' => $campaign->platform,
                    'ad_name' => $campaign->campaign_name,
                    'recommendation_type' => 'Increase Budget',
                    'message' => "High ROAS detected ({$campaign->roas}). Consider increasing budget."
                ]);
            }
        }

        Log::info("PPC Recommendations Generated: " . count($recommendations));
        return $recommendations;
    }
}
