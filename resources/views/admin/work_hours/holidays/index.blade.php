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
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<h1>Holidays</h1>
<h2>Set non-working days (holidays).</h2>
<form action="/admin/holidays/store" method="post" id="add-holiday">
    {{ csrf_field() }}
            <div class="row mb-3">
                <div class="col-12">
                    <label>Non-working day</label>
                    <div class="input">
                        <input class="form-control" id="date_from" name="holidays_date" autocomplete="off" value="{{old('holidays_date')}}" placeholder="01.01.{{date('Y')}}">
                        <span class="material-icons">date_range</span>
                    </div>
                </div>
            </div>

            <div class="text-end mb-5">
                <a href="/admin/work-hours" class="cancel-button">Back</a>
                <a href="#" class="save-button" onclick="document.getElementById('add-holiday').submit(); return false;">Add</a>
            </div>
    </form>
    <hr>

    <h2>Applied Holidays</h2>
    @foreach($holidays as $date)
    <div class="row customer">
        <div class="col-10">
            <div class="name"> <span class="material-icons">date_range</span> {{$date->holiday}}</div>
        </div>
        <div class="col-2 text-end">
        <a href="/admin/holidays/confirm-delete/{{$date->id}}" class="delete"><span class="material-icons">delete</span></a>
        </div>
    </div>
    <hr>
    @endforeach

<div id="myNav" class="overlay">
    <div class="overlay-content">
        <div>
        <div class="row">
            <div class="col-2"><button id="previous">&#8249;</button></div>
            <div class="col-8 text-center"><h3 id="month-present"></h3><div id="year-present"></div></div>
            <div class="col-2 text-end"><button id="next">&#8250;</button></div>
        </div>
        <table class="table-calendar mt-3" id="calendar">
        <thead id="thead-month"></thead>
        <tbody id="calendar-body"></tbody>
        </table>
        </div>
    </div>
</div>

<script src="/js/admin/calendar.js"></script>

    @include('admin.layout.footer')
</div>
@endsection