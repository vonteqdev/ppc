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
    protected $googleAdsService;
    protected $metaAdsService;
    protected $tiktokAdsService;
    protected $ga4Service;

    public function __construct(
        GoogleAdsService $googleAdsService,
        MetaAdsService $metaAdsService,
        TikTokAdsService $tiktokAdsService,
        GA4Service $ga4Service
    ) {
        $this->googleAdsService = $googleAdsService;
        $this->metaAdsService = $metaAdsService;
        $this->tiktokAdsService = $tiktokAdsService;
        $this->ga4Service = $ga4Service;
    }

    public function index()
    {
        // Ensure Google Ads API data is always structured
        $googleAdsData = $this->googleAdsService->getSummary();
        $googleAdsData = array_merge([
            'dates' => [],
            'clicks' => [],
            'total_spent' => 0
        ], $googleAdsData ?? []);

        $metaAdsData = $this->metaAdsService->getSummary();
        $metaAdsData = array_merge([
            'dates' => [],
            'clicks' => [],
            'total_spent' => 0
        ], $metaAdsData ?? []);

        $tiktokAdsData = $this->tiktokAdsService->getSummary();
        $tiktokAdsData = array_merge([
            'dates' => [],
            'clicks' => [],
            'total_spent' => 0
        ], $tiktokAdsData ?? []);

        $ga4Data = $this->ga4Service->getSummary();
        $ga4Data = array_merge([
            'dates' => [],
            'sessions' => []
        ], $ga4Data ?? []);

        // Default empty campaign data
        $totalSpend = [
            'Google Ads' => $googleAdsData['total_spent'] ?? 0,
            'Meta Ads' => $metaAdsData['total_spent'] ?? 0,
            'TikTok Ads' => $tiktokAdsData['total_spent'] ?? 0,
        ];
        $topCampaigns = [];

        return view('dashboard.overview', compact(
            'googleAdsData',
            'metaAdsData',
            'tiktokAdsData',
            'ga4Data',
            'totalSpend',
            'topCampaigns'
        ));
    }
}
