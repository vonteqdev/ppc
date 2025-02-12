<x-app-layout>

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header pb-0">
            <h6>Meta Ads Performance</h6>
            <small>Track and improve your Meta (Facebook & Instagram) Ads.</small>
        </div>
        <div class="card-body">
            <canvas id="metaAdsChart"></canvas>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header pb-0">
            <h6>Top Performing Ads</h6>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach ($data['top_ads'] as $ad)
                    <li class="list-group-item d-flex justify-content-between">
                        <span>{{ $ad['name'] }}</span>
                        <span class="badge bg-primary">{{ $ad['impressions'] }} Impressions</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById("metaAdsChart").getContext("2d");
    new Chart(ctx, {
        type: "bar",
        data: {
            labels: @json(array_keys($data['performance_trend'])),
            datasets: [{
                label: "Impressions",
                data: @json(array_values($data['performance_trend'])),
                backgroundColor: "#4267B2"
            }]
        }
    });
});
</script>
</x-app-layout>
