@extends('app.templates.default.site.layout.index', ['title' => __('site.working_hours_title')])

@section('content')

@include('app.templates.default.site.includes.header')

<div class="pt-5 gray-page">

    <div class="container">
        @if($website->logo)
        <div class="text-center">
            <a href="/" title="@lang('site.index_title')"><img src="/images/logos/{{$website->logo}}" class="mb-5" width="200"></a>
        </div>
        @endif
    </div>

    <div class="container">
        <div class="text-center mb-5">
            <h1 class="mb-3">@lang('site.working_hours_title')</h1>
        </div>
        <div class="row">
            <div class="col-xxl-3 col-xl-3 col-lg-3"></div>
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="offer working-hours py-5 px-3">
                    <div class="row">
                        <div class="col-6 text-end"><span>@lang('site.working_hours_monday')</span></div>
                        <div class="col-6">
                            @if($times->mon_closed)
                            <span class="closed">@lang('site.working_hours_closed')</span>
                            @else
                            @if($times->mon_from)
                            <span>{{$times->mon_from}}</span> - <span>{{$times->mon_to}}</span>
                            @endif
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 text-end"><span>@lang('site.working_hours_tuesday')</span></div>
                        <div class="col-6">
                            @if($times->tue_closed)
                            <span class="closed">@lang('site.working_hours_closed')</span>
                            @else
                            @if($times->tue_from)
                            <span>{{$times->tue_from}}</span> - <span>{{$times->tue_to}}</span>
                            @endif
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 text-end"><span>@lang('site.working_hours_wednesday')</span></div>
                        <div class="col-6">
                            @if($times->wed_closed)
                            <span class="closed">@lang('site.working_hours_closed')</span>
                            @else
                            @if($times->wed_from)
                            <span>{{$times->wed_from}}</span> - <span>{{$times->wed_to}}</span>
                            @endif
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 text-end"><span>@lang('site.working_hours_thursday')</span></div>
                        <div class="col-6">
                            @if($times->thu_closed)
                            <span class="closed">@lang('site.working_hours_closed')</span>
                            @else
                            @if($times->thu_from)
                            <span>{{$times->thu_from}}</span> - <span>{{$times->thu_to}}</span>
                            @endif
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 text-end"><span>@lang('site.working_hours_friday')</span></div>
                        <div class="col-6">
                            @if($times->fri_closed)
                            <span class="closed">@lang('site.working_hours_closed')</span>
                            @else
                            @if($times->fri_from)
                            <span>{{$times->fri_from}}</span> - <span>{{$times->fri_to}}</span>
                            @endif
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 text-end"><span>@lang('site.working_hours_saturday')</span></div>
                        <div class="col-6">
                            @if($times->sat_closed)
                            <span class="closed">@lang('site.working_hours_closed')</span>
                            @else
                            @if($times->sat_from)
                            <span>{{$times->sat_from}}</span> - <span>{{$times->sat_to}}</span>
                            @endif
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 text-end"><span>@lang('site.working_hours_sunday')</span></div>
                        <div class="col-6">
                            @if($times->sun_closed)
                            <span class="closed">@lang('site.working_hours_closed')</span>
                            @else
                            @if($times->sun_from)
                            <span>{{$times->sun_from}}</span> - <span>{{$times->sun_to}}</span>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3"></div>
        </div>

        @include('app.templates.default.site.includes.footer')
    </div>
</div>

@endsection