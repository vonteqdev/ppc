@push('page_title')
    | User Information
@endpush
<x-app-layout>
<div class="container-fluid mt-4">
    {{$user}}
</div>
@push('scripts')
@endpush
@push('styles')

@endpush
</x-app-layout>
