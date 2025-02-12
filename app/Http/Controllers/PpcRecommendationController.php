<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PpcRecommendationService;
use App\Models\PpcRecommendation;

class PpcRecommendationController extends Controller
{
    protected $recommendationService;

    public function __construct(PpcRecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    public function index()
    {
        $this->recommendationService->generateRecommendations();
        $recommendations = PpcRecommendation::latest()->get();
        return view('quick-insights.index', compact('recommendations'));
    }
}
