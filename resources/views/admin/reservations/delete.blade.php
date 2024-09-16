@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

<div class="container">
@if(Auth::user()->privilege == 1)
<h1>Tem certeza que quer fazer isso?</h1>
            <h2>Você irá apagar a reserva: {{$reservation->service}}</h2>

            <hr>
            <div class="text-end">
                <a href="{{$return_url}}" class="cancel-button">Cancelar</a>
                <a href="#" class="save-button" onclick="document.getElementById('delete').submit(); return false;">Apagar</a>
                <form method="post" action="/admin/reservations/delete" id="delete">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$id}}">
                    <input type="hidden" name="return_url" value="{{$return_url}}">
                </form>
            </div>
@else
<h1>Only administrator has the privileges to delete reservations</h1>
<hr>
<a href="{{$return_url}}" class="cancel-button">Go Back</a>
@endif
    @include('admin.layout.footer')
</div>
@endsection
