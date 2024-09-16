@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

        <div class="container">

        @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-success">
        @foreach ($errors->all() as $error)
        {{ $error }}<br>
        @endforeach
    </div>
@endif  
            <h1>New Campaign</h1>
            <h2>Write the promotion message.</h2>

            <form method="post" id="campaign" action="/admin/marketing/update/{{$campaign['id']}}">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-12">
                    <label>Campaign Title</label>
                    <div class="input">
                        <input class="form-control" name="marketing_title" value="{{$campaign['title']}}" autocomplete="off" placeholder="My promotion">
                        <span class="material-icons">title</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>Message Content (max 600 characters)</label>
                    <div class="input-plain">
                        <textarea class="form-control" name="marketing_msg" maxlength="600">{{$campaign['message']}}</textarea>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-end">
                <a href="/admin/marketing/edit/{{$id}}" class="cancel-button">Back</a>
                <a href="#" class="save-button" onclick="document.getElementById('campaign').submit(); return false;">Edit</a>
            </div>
            </form>

        @include('admin.layout.footer')
    </div>
@endsection