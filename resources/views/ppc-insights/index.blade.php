<x-app-layout>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0">
                <h6>PPC Attribution & ROAS Comparison</h6>
                <small>See where conversions come from and compare ROAS.</small>
            </div>
            <div class="card-body">
                <button class="btn btn-primary" onclick="fetchPpcData()">Update PPC Data</button>

                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th>Platform</th>
                            <th>Clicks</th>
                            <th>Conversions</th>
                            <th>Cost</th>
                            <th>Revenue</th>
                            <th>ROAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $entry)
                        <tr>
                            <td>{{ $entry->platform }}</td>
                            <td>{{ $entry->clicks }}</td>
                            <td>{{ $entry->conversions }}</td>
                            <td>${{ number_format($entry->cost, 2) }}</td>
                            <td>${{ number_format($entry->revenue, 2) }}</td>
                            <td>{{ $entry->roas }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card">
                <div class="card-header pb-0">
                    <h6>ROAS Comparison</h6>
                </div>
                <div class="card-body">
                    <canvas id="roasComparisonChart"></canvas>
                </div>
            </div>

        </div>
    </div>

    <script>
        function fetchPpcData() {
            fetch("{{ route('ppc-insights.fetch') }}", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
            }).then(response => location.reload());
        }
    </script>
</x-app-layout>
