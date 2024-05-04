@push('page_title')
    | Edit Role
@endpush
@push('navbar_actions')
    <a href="{{route('roles.index')}}" class="btn btn-primary btn-sm"><i class="fas fa-arrow-left"></i> Back to Roles page</a>
@endpush
<x-app-layout>
    <form method="post" id="updateRoleForm">
        @csrf
        @method('put')
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="form-label" for="name">Role Name</label>
                            <input type="text" value="{{$role->name}}" name="name" id="name" class="form-control" placeholder="Name" autofocus/>
                            <span id="error_name"></span>
                        </div>
                        <button type="button" id="updateRoleButton" class="btn btn-primary">Update Role</button>
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
                                    <input class="custom-control-input" name="permissions[]" onchange="checkSubPermissions('{{$key}}')" value="{{$key}}" id="perm-{{$key}}"
                                           @if(count(array_intersect($perms, $role->permissions->pluck('name')->toArray())) == count($perms)) checked @endif
                                           type="checkbox">
                                    <label class="custom-control-label" for="perm-{{$key}}"><b>{{$key}}</b></label>
                                    @foreach ($perms as $perm)
                                        <div class="col-2">
                                            <div class="custom-control custom-checkbox mb-3">
                                                <input @if(in_array($perm, $role->permissions->pluck('name')->toArray())) checked @endif class="custom-control-input subPerm-{{$key}}"
                                                       onchange="uncheckMainPermission('{{$key}}')"
                                                       name="permissions[]" value="{{$perm}}" id="perm-{{$perm}}" type="checkbox">
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
            $(document).on('keypress', '#updateRoleForm', function (e) {
                if (e.keyCode === 13) {
                    e.preventDefault();
                    disableButtonBeforeSendingRequest('updateRoleButton');
                    updateRole();
                }
            });

            $('#updateRoleButton').on('click', function(){
                disableButtonBeforeSendingRequest('updateRoleButton');
                updateRole();
            });

            function updateRole(){
                let formData = new FormData($('#updateRoleForm')[0]);
                axios.post("{{ route('roles.update', $role->id) }}", formData)
                .then((resp) => {
                    enableButtonAfterGettingResponse('updateRoleButton', 'Update Role');
                    if (resp.data.success == true) {
                        $.notify({
                            icon: 'far fa-check-circle',
                            title: `<b>Success</b>`,
                            message: `<br>Role updated successfully!`,
                        },notificationSuccessOptions);
                        setTimeout(function(){
                            window.location.href = "{{route('roles.index')}}";
                        }, 500);
                    }
                }).catch(errors => {
                    enableButtonAfterGettingResponse('updateRoleButton', 'Update Role');
                    let errorTitle = 'Validation Errors!';
                    if(errors.response.status === 500) errorTitle = 'Internal Server Error';
                    var errorString = '';
                    $.each(errors.response.data.errors, function (key, value) {
                        errorString+=`<br>${value}`;
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
                });
            }

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
