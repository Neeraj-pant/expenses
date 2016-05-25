@extends('layouts.app')

@section('content')
<div class="container back full">
    @include('alert')
    <div class="panel-heading"><h1>Create Group</h1></div>
    <form method="post" action="{{ url('/save-group') }}">
        {!! csrf_field() !!}
        <input type="text" placeholder="Group Name" name="name" value="{{ old('name') }}" required="">
        @if ($errors->has('name'))
            <span class="help-block">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif

        <div id="group-members">
            <div class="form-group">
                <select name="group_member_1" required="">
                    <option value="">--Select--</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <p id="error" class="help-block"></p>
        <div class="user-operation">
            <a id="create-user" class="follow" href="javascript:void(0)"><i class="fa fa-plus"></i><span>Add User</span></a>&nbsp;&nbsp;&nbsp;
            <a id="delete-user" class="follow" href="javascript:void(0)"><i class="fa fa-trash"></i><span>Remove User</span></a>
        </div>
        <div class="center-content">
            <button type="submit" class="btn btn-primary" id="submit-group">
                <i class="fa fa-btn fa-plus"></i>Add Group
            </button>
        </div>
    </form>
</div>
@endsection