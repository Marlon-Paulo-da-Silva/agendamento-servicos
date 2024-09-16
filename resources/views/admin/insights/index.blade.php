@extends('admin.layout.index')

@section('content')


      <div class="pt-5 gray-page">
        
        <div class="container">
            <div class="row">
            <div class="col-xxl-4 col-xl-4 col-lg-4">
                    <div class="stat sms-show p-3 mb-4">
                        <div class="row">
                            <div class="col-12">Average daily income this year</div>
                        </div>
                        <div class="text-center my-4" style="height:131px">
                            <h2 class="average-daily-income">{{$info->currency_sign}}{{\App\Helpers\Helpers::FormatPrice($info->currency_format, $avg_profit)}} / day</span></h2>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4">
                    <div class="stat p-3 mb-4">
                            <div class="row">
                                    <div class="col-12">Income in previous years</div>
                            </div>
                            <div class="chart years-chart">
                            @if(count($y_axis_profits) < 5)
                                <div class="range" style="bottom:calc(0% - 0.6rem);">{{$y_axis_profits[0]}}</div>
                                <div class="range" style="bottom:calc(33% - 0.6rem);">{{$y_axis_profits[1]}}</div>
                                <div class="range" style="bottom:calc(66% - 0.6rem);">{{$y_axis_profits[2]}}</div>
                                <div class="range" style="bottom:calc(100% - 0.6rem);">{{$y_axis_profits[3]}}</div>
                            @else
                                <div class="range" style="bottom:calc(0% - 0.6rem);">{{$y_axis_profits[0]}}</div>
                                <div class="range" style="bottom:calc(25% - 0.6rem);">{{$y_axis_profits[1]}}</div>
                                <div class="range" style="bottom:calc(50% - 0.6rem);">{{$y_axis_profits[2]}}</div>
                                <div class="range" style="bottom:calc(75% - 0.6rem);">{{$y_axis_profits[3]}}</div>
                                <div class="range" style="bottom:calc(100% - 0.6rem);">{{$y_axis_profits[4]}}</div>
                            @endif

                                    <div class="bar" style="height:{{$year_profits_display[4]['percent']}}%"></div>
                                    <div class="bar" style="height:{{$year_profits_display[3]['percent']}}%"></div>
                                    <div class="bar" style="height:{{$year_profits_display[2]['percent']}}%"></div>
                                    <div class="bar" style="height:{{$year_profits_display[1]['percent']}}%"></div>
                                    <div class="bar" style="height:{{$year_profits_display[0]['percent']}}%"></div>
                            </div>
                            <div class="mt-2" id="days" class="years">
                                <div>{{$year_profits_display[4]['year']}}<br>{{$year_profits_display[4]['profit']}}€</div>
                                <div>{{$year_profits_display[3]['year']}}<br>{{$year_profits_display[3]['profit']}}€</div>
                                <div>{{$year_profits_display[2]['year']}}<br>{{$year_profits_display[2]['profit']}}€</div>
                                <div>{{$year_profits_display[1]['year']}}<br>{{$year_profits_display[1]['profit']}}€</div>
                                <div>{{$year_profits_display[0]['year']}}<br>{{$year_profits_display[0]['profit']}}€</div>
                            </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4">
                    <div class="stat p-3 mb-4">
                            <div class="row">
                                    <div class="col-12">Average daily income over the years</div>
                            </div>
                            <div class="chart years-chart">
                            @if(count($y_axis_daily_inc) < 5)
                                <div class="range" style="bottom:calc(0% - 0.6rem);">{{$y_axis_daily_inc[0]}}</div>
                                <div class="range" style="bottom:calc(33% - 0.6rem);">{{$y_axis_daily_inc[1]}}</div>
                                <div class="range" style="bottom:calc(66% - 0.6rem);">{{$y_axis_daily_inc[2]}}</div>
                                <div class="range" style="bottom:calc(100% - 0.6rem);">{{$y_axis_daily_inc[3]}}</div>
                            @else
                                <div class="range" style="bottom:calc(0% - 0.6rem);">{{$y_axis_daily_inc[0]}}</div>
                                <div class="range" style="bottom:calc(25% - 0.6rem);">{{$y_axis_daily_inc[1]}}</div>
                                <div class="range" style="bottom:calc(50% - 0.6rem);">{{$y_axis_daily_inc[2]}}</div>
                                <div class="range" style="bottom:calc(75% - 0.6rem);">{{$y_axis_daily_inc[3]}}</div>
                                <div class="range" style="bottom:calc(100% - 0.6rem);">{{$y_axis_daily_inc[4]}}</div>
                            @endif

                                    <div class="bar" style="height:{{$year_daily_inc_display[4]['percent']}}%"></div>
                                    <div class="bar" style="height:{{$year_daily_inc_display[3]['percent']}}%"></div>
                                    <div class="bar" style="height:{{$year_daily_inc_display[2]['percent']}}%"></div>
                                    <div class="bar" style="height:{{$year_daily_inc_display[1]['percent']}}%"></div>
                                    <div class="bar" style="height:{{$year_daily_inc_display[0]['percent']}}%"></div>
                            </div>
                            <div class="mt-2" id="days" class="years">
                                <div>{{$year_daily_inc_display[4]['year']}}<br>{{$year_daily_inc_display[4]['profit']}}€</div>
                                <div>{{$year_daily_inc_display[3]['year']}}<br>{{$year_daily_inc_display[3]['profit']}}€</div>
                                <div>{{$year_daily_inc_display[2]['year']}}<br>{{$year_daily_inc_display[2]['profit']}}€</div>
                                <div>{{$year_daily_inc_display[1]['year']}}<br>{{$year_daily_inc_display[1]['profit']}}€</div>
                                <div>{{$year_daily_inc_display[0]['year']}}<br>{{$year_daily_inc_display[0]['profit']}}€</div>
                            </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4">
                    <div class="stat p-3 mb-4">
                            <div class="row">
                                    <div class="col-12">Reservations in the past 30 days</div>
                            </div>
                            <div class="chart">
                            @if(count($y_axis) < 5)
                                <div class="range" style="bottom:calc(0% - 0.6rem);">{{$y_axis[0]}}</div>
                                <div class="range" style="bottom:calc(33% - 0.6rem);">{{$y_axis[1]}}</div>
                                <div class="range" style="bottom:calc(66% - 0.6rem);">{{$y_axis[2]}}</div>
                                <div class="range" style="bottom:calc(100% - 0.6rem);">{{$y_axis[3]}}</div>
                            @else
                                <div class="range" style="bottom:calc(0% - 0.6rem);">{{$y_axis[0]}}</div>
                                <div class="range" style="bottom:calc(25% - 0.6rem);">{{$y_axis[1]}}</div>
                                <div class="range" style="bottom:calc(50% - 0.6rem);">{{$y_axis[2]}}</div>
                                <div class="range" style="bottom:calc(75% - 0.6rem);">{{$y_axis[3]}}</div>
                                <div class="range" style="bottom:calc(100% - 0.6rem);">{{$y_axis[4]}}</div>
                            @endif

                                @foreach($chart_days as $day)
                                    <div class="bar" style="height:{{$day['percent']}}%"></div>
                                @endforeach
                            </div>
                            <div class="mt-2" id="days">
                                <div>Mon<br>{{$chart_days['mon']['reservations']}}</div>
                                <div>Tue<br>{{$chart_days['tue']['reservations']}}</div>
                                <div>Wed<br>{{$chart_days['wed']['reservations']}}</div>
                                <div>Thu<br>{{$chart_days['thu']['reservations']}}</div>
                                <div>Fri<br>{{$chart_days['fri']['reservations']}}</div>
                                <div>Sat<br>{{$chart_days['sat']['reservations']}}</div>
                                <div>Sun<br>{{$chart_days['sun']['reservations']}}</div>
                            </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4">
                    <div class="stat p-3 mb-4">
                            <div class="row">
                                    <div class="col-12">Reservations this week</div>
                            </div>
                            <div class="chart">
                            @if(count($y_axis_weekly) < 5)
                                <div class="range" style="bottom:calc(0% - 0.6rem);">{{$y_axis_weekly[0]}}</div>
                                <div class="range" style="bottom:calc(33% - 0.6rem);">{{$y_axis_weekly[1]}}</div>
                                <div class="range" style="bottom:calc(66% - 0.6rem);">{{$y_axis_weekly[2]}}</div>
                                <div class="range" style="bottom:calc(100% - 0.6rem);">{{$y_axis_weekly[3]}}</div>
                            @else
                                <div class="range" style="bottom:calc(0% - 0.6rem);">{{$y_axis_weekly[0]}}</div>
                                <div class="range" style="bottom:calc(25% - 0.6rem);">{{$y_axis_weekly[1]}}</div>
                                <div class="range" style="bottom:calc(50% - 0.6rem);">{{$y_axis_weekly[2]}}</div>
                                <div class="range" style="bottom:calc(75% - 0.6rem);">{{$y_axis_weekly[3]}}</div>
                                <div class="range" style="bottom:calc(100% - 0.6rem);">{{$y_axis_weekly[4]}}</div>
                            @endif

                                @foreach($weekly_days as $day)
                                    <div class="bar" style="height:{{$day['percent']}}%"></div>
                                @endforeach
                            </div>
                            <div class="mt-2" id="days">
                                <div>Mon<br>{{$weekly_days['mon']['reservations']}}</div>
                                <div>Tue<br>{{$weekly_days['tue']['reservations']}}</div>
                                <div>Wed<br>{{$weekly_days['wed']['reservations']}}</div>
                                <div>Thu<br>{{$weekly_days['thu']['reservations']}}</div>
                                <div>Fri<br>{{$weekly_days['fri']['reservations']}}</div>
                                <div>Sat<br>{{$weekly_days['sat']['reservations']}}</div>
                                <div>Sun<br>{{$weekly_days['sun']['reservations']}}</div>
                            </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4">
                    <div class="stat p-3 mb-4">
                        <div class="row">
                            <div class="col-12">Current saloon occupancy</div>
                        </div>
                        <div class="text-center my-4" style="height:131px">
                            <div role="progressbar" style="--value:{{$occupied}}"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            @include('admin.layout.footer')
    </div>


@endsection