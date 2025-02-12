<x-app-layout>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0">
                <h6>Quick Insights</h6>
                <small>Smart recommendations and real-time alerts help you take control of your account.</small>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#critical">Critical</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#important">Important</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#good">Good</a>
                    </li>
                </ul>

                <div class="tab-content mt-3">
                    <div class="tab-pane fade show active" id="critical">
                        <ul class="list-group">
                            @foreach ($quickInsights['critical'] ?? [] as $insight)
                                <li class="list-group-item d-flex justify-content-between align-items-center text-danger">
                                    <span>🔴 {{ $insight->message }} <small class="text-muted">{{ $insight->timestamp }}</small></span>
                                    <span>
                                        <a href="#" class="text-muted small">Mark as read</a>
                                        <button class="btn btn-outline-primary btn-sm">See report</button>
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="important">
                        <ul class="list-group">
                            @foreach ($quickInsights['important'] ?? [] as $insight)
                                <li class="list-group-item d-flex justify-content-between align-items-center text-warning">
                                    <span>🟠 {{ $insight->message }} <small class="text-muted">{{ $insight->timestamp }}</small></span>
                                    <span>
                                        <a href="#" class="text-muted small">Mark as read</a>
                                        <button class="btn btn-outline-primary btn-sm">See report</button>
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="good">
                        <ul class="list-group">
                            @foreach ($quickInsights['good'] ?? [] as $insight)
                                <li class="list-group-item d-flex justify-content-between align-items-center text-success">
                                    <span>🟢 {{ $insight->message }} <small class="text-muted">{{ $insight->timestamp }}</small></span>
                                    <span>
                                        <a href="#" class="text-muted small">Mark as read</a>
                                        <button class="btn btn-outline-primary btn-sm">See report</button>
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
