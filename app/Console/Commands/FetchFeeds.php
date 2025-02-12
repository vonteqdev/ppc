<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\FeedImport;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class FetchFeeds extends Command
{
    protected $signature = 'feeds:fetch';
    protected $description = 'Fetch and update feeds based on their schedule';

    public function handle()
    {
        Log::info("Starting scheduled feed fetch...");

        $feeds = FeedImport::all();
        $now = Carbon::now();

        foreach ($feeds as $feed) {
            if ($this->shouldFetch($feed, $now)) {
                Log::info("Fetching feed: " . $feed->name);

                // Simulate fetching logic (Replace with actual fetch method)
                $feed->last_fetched_at = $now;
                $feed->save();

                Log::info("Successfully updated: " . $feed->name);
            }
        }

        Log::info("Feed fetching completed.");
        return 0;
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
}

