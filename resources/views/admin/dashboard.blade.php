@extends('admin.layouts.admin')

@section('header')
    <!-- vector map CSS -->
    <link href="{{ asset('admin/vector/jquery-jvectormap-2.0.3.css') }}" rel="stylesheet">
{{--    <link href="{{ asset('admin/plugins/bower_components/vectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet" />--}}
{{--    <link href="{{ asset('admin/plugins/bower_components/css-chart/css-chart.css') }}" rel="stylesheet">--}}
@endsection

@section('title', 'Dashboard')

@section('page_title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-lg-4 col-md-12">
            <div class="white-box">
                <h3 class="box-title">
                    Wishes
                    @if ($wishes_data['change'] > 0)
                        <small class="pull-right m-t-10 text-success">
                            <i class="fa fa-sort-asc"></i> {{ abs($wishes_data['change']) }}% &gt; last month
                        </small>
                    @elseif ($wishes_data['change'] < 0)
                        <small class="pull-right m-t-10 text-danger">
                            <i class="fa fa-sort-desc"></i> {{ abs($wishes_data['change']) }}% &gt; last month
                        </small>
                    @else
                        <small class="pull-right m-t-10 text-warning">
                            <i class="fa fa-minus"></i> {{ abs($wishes_data['change']) }}% &gt; last month
                        </small>
                    @endif
                </h3>
                <div class="stats-row">
                    <div class="stat-item">
                        <h6>Total</h6> <b>{{ $wishes_data['total'] }}</b>
                    </div>
                    <div class="stat-item">
                        <h6>Completed</h6> <b>{{ $wishes_data['completed'] }}</b>
                    </div>
                    <div class="stat-item">
                        <h6>In progress</h6> <b>{{ $wishes_data['in_progress'] }}</b>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="white-box">
                <h3 class="box-title">
                    Cash Flow
                    @if ($cash_flow['change'] > 0)
                        <small class="pull-right m-t-10 text-success">
                            <i class="fa fa-sort-asc"></i> {{ abs($cash_flow['change']) }}% &gt; last month
                        </small>
                    @elseif ($cash_flow['change'] < 0)
                        <small class="pull-right m-t-10 text-danger">
                            <i class="fa fa-sort-desc"></i> {{ abs($cash_flow['change']) }}% &gt; last month
                        </small>
                    @else
                        <small class="pull-right m-t-10 text-warning">
                            <i class="fa fa-minus"></i> {{ abs($cash_flow['change']) }}% &gt; last month
                        </small>
                    @endif
                </h3>
                <div class="stats-row">
                    <div class="stat-item">
                        <h6>Inflow</h6> <b>{{ $cash_flow['inflow'] }}</b>
                    </div>
                    <div class="stat-item">
                        <h6>Outflow</h6> <b>{{ $cash_flow['outflow'] }}</b>
                    </div>
                    <div class="stat-item">
                        <h6>Net Flow</h6>
                        @if ($cash_flow['new_flow'] > 0)
                            <b class="text-success">{{ abs($cash_flow['new_flow']) }}%</b>
                        @elseif ($cash_flow['new_flow'] < 0)
                            <b class="text-danger">{{ abs($cash_flow['new_flow']) }}%</b>
                        @else
                            <b class="text-warning">{{ abs($cash_flow['new_flow']) }}%</b>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="white-box">
                <h3 class="box-title">
                    Profit
                    @if ($profits_data['change'] > 0)
                        <small class="pull-right m-t-10 text-success">
                            <i class="fa fa-sort-asc"></i> {{ abs($profits_data['change']) }}% &gt; last month
                        </small>
                    @elseif ($profits_data['change'] < 0)
                        <small class="pull-right m-t-10 text-danger">
                            <i class="fa fa-sort-desc"></i> {{ abs($profits_data['change']) }}% &gt; last month
                        </small>
                    @else
                        <small class="pull-right m-t-10 text-warning">
                            <i class="fa fa-minus"></i> {{ abs($profits_data['change']) }}% &gt; last month
                        </small>
                    @endif
                </h3>
                <div class="stats-row">
                    <div class="stat-item">
                        <h6>Total</h6> <b>{{ $profits_data['total'] }}</b></div>
                    <div class="stat-item">
                        <h6>This month</h6> <b>{{ $profits_data['this_month'] }}</b></div>
                    <div class="stat-item">
                        <h6>Today</h6> <b>{{ $profits_data['today'] }}</b></div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="white-box">
                <h3 class="box-title">Site Visits</h3>
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <my-map :map="{{ $country_data['map_data'] }}"
                                :info="{{ json_encode($country_data['map_info']) }}"></my-map>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        @foreach($country_data['visits'] as $group => $visit)
        <div class="col-md-6">
            <div class="card countries-list">
                <div class="card-block">
                    <h3 class="card-title">{{ $group }}</h3>
                    <div class="card-text">
                        <ul class="country-state slimscrollcountry col-md-12">
                            @foreach($visit as $country => $data)
                                <li>
                                    <h2>{{ $data['count'] }}</h2> <small>From {{ $country }}</small>
                                    <div class="pull-right">{{ calculatePercent($data['count'], $data['total']) }}%</div>
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-{{ $colors[rand(0, 5)] }}"
                                             role="progressbar"
                                             aria-valuenow="{{ calculatePercent($data['count'], $data['total']) }}"
                                             aria-valuemin="0"
                                             aria-valuemax="100"
                                             style="width:{{ calculatePercent($data['count'], $data['total']) }}%;">
                                            <span class="sr-only">{{ calculatePercent($data['count'], $data['total']) }}% Complete</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    <!-- Flot Charts JavaScript -->
    <script src="{{ asset('admin/plugins/bower_components/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('admin/plugins/bower_components/flot.tooltip/js/jquery.flot.tooltip.min.js') }}"></script>
    <!-- google maps api -->
    {{--<script src="{{ asset('admin/plugins/bower_components/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>--}}
{{--    <script src="{{ asset('admin/plugins/bower_components/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>--}}
    <script src="{{ asset('admin/vector/jquery-jvectormap-2.0.3.min.js') }}"></script>
    <script src="{{ asset('admin/vector/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- Sparkline charts -->
    <script src="{{ asset('admin/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <!-- EASY PIE CHART JS -->
    <script src="{{ asset('admin/plugins/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/bower_components/jquery.easy-pie-chart/easy-pie-chart.init.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('admin/js/dashboard2.js') }}"></script>
    <script>
//        $(function(){
//            $('#visits-map').vectorMap({
//                map: 'world_mill_en',
//                backgroundColor: '#FFFFFF',
//                regionStyle: {
//                    initial: {
//                        fill: '#FFCA4A',
//                        'fill-opacity': 1,
//                        stroke: 'none'
//                    },
//                    hover: {
//                        "fill-opacity": 0.8,
//                        cursor: 'pointer'
//                    },
//                },
//                series: {
//                    regions: [{
//                        values: {
//                            AF:123
//                        },
//                        scale: ['#C8EEFF', '#0071A4'],
//                        normalizeFunction: 'polynomial'
//                    }]
//                },
//                onRegionTipShow: function(e, el, code){
//                    el.html(el.html()+' (GDP - '+gdpData[code]+')');
//                }
//            });
//        });
    </script>
@endsection