<x-app-layout>

@section('content')
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header pb-0">
            <h6>Meta Ads Performance</h6>
            <small>Continuously monitor Meta Ads' performance with advanced reports.</small>
        </div>
        <div class="card-body">
            <canvas id="metaAdsChart"></canvas>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header pb-0">
            <h6>Key Metrics</h6>
            <small>Last 7 days compared to the previous 7 days.</small>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <h4>{{ number_format($data['reach'] ?? 0, 2) }}m</h4>
                    <small>Reach</small>
                </div>
                <div class="col-md-3">
                    <h4>{{ number_format($data['impressions'] ?? 0, 2) }}m</h4>
                    <small>Impressions</small>
                </div>
                <div class="col-md-3">
                    <h4>{{ number_format($data['clicks'] ?? 0, 2) }}</h4>
                    <small>Clicks</small>
                </div>
                <div class="col-md-3">
                    <h4>${{ number_format($data['spend'] ?? 0, 2) }}k</h4>
                    <small>Spend</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById("metaAdsChart").getContext("2d");
    new Chart(ctx, {
        type: "line",
        data: {
            labels: @json($data['dates'] ?? []),
            datasets: [{
                label: "Clicks",
                data: @json($data['clicks'] ?? []),
                borderColor: "#1877F2",
                fill: false
            }]
        }
    });
});
</script>
</x-app-layout>
