@extends('app.templates.default.site.layout.index', ['title' => __('site.team_title')])

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
            <h1 class="mb-3">@lang('site.team_title')</h1>
        </div>
        <div class="row">
            @foreach($employees as $employee)
            <div class="col-xxl-4 col-xl-4 col-lg-4">
                <div class="offer p-5 text-center">
                    <div class="photo" style="background-image:url(@if($employee->profile_image)/images/profile_images/{{$employee->profile_image}}@else{{'/images/admin/icons/user_bg.png'}}@endif), var(--main-page-bg);"></div>
                    <h2 class="mb-4">{{$employee->name}} {{$employee->surname}}</h2>
                    @if($employee->about)
                    <div class="mb-4">
                        {{$employee->about}}
                    </div>
                    @endif
                    @if($employee->phone)
                    <a href="tel:+{{$employee->area_code}}{{$employee->phone}}" class="action-btn p-3"><span class="material-icons">smartphone</span> Call</a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @include('app.templates.default.site.includes.footer')
    </div>
</div>

@endsection