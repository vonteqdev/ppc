<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleAdsService;
use App\Services\MetaAdsService;
use App\Services\TikTokAdsService;

class BudgetMonitoringController extends Controller
{
    public function index()
    {
        $spendingData = [
            'Google Ads' => GoogleAdsService::getSummary()['total_spent'] ?? 0,
            'Meta Ads' => MetaAdsService::getSummary()['total_spent'] ?? 0,
            'TikTok Ads' => TikTokAdsService::getSummary()['total_spent'] ?? 0,
        ];

        return view('budget-monitoring.index', compact('spendingData'));
    }
}
