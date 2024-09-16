
@extends('app.templates.default.site.layout.index', ['title' => __('site.services_title')])

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
        <h1 class="mb-3">@lang('site.services_title')</h1>                    
        </div>
        <div class="row">
            <div class="col-xxl-3 col-xl-3 col-lg-3"></div>
            <div class="col-xxl-6 col-xl-6 col-lg-6">
            @foreach($categories as $cats)
        
                    <div class="service-cont">
                        <div class="service-title">
                            <div class="row">
                                <div class="col-10">
                                {{$cats['title']}}
                                </div>
                                <div class="col-2 text-end">
                                    <div class="expand"><span class="material-icons">expand_more</span></div>
                                </div>
                            </div>
                        </div>
                        <div class="rows">
                            @foreach($cats['services'] as $service)
                            <div class="service-row">
                                <div class="col col-left"><span>{{$service->title}}</span></div>
                                <div class="col col-right"><span>{{$info->currency_sign}}{{\App\Helpers\Helpers::FormatPrice($info->currency_format, $service->price)}}</span></div>
                            </div>
                            @endforeach
                        </div>
                    </div>
            @endforeach

            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3"></div>
        </div>

        @include('app.templates.default.site.includes.footer')
    </div>
</div>

<script>
          $(document).ready(function() {
            $('.service-title').on('click', function (e) {
                e.preventDefault();

                if($(this).parent().find('.rows').is(':visible'))
                {
                    $(this).parent().find('.rows').hide();
                    $(this).find('.material-icons').text('expand_more');
                } else {
                    $(this).parent().find('.rows').show();
                    $(this).find('.material-icons').text('expand_less');
                }

            })
          });
      </script>
@endsection