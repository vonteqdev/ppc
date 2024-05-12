@push('page_title')
    | Setup
@endpush
@push('navbar_header')
    Users
@endpush
<x-app-layout>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-lg-12">
            <div class="card">
                <x-setup.steps />
            </div>
        </div>
        <div id="nextStepSetup" @if (auth()->user()->websites()->count() == 0) style="display:none" @endif>
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card">
                        <div class="data-table" style="padding-top: 20px">
                            {{ $dataTable->table(['class' => 'table table-flush w-100']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        $('#signOutButton').click(function() {
            axios.delete("{{ route('setup.remove-account') }}")
                .then(response => {
                    if (response.data.success) {
                        $.notify({
                            icon: 'far fa-check-circle',
                            title: `<b>Success</b>`,
                            message: `<br>Account removed successfully!`,
                        },notificationSuccessOptions);
                        $('#signOutButton').remove();
                        $('#merchantButton').append('<a href="{{route('setup.init-auth', 'merchant')}}" class="btn btn-sm bg-gradient-primary mb-0"><i class="fas fa-plus pe-2" aria-hidden="true"></i>Sign In</a>');
                        $('#nextStepSetup').remove();
                    }
                })
                .catch(error => {
                    $.notify({
                        icon: 'far fa-times-circle',
                        title: `<b>Error</b>`,
                        message: `<br>Something went wrong!`,
                    },notificationDangerOptions);
                });
        });
    </script>
@endpush
@push('styles')

@endpush
</x-app-layout>
