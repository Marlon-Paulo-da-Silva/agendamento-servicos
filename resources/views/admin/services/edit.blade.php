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
    <h1>Editar Serviço</h1>
    <h2>Inserir título and configurar o preço.</h2>
    <form action="/admin/services/update/{{$id}}" method="post" id="edit-service">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-12">
            <label>Título</label>
            <div class="input">
                <input class="form-control" placeholder="Escova Progressiva" name="title" value="{{$service->title}}">
                <span class="material-icons">title</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Descrição</label>
            <div class="input">
                <input class="form-control" placeholder="escova Progressiva sem formol com procedimentos avançados" name="description" value="{{$service->description}}">
                <span class="material-icons">title</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Categoria</label>
            <div class="input">
                <select class="form-control" name="category">
                    <option value="0">- Escolha a categoria - </option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}" @if($service->category == $category->id) selected="selected"@endif>{{$category->title}}</option>
                @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Preço</label>
            <div class="input">
                <input class="form-control" placeholder="Cena" name="price" value="{{$service->price}}">
                <span class="material-icons">sell</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Duração</label>

                    <div class="input-plain">
                        <input class="form-control d-inline" type="number" style="width:70px" maxlength="2" min="0" max="23" placeholder="00" name="hours" value="{{$service->hours}}"> h
                        <input class="form-control d-inline" type="number" style="width:70px" maxlength="2" min="0" max="59" placeholder="00" name="minutes" value="{{$service->minutes}}"> min
                    </div>

        </div>
    </div>

    <hr>
    <div class="text-end">
        <a href="/admin/services" class="cancel-button">Cancelar</a>
        <a href="#" class="save-button" onclick="document.getElementById('edit-service').submit(); return false;">Salvar</a>
    </div>
    </form>

    @include('admin.layout.footer')
</div>
@endsection
