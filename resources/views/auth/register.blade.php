@extends('auth.layouts')

@section('content')

<body class="app app-signup p-0">
  <div class="row g-0 app-auth-wrapper">

    <div class="col-12 col-md-7 col-lg-6 auth-main-col text-center p-5">
      <div class="d-flex flex-column align-content-end">
        <div class="app-auth-body mx-auto">

          <div class="app-auth-branding mb-4">
            <a class="app-logo" href="index.html"><img class="logo-icon me-2" src="{{asset('images/app-logo.svg') }}" alt="logo"></a>
          </div>

          <h2 class="auth-heading text-center mb-4">{{ __('Register') }}</h2>

          <div class="auth-form-container text-start mx-auto">

            <form class="auth-form auth-signup-form" method="POST" action="{{ route('register') }}">
              @csrf

              <div class="email mb-3">
                <label class="sr-only" for="name">{{ __('Name') }}</label>
                <input id="name" name="name" type="text" class="form-control signup-name @error('name') is-invalid @enderror" placeholder="{{ __('Name') }}" required autocomplete="name" autofocus value="{{ old('name') }}">
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="email mb-3">
                <label class="sr-only" for="email">{{ __('E-Mail Address') }}</label>
                <input id="email" name="email" type="email" class="form-control signup-email @error('email') is-invalid @enderror" placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="password mb-3">
                <label class="sr-only" for="password">{{ __('Password') }}</label>
                <input id="password" name="password" type="password" class="form-control signup-password @error('password') is-invalid @enderror" placeholder="{{ __('Password') }}" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>

              <div class="password mb-3">
                <label class="sr-only" for="password-confirm">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" name="password_confirmation" type="password" class="form-control signup-password @error('password') is-invalid @enderror" placeholder="{{ __('Confirm Password') }}" required autocomplete="new-password">
              </div>

              <div class="text-center">
                <button type="submit" class="btn app-btn-primary w-100 theme-btn mx-auto">{{ __('Register') }}</button>
              </div>

            </form>

            <div class="auth-option text-center pt-5">Already have an account? <a class="text-link" href="{{route('login')}}" >{{ __('Login') }}</a></div>

          </div>

        </div>

        <footer class="app-auth-footer">
          <div class="container text-center py-3">
            <small class="copyright">by <a class="app-link" href="http://themes.3rdwavemedia.com" target="_blank">Xiaoying Riley</a> for developers</small>
          </div>
        </footer>

      </div>
    </div>

    <div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
      <div class="auth-background-holder"></div>
      <div class="auth-background-mask"></div>
    </div>

  </div>

</body>

@endsection
