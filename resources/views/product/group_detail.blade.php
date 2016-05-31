@extends('layouts.app')

@section('content')
<div class="container main">
    <?php $group = new App\Group; ?>
    <h1 class="no-wrap">Group : {{ $name = $group->getName($products['group_id']) }}</h1>
    <div class="sub-nav">    
        @include('filters.date_filters')
    </div>
    @include('alert')
    <div class="tables">
        <div class=" table-responsive-vertical shadow-z-1">
            <table id="table" class="table table-mc-light-blue">
                <thead>
                    <tr>
                        <th>Total Spend ({{ CURRENCY }})</th>
                        <th>Total Entries</th>
                        <th>Cleared ({{ CURRENCY }})</th>
                        <th>Pending ({{ CURRENCY }})</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{CURRENCY}} {{ $products['total'] }}</td>
                        <td>{{ $products['entries'] }}</td>
                        <td>{{CURRENCY}} {{ $products['cleared']['total'] }}&nbsp; ({{ $products['cleared']['count'] }} entries)</td>
                        <td>{{CURRENCY}} {{ $products['pending']['total'] }}&nbsp; ({{ $products['pending']['count'] }} entries)</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <div class="grid-wrapper">
        @foreach($products['user_data'] as $data)
            <div class="grid-6">
                <?php $user = new App\User(); ?>
                <h2 class="sub-head"><span>{{ $user->getName($data['user_id']) }}</span></h2>
                <div class="tables">
                    <div class=" table-responsive-vertical shadow-z-1">
                        <table id="table" class="table table-mc-light-blue">
                            <thead>
                                <tr>
                                    <th>Total Spend ({{ CURRENCY }})</th>
                                    <th>Total Entries</th>
                                    <th>Cleared ({{ CURRENCY }})</th>
                                    <th>Pending ({{ CURRENCY }})</th>
                                    <th>Pending From</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{CURRENCY}} {{ $data['total'] }}</td>
                                    <td>{{ $data['entries'] }}</td>
                                    <td>{{ CURRENCY }} {{ $data['cleared'] }}</td>
                                    <td>{{CURRENCY}} {{ $data['pending'] }}</td>
                                    <td>{{ $data['pending_date'] }}</td>
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
