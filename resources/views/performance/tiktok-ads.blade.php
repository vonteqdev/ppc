<x-app-layout>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0">
                <h6>TikTok Ads Performance</h6>
                <small>Continuously monitor TikTok ads' performance with advanced reports.</small>
            </div>
            <div class="card-body">
                <canvas id="tiktokChart"></canvas>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header pb-0">
                <h6>Performance Dashboard</h6>
                <small>You can see your profile metrics.</small>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <h4>{{ number_format(is_array($data['clicks']) ? ($data['clicks'][0] ?? 0) : ($data['clicks'] ?? 0), 2) }}k</h4>
                        <small>Clicks</small>
                    </div>
                    <div class="col-md-3">
                        <h4>{{ number_format(is_array($data['impressions']) ? ($data['impressions'][0] ?? 0) : ($data['impressions'] ?? 0), 2) }}k</h4>
                        <small>Impressions</small>
                    </div>
                    <div class="col-md-3">
                        <h4>{{ number_format(is_array($data['reach']) ? ($data['reach'][0] ?? 0) : ($data['reach'] ?? 0), 2) }}k</h4>
                        <small>Reach</small>
                    </div>
                    <div class="col-md-3">
                        <h4>{{ number_format(is_array($data['cost']) ? ($data['cost'][0] ?? 0) : ($data['cost'] ?? 0), 2) }}</h4>
                        <small>Cost</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header pb-0">
                <h6>Performance Funnel</h6>
            </div>
            <div class="card-body">
                <canvas id="performanceFunnel"></canvas>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var ctx = document.getElementById("tiktokChart").getContext("2d");

        new Chart(ctx, {
            type: "line",
            data: {
                labels: @json($data['dates'] ?? []),
                datasets: [{
                    label: "Clicks",
                    data: @json(is_array($data['clicks']) ? array_values($data['clicks']) : []),
                    borderColor: "#4285F4",
                    fill: false
                },
                {
                    label: "Impressions",
                    data: @json(is_array($data['impressions']) ? array_values($data['impressions']) : []),
                    borderColor: "#FB8500",
                    fill: false
                }]
            }
        });

        var funnelCtx = document.getElementById("performanceFunnel").getContext("2d");
        new Chart(funnelCtx, {
            type: "bar",
            data: {
                labels: ["Clicks", "Conversions", "Impressions"],
                datasets: [{
                    label: "Performance Funnel",
                    data: [
                        {{ $data['clicks'][0] ?? 0 }},
                        {{ $data['conversions'][0] ?? 0 }},
                        {{ $data['impressions'][0] ?? 0 }}
                    ],
                    backgroundColor: ["#4285F4", "#34A853", "#FB8500"]
                }]
            }
        });
    });
    </script>
</x-app-layout>
