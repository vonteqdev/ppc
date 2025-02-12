<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductLabelingService;
use App\Models\ProductLabel;

class ProductLabelingController extends Controller
{
    protected $labelingService;

    public function __construct(ProductLabelingService $labelingService)
    {
        $this->labelingService = $labelingService;
    }

    public function index()
    {
        $labels = ProductLabel::all();
        return view('product-labels.index', compact('labels'));
    }

    public function generateLabels()
    {
        $this->labelingService->assignLabels();
        return redirect()->back()->with('success', 'Labels assigned successfully.');
    }
}
