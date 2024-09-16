@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

<div class="container">

    <h1>{{$campaign['title']}}</h1>
    <h2>Campaign Options</h2>
    <div class="row customer">
        <div class="col-10">
            <div class="name">Edit Campaign</div>
            <div class="email mb-3">You can edit campaign message</div>
        </div>
        <div class="col-2 text-end">
        <a href="/admin/marketing/edit-item/{{$campaign['id']}}" class="delete"><span class="material-icons">edit</span></a>
        </div>
    </div>
    <hr>
    <div class="row customer">
        <div class="col-10">
            <div class="name">Delete Campaign</div>
            <div class="email mb-3">Campaign is going to be deleted</div>
        </div>
        <div class="col-2 text-end">
        <a href="/admin/marketing/confirm-delete/{{$campaign['id']}}" class="delete"><span class="material-icons">delete</span></a>
        </div>
    </div>
    <hr>
    <div class="text-end">
        <a href="/admin/marketing/list" class="cancel-button">Back to campaigns</a>
    </div>

    @include('admin.layout.footer')
</div>
@endsection