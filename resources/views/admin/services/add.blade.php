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
    <h1>Adicionar Novo Serviço</h1>
    <h2>Inserir título e configurar preço.</h2>
    <form action="/admin/services/store" method="post" id="add-service">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-12">
            <label>Título</label>
            <div class="input">
                <input class="form-control" placeholder="Nome do serviço" name="title" value="{{old('title')}}">
                <span class="material-icons">title</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Descrição</label>
            <div class="input">
                <input class="form-control" placeholder="Descreva em poucas palavras sobre esse serviço" name="description" value="{{old('description')}}">
                <span class="material-icons">title</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Categoria <a href="#" class="save-button" style="
                width: 94px;
                height: 23px;
                font-size: 10px;
                padding: 1px 12px;
                margin-left: 5px;
            "><span class="material-icons" style="font-size: 17px">add_circle</span> Adicionar</a></label>
            <div class="input">
                <select class="form-control" name="category">
                <option value="0">- Escolha a categoria - </option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}" @if(old('category') == $category->id) selected="selected"@endif>{{$category->title}}</option>
                @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Preço</label>
            <div class="input">
                <input class="form-control" placeholder="Preço" name="price" value="{{old('price')}}">
                <span class="material-icons">sell</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Tempo de duração</label>

                    <div class="input-plain">
                        <input class="form-control d-inline" type="number" style="width:70px" maxlength="2" min="0" max="23" placeholder="00" name="hours" value="{{old('hours')}}"> h
                        <input class="form-control d-inline" type="number" style="width:70px" maxlength="2" min="0" max="59" placeholder="00" name="minutes" value="{{old('minutes')}}"> min
                    </div>

        </div>
    </div>

    <hr>
    <div class="text-end">
        <a href="/admin/services" class="cancel-button">Cancelar</a>
        <a href="#" class="save-button" onclick="document.getElementById('add-service').submit(); return false;">Adicionar</a>
    </div>
    </form>

    @include('admin.layout.footer')
</div>
@endsection
