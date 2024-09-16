@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

<div class="container">
@if ($errors->any())
    <div class="alert alert-success">
        @foreach ($errors->all() as $error)
        {{ $error }}<br>
        @endforeach
    </div>
@endif       
    <h1>Edit review</h1>
    <h2>Edit first impression, name and review.</h2>
    <form action="/admin/reviews/update/{{$id}}" method="post" id="edit-review">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-12">
            <label>First Impression</label>
            <div class="input">
                <input class="form-control" placeholder="Quick and with quality" name="recension_impression" value="{{$review->impression}}">
                <span class="material-icons">format_quote</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Name</label>
            <div class="input">
                <input class="form-control" placeholder="John Doe" name="recension_name" value="{{$review->name}}">
                <span class="material-icons">badge</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>City</label>
            <div class="input">
                <input class="form-control" placeholder="Berlin" name="recension_city" value="{{$review->city}}">
                <span class="material-icons">location_city</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Review</label>
            <div class="input-plain">
                <textarea class="form-control" name="recension_review" placeholder="Review">{{$review->review}}</textarea>
            </div>
        </div>
    </div>
    
    <hr>
    <div class="text-end">
        <a href="/admin/reviews" class="cancel-button">Back to list</a>
        <a href="#" class="save-button" onclick="document.getElementById('edit-review').submit(); return false;">Save</a>
    </div>
    </form>

    @include('admin.layout.footer')
</div>
@endsection