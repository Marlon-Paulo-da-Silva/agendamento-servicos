@extends('app.templates.default.site.layout.index', ['title' => __('site.reviews_title')])

@section('content')
    @include('app.templates.default.site.includes.header')

    <div class="pt-5 gray-page">

        <div class="container">
            @if ($website->logo)
                <div class="text-center">
                    <a href="/" title="@lang('site.index_title')"><img src="/images/logos/{{ $website->logo }}" class="mb-5"
                            width="200"></a>
                </div>
            @endif
        </div>

        <div class="container">
            <div class="text-center mb-5">
                <h1 class="mb-3">@lang('site.reviews_title')</h1>
            </div>
            <div class="recensions">
                <div class="row">
                    <div class="col-xxl-3 col-xl-3 col-lg-3"></div>
                    <div class="col-xxl-6 col-xl-6 col-lg-6">
                        <div class="ct">
                            <div class="flex mt-5">
                                <div class="stars p-3">
                                    @for ($i = 1; $i <= round($avg_vote->vote); $i++)
                                        <span class="material-icons">star</span>
                                    @endfor
                                    <div class="grade">{{ round($avg_vote->vote, 1) }} @lang('site.reviews_from')</div>
                                </div>
                            </div>
                            <div class="grade-count text-center mb-5">@lang('site.reviews_based_on') {{ $review_count->ct }} @lang('site.reviews_based_reviews')</div>
                            <div class="row mb-3 grades">
                                <div class="col-1 text-end">5</div>
                                <div class="col-9">
                                    <div class="bar-cont">
                                        <div class="bar growBar"
                                            style="width:{{ round(($five->ct / ($review_count->ct ? $review_count->ct : 1)) * 100) }}%">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 text-center">
                                    {{ round(($five->ct / ($review_count->ct ? $review_count->ct : 1)) * 100) }}%</div>
                            </div>
                            <div class="row mb-3 grades">
                                <div class="col-1 text-end">4</div>
                                <div class="col-9">
                                    <div class="bar-cont">
                                        <div class="bar growBar"
                                            style="width:{{ round(($four->ct / ($review_count->ct ? $review_count->ct : 1)) * 100) }}%">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 text-center">
                                    {{ round(($four->ct / ($review_count->ct ? $review_count->ct : 1)) * 100) }}%</div>
                            </div>
                            <div class="row mb-3 grades">
                                <div class="col-1 text-end">3</div>
                                <div class="col-9">
                                    <div class="bar-cont">
                                        <div class="bar growBar"
                                            style="width:{{ round(($three->ct / ($review_count->ct ? $review_count->ct : 1)) * 100) }}%">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 text-center">
                                    {{ round(($three->ct / ($review_count->ct ? $review_count->ct : 1)) * 100) }}%</div>
                            </div>
                            <div class="row mb-3 grades">
                                <div class="col-1 text-end">2</div>
                                <div class="col-9">
                                    <div class="bar-cont">
                                        <div class="bar growBar"
                                            style="width:{{ round(($two->ct / ($review_count->ct ? $review_count->ct : 1)) * 100) }}%">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 text-center">
                                    {{ round(($two->ct / ($review_count->ct ? $review_count->ct : 1)) * 100) }}%</div>
                            </div>
                            <div class="row mb-3 grades">
                                <div class="col-1 text-end">1</div>
                                <div class="col-9">
                                    <div class="bar-cont">
                                        <div class="bar growBar"
                                            style="width:{{ round(($one->ct / ($review_count->ct ? $review_count->ct : 1)) * 100) }}%">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 text-center">
                                    {{ round(($one->ct / ($review_count->ct ? $review_count->ct : 1)) * 100) }}%</div>
                            </div>
                            <div class="flex">
                                <a href="#" class="p-3 submit-recension mt-3 mb-3">
                                    <span class="material-icons" style="vertical-align:middle">forum</span> @lang('site.reviews_write_review')
                                </a>
                            </div>

                        </div>
                    </div>
                    <div class="col-xxl-3 col-xl-3 col-lg-3"></div>
                </div>
                @foreach ($reviews as $review)
                    <div class="row mt-3">
                        <div class="col-xxl-3 col-xl-3 col-lg-3"></div>
                        <div class="col-xxl-6 col-xl-6 col-lg-6">
                            <div class="ct p-5 recension-comments">
                                <div class="stars">
                                    @for ($i = 1; $i <= $review->vote; $i++)
                                        <span class="material-icons">star</span>
                                    @endfor
                                </div>
                                <div class="my-3"><strong>“{{ $review->impression }}”</strong></div>
                                <div class="mb-3 comment">{{ $review->review }}</div>
                                <div class="commenteer">{{ $review->name }}, {{ $review->city }}</div>
                            </div>
                        </div>
                        <div class="col-xxl-3 col-xl-3 col-lg-3"></div>
                    </div>
                @endforeach
            </div>

            <div id="myNav" class="overlay">
                <div class="overlay-content">
                    <div class="my-5" id="recension-form-container">
                        <div id="recension-form-errors"></div>
                        <div class="text-center" style="color:#bbb; font-size:0.9rem">@lang('site.reviews_your_rating')</div>
                        <div class="mb-3 star-rating">
                            <a href="#" data-rating="1"><span class="material-icons">star</span></a>
                            <a href="#" data-rating="2"><span class="material-icons">star</span></a>
                            <a href="#" data-rating="3"><span class="material-icons">star</span></a>
                            <a href="#" data-rating="4"><span class="material-icons">star</span></a>
                            <a href="#" data-rating="5"><span class="material-icons">star</span></a>
                            <input type="hidden" id="rating" value="0">
                        </div>
                        <div class="input">
                            <input type="text" class="form-control mb-3" id="impression"
                                placeholder="@lang('site.reviews_impression')">
                            <span class="material-icons">format_quote</span>
                        </div>
                        <div class="input">
                            <input type="text" class="form-control mb-3" id="name" placeholder="@lang('site.reviews_name')">
                            <span class="material-icons">badge</span>
                        </div>
                        <div class="input">
                            <input type="text" class="form-control mb-3" id="city" placeholder="@lang('site.reviews_location')">
                            <span class="material-icons">location_city</span>
                        </div>
                        <div class="input-plain">
                            <textarea class="form-control" style="height:150px" id="review" placeholder="@lang('site.reviews_review')"></textarea>
                        </div>

                        <a href="#" class="action-btn p-3 text-center mb-3" id="contact-submit"
                            style="display:block"><span class="material-icons">send</span> @lang('site.reviews_send')</a>
                        <a href="#" class="cancel-btn cancel-recension p-3 text-center" id="contact-submit"
                            style="display:block">@lang('site.reviews_cancel')</a>


                    </div>
                </div>
            </div>


            @include('app.templates.default.site.includes.footer')
        </div>
    </div>
    <script src="/js/app/reviews.js"></script>
@endsection
