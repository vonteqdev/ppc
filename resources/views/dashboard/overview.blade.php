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
    });
    </script>
</x-app-layout>
