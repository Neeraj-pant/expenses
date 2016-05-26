@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Group Details</h1>
    @include('alert')
    <div class="table-responsive-vertical shadow-z-1">
        <table id="table" class="table table-mc-light-blue">
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
                        <td data-title="Name">{{ $group['name'] }}</td>
                        <td data-title="members">{{ $group['members'] }}</td>
                        @if(Auth::check())
                            <td data-title="sctions">
                                <!-- <a href="#" class="edit-group"><i class="glyphicon glyphicon-edit"></i></a>&nbsp; -->
                                <a href="#" class="report btn btn btn-orange btn-border-rev"><i class="fa fa-paper"></i>Get Detail</a>
                                @if($group['active_user_delete'] == 0 || $group['active_user_delete'] === false)
                                    <a href="#" class="delete-group modal-open" data-id="{{ $group['id'] }}"><i class="fa fa-trash"></i></a>
                                    @if($group['other_user_delete'] >= 1)
                                        <span class="text-info">{{ $group['other_user_delete'] }} Delete Request for this group</span>
                                    @endif
                                @else
                                    <a href="#" class="delete-group" ><i class="fa fa-check"></i></a>
                                    <span class="text-info">Delete Request Sent</span>
                                @endif
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

<!-- <div class="content">
  <h1>Modal Animations</h1>
  <div class="buttons">
    <div id="one" class="button">Unfolding</div>
    <div id="two" class="button">Revealing</div>
    <div id="three" class="button">Uncovering</div>
    <div id="four" class="button">Blow Up</div><br>
    <div id="five" class="button">Meep Meep</div>
    <div id="six" class="button">Sketch</div>
    <div id="seven" class="button">Bond</div>
  </div>
</div> -->

<div id="modal-container">
    <div id="delete" class="modal-background">
        <div class="modal">
            <a href="#" class="close close-modal">&times;</button></a>
            <form name="delete-group" method="POST" action="delete-group">
                {!! csrf_field() !!}
                <div class="modal-body">
                    <h2><small class="text-primary">Delete User</small></h2>
                    <h3><small class="text-info">After your approval delete request will be send to other group member.</small></h3>
                    <h3><small class="text-info">Group will be deleted after other members approval.</small></h3>
                    <input type="hidden" class="delete-group-id" name="delete_group_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="submit" id="delete-user" class="btn btn-navy btn-fill-vert-o">Proceed to Delete</button>
                    <button type="button" class="close-modal btn btn-purple btn-fill-vert" data-dismiss="modal">Cancel</button>
                </div>
            </form> 
        </div>
    </div>
</div>
@endsection
