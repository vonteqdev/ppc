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
                            <a href="javascript:void(0);" class="text-dark font-weight-600 text-sm">Google Merchant Center</a>
                            <small class="d-block text-muted">Sign in to Google Merchant to fetch your accounts, feeds and products</small>
                        </div>
                    </div>
                    <div class="text-end ms-auto" id="merchantButton">
                        @if (!auth()->user()->google_account)
                            <a href="{{route('setup.init-auth', 'merchant')}}" class="btn btn-sm bg-gradient-primary mb-0"><i class="fas fa-plus pe-2" aria-hidden="true"></i>Sign In</a>
                        @else
                            <button id="signOutButton" class="btn btn-sm bg-gradient-danger mb-0"><i class="fas fa-minus pe-2" aria-hidden="true"></i>Sign Out</button>
                        @endif
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
                    <!-- {{ $dataTable->table(['class' => 'table table-flush w-100']) }} -->
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="xmlFeedURL" class="form-label">XML Feed URL</label>
                                <input type="text" id="xmlFeedURL" class="form-control" id="xmlFeedURL" placeholder="XML Feed URL">
                            </div>
                            <button type="button" id="startFetching" class="btn btn-primary">Scan XML</button>
                        </div>
                        <div class="col-6" id="feedProducts">

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
        $('#startFetching').click(function(e) {
            e.preventDefault();
            e.target.disabled = true;
            e.target.innerHTML = 'Fetching...';
            axios.post("{{ route('setup.import-xml') }}", {
                url: $('#xmlFeedURL').val()
            }).then(response => {
                if (response.data.success) {
                    $.notify({
                        icon: 'far fa-check-circle',
                        title: `<b>Success</b>`,
                        message: `<br>XML feed fetched successfully!`,
                    },notificationSuccessOptions);

                    let html = '';
                    response.data.data.forEach(product => {
                        html += `<div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3">
                                        <img src="${product.image_link}" class="img-fluid" alt="product-image">
                                    </div>
                                    <div class="col-9">
                                        <h5>${product.title}</h5>
                                        <p>${product.description}</p>
                                        <p>Price: ${product.price}</p>
                                        <p>Availability: ${product.availability}</p>
                                        <p>Condition: ${product.condition}</p>
                                        <p>Brand: ${product.brand}</p>
                                        <p>Product Type: ${product.product_type}</p>
                                        <p>Shipping: ${product.shipping.country} - ${product.shipping.price}</p>
                                        <p>Tax: ${product.tax.country} - ${product.tax.rate} - ${product.tax.tax_ship}</p>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                    });
                    $('#feedProducts').html(html);
                }
                e.target.disabled = false;
                e.target.innerHTML = 'Scan XML';
            }).catch(error => {
                $.notify({
                    icon: 'far fa-times-circle',
                    title: `<b>Error</b>`,
                    message: `<br>Something went wrong!`,
                },notificationDangerOptions);
                e.target.disabled = false;
                e.target.innerHTML = 'Scan XML';
            });
        })
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
