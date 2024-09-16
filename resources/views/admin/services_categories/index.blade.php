@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page white-bg">

<div class="container">
    <h1>Categorias dos Serviços</h1>
    <h2>Divida sua oferta em categorias.</h2>
    <div class="row mb-5">
        <div class="col-12">
        <a href="/admin/services-categories/add" class="add-button"><span class="material-icons">add</span> Adicionar Nova Categoria</a>
        </div>
    </div>
</div>
<div class="letter">
<div class="container py-1">Categorias</div>
</div>
<div class="letter-contacts">
@foreach($categories as $cat)
<div class="customer-item">
    <div class="container">
        <div class="row customer py-3">+
            <div class="col-8">
                <div class="name">{{$cat['title']}}</div>
                <div class="email">Serviços vinculados: {{$cat['num']}}</div>
            </div>
            <div class="col-2 text-end">
                <a href="/admin/services-categories/edit/{{$cat['id']}}" class="delete"><span class="material-icons">edit</span></a>
                @if(!$cat['num'])
                <a href="/admin/services-categories/confirm-delete/{{$cat['id']}}" class="delete"><span class="material-icons">delete</span></a>
                @endif
            </div>
        </div>
    </div>
</div>
@endforeach
</div>

@include('admin.layout.footer', ['bg' => true])
</div>
@endsection
