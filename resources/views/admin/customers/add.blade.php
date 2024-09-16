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
    <h1>Adicionar Novo Cliente</h1>
    <h2>Inserir Nome, Sobrenome e Telefone.</h2>
    <form action="/admin/customers/store" method="post" id="add-customer">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-12">
            <label>Nome</label>
            <div class="input">
                <input class="form-control" placeholder="Nome" name="name" autocomplete="off" value="{{old('name')}}">
                <span class="material-icons">badge</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Sobrenome</label>
            <div class="input">
                <input class="form-control" placeholder="Sobrenome" name="surname" autocomplete="off" value="{{old('surname')}}">
                <span class="material-icons">badge</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <label>Código de area</label>
            <div class="input">
            <select class="form-control" name="area_code">
                @foreach($area_codes as $area_code)
                <option value="{{$area_code->code}}">{{$area_code->country}} (+{{$area_code->code}})</option>
            @endforeach
            </select>
        </div>
        </div>
        <div class="col-8">
            <label>Telefone</label>
            <div class="input">
                <input type="tel" class="form-control" id="phone" name="phone" autocomplete="off" placeholder="18 997586659" value="{{old('phone')}}">
                <span class="material-icons">call</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>E-mail (não-obrigatório)</label>
            <div class="input">
                <input class="form-control" type="email" placeholder="E-mail" name="email" autocomplete="off" value="{{old('email')}}">
                <span class="material-icons">alternate_email</span>
            </div>
        </div>
    </div>

    <hr>
    <div class="text-end">
        <a href="/admin/customers" class="cancel-button">Cancelar</a>
        <a href="#" class="save-button" onclick="document.getElementById('add-customer').submit(); return false;">Adicionar</a>
    </div>
    </form>
    @include('admin.layout.footer')
</div>
@endsection
