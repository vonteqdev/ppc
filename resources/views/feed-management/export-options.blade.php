<x-app-layout>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0">
                <h6>Export Options</h6>
                <small>Manage and configure feed export settings.</small>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($exports as $export)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $export->name }} ({{ ucfirst($export->platform) }})</span>
                            <a href="{{ route('feed-management.generateExport', ['platform' => $export->platform, 'name' => $export->name]) }}" class="btn btn-sm btn-primary">Generate Feed</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
