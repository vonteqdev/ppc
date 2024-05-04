@extends('user_type.guest', ['parentFolder' => 'authentication', 'childFolder' => 'signup', 'hasFooter' => 'footer', 'navbar' => 'cover'])

@section('content')
<!--navbar-->
  <main class="main-content main-content-bg mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-sm-8 mt-7 mt-md-5">
                <div class="card-header pb-0 text-left">
                  <h3 class="font-weight-bolder text-primary text-gradient">Join us today</h3>
                  <p class="mb-0">Enter your email and password to register</p>
                </div>
                <div class="card-body pb-3">
                  <form role="form" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div>
                      <x-input-label for="name" :value="__('First Name')" />
                      <x-text-input id="first_name" class="form-control block mt-1 w-full" placeholder="First Name" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />
                      <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                  </div>
                  <div class="mt-3">
                      <x-input-label for="name" :value="__('Last Name')" />
                      <x-text-input id="last_name" class="form-control block mt-1 w-full" placeholder="Last Name" type="text" name="last_name" :value="old('last_name')" required autofocus autocomplete="last_name" />
                      <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                  </div>
                  <div class="mt-3">
                      <x-input-label for="email" :value="__('Email')" />
                      <x-text-input id="email" class="form-control block mt-1 w-full" type="email" name="email" placeholder="Email" :value="old('email')" required autocomplete="username" />
                      <x-input-error :messages="$errors->get('email')" class="mt-2" />
                  </div>
                  <div class="mt-3">
                      <x-input-label for="password" :value="__('Password')" />
                      <x-text-input id="password" class="form-control block mt-1 w-full"
                                      type="password"
                                      name="password"
                                      placeholder="Password"
                                      required autocomplete="new-password" />
                      <x-input-error :messages="$errors->get('password')" class="mt-2" />
                  </div>

                  <div class="mt-3">
                      <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                      <x-text-input id="password_confirmation" class="form-control block mt-1 w-full"
                                      type="password"
                                      placeholder="Confirm Password"
                                      name="password_confirmation" required autocomplete="new-password" />
                      <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                  </div>
                    <div class="form-check form-check-info text-left mt-3">
                      <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                      <label class="form-check-label" for="flexCheckDefault">
                        I agree the <a href="#" class="text-dark font-weight-bolder">Terms and Conditions</a>
                      </label>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn bg-gradient-primary w-100 mt-4 mb-0">Sign up</button>
                    </div>
                  </form>
                </div>
                <div class="card-footer text-center pt-0 px-sm-4 px-1">
                  <p class="mb-4 mx-auto">
                    Already have an account?
                    <a href="{{route('login')}}" class="text-primary text-gradient font-weight-bold">Sign in</a>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('assets/img/curved-images/curved11.jpg')"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
<!--footer socials-->
@endsection