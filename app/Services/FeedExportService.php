<?php

namespace App\Services;

use App\Models\Product;

class FeedExportService
{
    public function exportFeed($filters)
    {
        $query = Product::query();

        if (isset($filters['revenue_min'])) {
            $query->where('revenue', '>=', $filters['revenue_min']);
        }

        if (isset($filters['roas_min'])) {
            $query->where('roas', '>=', $filters['roas_min']);
        }

        if (isset($filters['trending'])) {
            $query->whereHas('labels', function ($q) {
                $q->where('label', 'Uptrend');
            });
        }

        return $query->get();
    }
}
