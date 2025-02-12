<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FeedManagementService;

class FeedManagementController extends Controller
{
    public function index()
    {
        $feeds = FeedManagementService::getAllFeeds();
        return view('feed-management.index', compact('feeds'));
    }

    public function generateFeed(Request $request)
    {
        $feedType = $request->input('feed_type');
        return FeedManagementService::generateFeed($feedType);
    }
}
