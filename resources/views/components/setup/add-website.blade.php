<button data-bs-toggle="modal" data-bs-target="#modal-form" class="btn btn-sm bg-gradient-primary mb-0"><i class="fas fa-plus pe-2" aria-hidden="true"></i>Add Website</button>
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-center">
                        <h3 class="font-weight-bolder text-info text-gradient">Add new Website</h3>
                    </div>
                    <div class="card-body text-start">
                        <div class="row">
                            <div class="col-6">
                                <label for="website-url">Website URL</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="websiteUrlInput" placeholder="Website URL" aria-label="Website URL" aria-describedby="email-addon">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="feed-url">Feed URL</label>
                                    <div class="input-group">
                                        <input type="text" id="feedUrl" class="form-control" placeholder="Feed URL" aria-label="Feed URL" aria-describedby="email-addon">
                                    </div>
                                    <span class="text-muted" id="feedCheckingStatus" style="display:none"></span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="google_property">Google Property</label>
                                    <select class="form-control" id="google_property">
                                        <option selected disabled value="">Select Google Property</option>
                                        @foreach (auth()->user()->getAllGoogleAnalyticsProperties() as $property)
                                            <option value="{{ $property->id }}">{{ $property->display_name }} - {{ $property->type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="button" id="submitWebsite" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0">Add Website</button>
                        </div>
                </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $('#websiteUrlInput').on('focusout', function() {
        let url = $(this).val();
        if (!url.includes('https')) {
            $(this).val('https://' + url);
        }
    });
    $('#websiteUrlInput').on('focusout', function() {
        let url = $(this).val();
        if (url.includes('https')) {
            let domain = new URL(url).hostname;
            $('#google_property option').each(function() {
                if ($(this).text().includes(domain)) {
                    $(this).prop('selected', true);
                    $('#google_property').addClass('is-valid');
                    $('#websiteUrlInput').addClass('is-valid');
                    $.notify({
                        icon: 'far fa-check-circle',
                        title: `<b>Success</b>`,
                        message: `<br>We automatically selected the property for you! If the property is not correct, please select the correct one from the dropdown.`,
                    },notificationSuccessOptions);
                    return false;
                }
                $('#websiteUrlInput').addClass('is-valid');
            });
        }
    });

    $('#feedUrl').on('focusout', function() {
        let url = $(this).val();
        if (!url.includes('https')) {
            $(this).val('https://' + url);
        }
        if (url.includes('https')) {
            fetchFeedUrlAndReturnIfGood(url);
        }
    });

    $('#submitWebsite').click(function() {
        let websiteUrl = $('#websiteUrlInput').val();
        let feedUrl = $('#feedUrl').val();
        let googleProperty = $('#google_property').val();
        if (websiteUrl && feedUrl && googleProperty) {
            axios.post("{{ route('setup.add-website') }}", {
                website_url: websiteUrl,
                feed_url: feedUrl,
                google_property: googleProperty
            }).then(response => {
                if (response.data.success) {
                    $.notify({
                        icon: 'far fa-check-circle',
                        title: `<b>Success</b>`,
                        message: `<br>Website added successfully!`,
                    },notificationSuccessOptions);
                    $('#modal-form').modal('hide');
                    $('#websiteUrlInput').val('');
                    $('#feedUrl').val('');
                    $('#google_property').val('');

                    $('#websites-table').DataTable().ajax.reload();
                    $('#nextStepSetup').show();
                }
            }).catch(error => {
                $.notify({
                    icon: 'far fa-times-circle',
                    title: `<b>Error</b>`,
                    message: `<br>Something went wrong!`,
                },notificationDangerOptions);
            });
        } else {
            $.notify({
                icon: 'far fa-times-circle',
                title: `<b>Error</b>`,
                message: `<br>Please fill all the fields!`,
            },notificationDangerOptions);
        }
    });

    function fetchFeedUrlAndReturnIfGood(url) {
        $('#feedUrl').addClass('loadingInput');
        $('#feedCheckingStatus').show();
        $('#feedCheckingStatus').text('Checking feed...');
        axios.post("{{ route('setup.import-xml') }}", {
            url: url
        }).then(response => {
            if (response.data.success) {
                $.notify({
                    icon: 'far fa-check-circle',
                    title: `<b>Success</b>`,
                    message: `<br>XML feed fetched successfully!`,
                },notificationSuccessOptions);
                $('#feedUrl').addClass('is-valid');
                $('#feedUrl').removeClass('loadingInput');
                $('#feedCheckingStatus').html('Feed fetched successfully! We found <b>' + response.data.data.length + '</b> products.');
            }
        }).catch(error => {
            $('#feedUrl').addClass('is-invalid');
            $('#feedUrl').removeClass('loadingInput');
            $('#feedCheckingStatus').text('Feed could not be fetched. Please check the URL and try again.');
            $.notify({
                icon: 'far fa-times-circle',
                title: `<b>Error</b>`,
                message: `<br>Something went wrong!`,
            },notificationDangerOptions);
        });
    }
</script>
@endpush