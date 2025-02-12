<?php
namespace App\Services;

use App\Models\PpcAttribution;

class BudgetForecastingService
{
    public function analyzeSpendingTrends()
    {
        $data = PpcAttribution::whereDate('date', '>=', now()->subDays(60))
            ->groupBy('platform')
            ->selectRaw('platform, SUM(cost) as total_cost, SUM(revenue) as total_revenue')
            ->get();

        $budgetSuggestions = [];
        foreach ($data as $platform) {
            $roas = ($platform->total_revenue > 0) ? ($platform->total_revenue / max($platform->total_cost, 1)) : 0;
            if ($roas < 1) {
                $budgetSuggestions[$platform->platform] = "Reduce budget";
            } else {
                $budgetSuggestions[$platform->platform] = "Increase budget";
            }
        }

        return $budgetSuggestions;
    }
}
