<x-app-layout>
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header pb-0">
            <h6>Budget Monitoring</h6>
            <small>Track and control your ad spend.</small>
        </div>
        <div class="card-body">
            <div class="progress-info">
                <strong>All platforms</strong>
                <span>{{ number_format($totalPercentage, 2) }}% spent from budget</span>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $totalPercentage }}%" aria-valuenow="{{ $totalPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <p><strong>Budget:</strong> ${{ number_format($totalBudget, 2) }} | <strong>Spent:</strong> ${{ number_format($totalSpent, 2) }}</p>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            @foreach (['Google Ads' => $googleAdsBudget, 'Meta Ads' => $metaAdsBudget, 'TikTok Ads' => $tiktokAdsBudget] as $platform => $budget)
                <div class="budget-section mt-3">
                    <h6>{{ $platform }}</h6>
                    <span class="text-muted">{{ number_format($budget['percentage'], 2) }}% spent from budget</span>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: {{ $budget['percentage'] }}%" aria-valuenow="{{ $budget['percentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <p><strong>Budget:</strong> ${{ number_format($budget['budget'], 2) }} | <strong>Spent:</strong> ${{ number_format($budget['spent'], 2) }}</p>
                </div>
            @endforeach
        </div>
    </div>
</div>
</x-app-layout>
