<x-app-layout>

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header pb-0">
            <h6>TikTok Ads Performance</h6>
            <small>Track and optimize your TikTok ads performance.</small>
        </div>
        <div class="card-body">
            <canvas id="tiktokAdsChart"></canvas>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header pb-0">
            <h6>Top TikTok Campaigns</h6>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach ($data['top_campaigns'] as $campaign)
                    <li class="list-group-item d-flex justify-content-between">
                        {{ $campaign['name'] }}
                        <span class="badge bg-primary">{{ $campaign['engagement_rate'] }}% Engagement</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById("tiktokAdsChart").getContext("2d");
    new Chart(ctx, {
        type: "bar",
        data: {
            labels: @json(array_keys($data['performance_trend'])),
            datasets: [{
                label: "Engagement Rate",
                data: @json(array_values($data['performance_trend'])),
                backgroundColor: "#69C9D0"
            }]
        }
    });
});
</script>
</x-app-layout>
