<x-app-layout>
    <div class="container-fluid py-4">

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Labels</th>
                        <th>ROAS</th>
                        <th>Revenue</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>
                                @foreach ($product->labels as $label)
                                    <span class="badge bg-primary">{{ $label->label }}</span>
                                @endforeach
                            </td>
                            <td>{{ number_format($product->labels->where('label', 'High ROAS')->count() ? 'High' : 'Low', 2) }}</td>
                            <td>${{ number_format($product->orders->sum('total_price'), 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-body">
            <form action="{{ route('feed-management.export') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Feed Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Platform</label>
                    <select name="platform" class="form-control">
                        <option value="google">Google</option>
                        <option value="facebook">Facebook</option>
                        <option value="tiktok">TikTok</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Filters (Optional)</label>
                    <select name="filters[label]" class="form-control">
                        <option value="">Select Label</option>
                        @foreach ($labels as $label)
                            <option value="{{ $label }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Create Export</button>
            </form>
        </div>


        <div class="card">
            <div class="card-header pb-0">
                <h6>Feed Management</h6>
                <small>Manage your imported and exported feeds.</small>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#importFeeds">Import Feeds</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#exportFeeds">Export Feeds</a>
                    </li>
                </ul>

                <div class="tab-content mt-3">
                    <!-- Import Feeds Tab -->
                    <div class="tab-pane fade show active" id="importFeeds">
                        <h5>Imported Feeds</h5>
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addImportModal">+ Add Import Feed</button>
                        <ul class="list-group">
                            @if (!empty($feeds['imports']) && count($feeds['imports']) > 0)
                                @foreach ($feeds['imports'] as $feed)
                                    <li class="list-group-item d-flex justify-content-between">
                                        <strong>{{ $feed->name }}</strong> ({{ strtoupper($feed->type) }})
                                        <span class="badge bg-info">{{ $feed->frequency }}</span>
                                        <div>
                                            <a href="{{ route('feed-management.fetch', $feed->id) }}" class="btn btn-success btn-sm">Fetch</a>
                                            <button class="btn btn-danger btn-sm">Delete</button>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li class="list-group-item">No imported feeds available.</li>
                            @endif
                        </ul>
                    </div>

                    <!-- Export Feeds Tab -->
                    <div class="tab-pane fade" id="exportFeeds">
                        <h5>Exported Feeds</h5>
                        <ul class="list-group">
                            @if (!empty($feeds['exports']) && count($feeds['exports']) > 0)
                                @foreach ($feeds['exports'] as $feed)
                                    <li class="list-group-item d-flex justify-content-between">
                                        {{ $feed->name }} - {{ ucfirst($feed->platform) }}
                                        <a href="{{ $feed->export_url }}" target="_blank" class="btn btn-primary btn-sm">View</a>
                                    </li>
                                @endforeach
                            @else
                                <li class="list-group-item">No exported feeds available.</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
