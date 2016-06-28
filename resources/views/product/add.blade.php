@extends('layouts.app')

@section('content')
<div class="container back">
    @include('alert')
    <h1 class="bg-blue">Groups</h1>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <?php $numbers = range(1, 9); shuffle($numbers); $i=0; ?>
    <div class="figure-card">
         @foreach( $groups as $group)
            <div class="grid-4">
                <figure class="snip1336">
                    <img src="{{ url(BACKGROUND_PATH.$numbers[$i].'.jpg') }}" ><?php $i++; ?>
                    <!-- <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/331810/sample87.jpg" alt="sample87" /> -->
                    <figcaption>
                        <div class="profile"><span class="{{ $group['class'] }}">{{ $group['icon'] }}</span></div>
                        <h2>{{ $group['name'] }}<span>{{ date('d-M-Y', strtotime($group['created_at'])) }}</span></h2>
                        <h4>Members</h4><p>{{ $group['members'] }}</p>
                        @if (App::make('app\Http\Controllers\productController')->isUserInGroup($group['id']))
                            <a href="javascript:void(0)" class="follow-ic modal-open product-entry" data-id={{ $group['id'] }}>Make Entry</a>
                        @endif
                        <a href="{{ url('product/list/').'/'.$group['id'] }}" class="info">Check Info</a>
                    </figcaption>
                </figure>
            </div>
        @endforeach
    </div>




<div id="modal-container">
	<div id="entry" class="modal-background" >
	    <div class="modal">
	        <a href="#" class="close close-modal">&times;</button></a>
	        <form id="save-product-form" name="product-entry" method="POST" action="{{ url('product/save') }}">
	        	<div class="saving"><img src="{{ url('images/loader.gif') }}"></div>
	            {!! csrf_field() !!}
	            <h2 class="modal-title text-info">Add Product</h2>
	            <p class="text-success bg-info success"></p>
	            <div class="modal-body">
	                <input type="text" placeholder="Name" name="name" required="">
	                <div class="input-group-mix">
	                    <span class="input-group-addon">{{ CURRENCY }}</span>
	                    <input type="number" placeholder="Price" min="0" name="price" required="">
	                </div>
	                <div class="data-group">
	                    <input type='text' name="date" placeholder="Date" value="{{ date('m/d/Y') }}" class="datepicker" id='datepicker' min="0" required="" />
	                    <span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
	                </div>
	                <p class="text-danger bg-danger errors"></p>
	                <input type="hidden" class="product-group-id" name="product_group_id" value="">
	                <div class="modal-footer">
	                    <button type="button" id="add-product-ajax" class="btn btn-primary">Save &amp; Continue</button>
	                    <button type="submit" id="add-product" class="btn btn-info">Save</button>
	                    <button type="button" class="close-modal btn btn-purple btn-fill-vert" data-dismiss="modal">Cancel</button>
	                 </div>
	            </div>
	        </form> 
	    </div>
	</div>
</div>
@endsection
