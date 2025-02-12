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
    public function googleAds()
    {
        $data = GoogleAdsService::getSummary();
        return view('performance.google-ads', compact('data'));
    }

    public function metaAds()
    {
        $data = MetaAdsService::getSummary();
        return view('performance.meta-ads', compact('data'));
    }

    public function tiktokAds()
    {
        $data = TikTokAdsService::getSummary();
        return view('performance.tiktok-ads', compact('data'));
    }

    public function ga4()
    {
        $data = GA4Service::getSummary();
        return view('performance.ga4', compact('data'));
    }

    public function gsc()
    {
        $data = GSCService::getSummary();
        return view('performance.gsc', compact('data'));
    }
}
