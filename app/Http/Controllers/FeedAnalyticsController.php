<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeedImport;
use App\Models\FeedExport;
use App\Models\FeedErrorLog;
use Carbon\Carbon;

class FeedAnalyticsController extends Controller
{
    public function index()
    {
        // Fetch imported and exported feed data
        $importedFeeds = FeedImport::all();
        $exportedFeeds = FeedExport::all();

        // Count total products processed (simulated)
        $totalProductsImported = $importedFeeds->count() * 100; // Assume 100 products per feed

        // Count total errors logged
        $totalErrors = FeedErrorLog::count();

        // Find last fetch time
        $lastFetched = FeedImport::orderBy('last_fetched_at', 'desc')->first();

        // Return to the view
        return view('feed-management.analytics', [
            'totalFeeds' => $importedFeeds->count(),
            'totalExports' => $exportedFeeds->count(),
            'totalProductsImported' => $totalProductsImported,
            'totalErrors' => $totalErrors,
            'lastFetched' => $lastFetched ? Carbon::parse($lastFetched->last_fetched_at)->diffForHumans() : 'Never'
        ]);
    }
}
