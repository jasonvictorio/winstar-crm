@extends('auth.guest')

@section('title', 'Register')

@section('content')
<div class="register-box">
    <div class="register-logo">
        <a href="/">{{ config('app.name', 'Winstar CRM') }}</a>
    </div>

    <div class="card">
      <div class="card-body register-card-body">
        <p class="login-box-msg">Register</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf
          <div class="input-group mb-3">
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="form-control" placeholder="Full name">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input id="email" type="email" name="email" autocomplete="off" value="{{ old('email') }}" class="form-control" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
            <autocomplete-component class="input-group mb-3" :show-delete="false" css-class="form-control" placeholder="company" display-column="name" name="company_id" relation="companies">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-building"></span>
                  </div>
                </div>
            </autocomplete-component>

          <div class="input-group mb-3">
            <input id="password" type="password" class="form-control" placeholder="Password" name="password" required autocomplete="off">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input id="password-confirm" name="password_confirmation" required type="password" class="form-control" placeholder="Retype password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
              <div class="mb-2 col-12 text-danger" role="alert">
                  @if ($errors->has('name'))
                      <div>{{ $errors->first('name') }}</div>
                  @endif
                  @if ($errors->has('email'))
                      <div>{{ $errors->first('email') }}</div>
                  @endif
                  @if ($errors->has('company_id'))
                      <div>{{ $errors->first('company_id') }}</div>
                  @endif
                  @if ($errors->has('password'))
                      <div>{{ $errors->first('password') }}</div>
                  @endif
              </div>
          </div>
          <div class="row">
            <div class="col-8 d-flex align-items-center">
                <a href="/login" class="text-center">I already have a membership</a>
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">{{ __('Register') }}</button>
            </div>
          </div>
        </form>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->
{{--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
@endsection
