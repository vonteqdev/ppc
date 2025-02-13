<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\GoogleAdsService;
use App\Services\MetaAdsService;
use App\Services\TikTokAdsService;
use App\Services\GA4Service;
use App\Models\Campaign;
use App\Models\Product;
use App\Models\Order;
use App\Models\Analytics;


use DB;

class DashboardController extends Controller
{
    protected $googleAdsService;
    protected $metaAdsService;
    protected $tiktokAdsService;
    protected $ga4Service;

    public function __construct(
        GoogleAdsService $googleAdsService,
        MetaAdsService $metaAdsService,
        TikTokAdsService $tiktokAdsService,
        GA4Service $ga4Service
    ) {
        $this->googleAdsService = $googleAdsService;
        $this->metaAdsService = $metaAdsService;
        $this->tiktokAdsService = $tiktokAdsService;
        $this->ga4Service = $ga4Service;
    }

    public function index()
    {
        // Existing Ad Performance Data
        $googleAdsData = array_merge(['dates' => [], 'clicks' => [], 'total_spent' => 0], $this->googleAdsService->getSummary() ?? []);
        $metaAdsData = array_merge(['dates' => [], 'clicks' => [], 'total_spent' => 0], $this->metaAdsService->getSummary() ?? []);
        $tiktokAdsData = array_merge(['dates' => [], 'clicks' => [], 'total_spent' => 0], $this->tiktokAdsService->getSummary() ?? []);
        $ga4Data = array_merge(['dates' => [], 'sessions' => []], $this->ga4Service->getSummary() ?? []);

        // Spending Distribution
        $totalSpend = [
            'Google Ads' => $googleAdsData['total_spent'],
            'Meta Ads' => $metaAdsData['total_spent'],
            'TikTok Ads' => $tiktokAdsData['total_spent'],
        ];

        // Top Campaigns
        $topCampaigns = Campaign::orderByDesc('clicks')->limit(5)->get();

        // Product Metrics
        $heroProduct = Product::orderByDesc('revenue')->first();
        $mostOrderedProduct = Product::orderByDesc('orders')->first();
        $totalRevenue = Product::sum('revenue');
        $totalOrders = Product::sum('orders');
        $totalClicks = Product::sum('clicks');
        $productWithoutSales = Product::where('orders', 0)->count();
        $wastedMoney = Product::sum('wasted_money');

        // Revenue Data for Charts
        $revenueData = [
            'dates' => ['Day 1', 'Day 2', 'Day 3'],
            'values' => [1000, 1500, 2000]
        ];

        // Wasted Money Data for Charts
        $wastedMoneyData = [
            'without_sales' => $productWithoutSales,
            'total_spend' => $wastedMoney
        ];

        // Orders Data for Charts
        $ordersData = [
            'dates' => ['Week 1', 'Week 2', 'Week 3'],
            'values' => [50, 100, 150]
        ];

        // Profit Performance
        $profitPerformance = Product::selectRaw("
            CASE
                WHEN profit > 20000 THEN 'HIGH PROFIT'
                WHEN profit BETWEEN 10000 AND 20000 THEN 'NORMAL PROFIT'
                WHEN profit BETWEEN 1 AND 9999 THEN 'LOW PROFIT'
                WHEN profit = 0 THEN 'NO PROFIT'
                ELSE 'LOSS'
            END AS profit_label,
            COUNT(*) as products,
            SUM(revenue) as revenue,
            SUM(profit) as profit,
            SUM(cost_google) as cost_google,
            SUM(cost_facebook) as cost_facebook
        ")->groupBy('profit_label')
        ->orderByRaw("FIELD(profit_label, 'HIGH PROFIT', 'NORMAL PROFIT', 'LOW PROFIT', 'NO PROFIT', 'LOSS')")
        ->get();

        // Product Performance
        $productPerformance = Product::selectRaw("
            CASE
                WHEN revenue > 500000 THEN 'HIGH REVENUE'
                WHEN revenue BETWEEN 100000 AND 500000 THEN 'AVERAGE REVENUE'
                WHEN revenue = 0 THEN 'NO REVENUE'
                ELSE 'REST OF PRODUCTS (LOW + NO REVENUE)'
            END AS revenue_label,
            COUNT(*) as products,
            SUM(orders) as quantity,
            SUM(revenue) as revenue,
            SUM(clicks) as clicks,
            SUM(cost_google + cost_facebook) as cost
        ")->groupBy('revenue_label')
        ->orderByRaw("FIELD(revenue_label, 'HIGH REVENUE', 'AVERAGE REVENUE', 'NO REVENUE', 'REST OF PRODUCTS (LOW + NO REVENUE)')")
        ->get();

        // Brands Performance
        $brandsPerformance = Product::selectRaw("
            brand,
            COUNT(*) as products,
            SUM(revenue) as revenue,
            SUM(orders) as quantity,
            SUM(clicks) as clicks,
            SUM(cost_google + cost_facebook) as cost
        ")->groupBy('brand')->get();

        // Categories Performance
        $categoriesPerformance = Product::selectRaw("
            category,
            COUNT(*) as products,
            SUM(revenue) as revenue,
            SUM(orders) as quantity,
            SUM(clicks) as clicks,
            SUM(cost_google + cost_facebook) as cost
        ")->groupBy('category')->get();

        // Top Hero, Top Toxic, Top Ordered Products
        $topHero = Product::orderByDesc('revenue')->limit(3)->get();
        $topToxic = Product::where('profit', '<', 0)->orderBy('profit', 'asc')->limit(3)->get();
        $topOrdered = Product::orderByDesc('orders')->limit(3)->get();



        $priceRanges = [
            '1 - 50' => [1, 50],
            '50 - 75' => [50, 75],
            '75 - 100' => [75, 100],
            '100 - 125' => [100, 125],
            '125 - 150' => [125, 150],
            '150 - 175' => [150, 175],
            '175 - 200' => [175, 200],
            '200 - 250' => [200, 250],
            '250 - 300' => [250, 300],
            '300 - 350' => [300, 350],
            '350 - 400' => [350, 400],
            '400 - 450' => [400, 450]
        ];

        $pricePerformance = [];

        foreach ($priceRanges as $label => [$min, $max]) {
            $pricePerformance[] = Product::selectRaw("
                '$label' as price_range,
                COUNT(*) as total_products,
                SUM(revenue) as total_revenue,
                SUM(cost_google + cost_facebook) as total_cost,
                SUM(clicks) as total_clicks,
                (SUM(revenue) / NULLIF(SUM(cost_google + cost_facebook), 0)) as relative_roas
            ")->whereBetween('price', [$min, $max])->first();
        }

        $productROASPerformance = [
            'High ROAS Total' => Product::where('roas', '>', 10)->selectRaw("COUNT(*) as products, SUM(orders) as quantity, SUM(revenue) as revenue, SUM(clicks) as clicks, SUM(cost_google + cost_facebook) as cost")->first(),
            'Normal ROAS Total' => Product::whereBetween('roas', [5, 10])->selectRaw("COUNT(*) as products, SUM(orders) as quantity, SUM(revenue) as revenue, SUM(clicks) as clicks, SUM(cost_google + cost_facebook) as cost")->first(),
            'Low ROAS Total' => Product::whereBetween('roas', [1, 5])->selectRaw("COUNT(*) as products, SUM(orders) as quantity, SUM(revenue) as revenue, SUM(clicks) as clicks, SUM(cost_google + cost_facebook) as cost")->first(),
            'No ROAS Total' => Product::where('roas', '<', 1)->selectRaw("COUNT(*) as products, SUM(orders) as quantity, SUM(revenue) as revenue, SUM(clicks) as clicks, SUM(cost_google + cost_facebook) as cost")->first()
        ];


        $productClicksPerformance = [
            'Super Promoted' => Product::where('promotion_level', 'Super Promoted')->selectRaw("COUNT(*) as products, SUM(orders) as quantity, SUM(revenue) as revenue, SUM(clicks) as clicks, SUM(cost_google) as cost")->first(),
            'Normal Promoted' => Product::where('promotion_level', 'Normal Promoted')->selectRaw("COUNT(*) as products, SUM(orders) as quantity, SUM(revenue) as revenue, SUM(clicks) as clicks, SUM(cost_google) as cost")->first(),
            'Low Promoted' => Product::where('promotion_level', 'Low Promoted')->selectRaw("COUNT(*) as products, SUM(orders) as quantity, SUM(revenue) as revenue, SUM(clicks) as clicks, SUM(cost_google) as cost")->first(),
            'Not Promoted' => Product::where('promotion_level', 'Not Promoted')->selectRaw("COUNT(*) as products, SUM(orders) as quantity, SUM(revenue) as revenue, SUM(clicks) as clicks, SUM(cost_google) as cost")->first()
        ];

        $productGoogleROASPerformance = [
            'High ROAS GAds' => Product::where('google_roas', '>', 10)->selectRaw("COUNT(*) as products, SUM(orders) as quantity, SUM(revenue) as revenue, SUM(clicks) as clicks, SUM(cost_google) as cost")->first(),
            'Normal ROAS GAds' => Product::whereBetween('google_roas', [5, 10])->selectRaw("COUNT(*) as products, SUM(orders) as quantity, SUM(revenue) as revenue, SUM(clicks) as clicks, SUM(cost_google) as cost")->first(),
            'Low ROAS GAds' => Product::whereBetween('google_roas', [1, 5])->selectRaw("COUNT(*) as products, SUM(orders) as quantity, SUM(revenue) as revenue, SUM(clicks) as clicks, SUM(cost_google) as cost")->first(),
            'No ROAS GAds' => Product::where('google_roas', '<', 1)->selectRaw("COUNT(*) as products, SUM(orders) as quantity, SUM(revenue) as revenue, SUM(clicks) as clicks, SUM(cost_google) as cost")->first()
        ];

        //Google Ads Shopping Campaigns
        // Fetch campaign data
        $googleAdsCampaigns = Campaign::select('name', 'status', 'type', 'impressions', 'clicks', 'conversions', 'conversion_rate', 'cost', 'cost_per_conversion', 'cpc')
            ->orderByDesc('impressions')
            ->get();

        // Calculate summary data
        $googleAdsSummary = Campaign::selectRaw("
            SUM(impressions) as total_impressions,
            SUM(clicks) as total_clicks,
            SUM(conversions) as total_conversions,
            SUM(cost) as total_cost,
            AVG(cost_per_conversion) as avg_cost_per_conversion
        ")->first();

        //Number of Orders by Number of Products


        $ordersByProductCount = Order::selectRaw("product_count, COUNT(*) as total_orders")
            ->groupBy('product_count')
            ->orderBy('product_count')
            ->get();


        //Revenues, Sessions & Purchasers
        $productsRevenue = [
            'With Revenue' => Product::where('revenue', '>', 0)->count(),
            'Without Revenue' => Product::where('revenue', '=', 0)->count()
        ];

        $sessionsData = [
            'Engaged Sessions' => Analytics::where('metric', 'engaged_sessions')->value('value'),
            'Non-Engaged Sessions' => Analytics::where('metric', 'non_engaged_sessions')->value('value')
        ];

        $purchasersData = [
            'First Time Purchasers' => Analytics::where('metric', 'first_time_purchasers')->value('value'),
            'Recurring Purchasers' => Analytics::where('metric', 'recurring_purchasers')->value('value')
        ];



        return view('dashboard.overview', compact(
            'googleAdsData', 'metaAdsData', 'tiktokAdsData', 'ga4Data', 'totalSpend',
            'topCampaigns', 'heroProduct', 'mostOrderedProduct', 'totalRevenue', 'totalOrders',
            'totalClicks', 'productWithoutSales', 'wastedMoney', 'wastedMoneyData', 'revenueData',
            'ordersData', 'profitPerformance', 'productPerformance', 'brandsPerformance', 'categoriesPerformance',
            'topHero', 'topToxic', 'topOrdered', 'pricePerformance', 'productROASPerformance', 'productClicksPerformance', 'productGoogleROASPerformance' , 'googleAdsCampaigns', 'googleAdsSummary', 'ordersByProductCount', 'productsRevenue', 'sessionsData', 'purchasersData'
        ));
    }
}
