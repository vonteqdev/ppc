<x-app-layout>
    <div class="container-fluid py-4">
        <div class="row">
            <!-- Google Ads Performance -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Google Ads Performance</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="googleAdsChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Meta Ads Performance -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Meta Ads Performance</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="metaAdsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- TikTok Ads Performance -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>TikTok Ads Performance</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="tiktokAdsChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- GA4 Performance -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Google Analytics 4 Performance</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="ga4Chart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Ad Platforms Spend Distribution -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Ad Platforms - Amount Spent</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="spendDistributionChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top Campaigns -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Top Campaigns</h6>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($topCampaigns as $campaign)
                                <li class="list-group-item d-flex justify-content-between">
                                    {{ $campaign->name }}
                                    <span class="badge bg-primary">{{ $campaign->clicks }} Clicks</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid py-4">
        <div class="row">
            <!-- Hero Product -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Hero Product</h6>
                    </div>
                    <div class="card-body text-center">
                        <p>{{ $heroProduct->name ?? 'N/A' }}</p>
                        <img src="{{ $heroProduct->image_url ?? '#' }}" alt="Hero Product" class="img-fluid">
                        <a href="#" class="btn btn-primary mt-2">See All</a>
                    </div>
                </div>
            </div>

            <!-- Most Ordered Product -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Most Ordered Product</h6>
                    </div>
                    <div class="card-body text-center">
                        <p>{{ $mostOrderedProduct->name ?? 'N/A' }}</p>
                        <img src="{{ $mostOrderedProduct->image_url ?? '#' }}" alt="Most Ordered Product" class="img-fluid">
                        <a href="#" class="btn btn-primary mt-2">See All</a>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Revenue</h6>
                    </div>
                    <div class="card-body text-center">
                        <h4>{{ number_format($totalRevenue, 2) }} RON</h4>
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Wasted Money -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Wasted Money on Products without Sales</h6>
                    </div>
                    <div class="card-body text-center">
                        <h4>{{ number_format($wastedMoney, 2) }} RON</h4>
                        <canvas id="wastedMoneyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- Products with Sales -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>No. of Products with Sales</h6>
                    </div>
                    <div class="card-body text-center">
                        <h4>{{ $totalOrders }}</h4>
                    </div>
                </div>
            </div>

            <!-- Products with Irrelevant Sales -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>No. of Products with Irrelevant Sales</h6>
                    </div>
                    <div class="card-body text-center">
                        <h4>{{ $productWithoutSales }}</h4>
                    </div>
                </div>
            </div>

            <!-- Products with Clicks -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>No. of Products with Clicks</h6>
                    </div>
                    <div class="card-body text-center">
                        <h4>{{ $totalClicks }}</h4>
                    </div>
                </div>
            </div>

            <!-- Orders -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Total Orders</h6>
                    </div>
                    <div class="card-body text-center">
                        <h4>{{ $totalOrders }}</h4>
                        <canvas id="ordersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="container-fluid py-4">
        <!-- Profit Performance -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Profit Performance</h6>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Label</th>
                                    <th>Products</th>
                                    <th>Revenue</th>
                                    <th>Profit</th>
                                    <th>Cost Google</th>
                                    <th>Cost Facebook</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($profitPerformance as $row)
                                <tr>
                                    <td>{{ $row->profit_label }}</td>
                                    <td>{{ $row->products }}</td>
                                    <td>{{ number_format($row->revenue, 2) }} RON</td>
                                    <td>{{ number_format($row->profit, 2) }} RON</td>
                                    <td>{{ number_format($row->cost_google, 2) }} RON</td>
                                    <td>{{ number_format($row->cost_facebook, 2) }} RON</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Performance -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Product Performance</h6>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Label</th>
                                    <th>Products</th>
                                    <th>Quantity</th>
                                    <th>Revenue</th>
                                    <th>Clicks</th>
                                    <th>Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productPerformance as $row)
                                <tr>
                                    <td>{{ $row->revenue_label }}</td>
                                    <td>{{ $row->products }}</td>
                                    <td>{{ $row->quantity }}</td>
                                    <td>{{ number_format($row->revenue, 2) }} RON</td>
                                    <td>{{ $row->clicks }}</td>
                                    <td>{{ number_format($row->cost, 2) }} RON</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Hero, Top Toxic, Top Ordered -->
        <div class="row">
            @foreach([['title' => 'Top Hero', 'data' => $topHero], ['title' => 'Top Toxic', 'data' => $topToxic], ['title' => 'Top Ordered', 'data' => $topOrdered]] as $section)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>{{ $section['title'] }}</h6>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($section['data'] as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td><img src="{{ $product->image_url }}" width="50"></td>
                                    <td>{{ $product->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="#" class="btn btn-primary mt-2">See All</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Brands Performance</h6>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Brand</th>
                                    <th>Products</th>
                                    <th>Revenue</th>
                                    <th>Quantity</th>
                                    <th>Clicks</th>
                                    <th>Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($brandsPerformance as $brand)
                                <tr>
                                    <td>{{ $brand->brand }}</td>
                                    <td>{{ $brand->total_products }}</td>
                                    <td>{{ number_format($brand->total_revenue, 2) }} RON</td>
                                    <td>{{ $brand->total_orders }}</td>
                                    <td>{{ $brand->total_clicks }}</td>
                                    <td>{{ number_format($brand->total_cost, 2) }} RON</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Categories Performance</h6>
                    </div>
                    <canvas id="categoryRevenueChart"></canvas>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Label</th>
                                    <th>Products</th>
                                    <th>Revenue</th>
                                    <th>Quantity</th>
                                    <th>Clicks</th>
                                    <th>Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categoriesPerformance as $category)
                                <tr>
                                    <td>{{ $category->category }}</td>
                                    <td>{{ $category->products }}</td>
                                    <td>{{ number_format($category->revenue, 2) }} RON</td>
                                    <td>{{ $category->quantity }}</td>
                                    <td>{{ $category->clicks }}</td>
                                    <td>{{ number_format($category->cost, 2) }} RON</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="container-fluid py-4">
        <div class="row">
            @foreach([['title' => 'Top Hero', 'data' => $topHero], ['title' => 'Top Toxic', 'data' => $topToxic], ['title' => 'Top Ordered', 'data' => $topOrdered]] as $section)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>{{ $section['title'] }}</h6>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($section['data'] as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td><img src="{{ $product->image_url }}" width="50"></td>
                                    <td>{{ $product->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <a href="#" class="btn btn-primary mt-2">See All</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

<div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Price Ranges</h6>
                    </div>
                    <canvas id="priceRangesChart"></canvas>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Price Range (RON)</th>
                                    <th>Nr. of Products</th>
                                    <th>Revenue (RON)</th>
                                    <th>Cost</th>
                                    <th>Clicks</th>
                                    <th>Relative ROAS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pricePerformance as $range)
                                <tr>
                                    <td>{{ $range->price_range }}</td>
                                    <td>{{ $range->total_products }}</td>
                                    <td>{{ number_format($range->total_revenue, 2) }} RON</td>
                                    <td>{{ number_format($range->total_cost, 2) }} RON</td>
                                    <td>{{ $range->total_clicks }}</td>
                                    <td>{{ number_format($range->relative_roas, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


<div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Product ROAS Label by Total (Google & Facebook)</h6>
                    </div>
                    <canvas id="roasChart"></canvas>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Label</th>
                                    <th>Products</th>
                                    <th>Quantity</th>
                                    <th>Revenue</th>
                                    <th>Clicks</th>
                                    <th>Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productROASPerformance as $label => $data)
                                <tr>
                                    <td>{{ $label }}</td>
                                    <td>{{ $data->products }}</td>
                                    <td>{{ $data->quantity }}</td>
                                    <td>{{ number_format($data->revenue, 2) }} RON</td>
                                    <td>{{ $data->clicks }}</td>
                                    <td>{{ number_format($data->cost, 2) }} RON</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Product Clicks Performance by Google Ads</h6>
                    </div>
                    <canvas id="clicksPerformanceChart"></canvas>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Label</th>
                                    <th>Products</th>
                                    <th>Quantity</th>
                                    <th>Revenue</th>
                                    <th>Clicks</th>
                                    <th>Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productClicksPerformance as $label => $data)
                                <tr>
                                    <td>{{ $label }}</td>
                                    <td>{{ $data->products }}</td>
                                    <td>{{ $data->quantity }}</td>
                                    <td>{{ number_format($data->revenue, 2) }} RON</td>
                                    <td>{{ $data->clicks }}</td>
                                    <td>{{ number_format($data->cost, 2) }} RON</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Product ROAS Label by Google Ads</h6>
                    </div>
                    <canvas id="roasGoogleChart"></canvas>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Label</th>
                                    <th>Products</th>
                                    <th>Quantity</th>
                                    <th>Revenue</th>
                                    <th>Clicks</th>
                                    <th>Cost</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($productGoogleROASPerformance as $label => $data)
                                <tr>
                                    <td>{{ $label }}</td>
                                    <td>{{ $data->products }}</td>
                                    <td>{{ $data->quantity }}</td>
                                    <td>{{ number_format($data->revenue, 2) }} RON</td>
                                    <td>{{ $data->clicks }}</td>
                                    <td>{{ number_format($data->cost, 2) }} RON</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Google Ads Shopping Campaigns</h6>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Type</th>
                                    <th>Impressions</th>
                                    <th>Clicks</th>
                                    <th>Conversions</th>
                                    <th>Conv. Rate</th>
                                    <th>Cost (RON)</th>
                                    <th>Cost/Conv.</th>
                                    <th>CPC</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($googleAdsCampaigns as $campaign)
                                <tr>
                                    <td>{{ $campaign->name }}</td>
                                    <td>{{ $campaign->status }}</td>
                                    <td>{{ $campaign->type }}</td>
                                    <td>{{ number_format($campaign->impressions) }}</td>
                                    <td>{{ number_format($campaign->clicks) }}</td>
                                    <td>{{ number_format($campaign->conversions, 2) }}</td>
                                    <td>{{ number_format($campaign->conversion_rate, 2) }}%</td>
                                    <td>{{ number_format($campaign->cost, 2) }} RON</td>
                                    <td>{{ number_format($campaign->cost_per_conversion, 2) }} RON</td>
                                    <td>{{ number_format($campaign->cpc, 2) }} RON</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">Total:</td>
                                    <td>{{ number_format($googleAdsSummary->total_impressions) }}</td>
                                    <td>{{ number_format($googleAdsSummary->total_clicks) }}</td>
                                    <td>{{ number_format($googleAdsSummary->total_conversions, 2) }}</td>
                                    <td>-</td>
                                    <td>{{ number_format($googleAdsSummary->total_cost, 2) }} RON</td>
                                    <td>{{ number_format($googleAdsSummary->avg_cost_per_conversion, 2) }} RON</td>
                                    <td>-</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Number of Orders by Number of Products</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="ordersByProductCountChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Products Revenue</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="productsRevenueChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Sessions</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="sessionsChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Purchasers</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="purchasersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx1 = document.getElementById("googleAdsChart").getContext("2d");
        new Chart(ctx1, { type: "line", data: { labels: @json($googleAdsData['dates']), datasets: [{ label: "Clicks", data: @json($googleAdsData['clicks']), borderColor: "#4285F4", fill: false }] } });

        var ctx2 = document.getElementById("metaAdsChart").getContext("2d");
        new Chart(ctx2, { type: "line", data: { labels: @json($metaAdsData['dates']), datasets: [{ label: "Clicks", data: @json($metaAdsData['clicks']), borderColor: "#1877F2", fill: false }] } });

        var ctx3 = document.getElementById("tiktokAdsChart").getContext("2d");
        new Chart(ctx3, { type: "line", data: { labels: @json($tiktokAdsData['dates']), datasets: [{ label: "Clicks", data: @json($tiktokAdsData['clicks']), borderColor: "#000000", fill: false }] } });

        var ctx4 = document.getElementById("ga4Chart").getContext("2d");
        new Chart(ctx4, { type: "line", data: { labels: @json($ga4Data['dates']), datasets: [{ label: "Sessions", data: @json($ga4Data['sessions']), borderColor: "#FF9900", fill: false }] } });

        var ctx5 = document.getElementById("spendDistributionChart").getContext("2d");
        new Chart(ctx5, { type: "doughnut", data: { labels: ["Google Ads", "Meta Ads", "TikTok Ads"], datasets: [{ data: [@json($totalSpend['Google Ads']), @json($totalSpend['Meta Ads']), @json($totalSpend['TikTok Ads'])], backgroundColor: ["#4285F4", "#1877F2", "#000000"] }] } });

        // ✅ Fix Revenue Chart
        var ctx6 = document.getElementById("revenueChart").getContext("2d");
        new Chart(ctx6, {
            type: "line",
            data: {
                labels: @json($revenueData['dates']),
                datasets: [{
                    label: "Revenue",
                    data: @json($revenueData['values']),
                    borderColor: "#4CAF50",
                    fill: false
                }]
            }
        });

        // ✅ Fix Wasted Money Chart
        var ctx7 = document.getElementById("wastedMoneyChart").getContext("2d");
        new Chart(ctx7, {
            type: "doughnut",
            data: {
                labels: ["Products without Sales", "Total Spend"],
                datasets: [{
                    data: [@json($wastedMoneyData['without_sales']), @json($wastedMoneyData['total_spend'])],
                    backgroundColor: ["#FFA500", "#FF0000"]
                }]
            }
        });

        // ✅ Fix Orders Chart
        var ctx8 = document.getElementById("ordersChart").getContext("2d");
        new Chart(ctx8, {
            type: "line",
            data: {
                labels: @json($ordersData['dates']),
                datasets: [{
                    label: "Orders",
                    data: @json($ordersData['values']),
                    borderColor: "#0000FF",
                    fill: false
                }]
            }
        });

        var ctx9 = document.getElementById("categoryRevenueChart").getContext("2d");
        new Chart(ctx9, {
            type: "pie",
            data: {
                labels: ["High revenue", "Normal revenue", "No revenue"],
                datasets: [{
                    data: [45, 30, 25], // Example values, replace dynamically
                    backgroundColor: ["#6A5ACD", "#FFD700", "#FF6347"]
                }]
            }
        });


        var ctx10 = document.getElementById("priceRangesChart").getContext("2d");
        new Chart(ctx10, {
            type: "bar",
            data: {
                labels: @json(array_column($pricePerformance, 'price_range')),
                datasets: [{
                    label: "Revenue",
                    data: @json(array_column($pricePerformance, 'total_revenue')),
                    backgroundColor: "#4CAF50"
                }]
            }
        });

        var ctx11 = document.getElementById("roasChart").getContext("2d");
        new Chart(ctx11, {
            type: "bar",
            data: {
                labels: @json(array_keys($productROASPerformance)),
                datasets: [{
                    label: "Revenue",
                    data: @json(array_column($productROASPerformance, 'revenue')),
                    backgroundColor: "#FFD700"
                }]
            }
        });

        var ctx12 = document.getElementById("clicksPerformanceChart").getContext("2d");
        new Chart(ctx12, {
            type: "bar",
            data: {
                labels: @json(array_keys($productClicksPerformance)),
                datasets: [{
                    label: "Clicks",
                    data: @json(array_column($productClicksPerformance, 'clicks')),
                    backgroundColor: "#6A5ACD"
                }]
            }
        });

        var ctx13 = document.getElementById("roasGoogleChart").getContext("2d");
        new Chart(ctx13, {
            type: "bar",
            data: {
                labels: @json(array_keys($productGoogleROASPerformance)),
                datasets: [{
                    label: "Revenue",
                    data: @json(array_column($productGoogleROASPerformance, 'revenue')),
                    backgroundColor: "#FFD700"
                }]
            }
        });


        new Chart(document.getElementById("ordersByProductCountChart"), {
            type: "bar",
            data: {
                labels: @json(array_column($ordersByProductCount->toArray(), 'product_count')),
                datasets: [{
                    label: "Number of Orders",
                    data: @json(array_column($ordersByProductCount->toArray(), 'total_orders')),
                    backgroundColor: "#A78BFA"
                }]
            }
        });

        new Chart(document.getElementById("productsRevenueChart"), {
            type: "doughnut",
            data: {
                labels: ["Products with Revenue", "Products without Revenue"],
                datasets: [{ data: @json(array_values($productsRevenue)), backgroundColor: ["#4CAF50", "#FF6347"] }]
            }
        });

        new Chart(document.getElementById("sessionsChart"), {
            type: "pie",
            data: { labels: ["Engaged Sessions", "Non-Engaged Sessions"], datasets: [{ data: @json(array_values($sessionsData)), backgroundColor: ["#6A5ACD", "#FFD700"] }] }
        });

        new Chart(document.getElementById("purchasersChart"), {
            type: "pie",
            data: { labels: ["First Time Purchasers", "Recurring Purchasers"], datasets: [{ data: @json(array_values($purchasersData)), backgroundColor: ["#8E44AD", "#F39C12"] }] }
        });

    });
    </script>



</x-app-layout>
