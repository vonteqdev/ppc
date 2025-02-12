<x-app-layout>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0">
                <h6>Label Performance Report</h6>
                <small>Analyze the performance of products based on assigned labels.</small>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Label</th>
                            <th>Total Products</th>
                            <th>Total Revenue</th>
                            <th>Avg ROAS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($labelPerformance as $label)
                            <tr>
                                <td>{{ $label->label }}</td>
                                <td>{{ $label->total_products }}</td>
                                <td>${{ number_format($label->total_revenue, 2) }}</td>
                                <td>{{ number_format($label->avg_roas, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
