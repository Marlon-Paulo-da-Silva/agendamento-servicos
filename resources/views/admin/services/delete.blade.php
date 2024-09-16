@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

<div class="container">
<h1>Tem certeza que quer fazer isso?</h1>
            <h2>Você irá apagar: {{$service->title}} </h2>

            <hr>
            <div class="text-end">
                <a href="/admin/services" class="cancel-button">Cancelar</a>
                <a href="#" class="save-button" onclick="document.getElementById('delete').submit(); return false;">Apagar</a>
                <form method="post" action="/admin/services/delete" id="delete">
                    {{ csrf_field() }}
                    <input type="hidden" name="service" value="{{$service->id}}">
                </form>
            </div>

    @include('admin.layout.footer')
</div>
@endsection
