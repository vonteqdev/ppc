<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleAdsService;
use App\Services\MetaAdsService;
use App\Services\TikTokAdsService;
use App\Services\GA4Service;
use App\Models\Campaign;

class DashboardController extends Controller
{
    public function index()
    {
        $googleAdsData = GoogleAdsService::getSummary();
        $metaAdsData = MetaAdsService::getSummary();
        $tiktokAdsData = TikTokAdsService::getSummary();
        $ga4Data = GA4Service::getSummary();

        $totalSpend = [
            'Google Ads' => $googleAdsData['total_spent'] ?? 0,
            'Meta Ads' => $metaAdsData['total_spent'] ?? 0,
            'TikTok Ads' => $tiktokAdsData['total_spent'] ?? 0,
        ];

        $topCampaigns = Campaign::orderBy('performance_score', 'desc')->limit(5)->get();

        return view('dashboard.overview', compact('totalSpend', 'topCampaigns', 'ga4Data'));
    }
}
