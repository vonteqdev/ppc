<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleAdsService;

class GoogleAdsController extends Controller
{
    protected $googleAdsService;

    public function __construct(GoogleAdsService $googleAdsService)
    {
        $this->googleAdsService = $googleAdsService;
    }

    public function index()
    {
        // Ensure budget summary is initialized properly
        $budgetSummary = $this->googleAdsService->getSummary() ?? [
            'total_budget' => 0,
            'spent' => 0,
            'remaining' => 0,
            'percentage_spent' => 0
        ];

        return view('performance.google-ads', compact('budgetSummary'));
    }
}
