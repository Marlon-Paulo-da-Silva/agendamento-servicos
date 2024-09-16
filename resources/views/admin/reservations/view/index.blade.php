@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

<div class="container">
    <h1>{{$reservation->service}}</h1>
    <h2>{{$reservation->name}} {{$reservation->surname}}</h2>
    <div class="form-completion">
        <div class="completion-profile"
            style="background-image: url(@if ($reservation->profile_image) /images/profile_images/{{ $reservation->profile_image }}@else/images/admin/icons/user_color.png @endif);">
        </div>
        <div class="completion-title">
            <div class="title">@if(!$reservation->u_name){{'User'}}@else{{$reservation->u_name}} {{$reservation->u_surname}}@endif</div>
            <div class="occupation">{{$reservation->occupation}}</div>
        </div>
        <div class="completion-data p-3 mt-3 mb-4">
            <div><span class="material-icons">today</span> {{$reservation->start}}</div>
            <div class="text-end"><span class="material-icons">schedule</span> {{$reservation->time}}</div>
        </div>
    </div>
    @if (Auth::user()->privilege == 1)
    <div class="text-end">
    <a href="/admin/reservations/confirm-delete/{{$reservation->id}}?return_url=/admin/reservations" class="save-button mb-3">Apagar Agendamento</a>
    </div>
    @endif
    @include('admin.layout.footer')
</div>
@endsection
