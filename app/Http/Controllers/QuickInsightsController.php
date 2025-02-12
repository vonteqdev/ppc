<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\QuickInsightsService;


class QuickInsightsController extends Controller
{
    protected $quickInsightsService;

    public function __construct(QuickInsightsService $quickInsightsService)
    {
        $this->quickInsightsService = $quickInsightsService;
    }

    public function index()
    {
        // Fetch quick insights from the service
        $quickInsights = $this->quickInsightsService->getInsights();

        // Ensure default structure exists to prevent "Undefined Index" errors
        $quickInsights = array_merge([
            'critical' => collect([]),
            'important' => collect([]),
            'good' => collect([])
        ], $quickInsights ?? []);

        // Fetch PPC recommendations (Replace with your actual logic)
        $recommendations = [
            (object) [
                'platform' => 'Google Ads',
                'ad_name' => 'High-CTR Ad',
                'message' => 'Increase budget for this high-performing ad.',
                'recommendation_type' => 'Budget'
            ],
            (object) [
                'platform' => 'Meta Ads',
                'ad_name' => 'Low-Performance Ad',
                'message' => 'Consider pausing this ad due to high cost-per-click.',
                'recommendation_type' => 'Pause'
            ]
        ];

        return view('quick-insights.index', compact('quickInsights', 'recommendations'));
    }


    public function markAsRead($id)
    {
        $this->quickInsightsService->markInsightAsRead($id);
        return response()->json(['status' => 'success']);
    }
}
