@push('page_title')
    | Roles
@endpush
@push('navbar_header')
    Roles
@endpush
<x-app-layout>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="data-table" style="padding-top: 20px">
                    {{ $dataTable->table(['class' => 'table table-flush w-100']) }}
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
</x-app-layout>
