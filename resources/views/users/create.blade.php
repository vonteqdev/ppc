@push('page_title')
    | Create User
@endpush
<x-app-layout>
<div class="row">
    <div class="col-lg-6">
        <div class="card-wrapper">
            <div class="card">
                <div class="card-body">
                    <form id="createUserForm" method="post">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-control-label" for="first_name">First Name*</label>
                                    <input type="text" required name="first_name" class="form-control" id="first_name" autofocus />
                                    <span id="error_first_name"></span>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="last_name">Last Name*</label>
                                    <input type="text" required name="last_name" class="form-control" id="last_name" />
                                    <span id="error_last_name"></span>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="email">Email*</label>
                                    <input type="email" name="email" required class="form-control" id="email" placeholder="name@example.com" />
                                    <span id="error_email"></span>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="password">Password*</label>
                                    <input type="password" required name="password" class="form-control" id="password" />
                                    <span id="error_password"></span>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="password_confirmation">Confirm Password*</label>
                                    <input type="password" required name="password_confirmation" class="form-control" id="password_confirmation" />
                                    <span id="error_password_confirmation"></span>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" id="submitCreateUserForm">Add User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        $('#createUserForm').on('keyup', function(e){
            if (e.keyCode === 13) {
                e.preventDefault();
                disableButtonBeforeSendingRequest('submitCreateUserForm');
                createUser();
            }
        });

        $('#submitCreateUserForm').on('click', function(){
            disableButtonBeforeSendingRequest('submitCreateUserForm');
            createUser();
        });

        function createUser(){
            let formData = new FormData(document.getElementById('createUserForm'));
            axios.post("{{ route('users.store') }}", formData)
                .then((resp) => {
                    enableButtonAfterGettingResponse('submitCreateUserForm', 'Add User');
                    if(resp.data.success === true){
                        $('#createUserForm').trigger('reset');
                        $.notify({
                            icon: 'far fa-check-circle',
                            title: `<b>Success</b>`,
                            message: `<br>User created successfully!`,
                        },notificationSuccessOptions);
                        setTimeout(function(){
                            window.location.href = '{{ route('users.index') }}';
                        }, 500);
                    }
                }).catch(errors => {
                    enableButtonAfterGettingResponse('submitCreateUserForm', 'Add User');
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
                }
            );
        }
    </script>
@endpush
</x-app-layout>