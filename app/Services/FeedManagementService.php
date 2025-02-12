<?php
namespace App\Services;

use App\Models\FeedImport;
use App\Models\FeedExport;
use App\Models\Product;
use App\Models\ProductLabel;
use App\Models\FeedErrorLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use SimpleXMLElement;
use Illuminate\Support\Facades\View;

class FeedManagementService
{
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
        $products = Product::all()->toArray();

        if ($feed->filters) {
            $filters = json_decode($feed->filters, true);
            foreach ($filters as $filter) {
                $products = array_filter($products, function ($product) use ($filter) {
                    return eval("return {$product[$filter['field']]} {$filter['operator']} {$filter['value']};");
                });
            }
        }

        return $products;
    }

    /**
     * Generate Feed Export with Product Labels & Custom Filtering.
     */
    public function generateExportFeed($platform)
    {
        $feed = FeedExport::where('platform', $platform)->firstOrFail();
        $products = Product::all();

        // Add product labels from profitability analysis
        foreach ($products as $product) {
            $productLabel = ProductLabel::where('product_id', $product->id)->first();
            $product->custom_label = $productLabel ? $productLabel->label : 'Neutral';
        }

        // Apply filters
        $filteredProducts = $this->applyFilters($feed);

        // Render XML or CSV feed template
        return View::make('feed-management.export-template', compact('filteredProducts'))->render();
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


