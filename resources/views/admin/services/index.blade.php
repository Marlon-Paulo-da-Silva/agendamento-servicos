@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page white-bg">

<div class="container">
    <h1>Serviços</h1>
    <h2>Adicionar ou editar um serviço.</h2>
    <div class="row mb-5">
        <div class="col-12">
        <a href="/admin/services/add" class="add-button"><span class="material-icons">add</span> Adicionar Novo Serviço</a>
        </div>
    </div>
</div>
@foreach($categories as $cats)
@if($cats['num'])
<div class="letter">
<div class="container py-1">{{$cats['title']}}</div>
</div>


<div class="letter-contacts">
@foreach($cats['services'] as $service)
<div class="customer-item">
    <div class="container">
        <div class="row customer py-3">
            <div class="col-8">
                <div class="name">{{$service->title}}</div>
                <div class="email">{{$info->currency_sign}}{{\App\Helpers\Helpers::FormatPrice($info->currency_format, $service->price)}}</div>
            </div>
            <div class="col-2 text-end">
                <a href="/admin/services/edit/{{$service->id}}" class="delete"><span class="material-icons">edit</span></a>
                <a href="/admin/services/confirm-delete/{{$service->id}}" class="delete"><span class="material-icons">delete</span></a>
            </div>

        </div>
    </div>
</div>
@endforeach
</div>
@endif
@endforeach


@include('admin.layout.footer', ['bg' => true])
</div>
@endsection
