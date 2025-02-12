<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductLabel;
use App\Services\ProfitabilityService;

class ProfitabilityController extends Controller
{
    protected $profitabilityService;

    public function __construct(ProfitabilityService $profitabilityService)
    {
        $this->profitabilityService = $profitabilityService;
    }

    public function index()
    {
        $labels = ProductLabel::all();
        return view('profitability.index', compact('labels'));
    }

    public function analyze()
    {
        $this->profitabilityService->analyzeProductProfitability();
        return redirect()->route('profitability.index')->with('success', 'Profitability Analysis Completed.');
    }
}
