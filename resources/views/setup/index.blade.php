@push('page_title')
    | Setup
@endpush
@push('navbar_header')
    Users
@endpush
<x-app-layout>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-header d-flex align-items-center border-bottom py-3">
                    <div class="d-flex align-items-center">
                        <a href="javascript:;">
                            <img src="../../../assets/img/google-merchant-center.svg" class="avatar" alt="profile-image">
                        </a>
                        <div class="mx-3">
                            <a href="javascript:void(0);" class="text-dark font-weight-600 text-sm">Import your products</a>
                            <small class="d-block text-muted">Sign in to Google to fetch your accounts, feeds, products and sales analytics</small>
                        </div>
                    </div>
                    <div class="text-end ms-auto" id="merchantButton">
                                    <a href="http://localhost:8000/setup/init-auth/merchant" class="btn btn-sm bg-gradient-primary mb-0"><i class="fas fa-plus pe-2" aria-hidden="true"></i>Import Setup</a>
                            </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
          <div class="multisteps-form mb-5">
            <!--progress bar-->
            <div class="row">
              <div class="col-12 col-lg-8 mx-auto my-5">
                <div class="multisteps-form__progress">
                  <button class="multisteps-form__progress-btn js-active" type="Primary Source" title="Primary Source">
                    <span>User Info</span>
                  </button>
                  <button class="multisteps-form__progress-btn" type="button" title="Update Schedule">Update Schedule</button>
                  <button class="multisteps-form__progress-btn" type="button" title="Mapping Fields">Mapping Fields</button>
                  <button class="multisteps-form__progress-btn" type="button" title="Profile">Profile</button>
                </div>
              </div>
            </div>
            <!--form panels-->
            <div class="row">
              <div class="col-12 col-lg-8 m-auto">
                <form class="multisteps-form__form mb-8">
                  <!--single form panel-->
                  <div class="card multisteps-form__panel p-3 border-radius-xl bg-white js-active" data-animation="FadeIn">
                    <h5 class="font-weight-bolder mb-0">Primary Source</h5>
                    <p class="mb-0 text-sm">Mandatory informations</p>
                    <div class="multisteps-form__content">
                      <div class="row mt-3">
                        <div class="col-12 col-sm-12">
                          <label>Site Name</label>
                          <input class="multisteps-form__input form-control" type="text" placeholder="www.site.ro" />
                        </div>

                      </div>
                      <div class="row mt-3">
                          <div class="col-12 col-sm-12 mt-3 mt-sm-0">
                            <label>Feed Type</label>
                            <select class="multisteps-form__select form-control">
                                <option selected="selected">Google XML</option>
                                <option value="1">CSV/TXT</option>
                                <option value="2">Google Sheets</option>
                                <option value="2">JSON</option>
                             </select>
                          </div>
                      </div>
                      <div class="row mt-3">
                        <div class="col-12 col-sm-12">
                          <label>Source location</label>
                          <input class="multisteps-form__input form-control" type="text" placeholder="https://example.ro/feed.xml" />
                        </div>
                      </div>

                      <div class="button-row d-flex mt-4">
                        <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="button" title="Next">Next</button>
                      </div>
                    </div>
                  </div>
                  <!--single form panel-->
                  <div class="card multisteps-form__panel p-3 border-radius-xl bg-white" data-animation="FadeIn">
                    <h5 class="font-weight-bolder">Address</h5>
                    <div class="multisteps-form__content">
                      <div class="row mt-3">
                        <div class="col">
                          <label>Address 1</label>
                          <input class="multisteps-form__input form-control" type="text" placeholder="eg. Street 111" />
                        </div>
                      </div>
                      <div class="row mt-3">
                        <div class="col">
                          <label>Address 2</label>
                          <input class="multisteps-form__input form-control" type="text" placeholder="eg. Street 221" />
                        </div>
                      </div>
                      <div class="row mt-3">
                        <div class="col-12 col-sm-6">
                          <label>City</label>
                          <input class="multisteps-form__input form-control" type="text" placeholder="eg. Tokyo" />
                        </div>
                        <div class="col-6 col-sm-3 mt-3 mt-sm-0">
                          <label>State</label>
                          <select class="multisteps-form__select form-control">
                            <option selected="selected">...</option>
                            <option value="1">State 1</option>
                            <option value="2">State 2</option>
                          </select>
                        </div>
                        <div class="col-6 col-sm-3 mt-3 mt-sm-0">
                          <label>Zip</label>
                          <input class="multisteps-form__input form-control" type="text" placeholder="7 letters" />
                        </div>
                      </div>
                      <div class="button-row d-flex mt-4">
                        <button class="btn bg-gradient-light mb-0 js-btn-prev" type="button" title="Prev">Prev</button>
                        <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="button" title="Next">Next</button>
                      </div>
                    </div>
                  </div>
                  <!--single form panel-->
                  <div class="card multisteps-form__panel p-3 border-radius-xl bg-white" data-animation="FadeIn">
                    <h5 class="font-weight-bolder">Socials</h5>
                    <div class="multisteps-form__content">
                      <div class="row mt-3">
                        <div class="col-12">
                          <label>Twitter Handle</label>
                          <input class="multisteps-form__input form-control" type="text" placeholder="@soft" />
                        </div>
                        <div class="col-12 mt-3">
                          <label>Facebook Account</label>
                          <input class="multisteps-form__input form-control" type="text" placeholder="https://..." />
                        </div>
                        <div class="col-12 mt-3">
                          <label>Instagram Account</label>
                          <input class="multisteps-form__input form-control" type="text" placeholder="https://..." />
                        </div>
                      </div>
                      <div class="row">
                        <div class="button-row d-flex mt-4 col-12">
                          <button class="btn bg-gradient-light mb-0 js-btn-prev" type="button" title="Prev">Prev</button>
                          <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="button" title="Next">Next</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--single form panel-->
                  <div class="card multisteps-form__panel p-3 border-radius-xl bg-white h-100" data-animation="FadeIn">
                    <h5 class="font-weight-bolder">Profile</h5>
                    <div class="multisteps-form__content mt-3">
                      <div class="row">
                        <div class="col-12">
                          <label>Public Email</label>
                          <input class="multisteps-form__input form-control" type="text" placeholder="Use an address you don't use frequently." />
                        </div>
                        <div class="col-12 mt-3">
                          <label>Bio</label>
                          <textarea class="multisteps-form__textarea form-control" rows="5" placeholder="Say a few words about who you are or what you're working on."></textarea>
                        </div>
                      </div>
                      <div class="button-row d-flex mt-4">
                        <button class="btn bg-gradient-light mb-0 js-btn-prev" type="button" title="Prev">Prev</button>
                        <button class="btn bg-gradient-dark ms-auto mb-0" type="button" title="Send">Send</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>

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
