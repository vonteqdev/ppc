<x-app-layout>

<div class="container-fluid py-4">
    <div class="row">
        <!-- Pie Chart for Ad Spend -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Ad Spend Distribution</h6>
                </div>
                <div class="card-body">
                    <canvas id="adSpendChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Top Campaigns -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Top 5 Campaigns</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach ($topCampaigns as $campaign)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $campaign->name }}
                                <span class="badge bg-primary">{{ $campaign->performance_score }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- GA4 Insights -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>GA4 - Top Pages</h6>
                </div>
                <div class="card-body">
                    <ul>
                        @foreach ($ga4Insights['top_pages'] as $page)
                            <li>{{ $page['url'] }} - {{ $page['views'] }} views</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>GA4 - Traffic Sources</h6>
                </div>
                <div class="card-body">
                    <ul>
                        @foreach ($ga4Insights['source_medium'] as $source)
                            <li>{{ $source['source'] }} / {{ $source['medium'] }} - {{ $source['users'] }} users</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById("adSpendChart").getContext("2d");
    var data = {
        labels: ["Google Ads", "Meta Ads", "TikTok Ads"],
        datasets: [{
            data: [{{ $totalSpend['Google Ads'] }}, {{ $totalSpend['Meta Ads'] }}, {{ $totalSpend['TikTok Ads'] }}],
            backgroundColor: ["#4285F4", "#4267B2", "#69C9D0"],
        }]
    };

    new Chart(ctx, {
        type: "pie",
        data: data
    });
});
</script>


</x-app-layout>

