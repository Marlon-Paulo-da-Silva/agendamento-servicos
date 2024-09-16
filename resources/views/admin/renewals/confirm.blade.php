@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

<div class="container">
<h1>Ali želite podaljšati licenco?</h1>
            <h2>Licenca za {{$license->name}} {{$license->surname}} </h2>
            <div>Velja do {{$license->valid}}</div>
            <div class="mb-3">Podaljšana bo do: {{$license->renewed_to}}</div>
            
            <hr>
            
            <div class="text-end">
                <a href="/admin/renewals" class="cancel-button">Prekliči</a>
                <a href="#" class="save-button" onclick="document.getElementById('renew').submit(); return false;">Podaljšaj</a>
                <form method="post" action="/admin/renewals/renew/update" id="renew">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$license->id}}">
                </form>
            </div>

    @include('admin.layout.footer')
</div>
@endsection