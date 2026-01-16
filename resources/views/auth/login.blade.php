@extends('auth.layouts')

@section('content')

<body class="app app-login p-0">

  <div class="row g-0 app-auth-wrapper">

    <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">

      <div class="d-flex flex-column align-content-end">

        <div class="app-auth-body mx-auto">

          <div class="app-auth-branding mb-4"><a class="app-logo" href="index.html"><img class="logo-icon me-2"
                src="{{asset('images/app-logo.svg')}}" alt="logo"></a>
          </div>

          <h2 class="auth-heading text-center mb-5">{{ __('Login') }}</h2>

          <div class="auth-form-container text-start">

            <form class="auth-form login-form" method="POST" action="{{ route('login') }}">
                @csrf

              <div class="email mb-3">

                <label class="sr-only" for="email">{{ __('E-Mail Address') }}</label>

                <input id="email" name="email" type="email" class="form-control signin-email @error('email') is-invalid @enderror"
                  placeholder="{{ __('E-Mail Address') }}" required="required" autocomplete="email" autofocus value="{{ old('email') }}">

                @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror

              </div>

              <div class="password mb-3">
                <label class="sr-only" for="signin-password">{{ __('Password') }}</label>

                <input id="password" name="password" type="password" class="form-control signin-password @error('password') is-invalid @enderror"
                  placeholder="{{ __('Password') }}" required autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror

                <div class="extra mt-3 row justify-content-between">

                  <div class="col-6">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="remember" name="remember" {{ old('remember')? 'checked' : '' }}>
                      <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                      </label>
                    </div>
                  </div>

                  @if (Route::has('password.request'))
                  <div class="col-6">
                    <div class="forgot-password text-end">
                      <a href="{{route('password.request')}}">{{ __('Forgot Your Password?') }}</a>
                    </div>
                  </div>
                  @endif

                </div>

              </div>

              <div class="text-center">
                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">{{ __('Login') }}</button>
              </div>

            </form>

            <div class="auth-option text-center pt-5">No Account? Sign up <a class="text-link"
                href="{{route("register")}}">here</a>.
            </div>

          </div>


        </div>


        <footer class="app-auth-footer">
          <div class="container text-center py-3">
            <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
            <small class="copyright">by <a
                class="app-link" href="http://themes.3rdwavemedia.com" target="_blank">Xiaoying Riley</a> for
              developers</small>

          </div>
        </footer>

      </div>
    </div>

    <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
      <div class="auth-background-holder">
      </div>
      <div class="auth-background-mask"></div>
    </div>

  </div>

</body>

@endsection
