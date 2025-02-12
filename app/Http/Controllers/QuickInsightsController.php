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

        return view('quick-insights.index', compact('quickInsights'));
    }

    public function markAsRead($id)
    {
        $this->quickInsightsService->markInsightAsRead($id);
        return response()->json(['status' => 'success']);
    }
}
