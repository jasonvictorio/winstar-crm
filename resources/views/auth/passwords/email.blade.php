@extends('auth.guest')

@section('content')
<div class="login-box" style="width: 500px">
    <div class="login-logo">
        <a href="/">{{ config('app.name', 'Winstar CRM') }}</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
        <p class="login-box-msg">Reset password</p>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="input-group mb-3">
                <input placeholder="Email" id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>

                <button type="submit" class="btn btn-primary btn-block btn-flat">
                        {{ __('Send Password Reset Link') }}
                </button>
                <p class="mt-3 mb-0">
                    <a href="{{ route('login') }}">Back to login page</a>
                </p>
            <!-- /.col -->
            </div>

        </form>

        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->
@endsection
