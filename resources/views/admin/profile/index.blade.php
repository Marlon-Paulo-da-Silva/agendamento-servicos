@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

<div class="container">
    <form id="photo-form" action="*" method="post" enctype="multipart/form-data">
        <label class="profile-image mb-3" for="file" style="background-image:url(@if(Auth::user()->profile_image)/images/profile_images/{{Auth::user()->profile_image}}@else/images/admin/icons/user_color.png @endif);">
            <span class="material-icons">change_circle</span>
        </label>
        <input id="file" type="file" accept="image/*" name="photo"></a>
    </form>
    @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
    <h1>Perfil</h1>
    <h2>Adicionar sua foto e seu nome.</h2>
    <div class="row mb-5">
        <div class="col-12">
        <a href="/perfil" class="add-button"><span class="material-icons">lock</span> Mudar usuário e senha</a>
        </div>
    </div>
    <form method="post" id="profile" action="/admin/profile/update">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-12">
            <label>Nome Principal</label>
            <div class="input">
                <input class="form-control" name="name" value="{{$data->name}}">
                <span class="material-icons">badge</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Sobrenome</label>
            <div class="input">
                <input class="form-control" name="surname" value="{{$data->surname}}">
                <span class="material-icons">badge</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Segmento</label>
            <div class="input">
                <input class="form-control" name="occupation" value="{{$data->occupation}}">
                <span class="material-icons">work</span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Telefone</label>
            <div class="row">
                <div class="col-4">
                    <div class="input">
                <select class="form-control" name="area_code">
                    @foreach($area_codes as $area_code)
                    <option value="{{$area_code->code}}"@if($data->area_code==$area_code->code) selected="selected"@endif>{{$area_code->country}} (+{{$area_code->code}})</option>
                    @endforeach
                </select>
            </div>
            </div>
            <div class="col-8">
            <div class="input">
                <input class="form-control" name="phone" value="{{$data->phone}}">
                <span class="material-icons">call</span>
            </div>
            </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Sobre você</label>
            <div class="input-plain">
                <textarea class="form-control" name="about">{{$data->about}}</textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-plain">
                <input type="checkbox" id="include-profile" name="include_profile" value="1" @if($data->include_profile==1){{'checked'}}@endif> <label for="include-profile">Incluir meu perfil como parte da equipe</label>
            </div>
        </div>
    </div>
    <hr>
    <div class="text-end">
        <a href="#" class="save-button" onclick="document.getElementById('profile').submit(); return false;">Salvar</a>
    </div>
    </form>

    @include('admin.layout.footer')
</div>

<script src="/js/admin/profile.js"></script>

@endsection
