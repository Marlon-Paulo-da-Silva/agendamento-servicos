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
            <h2>Choose area code and insert promotional message.</h2>

            <form method="post" id="settings" action="/admin/marketing/store">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-12">
                    <label>Select customers from area</label>
                    <div class="input">
                    <select class="form-control mb-3" name="marketing_area_code">
                        @foreach($area_codes as $area_code)
                        <option value="{{$area_code->code}}">{{$area_code->country}} (+{{$area_code->code}})</option>
                        @endforeach
                    </select>
                </div>
            </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>Campaign Title</label>
                    <div class="input">
                        <input class="form-control" name="marketing_title" value="" autocomplete="off" placeholder="My promotion">
                        <span class="material-icons">title</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>Message content (max 600 characters)</label>
                    <div class="input-plain">
                        <textarea class="form-control" name="marketing_msg" maxlength="600"></textarea>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-end">
                <a href="/admin/marketing" class="cancel-button">Back</a>
                <a href="#" class="save-button" onclick="document.getElementById('settings').submit(); return false;">Save</a>
            </div>
            </form>

        @include('admin.layout.footer')
    </div>
@endsection