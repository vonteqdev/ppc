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
        $googleAdsBudget = GoogleAdsService::getBudgetSummary();
        $metaAdsBudget = MetaAdsService::getBudgetSummary();
        $tiktokAdsBudget = TikTokAdsService::getBudgetSummary();

        $totalBudget = $googleAdsBudget['budget'] + $metaAdsBudget['budget'] + $tiktokAdsBudget['budget'];
        $totalSpent = $googleAdsBudget['spent'] + $metaAdsBudget['spent'] + $tiktokAdsBudget['spent'];
        $totalPercentage = $totalBudget > 0 ? ($totalSpent / $totalBudget) * 100 : 0;

        return view('budget-monitoring.index', compact(
            'googleAdsBudget', 'metaAdsBudget', 'tiktokAdsBudget',
            'totalBudget', 'totalSpent', 'totalPercentage'
        ));
    }
}
