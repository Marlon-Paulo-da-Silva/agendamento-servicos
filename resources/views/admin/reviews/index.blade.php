@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

<div class="container">
    <h1>Customer Reviews</h1>
    <h2>Edit review or change status.</h2>
    <div class="waiting">
    <a href="/admin/reviews" class="cancel-button mb-4 @if($request->path() == 'admin/reviews'){{'selected'}}@endif">Waiting <span>({{$statuses->waiting}})</span></a>
    <a href="/admin/reviews/approved" class="cancel-button mb-4 @if($request->path() == 'admin/reviews/approved'){{'selected'}}@endif">Approved <span>({{$statuses->approved}})</span></a>
    <a href="/admin/reviews/bin" class="cancel-button mb-4 @if($request->path() == 'admin/reviews/bin'){{'selected'}}@endif">Bin <span>({{$statuses->bin}})</span></a>
    </div>
</div>

    <div class="letter-contacts reviews">
        @if(!$reviews->count())
        <div class="letter">
            <div class="container py-1">There are no reviews.</div>
        </div>
        @endif
        @foreach($reviews as $review)
        <div class="customer-item">
            <div class="container">
                <div class="row customer py-3">
                    <div class="col-8 col-xl-9">
                        <div class="name">
                            {{$review->name}}
                            @for ($i = 1; $i <= $review->vote; $i++)
                            <span class="material-icons">star</span>
                            @endfor
                        </div>
                        <div class="email" title="{{$review->review}}">{{$review->review}}</div>
                        <div class="email time">{{$review->created}}</div>
                    </div>
                    <div class="col-2 col-xl-1 text-end">
                        <a href="/admin/reviews/edit/{{$review->id}}" class="delete"><span class="material-icons">edit</span></a>
                    </div>
                    <div class="col-2 col-xl-1 text-end">
                        <a href="#" class="delete change-status" data-id="{{$review->id}}"><span class="material-icons">toggle_on</span></a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div id="myNav" class="overlay">
        <div class="overlay-content"></div>
    </div> 


@include('admin.layout.footer')
</div>
<script src="/js/admin/reviews.js"></script>
@endsection