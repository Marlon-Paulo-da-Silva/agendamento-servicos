@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page white-bg">

<div class="container">
    <h1>Clientes</h1>
    <h2>{{$customer_count}}
        @if($customer_count == 0)
            customers.
        @elseif($customer_count == 1)
            customer.
        @elseif($customer_count == 2)
            customers.
        @elseif($customer_count == 3)
            customers.
        @elseif($customer_count == 4)
            customers.
        @else
            customers.
        @endif
    </h2>
    <div class="row mb-3">
        <div class="col-9">
            <div class="input">
                <input type="text" class="form-control" autocomplete="off" id="name" placeholder="Search Customer">
                <span class="material-icons left">search</span>
            </div>
        </div>
        <div class="col-3">
        <a href="/admin/customers/add" class="add-button"><span class="material-icons">add</span></a>
        </div>
    </div>
</div>
<div id="customers">
    @foreach($customers as $key=>$customer)
    <div class="letter">
        <div class="container py-1">{{$key}}</div>
    </div>
    <div class="letter-contacts">
    @foreach($customer as $b)

        <div class="customer-item">
            <div class="container">
                <div class="row customer py-3">
                    <div class="col-8 col-xl-9">
                        <div class="name">{{$b['name']}} {{$b['surname']}}</div>
                        <div class="email">@if(strlen($b['email'])){{$b['email']}}@else Sem e-mail @endif</div>
                        <div class="email">+{{$b['area_code']}}{{$b['phone']}}</div>
                    </div>
                    <div class="col-2 col-xl-1 text-end">
                        <a href="/admin/customers/edit/{{$b['id']}}" class="delete"><span class="material-icons">edit</span></a>
                    </div>
                    <div class="col-2 col-xl-1 text-end">
                        <a href="tel:+{{$b['area_code']}}{{$b['phone']}}" class="delete"><span class="material-icons">call</span></a>
                    </div>
                </div>
            </div>
        </div>

    @endforeach
    </div>
    @endforeach
</div>
@include('admin.layout.footer', ['bg' => true])
</div>
<script src="/js/admin/customers.js"></script>
@endsection
