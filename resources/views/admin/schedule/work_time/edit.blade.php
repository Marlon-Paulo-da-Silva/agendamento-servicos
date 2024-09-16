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
<h1>Edit working time</h1>
<h2>{{$worktime->date_from}} - {{$worktime->date_to}}</h2>
<form action="/admin/schedule/work-time/update" method="post" id="add-work-time">
    {{ csrf_field() }}
    <input type="hidden" name="user" value="{{$member->id}}">
    <input type="hidden" name="id" value="{{$worktime->id}}">
            <div class="row">
            <div class="col-6">
                    <label>From</label>
                    <div class="input">
                        <input class="form-control" name="time_from" value="{{old('time_from') ?? $worktime->time_from }}" autocomplete="off" placeholder="08:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
                <div class="col-6">
                    <label>To</label>
                    <div class="input">
                        <input class="form-control" name="time_to" value="{{old('time_to') ?? $worktime->time_to }}" autocomplete="off" placeholder="16:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
            <div class="col-6">
                    <label>Lunch from</label>
                    <div class="input">
                        <input class="form-control" name="lunch_from" autocomplete="off" value="{{old('lunch_from') ?? $worktime->lunch_from }}" placeholder="12:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
                <div class="col-6">
                    <label>Lunch to</label>
                    <div class="input">
                        <input class="form-control" name="lunch_to" autocomplete="off" value="{{old('lunch_to') ?? $worktime->lunch_to }}" placeholder="13:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
            </div>
            <div class="text-end mb-5">
                <a href="/admin/schedule/work-time/{{$member->id}}" class="cancel-button">Back</a>
                <a href="#" class="save-button" onclick="document.getElementById('add-work-time').submit(); return false;">Add</a>
            </div>
    </form>

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