@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Users</h1>
    @include('alert')
    <div class="table-responsive-vertical shadow-z-1">
        <table id="table" class="table table-mc-light-blue">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Stats</th>
                    <th>Role</th>
                    @if(Auth::user()->role == 1)
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    @if($user->status == 0)
                        <tr class="danger">
                    @else
                        <tr>
                    @endif
                        <td data-title="Name">{{ $user->name }}</td>
                        <td data-title="Email">{{ $user->email }}</td>
                        <td data-title="Status">{{ userStatus($user->status) }}</td>
                        <td data-title="Role">{{ userRole($user->role) }}</td>
                        @if(Auth::user()->role == 1)
                            <td data-title="Actions">
                                <a href="#" class="edit-detail follow-single modal-open" data-id="{{ $user->id }}"><i class="fa fa-pencil"></i></a>&nbsp;
                                <a href="#" class="delete-user follow-single modal-open-2" data-id="{{ $user->id }}"><i class="fa fa-trash"></i></a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>






<div id="modal-container">
    <div id="edit" class="modal-background">
        <div class="modal">
            <a href="#" class="close close-modal">&times;</button></a>
            <form class="form-horizontal" id="edit-form" role="form" method="POST" action="update-user">
                {!! csrf_field() !!}
                <input type="text" placeholder="Name" name="name" value="{{ old('name') }}" required="">
                <input type="email" placeholder="Email" name="email" value="{{ old('email') }}" required="">
                <?php $roles = userRole(); ?>
                <select name="role" required="">
                    <option value="">--Select--</option>
                    @foreach ($roles as $key => $role)
                        <option value="{{ $key }}">{{ $role }}</option>
                    @endforeach
                </select>
                <label class="rember-label" for="#active">
                    <input type="checkbox" id="active" name="status" value="{{ old('status') }}">Active
                </label>
                <input type="hidden" name="id" value="">
                <div class="modal-footer">
                    <button type="submit" id="update-user" class="btn btn-primary">Save</button>
                    <button type="button" class="close-modal" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div id="modal-container-2">
    <div id="delete" class="modal-background">
        <div class="modal">
            <a href="#" class="close close-modal">&times;</button></a>
            <h2>Delete User</h2>
            <form name="delete-user" method="POST" action="delete-user">
                {!! csrf_field() !!}
                <input type="hidden" class="delete-id" name="delete_id" value="">                
                <div class="modal-footer">
                    <button type="submit" id="delete-user" class="btn btn-warning">Delete</button>
                    <button type="button" class="close-modal" data-dismiss="modal">Cancel</button>
                </div>
            </form> 
        </div>
    </div>
</div>
@endsection
