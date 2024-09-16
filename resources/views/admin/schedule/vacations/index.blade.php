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
<form action="/admin/schedule/vacations/store" method="post" id="add-work-time">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{$member->id}}">
            <div class="row">
                <div class="col-12">
                    <label>Beginning</label>
                    <div class="input">
                        <input class="form-control" id="date_from" name="date_from" autocomplete="off" value="@if(old('date_from')){{old('date_from')}}@else{{$work_times->date_from}}@endif" placeholder="01.01.{{date('Y')}}">
                        <span class="material-icons">date_range</span>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label>End</label>
                    <div class="input">
                        <input class="form-control" id="date_to" name="date_to" autocomplete="off" value="@if(old('date_to')){{old('date_to')}}@else{{$work_times->date_to}}@endif" placeholder="01.01.{{date('Y')}}">
                        <span class="material-icons">date_range</span>
                    </div>
                </div>
            </div>
            <div class="text-end mb-5">
                <a href="/admin/schedule/member/{{$member->id}}" class="cancel-button">Back</a>
                <a href="#" class="save-button" onclick="document.getElementById('add-work-time').submit(); return false;">Save</a>
            </div>
    </form>
    <hr>

<div id="myNav" class="overlay">
    <div class="overlay-content">
        <div>
        <div class="row">
            <div class="col-2"><button id="previous" onclick="previous()">&#8249;</button></div>
            <div class="col-8 text-center"><h3 id="month-present"></h3><div id="year-present"></div></div>
            <div class="col-2 text-end"><button id="next" onclick="next()">&#8250;</button></div>
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