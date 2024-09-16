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
    <h1>Adicionar Nova Categoria</h1>
    <h2>Inserir título da categoria.</h2>
    <form action="/admin/services-categories/store" method="post" id="add-category">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-12">
            <label>Título da Categoria</label>
            <div class="input">
                <input class="form-control" name="category" placeholder="Cabelo" value="{{old('category')}}">
                <span class="material-icons">title</span>
            </div>
        </div>
    </div>

    <hr>
    <div class="text-end">
        <a href="/admin/services-categories" class="cancel-button">Cancelar</a>
        <a href="#" class="save-button" onclick="document.getElementById('add-category').submit(); return false;">Adicionar</a>
    </div>
    </form>
    @include('admin.layout.footer')
</div>
@endsection
