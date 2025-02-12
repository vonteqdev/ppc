<x-app-layout>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0">
                <h6>Feed Analytics Dashboard</h6>
                <small>Monitor your feed health, errors, and performance.</small>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Total Imported Feeds -->
                    <div class="col-md-3">
                        <div class="card bg-light p-3 text-center">
                            <h4>{{ $totalFeeds }}</h4>
                            <small>Imported Feeds</small>
                        </div>
                    </div>

                    <!-- Total Exported Feeds -->
                    <div class="col-md-3">
                        <div class="card bg-light p-3 text-center">
                            <h4>{{ $totalExports }}</h4>
                            <small>Exported Feeds</small>
                        </div>
                    </div>

                    <!-- Total Products Imported -->
                    <div class="col-md-3">
                        <div class="card bg-light p-3 text-center">
                            <h4>{{ $totalProductsImported }}</h4>
                            <small>Total Products Processed</small>
                        </div>
                    </div>

                    <!-- Total Errors Logged -->
                    <div class="col-md-3">
                        <div class="card bg-danger text-white p-3 text-center">
                            <h4>{{ $totalErrors }}</h4>
                            <small>Errors Logged</small>
                        </div>
                    </div>
                </div>

                <!-- Last Fetch Time -->
                <div class="mt-4">
                    <h6>Last Feed Update: <strong>{{ $lastFetched }}</strong></h6>
                </div>

                <!-- Error Log Table -->
                <div class="card mt-4">
                    <div class="card-header pb-0">
                        <h6>Recent Errors</h6>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Feed Name</th>
                                    <th>Error Message</th>
                                    <th>Logged At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (\App\Models\FeedErrorLog::orderBy('logged_at', 'desc')->take(5)->get() as $error)

                                    <tr>
                                        <td>{{ $error->feed_name }}</td>
                                        <td>{{ $error->error_message }}</td>
                                        <td>{{ $error->logged_at }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
