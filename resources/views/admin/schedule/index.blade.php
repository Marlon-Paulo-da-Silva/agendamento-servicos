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

    <h1>Disponibilidades dos integrantes</h1>
    <h2>Definir horário de trabalho dos integrantes, horário de almoço e férias.</h2>

    <hr>
    @foreach($members as $member)
    <div class="row customer">
        <div class="col-2">
        <div class="customer-image mb-3" style="background-image:url(@if($member->profile_image)/images/profile_images/{{$member->profile_image}}@else/images/admin/icons/user_color.png @endif)"></div>

        </div>
        <div class="col-8">
            <div class="name">@if(!$member->name) Usuário(a) @else{{$member->name}} {{$member->surname}}@endif</div>
            <div class="email">{{$member->email}}</div>
        </div>
        <div class="col-2 text-end">
        <a href="/admin/schedule/member/{{$member->id}}" class="delete"><span class="material-icons">chevron_right</span></a>
        </div>
    </div>
    <hr>
    @endforeach

    @include('admin.layout.footer')
</div>
@endsection
