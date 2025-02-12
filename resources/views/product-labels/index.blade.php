<x-app-layout>
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-header pb-0">
                <h6>Product Labels</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('product-labels.generate') }}" method="POST">
                    @csrf
                    <button class="btn btn-primary">Generate Labels</button>
                </form>
                <ul class="list-group mt-4">
                    @foreach ($labels as $label)
                        <li class="list-group-item">
                            {{ $label->product->name }} - <strong>{{ $label->label }}</strong>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
