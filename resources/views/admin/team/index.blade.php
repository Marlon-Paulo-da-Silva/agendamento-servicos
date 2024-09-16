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

    <h1>Equipe</h1>
    <h2>Adicionar ou remover um integrante.</h2>
    <div class="row">
        <div class="col-12">
            <label>Adicionar Novo Integrante</label>
            <div class="input-customer">
                <form action="/admin/team/member/add" id="add-user" method="post">
                    {{ csrf_field() }}
                    <input type="email" class="form-control" autocomplete="off" value="" name="email" placeholder="Email" required>
                </form>
                <span class="material-icons left">person</span>
                <a href="#" onclick="document.getElementById('add-user').submit(); return false;"><span class="material-icons right">add_circle</span></a>
            </div>
        </div>
    </div>
    <hr>
    @foreach($members as $member)
    <div class="row customer">
        <div class="col-2">
        <div class="customer-image mb-3" style="background-image:url(@if($member->profile_image)/images/profile_images/{{$member->profile_image}}@else/images/admin/icons/user_color.png @endif)"></div>

        </div>
        <div class="col-8">
            <div class="name">@if(!$member->name) User @else{{$member->name}} {{$member->surname}}@endif</div>
            <div class="email">{{$member->email}}</div>
        </div>
        <div class="col-2 text-end">
        <a href="/admin/team/member/confirm-delete/{{$member->id}}" class="delete"><span class="material-icons">delete</span></a>
        </div>
    </div>
    <hr>
    @endforeach

    @include('admin.layout.footer')
</div>
@endsection
