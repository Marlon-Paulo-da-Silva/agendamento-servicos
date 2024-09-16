@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page white-bg">

<div class="container">
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
    <h1>SMS Podaljšanja</h1>
    <h2>Napolnite SMS kredite za stranko.
    </h2>
    <div class="row mb-3">
        <div class="col-12">
            <div class="input">
                <input type="text" class="form-control" autocomplete="off" id="name" placeholder="ID stranke">
                <span class="material-icons left">search</span>
            </div>
        </div>
    </div>
</div>
<div id="customers"></div>
@include('admin.layout.footer', ['bg' => true])
</div>
<script src="/js/admin/sms_renewals.js"></script>
@endsection