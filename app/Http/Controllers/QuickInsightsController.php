<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuickInsight;

class QuickInsightsController extends Controller
{
    public function index()
    {
        $quickInsights = [
            'critical' => QuickInsight::where('importance', 'critical')->get(),
            'important' => QuickInsight::where('importance', 'important')->get(),
            'good' => QuickInsight::where('importance', 'good')->get(),
        ];

        return view('quick-insights.index', compact('quickInsights'));
    }
}
