@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

<div class="container">
<h1>Are you sure?</h1>
            <h2>You are going to delete working time {{$work_time->date_from}} do {{$work_time->date_to}}</h2>
            
            <hr>
            <div class="text-end">
                <a href="/admin/schedule/work-time/{{$user}}" class="cancel-button">Cancel</a>
                <a href="#" class="save-button" onclick="document.getElementById('delete').submit(); return false;">Delete</a>
                <form method="post" action="/admin/schedule/work-time/delete" id="delete">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$id}}">
                    <input type="hidden" name="user" value="{{$user}}">
                </form>
            </div>

    @include('admin.layout.footer')
</div>
@endsection