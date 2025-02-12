<x-app-layout>

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header pb-0">
            <h6>GA4 Website Analytics</h6>
            <small>Track your website traffic and user engagement.</small>
        </div>
        <div class="card-body">
            <canvas id="ga4TrafficChart"></canvas>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header pb-0">
            <h6>Top Pages</h6>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach ($data['top_pages'] as $page)
                    <li class="list-group-item d-flex justify-content-between">
                        {{ $page['url'] }}
                        <span class="badge bg-primary">{{ $page['views'] }} Views</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById("ga4TrafficChart").getContext("2d");
    new Chart(ctx, {
        type: "line",
        data: {
            labels: @json(array_keys($data['traffic_trend'])),
            datasets: [{
                label: "Sessions",
                data: @json(array_values($data['traffic_trend'])),
                borderColor: "#F4B400",
                fill: false
            }]
        }
    });
});
</script>
</x-app-layout>
