<x-app-layout>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0">
                <h6>Feed Export Options</h6>
                <small>Customize your feed export settings.</small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('feed-management.update-export-options') }}">
                    @csrf
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="include_labels" value="1" checked>
                        <label class="form-check-label">Include Product Labels in Feed</label>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Save Options</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
