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
<h1>Horários de trabalho</h1>
<h2>Configure o tempo de trabalho semanal que pode ser repetido.</h2>
<form action="/admin/schedule/generate/store" method="post" id="add-work-time">
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{$member->id}}">
            <div class="row">
                <div class="col-12">
                    <label>Começa no dia</label>
                    <div class="input">
                        <input class="form-control" id="date_from" name="date_from" autocomplete="off" value="{{old('date_from')}}" placeholder="01.01.{{date('Y')}}">
                        <span class="material-icons">date_range</span>
                    </div>
                </div>
            </div>
            <!-- Ponedeljek -->
            <h3>Segunda</h3>
            <div class="row">
            <div class="col-6">
                    <label>Começa</label>
                    <div class="input">
                        <input class="form-control" name="mon_time_from" value="{{old('mon_time_from')}}" autocomplete="off" placeholder="08:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
                <div class="col-6">
                    <label>Até</label>
                    <div class="input">
                        <input class="form-control" name="mon_time_to" value="{{old('mon_time_to')}}" autocomplete="off" placeholder="16:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
            <div class="col-6">
                    <label>Almoça as</label>
                    <div class="input">
                        <input class="form-control" name="mon_lunch_from" autocomplete="off" value="{{old('mon_lunch_from')}}" placeholder="12:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
                <div class="col-6">
                    <label>Almoça até</label>
                    <div class="input">
                        <input class="form-control" name="mon_lunch_to" autocomplete="off" value="{{old('mon_lunch_to')}}" placeholder="13:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
            </div>
            <!-- Torek -->
            <h3>Terça</h3>
            <div class="row">
            <div class="col-6">
                    <label>Começa</label>
                    <div class="input">
                        <input class="form-control" name="tue_time_from" value="{{old('tue_time_from')}}" autocomplete="off" placeholder="08:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
                <div class="col-6">
                    <label>Até</label>
                    <div class="input">
                        <input class="form-control" name="tue_time_to" value="{{old('tue_time_to')}}" autocomplete="off" placeholder="16:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
            <div class="col-6">
                    <label>Almoça as</label>
                    <div class="input">
                        <input class="form-control" name="tue_lunch_from" autocomplete="off" value="{{old('tue_lunch_from')}}" placeholder="12:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
                <div class="col-6">
                    <label>Almoça até</label>
                    <div class="input">
                        <input class="form-control" name="tue_lunch_to" autocomplete="off" value="{{old('tue_lunch_to')}}" placeholder="13:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
            </div>
            <!-- Sreda -->
            <h3>Quarta</h3>
            <div class="row">
            <div class="col-6">
                    <label>Começa</label>
                    <div class="input">
                        <input class="form-control" name="wed_time_from" value="{{old('wed_time_from')}}" autocomplete="off" placeholder="08:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
                <div class="col-6">
                    <label>Até</label>
                    <div class="input">
                        <input class="form-control" name="wed_time_to" value="{{old('wed_time_to')}}" autocomplete="off" placeholder="16:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
            <div class="col-6">
                    <label>Almoça as</label>
                    <div class="input">
                        <input class="form-control" name="wed_lunch_from" autocomplete="off" value="{{old('wed_lunch_from')}}" placeholder="12:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
                <div class="col-6">
                    <label>Almoça até</label>
                    <div class="input">
                        <input class="form-control" name="wed_lunch_to" autocomplete="off" value="{{old('wed_lunch_to')}}" placeholder="13:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
            </div>
            <!-- Četrtek -->
            <h3>Quinta</h3>
            <div class="row">
            <div class="col-6">
                    <label>Começa</label>
                    <div class="input">
                        <input class="form-control" name="thu_time_from" value="{{old('thu_time_from')}}" autocomplete="off" placeholder="08:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
                <div class="col-6">
                    <label>Até</label>
                    <div class="input">
                        <input class="form-control" name="thu_time_to" value="{{old('thu_time_to')}}" autocomplete="off" placeholder="16:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
            <div class="col-6">
                    <label>Almoça as</label>
                    <div class="input">
                        <input class="form-control" name="thu_lunch_from" autocomplete="off" value="{{old('thu_lunch_from')}}" placeholder="12:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
                <div class="col-6">
                    <label>Almoça até</label>
                    <div class="input">
                        <input class="form-control" name="thu_lunch_to" autocomplete="off" value="{{old('thu_lunch_to')}}" placeholder="13:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
            </div>
            <!-- Petek -->
            <h3>Sexta</h3>
            <div class="row">
            <div class="col-6">
                    <label>Começa</label>
                    <div class="input">
                        <input class="form-control" name="fri_time_from" value="{{old('fri_time_from')}}" autocomplete="off" placeholder="08:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
                <div class="col-6">
                    <label>Até</label>
                    <div class="input">
                        <input class="form-control" name="fri_time_to" value="{{old('fri_time_to')}}" autocomplete="off" placeholder="16:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
            <div class="col-6">
                    <label>Almoça as</label>
                    <div class="input">
                        <input class="form-control" name="fri_lunch_from" autocomplete="off" value="{{old('fri_lunch_from')}}" placeholder="12:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
                <div class="col-6">
                    <label>Almoça até</label>
                    <div class="input">
                        <input class="form-control" name="fri_lunch_to" autocomplete="off" value="{{old('fri_lunch_to')}}" placeholder="13:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
            </div>
            <!-- Sobota -->
            <h3>Sábado</h3>
            <div class="row">
            <div class="col-6">
                    <label>Começa</label>
                    <div class="input">
                        <input class="form-control" name="sat_time_from" value="{{old('sat_time_from')}}" autocomplete="off" placeholder="08:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
                <div class="col-6">
                    <label>Até</label>
                    <div class="input">
                        <input class="form-control" name="sat_time_to" value="{{old('sat_time_to')}}" autocomplete="off" placeholder="16:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
            <div class="col-6">
                    <label>Almoça as</label>
                    <div class="input">
                        <input class="form-control" name="sat_lunch_from" autocomplete="off" value="{{old('sat_lunch_from')}}" placeholder="12:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
                <div class="col-6">
                    <label>Almoça até</label>
                    <div class="input">
                        <input class="form-control" name="sat_lunch_to" autocomplete="off" value="{{old('sat_lunch_to')}}" placeholder="13:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
            </div>
            <!-- Nedelja -->
            <h3>Domingo</h3>
            <div class="row">
            <div class="col-6">
                    <label>Começa</label>
                    <div class="input">
                        <input class="form-control" name="sun_time_from" value="{{old('sun_time_from')}}" autocomplete="off" placeholder="08:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
                <div class="col-6">
                    <label>Até</label>
                    <div class="input">
                        <input class="form-control" name="sun_time_to" value="{{old('sun_time_to')}}" autocomplete="off" placeholder="16:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
            <div class="col-6">
                    <label>Almoça as</label>
                    <div class="input">
                        <input class="form-control" name="sun_lunch_from" autocomplete="off" value="{{old('sun_lunch_from')}}" placeholder="12:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
                <div class="col-6">
                    <label>Almoça até</label>
                    <div class="input">
                        <input class="form-control" name="sun_lunch_to" autocomplete="off" value="{{old('sun_lunch_to')}}" placeholder="13:00">
                        <span class="material-icons">schedule</span>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label>Gerar para:</label>
                    <div class="input">
                                <select class="form-control" name="repeat">
                                    <option value="1" @if(old('repeat') == 1){{'selected="selected"'}}@endif>1 Semana</option>
                                    <option value="2" @if(old('repeat') == 2){{'selected="selected"'}}@endif>2 Semanas</option>
                                    <option value="3" @if(old('repeat') == 3){{'selected="selected"'}}@endif>3 Semanas</option>
                                    <option value="4" @if(old('repeat') == 4){{'selected="selected"'}}@endif>1 Semanas</option>
                                    <option value="5" @if(old('repeat') == 5){{'selected="selected"'}}@endif>2 Semanas</option>
                                    <option value="6" @if(old('repeat') == 6){{'selected="selected"'}}@endif>3 Semanas</option>
                                    <option value="7" @if(old('repeat') == 7){{'selected="selected"'}}@endif>6 Semanas</option>
                                </select>
                            </div>
                </div>
            </div>

            <div class="text-end mb-5">
                <a href="/admin/schedule/work-time/{{$member->id}}" class="cancel-button">Voltar</a>
                <a href="#" class="save-button" onclick="document.getElementById('add-work-time').submit(); return false;">Gerar</a>
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
