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
<h1>Horário de trabalho</h1>
<h2>Gerar horas de trabalho para o integrante.</h2>
<a href="/admin/schedule/generate/{{$member->id}}" class="save-button mb-3">Gerar horários padrões</a>
<form action="/admin/schedule/work-time/store" method="post" id="add-work-time">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{$member->id}}">
            <div class="row">
                <div class="col-12">
                    <label>Começa</label>
                    <div class="input">
                        <input class="form-control" id="date_from" name="date_from" autocomplete="off" value="{{old('date_from')}}" placeholder="01.01.{{date('Y')}}">
                        <span class="material-icons">date_range</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>Termina</label>
                    <div class="input">
                        <input class="form-control" id="date_to" name="date_to" autocomplete="off" value="{{old('date_to')}}" placeholder="01.01.{{date('Y')}}">
                        <span class="material-icons">date_range</span>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-6">
                    <label>From</label>
                    <div class="input">
                        <input class="form-control" name="time_from" value="{{old('time_from')}}" autocomplete="off" placeholder="08:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
                <div class="col-6">
                    <label>To</label>
                    <div class="input">
                        <input class="form-control" name="time_to" value="{{old('time_to')}}" autocomplete="off" placeholder="16:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
            <div class="col-6">
                    <label>Lunch From</label>
                    <div class="input">
                        <input class="form-control" name="lunch_from" autocomplete="off" value="{{old('lunch_from')}}" placeholder="12:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
                <div class="col-6">
                    <label>Lunch To</label>
                    <div class="input">
                        <input class="form-control" name="lunch_to" autocomplete="off" value="{{old('lunch_to')}}" placeholder="13:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
            </div>
            <div class="text-end mb-5">
                <a href="/admin/schedule/member/{{$member->id}}" class="cancel-button">Back</a>
                <a href="#" class="save-button" onclick="document.getElementById('add-work-time').submit(); return false;">Add</a>
            </div>
    </form>
    <hr>

    <h2>Active Working hours</h2>
    @foreach($work_times as $time)
    <div class="row customer">
        <div class="col-8">
            <div class="name"> <span class="material-icons">date_range</span> {{$time->date_from}} - {{$time->date_to}}</div>
            <div class="email"><span class="material-icons">watch_later</span> {{$time->time_from}} do {{$time->time_to}}</div>
            @if($time->lunch_from)<div class="email mb-3"><span class="material-icons">restaurant</span> {{$time->lunch_from}} do {{$time->lunch_to}}</div>@endif
        </div>
        <div class="col-2 text-end">
        <a href="/admin/schedule/work-time/{{$member->id}}/edit/{{$time->id}}" class="delete"><span class="material-icons">edit</span></a>
        </div>
        <div class="col-2 text-end">
        <a href="/admin/schedule/work-time/confirm-delete/{{$time->id}}/{{$member->id}}" class="delete"><span class="material-icons">delete</span></a>
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
