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
                <div class="panel-heading">All Transactions</div>
                <div class="panel-body">
                    <div class="grid">
                        @foreach( $users as $user )
                            <div class="grid-item">
                                <div class="panel panel-primary">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">{{ $user->name }}</h3>
                                    </div>
                                    <ul class="list-group"><?php $pObj = new App\Product; $products = $pObj->getProduct($user->id, $user->group_id); ?>
                                        <p class="list-group-item panel-head-capt">Name<span class="pull-right"> Price </span></p>
                                        @foreach ($products as $product)
                                            <p class="list-group-item text-info">{{ $product->name }} <span class="pull-right">
                                                ₹ &nbsp;{{ $product->price }}
                                            </span> <span class="date-view">{{ date('d-M-Y', strtotime($product->date)) }}</span></p>
                                        @endforeach
                                        <p class="list-group-item text-warning warning">Total <span class="pull-right">
                                                ₹ &nbsp;{{ $products->total }}
                                        </span></p>
                                    </ul>
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
                                <div class="input-group date-select">
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
$(document).ready(function(){
    $('.date-select').datepicker({
        endDate: "tomorow",
        todayBtn: "linked",
        autoclose: true,
        format: 'dd/mm/yy',
        todayHighlight: true,
    });

    $('.grid').masonry({
      itemSelector: '.grid-item',
    });
});
</script>
@endsection
