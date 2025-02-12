<x-app-layout>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0">
                <h6>Feed Management</h6>
                <small>Generate and optimize product feeds.</small>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach ($feeds as $feed)
                        <li class="list-group-item d-flex justify-content-between">
                            {{ $feed['name'] }}
                            <button class="btn btn-primary generate-feed" data-type="{{ $feed['type'] }}">Generate</button>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll(".generate-feed").forEach(button => {
            button.addEventListener("click", function() {
                let feedType = this.getAttribute("data-type");
                fetch("/feed-management/generate", {
                    method: "POST",
                    headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                    body: JSON.stringify({ feed_type: feedType })
                })
                .then(response => response.text())
                .then(data => {
                    alert("Feed Generated Successfully!");
                });
            });
        });
    });
    </script>
</x-app-layout>
