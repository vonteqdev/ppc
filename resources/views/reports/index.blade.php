<x-app-layout>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0">
                <h6>Scheduled Reports</h6>
                <small>Manage automated PPC performance reports.</small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('reports.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Frequency</label>
                        <select name="frequency" class="form-control">
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Schedule Report</button>
                </form>

                <hr>

                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Frequency</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schedules as $schedule)
                        <tr>
                            <td>{{ $schedule->email }}</td>
                            <td>{{ ucfirst($schedule->frequency) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
