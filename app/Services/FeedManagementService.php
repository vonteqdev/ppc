<?php
namespace App\Services;

use App\Models\FeedImport;
use App\Models\FeedExport;
use App\Models\Product;
use App\Models\ProductLabel;
use App\Models\PpcAttribution;
use App\Models\FeedErrorLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;
use Illuminate\Support\Facades\View;

class FeedManagementService
{

    public function assignLabels()
    {
        $products = Product::all();

        foreach ($products as $product) {
            $this->assignRevenueLabel($product);
            $this->assignRoasLabel($product);
            $this->assignTrendLabel($product);
            $this->assignPriceRangeLabel($product);
            $this->assignGoogleClicksLabel($product);
            $this->assignConversionRateLabel($product);
            $this->assignBenchmarkLabel($product);
            $this->assignNewProductsLabel($product);
            $this->assignPromotedLabel($product);
            $this->assignCartLabel($product);
        }
    }

    private function assignRevenueLabel(Product $product)
    {
        $revenue = $product->orders()->sum('total_price');

        if ($revenue > 5000) {
            $this->updateLabel($product, 'High Revenue');
        } elseif ($revenue > 1000) {
            $this->updateLabel($product, 'Medium Revenue');
        } else {
            $this->updateLabel($product, 'Low Revenue');
        }
    }

    private function assignRoasLabel(Product $product)
    {
        $ppcData = PpcAttribution::where('product_id', $product->id)->first();

        if ($ppcData) {
            if ($ppcData->roas > 5) {
                $this->updateLabel($product, 'High ROAS');
            } elseif ($ppcData->roas > 2) {
                $this->updateLabel($product, 'Medium ROAS');
            } else {
                $this->updateLabel($product, 'Low ROAS');
            }
        }
    }

    private function assignTrendLabel(Product $product)
    {
        $last30DaysRevenue = $product->orders()->where('created_at', '>=', now()->subDays(30))->sum('total_price');
        $previous30DaysRevenue = $product->orders()->whereBetween('created_at', [now()->subDays(60), now()->subDays(30)])->sum('total_price');

        if ($last30DaysRevenue > $previous30DaysRevenue) {
            $this->updateLabel($product, 'Trending Up');
        } elseif ($last30DaysRevenue < $previous30DaysRevenue) {
            $this->updateLabel($product, 'Trending Down');
        } else {
            $this->updateLabel($product, 'Stable Trend');
        }
    }

    private function assignPriceRangeLabel(Product $product)
    {
        if ($product->price >= 1000) {
            $this->updateLabel($product, 'Premium Product');
        } elseif ($product->price >= 500) {
            $this->updateLabel($product, 'Mid-Range Product');
        } else {
            $this->updateLabel($product, 'Budget Product');
        }
    }

    private function assignGoogleClicksLabel(Product $product)
    {
        $ppcData = PpcAttribution::where('product_id', $product->id)->first();

        if ($ppcData) {
            if ($ppcData->clicks > 1000) {
                $this->updateLabel($product, 'High Clicks');
            } elseif ($ppcData->clicks > 500) {
                $this->updateLabel($product, 'Medium Clicks');
            } else {
                $this->updateLabel($product, 'Low Clicks');
            }
        }
    }

    private function assignConversionRateLabel(Product $product)
    {
        $conversionRate = $product->orders()->count() / max(1, $product->views);

        if ($conversionRate >= 0.05) {
            $this->updateLabel($product, 'High Conversion Rate');
        } elseif ($conversionRate >= 0.02) {
            $this->updateLabel($product, 'Medium Conversion Rate');
        } else {
            $this->updateLabel($product, 'Low Conversion Rate');
        }
    }

    private function assignBenchmarkLabel(Product $product)
    {
        // Placeholder logic: Compare against industry benchmark
        $industryAveragePrice = 1000;
        if ($product->price < $industryAveragePrice) {
            $this->updateLabel($product, 'Underpriced');
        } elseif ($product->price > $industryAveragePrice) {
            $this->updateLabel($product, 'Overpriced');
        } else {
            $this->updateLabel($product, 'Competitive Pricing');
        }
    }

    private function assignNewProductsLabel(Product $product)
    {
        if ($product->created_at >= now()->subDays(30)) {
            $this->updateLabel($product, 'New Product');
        }
    }

    private function assignPromotedLabel(Product $product)
    {
        $adSpend = PpcAttribution::where('product_id', $product->id)->sum('cost');

        if ($adSpend > 1000) {
            $this->updateLabel($product, 'Highly Promoted');
        }
    }

    private function assignCartLabel(Product $product)
    {
        $cartAdds = $product->cartLogs()->count();
        $purchases = $product->orders()->count();

        if ($cartAdds > 10 && $purchases < 3) {
            $this->updateLabel($product, 'High Cart Abandonment');
        }
    }

    private function updateLabel(Product $product, $label)
    {
        ProductLabel::updateOrCreate(
            ['product_id' => $product->id, 'label' => $label]
        );
    }

    /**
     * Validate the feed format (XML/CSV).
     */
    public function validateFeed($source, $type)
    {
        try {
            if ($type == 'xml') {
                $xmlContent = file_get_contents($source);
                new SimpleXMLElement($xmlContent);
            } elseif ($type == 'csv') {
                $csvData = file_get_contents($source);
                if (!str_contains($csvData, ',')) {
                    return false;
                }
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Auto-fetch feeds based on frequency (hourly, daily, weekly).
     */
    public function fetchScheduledFeeds()
    {
        Log::info("Starting scheduled feed fetch...");
        $feeds = FeedImport::all();
        $now = Carbon::now();

        foreach ($feeds as $feed) {
            if ($this->shouldFetch($feed, $now)) {
                Log::info("Fetching feed: " . $feed->name);

                // Simulating feed update
                $feed->last_fetched_at = $now;
                $feed->save();

                Log::info("Successfully updated: " . $feed->name);
            }
        }

        Log::info("Feed fetching completed.");
    }

    /**
     * Determine if the feed should be updated based on frequency.
     */
    private function shouldFetch($feed, $now)
    {
        if (!$feed->last_fetched_at) {
            return true;
        }

        $lastFetched = Carbon::parse($feed->last_fetched_at);

        switch ($feed->frequency) {
            case 'hourly':
                return $lastFetched->diffInHours($now) >= 1;
            case 'daily':
                return $lastFetched->diffInDays($now) >= 1;
            case 'weekly':
                return $lastFetched->diffInDays($now) >= 7;
            default:
                return false;
        }
    }

    /**
     * Apply filters to product feed before exporting.
     */
    public function applyFilters($feed)
    {
        $query = Product::query();

        if (!empty($feed->filters)) {
            $filters = json_decode($feed->filters, true);

            foreach ($filters as $filter) {
                if ($filter['field'] == 'label') {
                    $query->whereHas('labels', function ($q) use ($filter) {
                        $q->where('label', $filter['value']);
                    });
                } else {
                    $query->where($filter['field'], $filter['operator'], $filter['value']);
                }
            }
        }

        return $query->get();
    }

    /**
     * Generate Feed Export with Product Labels & Custom Filtering.
     */
    public function generateExportFeed($platform)
    {
        $feed = FeedExport::where('platform', $platform)->firstOrFail();

        // Cache the results for faster performance
        $products = Cache::remember("export_feed_{$platform}", 600, function () use ($feed) {
            return $this->applyFilters($feed);
        });

        // Preload labels for all products in a single query
        $productLabels = ProductLabel::whereIn('product_id', $products->pluck('id'))
            ->get()
            ->groupBy('product_id');

        foreach ($products as $product) {
            $product->labels = $productLabels[$product->id]->pluck('label')->toArray() ?? [];
        }

        return View::make('feed-management.export-template', compact('products'))->render();
    }

    /**
     * Log Errors Related to Feed Processing.
     */
    public function logError($feedName, $message)
    {
        FeedErrorLog::create([
            'feed_name' => $feedName,
            'error_message' => $message,
            'logged_at' => now(),
        ]);
    }
}


