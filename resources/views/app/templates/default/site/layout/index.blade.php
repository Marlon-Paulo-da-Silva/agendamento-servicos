<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@if($info->company){{$info->company}}@endif - {{$title}}</title>
    @if($website->logo)<link rel="apple-touch-icon" href="/images/logos/{{$website->logo}}">@endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{$website->address}}">
    
    <!-- OpenGraph -->
    <meta property="og:title" content="@if($info->company){{$info->company}}@endif - Booking">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{url()->current()}}">
    @if($website->address)<meta property="og:description" content="{{$website->address}}">@endif

    @if($website->logo)<meta property="og:image" content="/images/logos/{{$website->logo}}">@endif
    
    
    <!-- Twitter -->
    @if($website->logo)<meta property="twitter:card" content="/images/logos/{{$website->logo}}">@endif

    <meta property="twitter:url" content="{{url()->current()}}">
    <meta property="twitter:title" content="@if($info->company){{$info->company}}@endif - Booking">
    @if($website->address)<meta property="twitter:description" content="{{$website->address}}">@endif

    @if($website->logo)<meta property="twitter:image" content="/images/logos/{{$website->logo}}">@endif
    
    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/icon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/app/templates/default/site/custom.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/swiper-bundle.min.css">
    <script src="/js/admin/jquery.min.js"></script>
    <style>
        :root {
        --main-page-color:{{$colors[0]}};
        --main-page-bg:linear-gradient(-47deg, {{$colors[1]}} 0%, {{$colors[0]}} 100%);
        }
    </style>
  </head>
  <body>

@yield('content')
<div class="gray-page" style="padding-top:0">
<div id="piskotki" class="text-center p-3">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="mb-3 mt-3">@lang('site.layout_cookies')</div>
                    </div>
                    <div class="col-xl-4 text-center">
                        <a href="#" id="confirm-piskotki" class="action-btn p-3">@lang('site.layout_cookies_ok')</a>
                    </div>
                </div>
            </div>   
        </div>
      </div>
<script src="/js/app/menu.js"></script>
<script src="/js/app/piskotki.js"></script>
<script src="/js/admin/swiped-events.js"></script>
    </body>
</html>
