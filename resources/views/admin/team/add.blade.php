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
<h1>Adicionar novo integrante ao time</h1>
            <h2>@if($email){{$email}}@else{{old('email')}}@endif</h2>
            <h2>Configure uma senha forte com ao menos 6 caracteres.</h2>
            <form method="post" id="new-user" action="/admin/team/member/store">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-12">
                    <label>Nome</label>
                    <div class="input">
                        <input type="text" class="form-control" name="name" value="{{old('name')}}" placeholder="Nome">
                        <span class="material-icons">badge</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>Sobrenome</label>
                    <div class="input">
                        <input type="text" class="form-control" name="surname" value="{{old('surname')}}" placeholder="Sobrenome">
                        <span class="material-icons">badge</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>Senha</label>
                    <div class="input-customer">
                        <input type="password" id="password" class="form-control" name="password" placeholder="Ao menos 6 caracteres">
                        <span class="material-icons left">lock</span>
                        <a href="#" id="show-password"><span class="material-icons right">visibility_off</span></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>Repita a Senha</label>
                    <div class="input-customer">
                        <input type="password" id="repeat-password" class="form-control" name="password_confirmation" placeholder="Ao menos 6 caracteres">
                        <span class="material-icons left">lock</span>
                        <a href="#" id="show-repeat-password"><span class="material-icons right">visibility_off</span></a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-end">
                <a href="/admin/team" class="cancel-button">Cancelar</a>
                <a href="#" class="save-button" onclick="document.getElementById('new-user').submit(); return false;">Salvar</a>
            </div>
            <input type="hidden" name="email" value="@if($email){{$email}}@else{{old('email')}}@endif">
            </form>
            <script type="text/javascript">
                $(document).ready(function() {
                    $('#show-password').on('click', function (e) {
                        e.preventDefault();
                        if($('#password').hasClass('visible')) {
                            $('#password').prop('type', 'password');
                            $(this).find('.material-icons').text('visibility_off');
                        } else {
                            $('#password').prop('type', 'text');
                            $(this).find('.material-icons').text('visibility');
                        }

                        $('#password').toggleClass('visible');
                    });

                    $('#show-repeat-password').on('click', function (e) {
                        e.preventDefault();
                        if($('#repeat-password').hasClass('visible')) {
                            $('#repeat-password').prop('type', 'password');
                            $(this).find('.material-icons').text('visibility_off');
                        } else {
                            $('#repeat-password').prop('type', 'text');
                            $(this).find('.material-icons').text('visibility');
                        }

                        $('#repeat-password').toggleClass('visible');
                    });

                });

            </script>

    @include('admin.layout.footer')
</div>
@endsection
