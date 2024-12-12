<div class="card-header d-flex align-items-center border-bottom py-3">
    <div class="d-flex align-items-center">
        <a href="javascript:;">
            <img src="../../../assets/img/google-merchant-center.svg" class="avatar" alt="profile-image" />
            <img src="../../../assets/img/google-analytics.png" class="avatar" alt="profile-image" />
            <img src="../../../assets/img/google-ads.webp" class="avatar" alt="profile-image" />
        </a>
        <div class="mx-3">
            <a href="javascript:void(0);" class="text-dark font-weight-600 text-sm">Google Connect</a>
            <small class="d-block text-muted">Sign in to Google to fetch your accounts, feeds, products and sales analytics</small>
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
@if (auth()->user()->readyToAddWebsite())
    <div class="card-header d-flex align-items-center border-bottom py-3">
        <div class="d-flex align-items-center">
            <a href="javascript:;">
                <i class="fas fa-globe fa-2x"></i>
            </a>
            <div class="mx-3">
                <a href="javascript:void(0);" class="text-dark font-weight-600 text-sm">Website</a>
                <small class="d-block text-muted">Add your website and connect it with your Google data</small>
            </div>
        </div>
        <div class="text-end ms-auto" id="merchantButton">
            <x-setup.add-website />
        </div>
    </div>
@endif