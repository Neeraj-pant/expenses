@extends('layouts.app')

@section('content')
<?php $user = new App\User(); ?>

<script type="text/javascript">
	$(function () {
	    $('#container').highcharts({
	        title: {
	            text: 'Monthly Average of Funds',
	            x: -20 //center
	        },
	        xAxis: {
	            categories: [
	            	@foreach($products as $product)
	            		"{{ date('M', strtotime($product->date)) }}",
	            	@endforeach
	            ]
	        },
	        yAxis: {
	            title: {
	                text: 'Money'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: "{{ CURRENCY }}"
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	        series: [
	     		@foreach($users_detail as $user_data)
		         	{
		         		name: "{{ $user->getName($user_data[0][0]->user_id) }}",
		         		data: [
		         			@foreach ($user_data as $element)
		         				{{ $element[0]->total }},
		         			@endforeach
		         		]
		         	},
	        	@endforeach
	        ]
	    });
	});
</script>

    <?php $u_group = new App\UserGroup();
        $in_group = $u_group->isInGroup( Auth::user()->id, $id );
        $members = $u_group->members( $id );
    ?>

    @if(isset($in_group[0]['id']))
        <?php $product = new App\Product; $wallet = $product->wallet( $id, $members )?>
        <?php $cls = ''; if($wallet < 0 ){ $cls = 'neg'; } ?>
        <span class="wallet {{ $cls }}">Wallet &nbsp; : &nbsp; {{ round($wallet, 2) }}</span>
    @endif


<div class="container main">

    <!-- Date filter for group
     <?php $group = new App\Group;?>
    <h1 class="no-wrap">Group : {{ $name = $group->getName($id) }}</h1>
    <div class="sub-nav" id="group-filter">
        {{ csrf_field() }}
        @include('filters.date_filters')
        <input type="hidden" name="gp_id" class="gp-id" value="{{ $id }}">
    </div> -->


    @include('alert')
    <h1 class="bg-blue">Groups Detail</h1>

    <button id="graph">Graph View</button>
    <button id="table">Table View</button>
    <!-- <button id="stats">Stats</button> -->

    <div id="table-view">
	    <div class="tables">
	        <div class=" table-responsive-vertical shadow-z-1">
	            <table id="table" class="table table-mc-light-blue">
	                <thead>
	                    <tr>
	                        <th>Month</th>
	                        <th>Total Spend ({{ CURRENCY }})</th>
	                        <th>Total Entries</th>
	                        <th>Month Average ({{ CURRENCY }})</th>
	                    </tr>
	                </thead>
	                <tbody>
	                    @foreach($products as $product)
	                        <tr>
	                            <td>{{ date('M-Y', strtotime($product->date)) }}</td>
	                            <td>{{CURRENCY}} {{ $product->total }}</td>
	                            <td>{{ $product->entries }}</td>
	                            <td>{{CURRENCY}} {{ round($product->month_avg, 2) }}</td>
	                        </tr>
	                    @endforeach
	                </tbody>
	            </table>
	        </div>
	    </div>

	    <div class="grid-wrapper">
	        @foreach($users_detail as $user_data)
	            <div class="grid-6">
	                <h2 class="sub-head"><span>{{ $user->getName($user_data[0][0]->user_id) }}</span></h2>
	                <div class="tables">
	                    <div class=" table-responsive-vertical shadow-z-1">
	                        <table id="table" class="table table-mc-light-blue">
	                            <thead>
	                                <tr>
	                                    <th>Month</th>
	                                    <th>Total Entries</th>
	                                    <th>Total Spend</th>
	                                </tr>
	                            </thead>
	                            <tbody>
	                                @foreach( $user_data as $data )
	                                    <?php $type = ''; if($data[0]->advance < 0){ $type = 'neg'; } ?>
	                                    <tr>
	                                        <td>{{ date('M-Y', strtotime($data[0]->date)) }}</td>
	                                        <td>{{ $data[0]->entries }}</td>
	                                        <td>{{CURRENCY}} {{ $data[0]->total }} <span class="advance {{ $type }}">{{ round($data[0]->advance, 2) }}</span> </td>
	                                    </tr>
	                                @endforeach
	                            </tbody>
	                        </table>
	                    </div>
	                </div>
	            </div>
	        @endforeach
	    </div>
	</div>

	<div id="graph-view">
		<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
	</div>
</div>

@endsection
