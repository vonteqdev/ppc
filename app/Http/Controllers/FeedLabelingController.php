<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductLabel;
use App\Services\ProfitabilityService;

class FeedLabelingController extends Controller
{
    protected $profitabilityService;

    public function __construct(ProfitabilityService $profitabilityService)
    {
        $this->profitabilityService = $profitabilityService;
    }

    public function index()
    {
        $labels = ProductLabel::all();
        return view('feed-management.labeling-dashboard', compact('labels'));
    }

    public function analyze()
    {
        $this->profitabilityService->analyzeProductProfitability();
        return redirect()->route('feed-management.labeling-dashboard')->with('success', 'Profitability Analysis Completed.');
    }
}
