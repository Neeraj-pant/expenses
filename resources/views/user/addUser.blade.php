@extends('layouts.app')

@section('content')
 

<div class="container">
    @include('alert')
    <div class="panel-heading"><h1>Add User</h1></div>
    <form method="POST" action="{{ url('/save-user') }}">
        {!! csrf_field() !!}
        <input placeholder="Name" type="text" name="name" value="{{ old('name') }}" required="">
        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
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
        <?php $roles = userRole(); ?>
    	<select name="role" required="">
            <option value="">--Select--</option>
            @foreach ($roles as $key => $role)
                <option value="{{ $key }}">{{ $role }}</option>
            @endforeach
        </select>                
        @if ($errors->has('role'))
            <span class="help-block">
                <strong>{{ $errors->first('role') }}</strong>
            </span>
        @endif
        <input type="hidden" name="status" value="1">
        <button type="submit" class="btn btn-primary">
            <i class="fa fa-btn fa-plus"></i>Add User
        </button>
    </form>
</div>
@endsection