<?php
namespace App\Services;

use App\Models\PpcAttribution;
use App\Models\Product;

class ProductLabelingService
{
    public function assignLabels()
    {
        $products = Product::all();

        foreach ($products as $product) {
            $roas = $product->roas;
            $margin = $product->profit_margin;
            $clicks = $product->clicks;
            $views = $product->views;
            $addedToCart = $product->added_to_cart;

            // ROAS Labels
            if ($roas > 5) {
                $this->addLabel($product->id, 'High ROAS');
            } elseif ($roas > 2) {
                $this->addLabel($product->id, 'Medium ROAS');
            } else {
                $this->addLabel($product->id, 'Low ROAS');
            }

            // Profit Margin Labels
            if ($margin > 30) {
                $this->addLabel($product->id, 'High Profit Margin');
            } elseif ($margin > 15) {
                $this->addLabel($product->id, 'Medium Profit Margin');
            } else {
                $this->addLabel($product->id, 'Low Profit Margin');
            }

            // Trend Labels
            if ($views > 1000) {
                $this->addLabel($product->id, 'Trending Product');
            }

            // Cart Behavior Labels
            if ($addedToCart > 50 && $roas < 1) {
                $this->addLabel($product->id, 'Abandoned Cart Product');
            }
        }
    }

    private function addLabel($productId, $labelName)
    {
        ProductLabel::updateOrCreate(
            ['product_id' => $productId, 'label' => $labelName],
            ['updated_at' => now()]
        );
    }

    private function calculateTrends($product)
    {
        $past30Days = PpcAttribution::where('product_id', $product->id)
            ->whereDate('date', '>=', now()->subDays(30))->sum('revenue');
        $past60Days = PpcAttribution::where('product_id', $product->id)
            ->whereDate('date', '>=', now()->subDays(60))->sum('revenue');

        if ($past30Days > $past60Days * 1.2) {
            $product->labels()->updateOrCreate(['label' => 'Uptrend']);
        } elseif ($past30Days < $past60Days * 0.8) {
            $product->labels()->updateOrCreate(['label' => 'Downtrend']);
        }
    }

    private function assignPriceRange($product)
    {
        $priceRanges = [
            '0-50' => ['min' => 0, 'max' => 50],
            '51-100' => ['min' => 51, 'max' => 100],
            '101-250' => ['min' => 101, 'max' => 250],
            '251-500' => ['min' => 251, 'max' => 500],
            '500+' => ['min' => 501, 'max' => 10000],
        ];

        foreach ($priceRanges as $range => $limits) {
            if ($product->price >= $limits['min'] && $product->price <= $limits['max']) {
                $product->update(['price_range' => $range]);
            }
        }
    }
}
