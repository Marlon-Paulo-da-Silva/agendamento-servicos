@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

<div class="container">
<h1>Are you sure?</h1>
            <h2>You are going to delete @if(!$user->name) User, @else {{$user->name}} {{$user->surname}}, @endif {{$user->email}} </h2>
            
            <hr>
            <div class="text-end">
                <a href="/admin/team" class="cancel-button">Cancel</a>
                <a href="#" class="save-button" onclick="document.getElementById('delete').submit(); return false;">Delete</a>
                <form method="post" action="/admin/team/member/delete" id="delete">
                    {{ csrf_field() }}
                    <input type="hidden" name="user" value="{{$user->id}}">
                </form>
            </div>

    @include('admin.layout.footer')
</div>
@endsection