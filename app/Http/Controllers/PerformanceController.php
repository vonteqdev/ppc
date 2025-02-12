<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleAdsService;
use App\Services\MetaAdsService;
use App\Services\TikTokAdsService;
use App\Services\GA4Service;
use App\Services\GSCService;

class PerformanceController extends Controller
{
    protected $googleAdsService;
    protected $metaAdsService;
    protected $tiktokAdsService;
    protected $ga4Service;
    protected $gscService;

    public function __construct(
        GoogleAdsService $googleAdsService,
        MetaAdsService $metaAdsService,
        TikTokAdsService $tiktokAdsService,
        GA4Service $ga4Service,
        GSCService $gscService
    ) {
        $this->googleAdsService = $googleAdsService;
        $this->metaAdsService = $metaAdsService;
        $this->tiktokAdsService = $tiktokAdsService;
        $this->ga4Service = $ga4Service;
        $this->gscService = $gscService;
    }

    public function googleAds()
    {
        $data = $this->googleAdsService->getSummary();
        return view('performance.google-ads', compact('data'));

    }

    public function metaAds()
{
    $data = $this->metaAdsService->getSummary() ?? [
        'clicks' => 0,
        'impressions' => 0,
        'reach' => 0,
        'spend' => 0,
        'dates' => [],
    ];

    return view('performance.meta-ads', compact('data'));
}


    public function tiktokAds()
    {
        $data = (new TikTokAdsService())->getSummary();
        return view('performance.tiktok-ads', compact('data'));
    }

    public function ga4()
    {
        $rawData = $this->ga4Service->getSummary() ?? [];

        $data = [
            'traffic_trend' => $rawData['traffic_trend'] ?? [],
            'top_pages' => $rawData['top_pages'] ?? [],
        ];

        return view('performance.ga4', compact('data'));
    }

    public function gsc()
    {
        $gscService = new GSCService();

        $rawData = $gscService->getSummary() ?? [
            'clicks' => [],
            'impressions' => [],
            'avg_position' => 0,
            'ctr' => 0,
            'dates' => [],
            'top_queries' => [],
        ];

        // Extract single values if array, otherwise use defaults
        $data = [
            'clicks' => is_array($rawData['clicks']) ? array_values($rawData['clicks']) : [$rawData['clicks']],
            'impressions' => is_array($rawData['impressions']) ? array_values($rawData['impressions']) : [$rawData['impressions']],
            'avg_position' => is_array($rawData['avg_position']) ? ($rawData['avg_position'][0] ?? 0) : $rawData['avg_position'],
            'ctr' => is_array($rawData['ctr']) ? ($rawData['ctr'][0] ?? 0) : $rawData['ctr'],
            'dates' => is_array($rawData['dates']) ? array_values($rawData['dates']) : [$rawData['dates']],
            'top_queries' => $rawData['top_queries'] ?? [],
        ];

        return view('performance.gsc', compact('data'));
    }


}
