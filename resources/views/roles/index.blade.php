@push('page_title')
    | Roles
@endpush
@push('navbar_header')
    Roles
@endpush
<x-app-layout>
<a href="{{route('roles.create')}}" type="button" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add new Role</a>
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
<script>
function deleteRole(id) {
    Swal.fire({
        title: 'Are you sure?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'swal-button'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`/roles/${id}`)
            .then((response) => {
                if (response.data.success == true) {
                    Swal.fire('Success', 'Role has been deleted successfully!', 'success');
                    window.LaravelDataTables["roles-table"].ajax.reload()
                }
            })
            .catch((error) => {
                Swal.fire('ERROR', error.response.data.message, 'error');
            });
        }
    });
}
</script>
@endpush
</x-app-layout>
