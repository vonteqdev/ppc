<x-app-layout>

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header pb-0">
            <h6>Google Ads Performance</h6>
            <small>Monitor key metrics and optimize your Google Ads campaigns.</small>
        </div>
        <div class="card-body">
            <canvas id="googleAdsChart"></canvas>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header pb-0">
            <h6>Top Performing Keywords</h6>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach ($data['top_keywords'] as $keyword)
                    <li class="list-group-item d-flex justify-content-between">
                        {{ $keyword['keyword'] }}
                        <span class="badge bg-primary">{{ $keyword['clicks'] }} Clicks</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById("googleAdsChart").getContext("2d");
    new Chart(ctx, {
        type: "line",
        data: {
            labels: @json(array_keys($data['performance_trend'])),
            datasets: [{
                label: "Clicks",
                data: @json(array_values($data['performance_trend'])),
                borderColor: "#4285F4",
                fill: false
            }]
        }
    });
});
</script>
</x-app-layout>x-app-layout>

