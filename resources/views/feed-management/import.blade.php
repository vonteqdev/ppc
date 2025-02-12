<x-app-layout>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header">
                <h6>Import Feeds</h6>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addImportModal">+ Add Import Feed</button>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($importFeeds as $feed)
                        <li class="list-group-item d-flex justify-content-between">
                            <strong>{{ $feed->name }}</strong> ({{ strtoupper($feed->type) }})
                            <button class="btn btn-success" onclick="fetchFeed({{ $feed->id }})">Fetch Now</button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <!-- Add Import Feed Modal -->
    <div class="modal fade" id="addImportModal">
        <div class="modal-dialog">
            <form action="/feed-management/import" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header"><h5>Add Import Feed</h5></div>
                    <div class="modal-body">
                        <input type="text" name="name" class="form-control mb-2" placeholder="Feed Name">
                        <input type="url" name="source" class="form-control mb-2" placeholder="Feed URL">
                        <select name="type" class="form-control mb-2">
                            <option value="xml">XML</option>
                            <option value="csv">CSV</option>
                            <option value="json">JSON</option>
                        </select>
                        <select name="frequency" class="form-control">
                            <option value="hourly">Hourly</option>
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
