@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

<div class="container">
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
    <h1>Meus Serviços</h1>
    <h2>Escolha os serviços que você gostaria de oferecer</h2>
    <div class="mb-3">
    <a href="#" class="cancel-button" id="mark-all">Marcar Todos</a> <a href="#" class="cancel-button" id="unmark-all">Desmarcar Todos</a>
</div>
    <form method="post" action="/admin/my-services/update" id="my-services">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-12">

        <div class="services">
        @foreach($categories as $cats)
        <div class="service-cont">
                        @if($cats['num'])
                        <div class="service-title">
                            <div class="row">
                                <div class="col-10">
                                {{$cats['title']}}
                                </div>
                                <div class="col-2 text-end">
                                    <div class="expand"><span class="material-icons">expand_more</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="rows">
                            @foreach($cats['services'] as $service)
                            <div class="row service">
                                <div class="col-12">
                                    <input type="checkbox" name="checked[]" style="display:none" value="{{$service->id}}" @if($service->checked)checked @endif>
                                    <a href="#" @if($service->checked)class="sel"@endif>
                                    <span class="material-icons">@if($service->checked){{'check_circle_outline'}}@else{{'radio_button_unchecked'}}@endif</span>
                                    <span>{{$service->title}}</span><br>
                                    <span style="font-size:0.8rem">
                                        @if($service->hours)
                                            {{$service->hours}} h 
                                        @endif 
                                        {{$service->minutes}} min / 
                                        R$ {{ number_format($service->price, 2, ',', '.') }} 
                                    </span>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        @endif

        </div>
        @endforeach


            </div>
            <div class="mb-3"></div>

        </div>
    </div>


    <hr>
    <div class="text-end">
        <a href="#" class="save-button" onclick="document.getElementById('my-services').submit(); return false;">Salvar</a>
    </div>
    </form>

    @include('admin.layout.footer')
</div>
<script src="/js/admin/my_services.js"></script>
@endsection
