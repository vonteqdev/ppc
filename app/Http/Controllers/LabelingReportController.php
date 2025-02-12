<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductLabel;

class LabelingReportController extends Controller
{
    public function index()
    {
        $labelPerformance = ProductLabel::select('label')
            ->selectRaw('COUNT(*) as total_products')
            ->selectRaw('SUM(products.revenue) as total_revenue')
            ->selectRaw('AVG(products.roas) as avg_roas')
            ->join('products', 'products.id', '=', 'product_labels.product_id')
            ->groupBy('label')
            ->orderBy('total_revenue', 'desc')
            ->get();

        return view('reports.labeling-performance', compact('labelPerformance'));
    }
}
