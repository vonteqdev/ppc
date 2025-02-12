<?php

namespace App\Services;

use App\Models\QuickInsight;

class QuickInsightsService
{
    public function getInsights()
    {
        return [
            'critical' => QuickInsight::where('importance', 'critical')->get(),
            'important' => QuickInsight::where('importance', 'important')->get(),
            'good' => QuickInsight::where('importance', 'good')->get(),
        ];
    }

    public function markInsightAsRead($id)
    {
        $insight = QuickInsight::find($id);
        if ($insight) {
            $insight->update(['read' => true]);
        }
    }
}
