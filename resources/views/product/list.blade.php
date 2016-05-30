@extends('layouts.app')

@section('content')
<div class="container ">
    <h1>Entries</h1>
    @include('alert')

    <div class="grid">
        @foreach( $users as $user )
            <div class="grid-item">
                <?php $pObj = new App\Product; $products = $pObj->getProduct($user->id, $user->group_id); ?>
                <div class="list-group">
                    <h2>{{ $user->name }}<span class="total">₹ {{ $products->total }}</span></h2>
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
                                                <p>₹ &nbsp;{{ $product->price }} </p>      
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

<script>
    $('.grid').masonry({
      itemSelector: '.grid-item'
    });
</script>
@endsection
