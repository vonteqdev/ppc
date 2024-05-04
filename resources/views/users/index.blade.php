@push('page_title')
    | Users
@endpush
@push('navbar_header')
    Users
@endpush
<x-app-layout>
<a href="{{route('users.create')}}" type="button" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add new User</a>
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
        function deleteUser(id) {
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
                    axios.delete(`/users/${id}`)
                    .then((response) => {
                        if (response.data.success == true) {
                            Swal.fire('Success', 'User has been deleted successfully!', 'success');
                            window.LaravelDataTables["users-table"].ajax.reload()
                        }
                    })
                    .catch((error) => {
                        Swal.fire('ERROR', 'Something went wrong!', 'error');
                    });
                }
            });
        }
    </script>
@endpush
@push('styles')

@endpush
</x-app-layout>
