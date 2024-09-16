@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

<div class="container">
    <div class="text-center">
        <h1>Izberite vrsto plačila</h1>
        <h2>Naročnino lahko poravnate preko Paypala ali UPN naloga.</h2>
        <div class="pay-buttons">
            <a href="/admin/paywithpaypal" class="save-button mb-3">Plačajte preko Paypala</a>
            <a href="/admin/upn" class="save-button mb-3">Plačajte preko UPN naloga</a>
            <a href="/admin/upn-qr" class="save-button">Plačajte preko UPN QR kode</a>
        </div>
    </div>

    @include('admin.layout.footer')
</div>
@endsection