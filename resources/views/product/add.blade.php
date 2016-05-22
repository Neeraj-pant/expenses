@extends('layouts.app')

@section('content')
<div class="container">
    @include('alert')
    <div class="row">
        <div class="col-xs-12">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">Select  Group</div>
                <div class="panel-body">
                    <div class="row">
                        @foreach( $groups as $group)
                        <div class="col-sm-4 text-center">
                            <div class="card" style="border:1px solid #46b8da; padding:10px">
                                <div class="card-block">
                                    <h4 class="card-title text-primary">{{ $group['name'] }}</h4>
                                    <p class="card-text"><b>Members : </b> {{ $group['members'] }}</p>
                                    <p class="card-text"><b>Created at : </b> {{ date('d-m-Y', strtotime($group['created_at'])) }}</p>
                                    <a href="#" id="product-entry" data-id="{{ $group['id'] }}" class="btn btn-info"  data-toggle="modal" data-target="#entry">Make Entry</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div id="entry" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <form name="product-entry" method="POST" action="{{ url('product/save') }}">
            {!! csrf_field() !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-primary">Add Product</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-3 col-md-offset-1 control-label">Product Name</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                        <label class="col-md-3 col-md-offset-1 control-label">Product Price</label>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-addon">₹</span>
                                    <input type="number" class="form-control" min="0" name="price" value="{{ old('price') }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                        <label class="col-md-3 col-md-offset-1 control-label">Select Date</label>
                            <div class="col-md-6">
                                <div class="input-group date">
                                    <input type='text' name="date" class="form-control datepicker" id='datepicker' value="{{ date('d/m/Y') }}" min="0" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" class="product-group-id" name="product_group_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="submit" id="add-product" class="btn btn-info">Save</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form> 
    </div>
</div>
<script type="text/javascript">
    $('.input-group.date').datepicker({
    endDate: "tomorow",
    todayBtn: "linked",
    autoclose: true,
    multidate: "d/m/y",
    todayHighlight: true,
    });
</script>
@endsection
