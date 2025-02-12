<x-app-layout>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0">
                <h6>Custom Labeling Rules</h6>
                <small>Define your own product classification rules.</small>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('labeling-rules.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-2">
                            <select class="form-control" name="platform" required>
                                <option value="">Select Platform</option>
                                <option value="Google">Google Ads</option>
                                <option value="Meta">Meta Ads</option>
                                <option value="TikTok">TikTok Ads</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="label" required>
                                <option value="">Select Label</option>
                                <option value="Hero">Hero</option>
                                <option value="Villain">Villain</option>
                                <option value="Zombie">Zombie</option>
                                <option value="Sidekick">Sidekick</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="metric" required>
                                <option value="">Select Metric</option>
                                <option value="ROAS">ROAS</option>
                                <option value="Conversion Rate">Conversion Rate</option>
                                <option value="Clicks">Clicks</option>
                                <option value="Impressions">Impressions</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-control" name="condition" required>
                                <option value="">Select Condition</option>
                                <option value=">">Greater Than</option>
                                <option value="<">Less Than</option>
                                <option value="=">Equals</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="number" step="0.01" class="form-control" name="value" placeholder="Value" required>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Add Rule</button>
                        </div>
                    </div>
                </form>

                <hr>

                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th>Platform</th>
                            <th>Label</th>
                            <th>Metric</th>
                            <th>Condition</th>
                            <th>Value</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rules as $rule)
                        <tr>
                            <td>{{ $rule->platform }}</td>
                            <td>{{ $rule->label }}</td>
                            <td>{{ $rule->metric }}</td>
                            <td>{{ $rule->condition }}</td>
                            <td>{{ $rule->value }}</td>
                            <td>
                                <form method="POST" action="{{ route('labeling-rules.destroy', $rule->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
