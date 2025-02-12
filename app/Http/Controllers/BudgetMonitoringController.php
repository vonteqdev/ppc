<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleAdsService;
use App\Services\MetaAdsService;
use App\Services\TikTokAdsService;
use App\Models\PpcAttribution;

class BudgetMonitoringController extends Controller
{
    protected $googleAdsService;
    protected $metaAdsService;
    protected $tiktokAdsService;

    public function __construct(
        GoogleAdsService $googleAdsService,
        MetaAdsService $metaAdsService,
        TikTokAdsService $tiktokAdsService
    ) {
        $this->googleAdsService = $googleAdsService;
        $this->metaAdsService = $metaAdsService;
        $this->tiktokAdsService = $tiktokAdsService;
    }

    public function index()
    {
        // Fetch budget summaries and ensure they return arrays
        $googleAdsBudget = $this->googleAdsService->getSummary() ?? [];
        $metaAdsBudget = $this->metaAdsService->getSummary() ?? [];
        $tiktokAdsBudget = $this->tiktokAdsService->getSummary() ?? [];

        // Ensure all keys exist to prevent errors in Blade
        $googleAdsBudget = array_merge([
            'budget' => 0,  // ✅ Ensure "budget" key is always set
            'spent' => 0,
            'remaining' => 0,
            'percentage' => 0,
        ], $googleAdsBudget);

        $metaAdsBudget = array_merge([
            'budget' => 0,  // ✅ Ensure "budget" key is always set
            'spent' => 0,
            'remaining' => 0,
            'percentage' => 0,
        ], $metaAdsBudget);

        $tiktokAdsBudget = array_merge([
            'budget' => 0,  // ✅ Ensure "budget" key is always set
            'spent' => 0,
            'remaining' => 0,
            'percentage' => 0,
        ], $tiktokAdsBudget);

        // Safely calculate total budget and spend
        $totalBudget = $googleAdsBudget['budget'] + $metaAdsBudget['budget'] + $tiktokAdsBudget['budget'];
        $totalSpent = $googleAdsBudget['spent'] + $metaAdsBudget['spent'] + $tiktokAdsBudget['spent'];
        $totalPercentage = $totalBudget > 0 ? ($totalSpent / $totalBudget) * 100 : 0;

        // Fetch budget trends
        $budgetTrends = PpcAttribution::selectRaw("DATE(date) as day, SUM(cost) as total_spent")
            ->groupBy('day')
            ->orderBy('day', 'asc')
            ->get();

        // Placeholder budget suggestions
        $budgetSuggestions = [
            'Google Ads' => 'Increase budget for high ROAS campaigns',
            'Meta Ads' => 'Reduce spend on underperforming ads',
            'TikTok Ads' => 'Optimize targeting for better engagement',
        ];

        return view('budget-monitoring.index', compact(
            'googleAdsBudget', 'metaAdsBudget', 'tiktokAdsBudget',
            'totalBudget', 'totalSpent', 'totalPercentage', 'budgetTrends', 'budgetSuggestions'
        ));
    }



}

