<x-app-layout>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0">
                <h6>Budget Monitoring</h6>
                <small>Track and control your ad spend.</small>
            </div>
            <div class="card-body">
                <ul>
                    @foreach ($spendingData as $platform => $amount)
                        <li>{{ $platform }}: ${{ number_format($amount, 2) }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
