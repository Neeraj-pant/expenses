@extends('layouts.app')

@section('content')
<div class="container">
    @include('alert')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create Group</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="post" action="{{ url('/save-group') }}">
                        {!! csrf_field() !!}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Group Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div  id="group-members">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Members</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="group_member_1">
                                        <option value="">--Select--</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <p id="error" class="label label-danger"></p>
                        </div>
                        <div class="text-center">
                            <a id="create-user" href="javascript:void(0)"><span class="glyphicon glyphicon-plus"></span></a>&nbsp;&nbsp;&nbsp;
                            <a id="delete-user" href="javascript:void(0)"><span class="glyphicon glyphicon-trash"></span></a>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" id="submit-group">
                                    <i class="fa fa-btn fa-plus"></i>Add Group
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection