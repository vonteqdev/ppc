@push('page_title')
    | Create Role
@endpush
@push('navbar_header')
    Create Role
@endpush
@push('navbar_actions')
<a href="{{route('roles.index')}}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-left"></i> Back to Roles page</a>
@endpush
<x-app-layout>
    <form method="post" id="roleForm">
        @csrf
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label" for="name">Role Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" autofocus />
                            <span id="error_name"></span>
                        </div>
                        <button type="submit" class="btn btn-primary" id="submitCreateRoleForm">Add Role</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        Permissions
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach ($permissions as $key => $perms)
                                <div class="custom-control custom-checkbox mb-3 ml-3">
                                    <input class="custom-control-input" name="permissions[]" onchange="checkSubPermissions('{{$key}}')" value="{{$key}}" id="perm-{{$key}}" type="checkbox">
                                    <label class="custom-control-label" for="perm-{{$key}}"><b>{{$key}}</b></label>
                                    @foreach ($perms as $perm)
                                        <div class="col-2">
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input class="custom-control-input subPerm-{{$key}}" onchange="uncheckMainPermission('{{$key}}')" name="permissions[]" value="{{$perm}}" id="perm-{{$perm}}" type="checkbox">
                                                <label class="custom-control-label" for="perm-{{$perm}}">{{$perm}}</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('scripts')
        <script>
            $('#roleForm').on('submit', function(e) {
                disableButtonBeforeSendingRequest('submitCreateRoleForm');
                e.preventDefault();
                let formData = new FormData(this);
                axios.post("{{route('roles.store')}}", formData).then((resp) => {
                    enableButtonAfterGettingResponse('submitCreateRoleForm', 'Add Role');
                    if (resp.data.success == true) {
                        $('#roleForm').trigger('reset');
                        $.notify({
                            icon: 'far fa-check-circle',
                            title: `<b>Success</b>`,
                            message: `<br>Role created successfully!`,
                        },notificationSuccessOptions);
                        setTimeout(function(){
                            window.location.href = '{{ route('roles.index') }}';
                        }, 500);
                    }
                }).catch((err) => {
                    enableButtonAfterGettingResponse('submitCreateRoleForm', 'Add Role');
                    let response = err.response.data;
                    let errorTitle = 'Validation Errors!';
                    if(err.response.status === 500) errorTitle = 'Internal Server Error';
                    var errorString = '';
                    $.each(response.errors, function (key, value) {
                        errorString += '<li>'+value+'</li>';
                        $('#'+key).addClass('is-invalid');
                        $('#error_'+key).html(value).addClass('invalid-feedback d-block');
                        $('#'+key).focus(function(){
                            $(this).removeClass('is-invalid');
                            $('#error_'+key).html('');
                        });
                    });
                    $.notify({
                        icon: 'far fa-times-circle',
                        title: `<b>${errorTitle}</b>`,
                        message: `${errorString}`,
                    },notificationDangerOptions);
                })
            });

            function checkSubPermissions(permissionName) {
                let subPermissions = document.querySelectorAll('.subPerm-'+permissionName);

                let mainCheckbox = document.getElementById('perm-'+permissionName);
                subPermissions.forEach(function (checkbox) {
                    checkbox.checked = mainCheckbox.checked;
                });
            }

            function uncheckMainPermission(permissionName) {
                let mainCheckbox = document.getElementById('perm-'+permissionName);
                if (mainCheckbox.checked) {
                    mainCheckbox.checked = false;
                }
            }
        </script>
    @endpush
</x-app-layout>

