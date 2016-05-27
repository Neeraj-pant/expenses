@extends('layouts.app')

@section('content')
<div class="container main">
    <h1 class="no-wrap">Group List</h1>
    @include('alert')
    <div class="group-layout">
        <div class="layout-type">
            <a href="#" data-type="panels"><i class="fa fa-align-justify"></i></a><a href="#" class="active" data-type="tables"><i class="fa fa-th"></i></a>
        </div>
    </div>
    <div class="panels">
        <div class="panel-wrapper">
            <div class="panel">
                <?php $numbers = range(1, 9); shuffle($numbers); $i=0; ?>
                @foreach($groups as $group)
                    <div class="panel-element">
                        @if(Auth::check())
                            <div class="element-actions">
                                @if($group['active_user_delete'] == 0 || $group['active_user_delete'] === false)
                                    @if($group['other_user_delete'] >= 1)
                                        <span class="text-info">{{ $group['other_user_delete'] }} Delete Request for this group</span>
                                    @endif
                                    <a href="#" class="delete-group modal-open panel-button btn-action btn-hide" data-id="{{ $group['id'] }}"><i class="fa fa-trash"></i></a>
                                @else
                                    <a href="#" class="panel-button btn-action btn-heart delete-group" ><i class="fa fa-check"></i></a>
                                    <span class="text-info">Delete Request Sent</span>
                                @endif
                            </div>
                        @endif
                        <div class="element-content">
                            <button class="panel-button btn btn-more">
                                <i class="fa fa-ellipsis-h icon-closed"></i>
                                <i class="fa fa-times icon-open"></i>
                                <i class="fa fa-heart-o icon-hearted"></i>
                            </button>
                            <div class="content-post">
                                <div class="post-avatar"><img src="{{ url(BACKGROUND_PATH.$numbers[$i].'.jpg') }}" ><?php $i++; ?></div>
                                <div class="post-content">
                                    <span class="post-title">{{ $group['name'] }}</span>
                                    <p class="post-body">{{ $group['members'] }}</p>
                                     @if($group['active_user_delete'] == 0 || $group['active_user_delete'] === false)
                                        @if($group['other_user_delete'] >= 1)
                                            <span class="text-info">{{ $group['other_user_delete'] }} Delete Request for this group</span>
                                            @endif
                                        @else
                                            <span class="text-info">Delete Request Sent</span>
                                        @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="tables">
        <div class=" table-responsive-vertical shadow-z-1">
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
                                    <a href="group-detail/{{ $group['id'] }}" class="report btn btn btn-orange btn-border-rev"><i class="fa fa-paper"></i>Get Detail</a>
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
