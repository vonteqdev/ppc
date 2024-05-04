@push('page_title')
    | Permissions
@endpush
@push('navbar_header')
    Permissions
@endpush
<x-app-layout>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col">
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
    <script>
        $(document).ready(function() {
            function updateCurrentPageValue() {
                let info = window.LaravelDataTables["permissions-table"].page.info();
                if(info.recordsTotal <= info.length){
                    $('#permissions-table_paginate').hide();
                    return;
                }
                $('#permissions-table_paginate').show();
                let currentPage = info.page + 1;
                let totalPages = info.pages;
                let string = currentPage + ' of ' + totalPages
                $('#noOfResults').replaceWith(string);
            }
            $('#permissions-table').on('draw.dt', function() {
                updateCurrentPageValue();
            });
            $('#permissions-table').on('page.dt', function() {
                updateCurrentPageValue();
            });
        });
    </script>
@endpush
</x-app-layout>
