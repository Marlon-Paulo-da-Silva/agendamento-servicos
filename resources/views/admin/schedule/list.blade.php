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

    <div class="row">
        <div class="col-2">
            <div class="customer-image mb-3 mt-1" style="background-image:url(@if($member->profile_image)/images/profile_images/{{$member->profile_image}}@else/images/admin/icons/user_color.png @endif)"></div>
        </div>
        <div class="col-10">
            <h1>@if(!$member->name) Usuário(a) @else{{$member->name}} {{$member->surname}}@endif</h1>
            <h2>Definir horário de trabalho, horário de almoço e férias.</h2>
        </div>
    </div>
    <hr>
    <div class="row customer">
        <div class="col-10">
            <div class="name">Horário de trabalho</div>
            <div class="email mb-3">Defina o horário de trabalho do funcionário e o horário do almoço.</div>
        </div>
        <div class="col-2 text-end">
        <a href="/admin/schedule/work-time/{{$member->id}}" class="delete"><span class="material-icons">chevron_right</span></a>
        </div>
    </div>
    <hr>
    <div class="row customer">
        <div class="col-10">
            <div class="name">Férias</div>
            <div class="email mb-3">Definir férias para o funcionário.</div>
        </div>
        <div class="col-2 text-end">
        <a href="/admin/schedule/vacations/{{$member->id}}" class="delete"><span class="material-icons">chevron_right</span></a>
        </div>
    </div>
    <hr>
    <div class="text-end">
                <a href="/admin/schedule" class="cancel-button">Voltar</a>
    </div>

    @include('admin.layout.footer')
</div>
@endsection
