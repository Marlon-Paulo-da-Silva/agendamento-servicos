@extends('app.templates.default.site.layout.index', ['title' => __('site.reservations_title')])

@section('content')
    @include('app.templates.default.site.includes.header')


    <div class="gray-page">

        <div class="container">

            <input type="hidden" id="service" value="">
            <input type="hidden" id="slot" value="">
            <input type="hidden" id="user" value="">
            <input type="hidden" id="customer" value="">

            <div class="pages" id="first">

                <div class="pt-3 mb-3">
                    <div class="p-5 blush-cont">
                        <div class="row">
                            <div class="col-xl-7 col-lg-7 col-md-12">
                                <h2 class="mb-4">{{ $info->company }}</h2>
                                <h1>@lang('site.reservations_title')</h1>
                                <h3>@lang('site.reservations_from') {{ $date_start }} @lang('site.reservations_to') {{ $date_end }}</h3>
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-md-6">
                                        <a href="#" class="p-3 mt-3 choose-btn"><span
                                                class="material-icons">add</span> @lang('site.reservations_choose')</a>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 d-none d-md-block d-lg-block d-xl-block">
                                        <div class="profiles-cont">
                                            @foreach ($employees as $key => $employee)
                                                <a class="profiles user{{ $key }}"
                                                    title="{{ $employee->name }} {{ $employee->surname }}"
                                                    style="background-image:url(@if ($employee->profile_image) /images/profile_images/{{ $employee->profile_image }}@else/images/admin/icons/user_bg.png @endif), var(--main-page-bg)"></a>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-5 text-center d-none d-lg-block d-xl-block">
                                <div class="logo"
                                    style="background-image:url(@if ($website->logo) /images/logos/{{ $website->logo }}@else/images/app/templates/default/app/appointment.svg @endif);">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-12">

                        <div class="services">
                            @foreach ($categories as $cats)
                                @if ($cats['num'])
                                    <div class="service-cont">
                                        <div class="service-title">
                                            <div class="row">
                                                <div class="col-10">
                                                    {{ $cats['title'] }}
                                                </div>
                                                <div class="col-2 text-end">
                                                    <div class="expand"><span class="material-icons">expand_more</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="rows">
                                            @foreach ($cats['services'] as $service)
                                                <div class="row service">
                                                    <div class="col-12">
                                                        <a href="#" data-id="{{ $service->id }}"
                                                            data-price="{{ $info->currency_sign }}{{ \App\Helpers\Helpers::FormatPrice($info->currency_format, $service->price) }}"
                                                            data-title="{{ $service->title }}">
                                                            <div class="icon"><span
                                                                    class="material-icons">radio_button_unchecked</span>
                                                            </div>
                                                            <div>{{ $service->title }}</div>
                                                            <div style="font-size:0.8rem">
                                                                @if ($service->hours)
                                                                    {{ $service->hours }} h
                                                                @endif {{ $service->minutes }} min /
                                                                {{ $info->currency_sign }}{{ \App\Helpers\Helpers::FormatPrice($info->currency_format, $service->price) }}
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>



                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="mb-3"></div>

                    </div>
                </div>

            </div>

            <div class="pages" id="second">

                <div class="pt-3 mb-3">
                    <div class="p-5 blush-cont">
                        <div class="row">
                            <div class="col-xl-7 col-lg-7 col-md-12">
                                <h2 class="mb-4">{{ $info->company }}</h2>
                                <h1><span id="service-display"></span><span id="service-price"></span></h1>
                                <h3>@lang('site.reservations_term')</h3>
                            </div>
                            <div class="col-5 text-center d-none d-lg-block d-xl-block">
                                <div class="logo"
                                    style="background-image:url(@if ($website->logo) /images/logos/{{ $website->logo }}@else/images/app/templates/default/app/appointment.svg @endif);">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="swiper mb-3 mySwiper">
                    <div class="swiper-wrapper">
                        @foreach ($days as $day)
                            <div data-date="{{ $day['date_iso'] }}"
                                class="swiper-slide @if ($day['disabled']) {{ 'disabled' }} @endif @if ($day['selected']) {{ 'selected' }} @endif">
                                <div class="weekday">{{ $day['day_name'] }}</div>
                                <div class="day">{{ $day['day'] }}</div>
                                <div class="month">
                                    @if ($day['disabled'])
                                        {{ __('site.reservations_closed') }}@else{{ $day['month'] }}
                                    @endif
                                </div>
                                <div class="year" style="display:none">{{ $day['year'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div id="terms" class="mb-4"></div>

            </div>


            <div class="pages" id="third">

                <div class="pt-3 mb-3">
                    <div class="p-5 blush-cont">
                        <div class="row">
                            <div class="col-xl-7 col-lg-7 col-md-12">
                                <h2 class="mb-4">{{ $info->company }}</h2>
                                <h1>@lang('site.reservations_info')</h1>
                                <h3>@lang('site.reservations_submit_phone')</h3>
                            </div>
                            <div class="col-5 text-center d-none d-lg-block d-xl-block">
                                <div class="logo"
                                    style="background-image:url(@if ($website->logo) /images/logos/{{ $website->logo }}@else/images/app/templates/default/app/appointment.svg @endif);">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="customer-response"></div>

                <div class="p-4 blush-cont">
                    <div class="row">
                        <div class="12">
                            <div class="input">
                                <select size="1" class="form-control" id="form-area-code">
                                    @foreach ($area_codes as $area_code)
                                        <option
                                            value="{{ $area_code->code }}"@if ($info->area_code == $area_code->id) selected="selected" @endif>
                                            {{ $area_code->country }} (+{{ $area_code->code }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="input" style="margin-bottom:0">
                                <input type="tel" class="form-control" id="form-phone" autocomplete="off"
                                    placeholder="040 111 333">
                                <span class="material-icons">call</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="pages" id="fourth"></div>


            <div class="pages" id="fifth">


                <div class="pt-3 mb-3">
                    <div class="p-5 blush-cont">
                        <div class="row">
                            <div class="col-xl-7 col-lg-7 col-md-12">
                                <h2 class="mb-4">{{ $info->company }}</h2>
                                <h1>@lang('site.reservations_not_customer')</h1>
                                <h3>@lang('site.reservations_fill_form')</h3>
                            </div>
                            <div class="col-5 text-center d-none d-lg-block d-xl-block">
                                <div class="logo"
                                    style="background-image:url(@if ($website->logo) /images/logos/{{ $website->logo }}@else/images/app/templates/default/app/appointment.svg @endif);">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="full-customer-response"></div>

                <div class="p-4 blush-cont">

                    <div class="row">
                        <div class="col-12">
                            <div class="input">
                                <input class="form-control" placeholder="@lang('site.reservations_name')" id="full-form-name"
                                    autocomplete="off">
                                <span class="material-icons">badge</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="input">
                                <input class="form-control" placeholder="@lang('site.reservations_surname')" autocomplete="off"
                                    id="full-form-surname">
                                <span class="material-icons">badge</span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="12">
                            <div class="input">
                                <select size="1" class="form-control" id="full-form-area-code">
                                    @foreach ($area_codes as $area_code)
                                        <option
                                            value="{{ $area_code->code }}"@if ($info->area_code == $area_code->id) selected="selected" @endif>
                                            {{ $area_code->country }} (+{{ $area_code->code }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="input">
                                <input type="tel" class="form-control" id="full-form-phone" autocomplete="off"
                                    placeholder="040 111 333">
                                <span class="material-icons">call</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="input" style="margin-bottom:0">
                                <input class="form-control" type="email" placeholder="@lang('site.reservations_email')"
                                    id="full-form-email" autocomplete="off">
                                <span class="material-icons">alternate_email</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div id="navigation" class="py-3">
                <div class="container">
                    <div class="row">
                        <div class="col-6">
                            <a href="#" id="cancel-button" class="cancel-button p-3 text-center"><span
                                    class="material-icons">arrow_back_ios</span> @lang('site.reservations_back')</a>
                        </div>
                        <div class="col-6">
                            <a href="#" id="save-button" class="save-button text-center p-3" style="display:block"
                                data-url="second">@lang('site.reservations_continue') <span
                                    class="material-icons">arrow_forward_ios</span></a>
                        </div>
                    </div>

                </div>
            </div>

            <div id="myNav" class="overlay">
                <div class="overlay-content">
                    <div class="text-center mb-3" style="font-size:0.9rem">@lang('site.reservations_choose_employee')</div>
                    <div id="employees"></div>
                </div>
            </div>

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

        var languages = {
            term_reserved: "@lang('site.reservations_term_reserved')",
            price: "@lang('site.reservations_price')",
            term_cannot_be_reserved: "@lang('site.reservations_term_cannot_be_reserved')",
            why: "@lang('site.reservations_why')",
            try_again: "@lang('site.reservations_try_again')",
            no_valus_selected: "@lang('site.reservations_no_valus_selected')",
            to_begining: "@lang('site.reservations_to_begining')",
            unexpected_error: "@lang('site.reservations_unexpected_error')",
            no_available_terms: "@lang('site.reservations_no_available_terms')",
            continue: "@lang('site.reservations_continue')"
        };

        var time_format = {{$time_format}};

        
    </script>
    <script src="/js/app/swiper8.min.js"></script>
    <script src="/js/app/reservations_add.js"></script>
@endsection
