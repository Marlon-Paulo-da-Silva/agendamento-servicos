@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page white-bg">

<div class="container">
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
    <h1>Podaljšanja</h1>
    <h2>Podaljšajte licenco za stranko.
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
<script src="/js/admin/renewals.js"></script>
@endsection