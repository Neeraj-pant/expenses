@extends('layouts.app')

@section('content')
<div class="container">
    @include('alert')
    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">Group Details</div>
                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Members</th>
                                @if(Auth::user()->role == 1)
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($groups as $group)
                                <tr>
                                    <td>{{ $group['name'] }}</td>
                                    <td>{{ $group['members'] }}</td>
                                    @if(Auth::check())
                                        <td>
                                            <a href="#" class="edit-group"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;
                                            @if($group['active_user_delete'] == 0 || $group['active_user_delete'] === false)
                                                <a href="#" class="delete-group" data-toggle="modal" data-target="#delete" data-id="{{ $group['id'] }}"><i class="glyphicon glyphicon-trash"></i></a>&nbsp;&nbsp;
                                                <a href="#" class="report btn btn-info btn-xs"><i class="glyphicon glyphicon-paper"></i>Get Detail</a>
                                                @if($group['other_user_delete'] == 1)
                                                    <span class="text-info">You Have {{ $group['delete_request'] }} Delete Request for this group</span>
                                                @endif
                                            @else
                                                <a href="#" class="delete-group" ><i class="glyphicon glyphicon-ok"></i></a>&nbsp;&nbsp;
                                                <a href="#" class="report btn btn-info btn-xs"><i class="glyphicon glyphicon-paper"></i>Get Detail</a>&nbsp;&nbsp;
                                                <span class="text-info">Delete Request Sent</span>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>
    </div>
</div>


<div id="delete" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form name="delete-group" method="POST" action="delete-group">
            {!! csrf_field() !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Delete User</h4>
                </div>
                <div class="modal-body">
                    <h2><small class="text-primary">Delete User</small></h2>
                    <h3><small class="text-info">After your approval delete request will be send to other group member.</small></h3>
                    <h3><small class="text-info">Group will be deleted after other members approval.</small></h3>
                    <input type="hidden" class="delete-group-id" name="delete_group_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="submit" id="delete-user" class="btn btn-info">Proceed to Delete</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form> 
    </div>
</div>
@endsection
