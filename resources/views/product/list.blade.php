@extends('layouts.app')

@section('content')
<div class="container ">
    <h1>Entries</h1>
    @include('alert')
    @if (App::make('app\Http\Controllers\productController')->isUserInGroup(Request::segment(3)))
        <button type="button" class="popup-btn btn-in product-entry" data-id={{ Request::segment(3) }}>Make Entry</button>
    @endif
    <div class="grid">
        @foreach( $users as $user )
            <div class="grid-item">
                <?php $pObj = new App\Product; $products = $pObj->getProduct($user->id, $user->group_id); ?>
                <div class="list-group">
                    <h2>{{ $user->name }}<span class="total">{{ CURRENCY }} {{ $products->total }}</span></h2>
                    <div class="entry-wrapper">
                        @if( $products->total == 0)
                            <p>No Data Found !</p>
                        @endif
                        @foreach ($products as $product)
                            <div class="cont_princ_lists">
                                <ul>
                                    <li class="list_shopping li_num_0_1">
                                        <div class="col_md_1_list">
                                            <p>{{ $product->name }}</p>
                                        </div>
                                        <div class="col_md_2_list">
                                            <p>{{ date('d-M-Y', strtotime($product->date)) }}</p>
                                        </div>
                                        <div class="col_md_3_list">
                                            <div class="cont_text_date">
                                                <p>{{ CURRENCY }} &nbsp;{{ $product->price }} </p>      
                                            </div>
                                            @if($user->id == Auth::user()->id)
                                                <div class="cont_btns_options">
                                                    <ul>
                                                        <li>
                                                            <a href="{{url('product/delete/'.$product->id)}}" class="delete-product" onclick="finish_action('0','0_1');"><i class="fa fa-trash"></i></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>



<<<<<<< HEAD


<div class="popups-cont modal-background" id="entry" >
    <div class="popups-cont__overlay"></div>
    <div class="popup">
        <div class="popup__pieces"></div>
        <div class="popup__content">
            <div class="popup__close"></div>
             <h2 class="modal-title text-info">Add Product</h2>
            <form id="save-product-form" name="product-entry" method="POST" action="{{ url('product/save') }}">
                {!! csrf_field() !!}
                <p class="text-success bg-info success"></p>
                <div class="modal-body">
                    <input type="text" placeholder="Name" name="name" value="{{ old('name') }}" required="">
                    <div class="input-group-mix">
                        <span class="input-group-addon">{{ CURRENCY }}</span>
                        <input type="number" placeholder="Price" min="0" name="price" value="{{ old('price') }}" required="">
                    </div>
                    <div class="data-group">
                        <input type='text' name="date" placeholder="Date" class="datepicker" id='datepicker' value="{{ date('d/m/Y') }}" min="0" required="" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    <p class="text-danger bg-danger errors"></p>
                    <input type="hidden" class="product-group-id" name="product_group_id" value="">
                    <input type="hidden" name="product_url" value="{{ Request::segment(3) }}">
                    <div class="modal-footer">
                        <!-- <button type="button" id="add-product-ajax" class="btn btn-primary">Save &amp; Continue</button> -->
                        <button type="submit" id="add-product" class="btn btn-info">Save</button>
                     </div>
                </div>
            </form> 
        </div>
    </div>
=======
<div id="modal-container">
	<div id="entry" class="modal-background" >
	    <div class="modal">
	        <a href="#" class="close close-modal">&times;</button></a>
	        <form id="save-product-form" name="product-entry" method="POST" action="{{ url('product/save') }}">
	            {!! csrf_field() !!}
	            <h2 class="modal-title text-info">Add Product</h2>
	            <p class="text-success bg-info success"></p>
	            <div class="modal-body">
	                <input type="text" placeholder="Name" name="name" value="{{ old('name') }}" required="">
	                <div class="input-group-mix">
	                    <span class="input-group-addon">{{ CURRENCY }}</span>
	                    <input type="number" placeholder="Price" min="0" name="price" value="{{ old('price') }}" required="">
	                </div>
	                <div class="data-group">
	                    <input type='text' name="date" placeholder="Date" class="datepicker" id='datepicker' value="{{ date('m/d/Y') }}" min="0" required="" />
	                    <span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
	                </div>
	                <p class="text-danger bg-danger errors"></p>
	                <input type="hidden" class="product-group-id" name="product_group_id" value="">
	                <input type="hidden" name="product_url" value="{{ Request::segment(3) }}">
	                <div class="modal-footer">
	                    <!-- <button type="button" id="add-product-ajax" class="btn btn-primary">Save &amp; Continue</button> -->
	                    <button type="submit" id="add-product" class="btn btn-info">Save</button>
	                    <button type="button" class="close-modal btn btn-purple btn-fill-vert" data-dismiss="modal">Cancel</button>
	                 </div>
	            </div>
	        </form> 
	    </div>
	</div>
>>>>>>> master
</div>



<script>
    $('.grid').masonry({
      itemSelector: '.grid-item'
    });
</script>
@endsection
