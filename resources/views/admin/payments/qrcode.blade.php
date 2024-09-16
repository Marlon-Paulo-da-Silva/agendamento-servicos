@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

<div class="container">

    <h1>Plačilo z UPN QR kodo</h1>
    <h2>Skenirajte kodo z vašo mobilno banko</h2>
    
    <div class="text-center">
        {{$qr_code}}
    </div>
    @include('admin.layout.footer')
</div>
@endsection