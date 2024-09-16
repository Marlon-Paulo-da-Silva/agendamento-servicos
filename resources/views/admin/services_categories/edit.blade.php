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
    <h1>Editar Categoria</h1>
    <h2>Inserir Título da Categoria.</h2>
    <form action="/admin/services-categories/update/{{$id}}" method="post" id="add-category">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-12">
            <label>Título</label>
            <div class="input">
                <input class="form-control" name="category" placeholder="Hairstyling" value="{{$category['title']}}">
                <span class="material-icons">title</span>
            </div>
        </div>
    </div>

    <hr>
    <div class="text-end">
        <a href="/admin/services-categories" class="cancel-button">Cancelar</a>
        <a href="#" class="save-button" onclick="document.getElementById('add-category').submit(); return false;">Salvar</a>
    </div>
    </form>
    @include('admin.layout.footer')
</div>
@endsection
