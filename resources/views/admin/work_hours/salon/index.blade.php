@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

<div class="container">
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-success">
        @foreach ($errors->all() as $error)
        {{ $error }}<br>
        @endforeach
    </div>
@endif
    <h1>Horários de trabalho da empresa</h1>
    <h2>Configure os horários.</h2>
    <form method="post" id="work-hours" action="/admin/salon-work-hours/update">
    {{ csrf_field() }}
    <h3>Segunda</h3>
    <div class="row">
        <div class="col-12">
            <div class="input-plain text-center">
                        <input type="text" class="form-control text-center" name="mon_from" maxlength="5" placeholder="08:00" value="{{$data->mon_from}}"@if($data->mon_closed) disabled @endif> -
                        <input type="text" class="form-control text-center" name="mon_to" maxlength="5" placeholder="16:00" value="{{$data->mon_to}}"@if($data->mon_closed) disabled @endif>
                        <input type="checkbox" style="display:none" name="mon_closed" id="mon_closed" value="1"@if($data->mon_closed) checked="checked"@endif> <label for="mon_closed">{{ $data->mon_closed ? 'Aberto' : 'Fechado'}}</label>
                    </div>
        </div>
    </div>
    <hr>
    <h3>Terça</h3>
    <div class="row">
        <div class="col-12">
            <div class="input-plain text-center">
                        <input type="text" class="form-control text-center" name="tue_from" maxlength="5"placeholder="08:00" value="{{$data->tue_from}}"@if($data->tue_closed) disabled @endif> -
                        <input type="text" class="form-control text-center" name="tue_to" maxlength="5" placeholder="16:00" value="{{$data->tue_to}}"@if($data->tue_closed) disabled @endif>
                        <input type="checkbox" style="display:none" name="tue_closed" id="tue_closed" value="1"@if($data->tue_closed) checked="checked"@endif> <label for="tue_closed">{{ $data->tue_closed ? 'Aberto' : 'Fechado'}}</label>
                    </div>
        </div>
    </div>
    <hr>
    <h3>Quarta</h3>
    <div class="row">
        <div class="col-12">
            <div class="input-plain text-center">
                        <input type="text" class="form-control text-center" name="wed_from" maxlength="5" placeholder="08:00" value="{{$data->wed_from}}"@if($data->wed_closed) disabled @endif> -
                        <input type="text" class="form-control text-center" name="wed_to" maxlength="5" placeholder="16:00" value="{{$data->wed_to}}"@if($data->wed_closed) disabled @endif>
                        <input type="checkbox" style="display:none" name="wed_closed" id="wed_closed" value="1"@if($data->wed_closed) checked="checked"@endif> <label for="wed_closed">{{ $data->wed_closed ? 'Aberto' : 'Fechado'}}</label>
                    </div>
        </div>
    </div>
    <hr>
    <h3>Quinta</h3>
    <div class="row">
        <div class="col-12">
            <div class="input-plain text-center">
                        <input type="text" class="form-control text-center" name="thu_from" maxlength="5" placeholder="08:00" value="{{$data->thu_from}}"@if($data->thu_closed) disabled @endif> -
                        <input type="text" class="form-control text-center" name="thu_to" maxlength="5" placeholder="16:00" value="{{$data->thu_to}}"@if($data->thu_closed) disabled @endif>
                        <input type="checkbox" style="display:none" name="thu_closed" id="thu_closed" value="1"@if($data->thu_closed) checked="checked"@endif> <label for="thu_closed">{{ $data->thu_closed ? 'Aberto' : 'Fechado'}}</label>
                    </div>
        </div>
    </div>
    <hr>
    <h3>Sexta</h3>
    <div class="row">
        <div class="col-12">
            <div class="input-plain text-center">
                        <input type="text" class="form-control text-center" name="fri_from" maxlength="5" placeholder="08:00" value="{{$data->fri_from}}"@if($data->fri_closed) disabled @endif> -
                        <input type="text" class="form-control text-center" name="fri_to" maxlength="5" placeholder="16:00" value="{{$data->fri_to}}"@if($data->fri_closed) disabled @endif>
                        <input type="checkbox" style="display:none" name="fri_closed" id="fri_closed" value="1"@if($data->fri_closed) checked="checked"@endif> <label for="fri_closed">{{ $data->fri_closed ? 'Aberto' : 'Fechado'}}</label>
                    </div>
        </div>
    </div>
    <hr>
    <h3>Sábado</h3>
    <div class="row">
        <div class="col-12">
            <div class="input-plain text-center">
                        <input type="text" class="form-control text-center" name="sat_from" maxlength="5" placeholder="08:00" value="{{$data->sat_from}}"@if($data->sat_closed) disabled @endif> -
                        <input type="text" class="form-control text-center" name="sat_to" maxlength="5" placeholder="16:00" value="{{$data->sat_to}}"@if($data->sat_closed) disabled @endif>
                        <input type="checkbox" style="display:none" name="sat_closed" id="sat_closed" value="1"@if($data->sat_closed) checked="checked"@endif> <label for="sat_closed">{{ $data->sat_closed ? 'Aberto' : 'Fechado'}}</label>
                    </div>
        </div>
    </div>
    <hr>
    <h3>Domingo</h3>
    <div class="row">
        <div class="col-12">
            <div class="input-plain text-center">
                        <input type="text" class="form-control text-center" name="sun_from" maxlength="5" placeholder="08:00" value="{{$data->sun_from}}"@if($data->sun_closed) disabled @endif> -
                        <input type="text" class="form-control text-center" name="sun_to" maxlength="5" placeholder="16:00" value="{{$data->sun_to}}"@if($data->sun_closed) disabled @endif>
                        <input type="checkbox" style="display:none" name="sun_closed" id="sun_closed" value="1"@if($data->sun_closed) checked="checked"@endif> <label for="sun_closed">{{ $data->sun_closed ? 'Aberto' : 'Fechado'}}</label>
                    </div>
        </div>
    </div>
    <hr>
    <div class="text-end">
        <a href="#" class="save-button" onclick="document.getElementById('work-hours').submit(); return false;">Salvar</a>
    </div>
    </form>
    @include('admin.layout.footer')
</div>
<script>
          $(document).ready(function() {
            $('input[type=checkbox]').on('change', function () {

                var is_checked = $(this).prop('checked');

                if(is_checked)
                {
                    $(this).parent().find('input[type=text]').prop( "disabled", true );
                } else {
                    $(this).parent().find('input[type=text]').prop( "disabled", false );
                }
            });

            $("label").on("click", function(e) {

                var text = $(this).text();

                $(this).text(
                    text == "Fechado" ? "Aberto" : "Fechado"
                );
            });
          });
      </script>
@endsection
