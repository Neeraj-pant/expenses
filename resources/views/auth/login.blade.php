@extends('layouts.app')

@section('content')
<div class="container">
    @include('alert')
    <div class="panel-heading"><h1>Login</h1></div>
    <form method="POST" action="{{ url('/login') }}">
        {!! csrf_field() !!}
        <input type="email" placeholder="Email" name="email" value="{{ old('email') }}" required="">
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
        <input type="password" placeholder="Password" name="password" required="">
        @if ($errors->has('password'))
            <span class="help-block">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif
        <label class="rember-label" for="#remember">
            <input type="checkbox" id="remember" name="remember"> Remember Me
        </label>
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-btn fa-sign-in"></i>Login
        </button>
        <a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
    </form>
</div>
@endsection
