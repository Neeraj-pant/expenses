@extends('layouts.app')

@section('content')

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
    <button id="stat">User Stat</button>
    <button id="Properties">Properties</button>

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
	                <?php $user = new App\User(); ?>
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
		<canvas id="myChart" width="400" height="400"></canvas>
		<script>
			var ctx = document.getElementById("myChart");
			var myChart = new Chart(ctx, {
			    type: 'bar',
			    data: {
			        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
			        datasets: [{
			            label: '# of Votes',
			            data: [12, 19, 3, 5, 2, 3],
			            backgroundColor: [
			                'rgba(255, 99, 132, 0.2)',
			                'rgba(54, 162, 235, 0.2)',
			                'rgba(255, 206, 86, 0.2)',
			                'rgba(75, 192, 192, 0.2)',
			                'rgba(153, 102, 255, 0.2)',
			                'rgba(255, 159, 64, 0.2)'
			            ],
			            borderColor: [
			                'rgba(255,99,132,1)',
			                'rgba(54, 162, 235, 1)',
			                'rgba(255, 206, 86, 1)',
			                'rgba(75, 192, 192, 1)',
			                'rgba(153, 102, 255, 1)',
			                'rgba(255, 159, 64, 1)'
			            ],
			            borderWidth: 1
			        }]
			    },
			    options: {
			        scales: {
			            yAxes: [{
			                ticks: {
			                    beginAtZero:true
			                }
			            }]
			        }
			    }
			});
			</script>
	</div>
<script>
var chartInstance = new Chart(ctx, {
    type: 'line',
    data: data,
    options: {
        responsive: false
    }
});
</script>
</div>
@endsection
