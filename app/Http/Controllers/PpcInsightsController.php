<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PpcAttribution;
use App\Services\PpcAttributionService;

class PpcInsightsController extends Controller
{
    protected $ppcAttributionService;

    public function __construct(PpcAttributionService $ppcAttributionService)
    {
        $this->ppcAttributionService = $ppcAttributionService;
    }

    public function index()
    {
        $data = PpcAttribution::orderBy('date', 'desc')->get();
        return view('ppc-insights.index', compact('data')); // ✅ Ensure this matches the view path
    }

    public function fetch()
    {
        $this->ppcAttributionService->fetchPpcData();
        return redirect()->route('ppc-insights.index')->with('success', 'PPC data updated.');
    }
}
