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
    <h1>Editar Cliente</h1>
    <h2>Mudar Nome, Sobrenome e E-mail.</h2>
    <form action="/admin/customers/update/{{$customer->id}}" method="post" id="edit-customer">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-12">
            <label>Nome</label>
            <div class="input">
                <input class="form-control" placeholder="Nome" name="name" autocomplete="off" value="{{$customer->name}}">
                <span class="material-icons">badge</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Sobrenome</label>
            <div class="input">
                <input class="form-control" placeholder="Sobrenome" name="surname" autocomplete="off" value="{{$customer->surname}}">
                <span class="material-icons">badge</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>E-mail (não-obrigatórios)</label>
            <div class="input">
                <input class="form-control" type="email" placeholder="E-mail" name="email" autocomplete="off" value="{{$customer->email}}">
                <span class="material-icons">alternate_email</span>
            </div>
        </div>
    </div>

    <hr>
    <div class="text-end">
        <a href="/admin/customers" class="cancel-button">Cancelar</a>
        <a href="#" class="save-button" onclick="document.getElementById('edit-customer').submit(); return false;">Editar</a>
    </div>
    </form>
    @include('admin.layout.footer')
</div>
@endsection
