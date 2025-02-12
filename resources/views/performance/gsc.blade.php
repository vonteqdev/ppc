<x-app-layout>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0">
                <h6>Search Console Performance</h6>
                <small>Monitor organic traffic data from Search Console.</small>
            </div>
            <div class="card-body">
                <canvas id="gscChart"></canvas>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header pb-0">
                <h6>Results Dashboard</h6>
                <small>You can see your profile-related statistics.</small>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <h4>{{ number_format(is_array($data['clicks']) ? ($data['clicks'][0] ?? 0) : ($data['clicks'] ?? 0), 2) }}k</h4>
                        <small>Total Clicks</small>
                    </div>
                    <div class="col-md-3">
                        <h4>{{ number_format(is_array($data['impressions']) ? ($data['impressions'][0] ?? 0) : ($data['impressions'] ?? 0), 2) }}k</h4>
                        <small>Total Impressions</small>
                    </div>
                    <div class="col-md-3">
                        <h4>{{ number_format(is_array($data['avg_position']) ? ($data['avg_position'][0] ?? 0) : ($data['avg_position'] ?? 0), 2) }}</h4>
                        <small>Average Position</small>
                    </div>
                    <div class="col-md-3">
                        <h4>{{ number_format(is_array($data['ctr']) ? ($data['ctr'][0] ?? 0) : ($data['ctr'] ?? 0), 2) }}%</h4>
                        <small>Total CTR</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header pb-0">
                <h6>Top 10 Queries</h6>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($data['top_queries'] ?? [] as $query)
                        <li class="list-group-item d-flex justify-content-between">
                            {{ $query['keys'][0] ?? 'N/A' }}
                            <span class="badge bg-primary">{{ $query['clicks'] ?? 0 }} Clicks</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById("gscChart").getContext("2d");

        new Chart(ctx, {
            type: "line",
            data: {
                labels: @json($data['dates'] ?? []),
                datasets: [{
                    label: "Total Clicks",
                    data: @json(is_array($data['clicks']) ? array_values($data['clicks']) : []),
                    borderColor: "#34A853",
                    fill: false
                }]
            }
        });
    });
    </script>
</x-app-layout>
