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
                <div class="card-header d-flex align-items-center border-bottom py-3">
                    <div class="d-flex align-items-center">
                        <a href="javascript:;">
                            <img src="../../../assets/img/google-merchant-center.svg" class="avatar" alt="profile-image" />
                        </a>
                        <div class="mx-3">
                            <a href="javascript:;" class="text-dark font-weight-600 text-sm">Google Merchant Center</a>
                            <small class="d-block text-muted">Sign in to Google Merchant to fetch your accounts, feeds and products</small>
                        </div>
                    </div>
                    <div class="text-end ms-auto">
                        <button type="button" class="btn btn-sm bg-gradient-primary mb-0"><i class="fas fa-plus pe-2" aria-hidden="true"></i>Sign In</button>
                    </div>
                </div>
                <div class="card-header d-flex align-items-center border-bottom py-3">
                    <div class="d-flex align-items-center">
                        <a href="javascript:;">
                            <img src="../../../assets/img/google-analytics.png" class="avatar" alt="profile-image" />
                        </a>
                        <div class="mx-3">
                            <a href="javascript:;" class="text-dark font-weight-600 text-sm">Google Analytics</a>
                            <small class="d-block text-muted">Sign in to Google Analytics to fetch sales statistics</small>
                        </div>
                    </div>
                    <div class="text-end ms-auto">
                        <button type="button" class="btn btn-sm bg-gradient-primary mb-0"><i class="fas fa-plus pe-2" aria-hidden="true"></i>Sign In</button>
                    </div>
                </div>
                <div class="card-header d-flex align-items-center border-bottom py-3">
                    <div class="d-flex align-items-center">
                        <a href="javascript:;">
                            <img src="../../../assets/img/google-ads.webp" class="avatar" alt="profile-image" />
                        </a>
                        <div class="mx-3">
                            <a href="javascript:;" class="text-dark font-weight-600 text-sm">Google Ads</a>
                            <small class="d-block text-muted">Sign in to Google Ads to manage your campaigns and view performance reports</small>
                        </div>
                    </div>
                    <div class="text-end ms-auto">
                        <button type="button" class="btn btn-sm bg-gradient-primary mb-0"><i class="fas fa-plus pe-2" aria-hidden="true"></i>Sign In</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
@push('scripts')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
    </script>
@endpush
@push('styles')

@endpush
</x-app-layout>
