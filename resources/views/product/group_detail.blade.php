@extends('layouts.app')

@section('content')
<div class="container main">
    <?php $group = new App\Group; ?>
    <h1 class="no-wrap">Group : {{ $name = $group->getName($products['group_id']) }}</h1>
    <div class="sub-nav" id="group-filter">
        {{ csrf_field() }} 
        @include('filters.date_filters')
        <input type="hidden" name="gp_id" class="gp-id" value="{{ $products['group_id'] }}">
    </div>
    @include('alert')
    <div class="tables">
        <div class=" table-responsive-vertical shadow-z-1">
            <table id="table" class="table table-mc-light-blue">
                <thead>
                    <tr>
                        <th>Total Spend ({{ CURRENCY }})</th>
                        <th>Total Entries</th>
                        <th>Month Average ({{ CURRENCY }})</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{CURRENCY}} {{ $products['total'] }}</td>
                        <td>{{ $products['entries'] }}</td>
                        <td>{{CURRENCY}} {{ $products['month_avg'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <div class="grid-wrapper">
        @foreach($products['user_data'] as $data)
            <div class="grid-6">
                <?php $user = new App\User(); ?>
                <h2 class="sub-head"><span>{{ $user->getName($data['user_id']) }}</span><span>{{ $data['advance'] }}</span></h2>
                <div class="tables">
                    <div class=" table-responsive-vertical shadow-z-1">
                        <table id="table" class="table table-mc-light-blue">
                            <thead>
                                <tr>
                                    <th>Total Spend ({{ CURRENCY }})</th>
                                    <th>Total Entries</th>
                                    <th>Spend &nbsp; From &nbsp; {{CURRENCY}} {{ $products['month_avg'] }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{CURRENCY}} {{ $data['total'] }}</td>
                                    <td>{{ $data['entries'] }}</td>
                                    <td>{{CURRENCY}} {{ $data['user_avg'] }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
