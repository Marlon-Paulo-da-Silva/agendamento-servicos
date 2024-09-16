@extends('app.templates.default.site.layout.index', ['title' => __('site.contact_title')])

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
        <h1 class="mb-3">@lang('site.contact_title')</h1>
                             
        </div>
        @if($info->company)
        <div class="row">
            <div class="col-xxl-3 col-xl-3 col-lg-3"></div>
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="offer p-5 text-center">
                @if($info->company)<h2>{{$info->company}}</h2>@endif
                    <div class="text-center">
                        @if($info->address){{$info->address}}<br>@endif
                        @if($info->zip){{$info->zip}}@endif @if($info->city){{$info->city}}<br><br>@endif
                        @if($info->taxid)@lang('site.contact_vat') {{$info->taxid}}<br><br>@endif
                        @if($info->site_email)@lang('site.contact_email') <a href="mailto:{{$info->site_email}}">{{$info->site_email}}</a><br>@endif
                        @if($info->site_phone)@lang('site.contact_phone') {{$info->site_phone}}@endif
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3"></div>
        </div>
        @endif
        <div class="row">
            <div class="col-xxl-3 col-xl-3 col-lg-3"></div>
            <div class="col-xxl-6 col-xl-6 col-lg-6">
                <div class="offer p-5 text-center">
                    <div id="contact-container">
                    <div id="contact-errors"></div>
                    <h2 class="mb-3">@lang('site.contact_send_msg')</h2>
                    <div class="input">
                        <input type="text" class="form-control" id="contact-name" autocomplete="off" placeholder="@lang('site.contact_name')">
                        <span class="material-icons">badge</span>
                    </div>
                    <div class="input">
                        <input type="email" class="form-control" id="contact-email" autocomplete="off" placeholder="@lang('site.contact_email')">
                        <span class="material-icons">email</span>
                    </div>
                    <div class="input">
                        <input type="text" class="form-control" id="contact-subject" autocomplete="off" placeholder="@lang('site.contact_subject')">
                        <span class="material-icons">format_quote</span>
                    </div>
                    <div class="input-plain">
                        <textarea class="form-control" placeholder="@lang('site.contact_message')" id="contact-message" cols="30" rows="5"></textarea>
                    </div>
                    <a href="#" class="action-btn p-3" id="contact-submit" style="display:block"><span class="material-icons">send</span> @lang('site.contact_send')</a>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3"></div>
        </div>
        <script src="/js/app/contact.js"></script>
        @include('app.templates.default.site.includes.footer')
    </div>
</div>

@endsection