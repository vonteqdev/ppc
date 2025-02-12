<x-app-layout>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0">
                <h6>Profitability Analysis</h6>
                <small>Analyze product performance and categorize them.</small>
            </div>
            <div class="card-body">
                <button class="btn btn-primary" onclick="analyzeProfitability()">Run Analysis</button>

                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Label</th>
                            <th>ROAS</th>
                            <th>Conversion Rate</th>
                            <th>Clicks</th>
                            <th>Impressions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($labels as $label)
                        <tr>
                            <td>{{ $label->product_id }}</td>
                            <td><span class="badge bg-info">{{ $label->label }}</span></td>
                            <td>{{ $label->roas }}</td>
                            <td>{{ $label->conversion_rate }}%</td>
                            <td>{{ $label->clicks }}</td>
                            <td>{{ $label->impressions }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function analyzeProfitability() {
            fetch("{{ route('profitability.analyze') }}", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
            }).then(response => location.reload());
        }
    </script>
</x-app-layout>
