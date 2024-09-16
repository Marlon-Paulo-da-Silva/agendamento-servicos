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

    <h1>Horário de funcionamento</h1>
    <h2>Configure os horários de funcionamento e os horários que não abre (horários de folga).</h2>
    <hr>
    <div class="row customer">
        <div class="col-10">
            <div class="name">Horário de funcionamento</div>
            <div class="email mb-3">Configurar Horário de funcionamento.</div>
        </div>
        <div class="col-2 text-end">
        <a href="/admin/salon-work-hours" class="delete"><span class="material-icons">edit</span></a>
        </div>
    </div>
    <hr>
    <div class="row customer">
        <div class="col-10">
            <div class="name">Folgas</div>
            <div class="email mb-3">Configurar horários que não abre (horários de folga).</div>
        </div>
        <div class="col-2 text-end">
        <a href="/admin/holidays" class="delete"><span class="material-icons">edit</span></a>
        </div>
    </div>
    <hr>

    @include('admin.layout.footer')
</div>
@endsection
