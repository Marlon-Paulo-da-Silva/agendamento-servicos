@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

<div class="container">
<?php

$valid_to = Auth::user()->valid_to;
$target = new \DateTime($valid_to);
$valid = $target->format('d.m.Y');

?>
        <h1>Licenca</h1>
        <h2>Registrirani ste kot uporabnik {{Auth::user()->email}}</h2>
        <div class="mb-3">Licenca je veljavna do {{$valid}}</div>
        <div class="pay-buttons text-center">
            <a href="/admin/select-payment" class="save-button mb-3">Podaljšaj licenco</a>
        </div>

    @include('admin.layout.footer')
</div>
@endsection