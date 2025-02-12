<x-app-layout>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0">
                <h6>Search Console Performance</h6>
                <small>Track your website's organic search performance.</small>
            </div>
            <div class="card-body">
                <canvas id="gscPerformanceChart"></canvas>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header pb-0">
                <h6>Top Queries</h6>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($data['top_queries'] as $query)
                        <li class="list-group-item d-flex justify-content-between">
                            {{ $query['query'] }}
                            <span class="badge bg-primary">{{ $query['clicks'] }} Clicks</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById("gscPerformanceChart").getContext("2d");
        new Chart(ctx, {
            type: "line",
            data: {
                labels: @json(array_keys($data['performance_trend'])),
                datasets: [{
                    label: "Total Clicks",
                    data: @json(array_values($data['performance_trend'])),
                    borderColor: "#34A853",
                    fill: false
                }]
            }
        });
    });
    </script>
</x-app-layout>
