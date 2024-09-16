@extends('app.templates.default.site.layout.index', ['title' => __('site.index_title')])

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

    <div class="index-swiper">
        <div class="swiper-wrapper">
        @php

        $images = false;

        for($i=1; $i<=10; $i++)
        {
            $name = 'photo_'.$i;

        @endphp
        @if($photos->$name)
        @php $images = true; @endphp
            <div class="swiper-slide" style="background-image: url(/images/website_photos/{{$photos->$name}})"></div>
            @endif
        @php
        }
        @endphp
        @if(!$images)
        <div class="swiper-slide" style="background-image: url(/images/app/templates/default/site/photo.svg)"></div>
        @endif
        </div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>

    <div class="container">
        <div class="pb-3" style="width:80%; margin:auto">
            <div class="text-center my-5">
                @if($website->title)
                <h1 class="mb-3">{{$website->title}}</h1>
                @endif
                @if($website->address)
                <div class="welcome">{{$website->address}}</div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-4 col-xl-4 col-lg-4">
                <div class="offer p-5 text-center" style="position: relative;">
                    <div _ngcontent-puk-c45 class="offer-resize" style="background-image: url(/images/app/templates/default/app/appointment.svg), var(--main-page-bg);"></div>
                    <h2>@lang('site.index_how_to_book')</h2>
                    <div class="my-4">
                        @lang('site.index_how_to_book_text')
                    </div>
                    <a href="/booking" class="p-3 action-btn"><span class="material-icons">watch_later</span> @lang('site.index_book_btn')</a>
                </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-4">
                <div class="offer p-5 text-center" style="position: relative;">
                    <div _ngcontent-puk-c45 class="offer-resize" style="background-image: url(/images/app/templates/default/app/hair.svg), var(--main-page-bg);"></div>
                    <h2>@lang('site.index_services')</h2>
                    <div class="my-4">
                        @lang('site.index_services_text')
                    </div>
                    <a href="/services" class="action-btn p-3"><span class="material-icons">storefront</span> @lang('site.index_view_services')</a>
                </div>
            </div>
            <div class="col-xxl-4 col-xl-4 col-lg-4">
                <div class="offer p-5 text-center" style="position: relative;">
                    <div _ngcontent-puk-c45 class="offer-resize" style="background-image: url(/images/app/templates/default/app/contact.svg), var(--main-page-bg);"></div>
                    <h2>@lang('site.index_call_us')</h2>
                    <div class="my-4">
                        @lang('site.index_still_call_us') @if($info->site_phone){{$info->site_phone}}@endif. @lang('site.index_meeting')
                    </div>
                    {{-- @if($info->site_phone) --}}
                    <a href="tel:{{$info->site_phone}}" class="p-3 action-btn"><span class="material-icons">smartphone</span> @lang('site.index_call_us_btn')</a>
                    {{-- @endif --}}
                </div>
            </div>
        </div>
        @include('app.templates.default.site.includes.footer')
    </div>
</div>

<!-- Swiper JS -->
<script src="/js/admin/swiper8.min.js"></script>
<!-- Initialize Swiper -->
<script>
    const swiper = new Swiper('.index-swiper', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    });
</script>

<style>.hover-underline-animation[_ngcontent-puk-c13] {
    display: inline-block;
    position: relative
  }

  .hover-underline-animation[_ngcontent-puk-c13]:after {
    content: "";
    position: absolute;
    width: 100%;
    transform: scaleX(0);
    height: 1px;
    bottom: 0;
    left: 0;
    background-color: #fff;
    transform-origin: bottom right;
    transition: transform .25s ease-out
  }

  .hover-underline-animation[_ngcontent-puk-c13]:hover:after {
    transform: scaleX(1);
    transform-origin: bottom left
  }

  .hover-underline-animation.active[_ngcontent-puk-c13]:after {
    transform: scaleX(1);
    transform-origin: bottom left
  }

  .header.active[_ngcontent-puk-c13] {
    background: var(--main-page-bg-opacity)
  }

  .header.active[_ngcontent-puk-c13] .reserve[_ngcontent-puk-c13] {
    border: 1px solid #FFF
  }

  </style>
  <style>
  .video[_ngcontent-puk-c45] {
    height: 100vh;
    width: 100vw;
    position: relative;
    overflow: hidden
  }

  video[_ngcontent-puk-c45] {
    height: 100%;
    min-width: 100%;
    min-height: 56.25vw;
    position: absolute;
    left: 50%;
    bottom: 0;
    transform: translate(-50%)
  }

  .logo-sign[_ngcontent-puk-c45] {
    position: relative;
    z-index: 100
  }

  .welcome-cont[_ngcontent-puk-c45] {
    position: relative;
    z-index: 101;
    color: #fff
  }

  h1[_ngcontent-puk-c45] {
    color: #fff
  }

  .background-gradient[_ngcontent-puk-c45] {
    position: absolute;
    width: 100%;
    height: 100%;
    background: linear-gradient(0deg, rgba(0, 0, 0, 0) 0%, rgba(0, 0, 0, .5) 100%);
    z-index: 99;
    bottom: 0;
    left: 0
  }

  .offer[_ngcontent-puk-c45] .offer-resize[_ngcontent-puk-c45] {
    transition: background-size .5s;
    position: absolute;
    left: 0;
    right: 0;
    top: -40px;
    margin-left: auto;
    margin-right: auto;
    height: 80px;
    width: 80px;
    background-size: 50%, contain;
    background-repeat: no-repeat, no-repeat;
    background-position: center, center;
    border-radius: 100%
  }

  .offer:hover div:first-child {
    background-size: 65%, contain !important
  }


  .pin-container[_ngcontent-puk-c45] {
    padding: 0;
    width: 60%;
    margin: auto;
    display: grid;
    grid-template-columns: repeat(auto-fill, var(--card_width));
    grid-auto-rows: var(--row_increment);
    justify-content: center
  }

  .pin-card[_ngcontent-puk-c45] {
    padding: 0;
    margin: 4px;
    border-radius: 30px;
    background-color: var(--font-colored);
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center center;
    position: relative
  }

  .card-small[_ngcontent-puk-c45] {
    grid-row-end: span var(--card_small)
  }

  .card-medium[_ngcontent-puk-c45] {
    grid-row-end: span var(--card_medium)
  }

  .card-large[_ngcontent-puk-c45] {
    grid-row-end: span var(--card_large)
  }

  .pin-card[_ngcontent-puk-c45],
  .map[_ngcontent-puk-c45] {
    transform: translateY(500vh);
    position: relative
  }

  .pin-card.active[_ngcontent-puk-c45],
  .map.active[_ngcontent-puk-c45] {
    animation-name: photo;
    animation-duration: .4s;
    animation-fill-mode: forwards;
    animation-iteration-count: 1
  }

  .cut[_ngcontent-puk-c45] {
    width: 100%;
    color: #fff;
    min-height: 550px;
    background-image: url(/images/app/templates/default/app/cut.svg), var(--main-page-bg);
    background-position: center top;
    background-repeat: no-repeat;
    background-size: 100%
  }

  .pin-card[_ngcontent-puk-c45] .bg[_ngcontent-puk-c45] {
    position: absolute;
    opacity: 0;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: #00000095 url(/images/app/templates/default/app/zoom.svg);
    background-repeat: no-repeat, no-repeat;
    background-position: center, center;
    background-size: 60px;
    border-radius: 30px;
    transition: opacity .5s
  }

  .pin-card[_ngcontent-puk-c45]:hover .bg[_ngcontent-puk-c45] {
    opacity: 1
  }

  .modal[_ngcontent-puk-c45] {
    display: none;
    position: fixed;
    z-index: 100000000000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: #000
  }

  .modal-content[_ngcontent-puk-c45] {
    position: relative;
    margin: auto;
    padding: 0;
    width: 100%;
    max-width: 640px
  }

  .mySlides[_ngcontent-puk-c45] {
    background: #000;
    text-align: center
  }

  .mySlides[_ngcontent-puk-c45] img[_ngcontent-puk-c45] {
    width: 100%;
    border-radius: 30px
  }

  .cursor[_ngcontent-puk-c45] {
    cursor: pointer
  }

  .close[_ngcontent-puk-c45] {
    color: #fff;
    position: absolute;
    top: 1rem;
    z-index: 10;
    right: 1rem;
    font-weight: 700
  }

  .map[_ngcontent-puk-c45] {
    border-radius: 30px;
    margin: auto;
    width: 50%
  }

  @keyframes photo {
    0% {
      transform: translateY(500vh)
    }

    to {
      transform: translateY(0)
    }
  }

  @media only screen and (max-width:575px) {
    .pin-container[_ngcontent-puk-c45] {
      width: 100%;
      grid-template-columns: repeat(auto-fill, 50%)
    }

    .card-small[_ngcontent-puk-c45] {
      --card_small: 15;
      grid-row-end: span var(--card_small)
    }

    .card-medium[_ngcontent-puk-c45] {
      --card_medium: 18;
      grid-row-end: span var(--card_medium)
    }

    .card-large[_ngcontent-puk-c45] {
      --card_large: 21;
      grid-row-end: span var(--card_large)
    }

    .map[_ngcontent-puk-c45] {
      width: 100%
    }
  }

  @media only screen and (min-width:576px) and (max-width:768px) {
    .pin-container[_ngcontent-puk-c45] {
      width: 100%;
      grid-template-columns: repeat(auto-fill, 50%)
    }

    .map[_ngcontent-puk-c45] {
      width: 100%
    }
  }

  @media only screen and (min-width:769px) and (max-width:992px) {
    .pin-container[_ngcontent-puk-c45] {
      width: 100%;
      grid-template-columns: repeat(auto-fill, 33.333333333%)
    }
  }

  @media only screen and (min-width:993px) and (max-width:1199px) {
    .pin-container[_ngcontent-puk-c45] {
      width: 80%;
      grid-template-columns: repeat(auto-fill, 33.333333333%)
    }
  }

  </style>
@endsection
