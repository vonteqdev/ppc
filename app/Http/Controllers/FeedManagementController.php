<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeedImport;
use App\Models\FeedExport;
use App\Services\FeedManagementService;
use Illuminate\Support\Facades\Storage;

class FeedManagementController extends Controller
{
    protected $feedService;

    public function __construct(FeedManagementService $feedService)
    {
        $this->feedService = $feedService;
    }

    /**
     * Display the feed management dashboard.
     */
    public function index()
    {
        $importedFeeds = FeedImport::all();
        $exportedFeeds = FeedExport::all();

        return view('feed-management.index', [
            'feeds' => [
                'imports' => $importedFeeds,
                'exports' => $exportedFeeds
            ]
        ]);
    }

    /**
     * Handle file upload for importing a feed.
     */
    public function importFeed(Request $request)
    {
        $request->validate([
            'feed_name' => 'required|string|max:255',
            'feed_source' => 'nullable|url',
            'feed_file' => 'nullable|file|mimes:xml,csv',
            'frequency' => 'required|in:hourly,daily,weekly',
        ]);

        if ($request->hasFile('feed_file')) {
            $file = $request->file('feed_file');
            $path = $file->store('imports', 'public');
            $source = $path;
            $type = $file->extension();
        } else {
            $source = $request->feed_source;
            $type = pathinfo($source, PATHINFO_EXTENSION);
        }

        // Validate & parse feed before storing
        if (!$this->feedService->validateFeed($source, $type)) {
            return redirect()->back()->with('error', 'Invalid Feed Format!');
        }

        FeedImport::create([
            'name' => $request->feed_name,
            'source' => $source,
            'type' => $type,
            'frequency' => $request->frequency,
            'last_fetched_at' => now(),
        ]);

        return redirect()->route('feed-management.index')->with('success', 'Feed imported successfully.');
    }

    /**
     * Fetch and update feeds based on schedule.
     */
    public function fetchFeeds()
    {
        $this->feedService->fetchScheduledFeeds();
        return redirect()->route('feed-management.index')->with('success', 'Feeds updated successfully.');
    }

    /**
     * Create a new export feed.
     */
    public function createExport(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'platform' => 'required|in:google,facebook,tiktok',
            'columns' => 'required|array',
            'filters' => 'nullable|array',
        ]);

        $exportUrl = url('/export/' . strtolower($request->platform) . '-' . str_slug($request->name) . '.xml');

        FeedExport::create([
            'name' => $request->name,
            'platform' => $request->platform,
            'export_url' => $exportUrl,
            'columns' => json_encode($request->columns),
            'filters' => json_encode($request->filters),
        ]);

        return redirect()->route('feed-management.index')->with('success', 'Export feed created successfully.');
    }

    /**
     * Generate export feed content.
     */
    public function generateExport($platform, $name)
    {
        $feed = FeedExport::where('platform', $platform)->where('name', $name)->firstOrFail();
        $products = $this->feedService->applyFilters($feed);

        $xml = view('feed-management.export-template', compact('products'))->render();

        return response($xml)->header('Content-Type', 'application/xml');
    }


    public function updateExportOptions(Request $request)
    {
        $includeLabels = $request->has('include_labels') ? 1 : 0;

        // Save export settings globally (or per user in future)
        session(['include_labels' => $includeLabels]);

        return redirect()->back()->with('success', 'Export options updated.');
    }
}

