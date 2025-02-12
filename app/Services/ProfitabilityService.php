<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductLabel;
use App\Models\LabelingRule;
use Illuminate\Support\Facades\Log;

class ProfitabilityService
{
    public function analyzeProductProfitability()
    {
        $products = Product::all();
        $rules = LabelingRule::all();

        foreach ($products as $product) {
            $productLabels = [];

            foreach ($rules as $rule) {
                if ($this->matchesRule($product, $rule)) {
                    $productLabels[] = $rule->label;
                }
            }

            // Assign most relevant label (e.g., priority order: Hero > Villain > Sidekick > Zombie)
            $finalLabel = $this->determineBestLabel($productLabels);

            ProductLabel::updateOrCreate(
                ['product_id' => $product->id],
                [
                    'label' => $finalLabel,
                    'roas' => $product->revenue > 0 ? round($product->revenue / max(1, $product->ad_spend), 2) : 0,
                    'conversion_rate' => $product->clicks > 0 ? round(($product->conversions / $product->clicks) * 100, 2) : 0,
                    'clicks' => $product->clicks,
                    'impressions' => $product->impressions
                ]
            );
        }

        Log::info("Product profitability analysis completed.");
    }

    /**
     * Check if a product matches a given rule.
     */
    private function matchesRule($product, $rule)
    {
        $value = 0;

        switch ($rule->metric) {
            case 'ROAS':
                $value = $product->revenue > 0 ? round($product->revenue / max(1, $product->ad_spend), 2) : 0;
                break;
            case 'Conversion Rate':
                $value = $product->clicks > 0 ? round(($product->conversions / $product->clicks) * 100, 2) : 0;
                break;
            case 'Clicks':
                $value = $product->clicks;
                break;
            case 'Impressions':
                $value = $product->impressions;
                break;
        }

        // Apply condition dynamically
        switch ($rule->condition) {
            case '>':
                return $value > $rule->value;
            case '<':
                return $value < $rule->value;
            case '=':
                return $value == $rule->value;
        }

        return false;
    }

    /**
     * Determine the most relevant label for a product based on priority.
     */
    private function determineBestLabel($labels)
    {
        $priority = ['Hero', 'Villain', 'Sidekick', 'Zombie'];
        foreach ($priority as $label) {
            if (in_array($label, $labels)) {
                return $label;
            }
        }
        return 'Neutral';
    }
}
