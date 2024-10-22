@extends('admin.layout.index')

@section('content')
<link rel="stylesheet" href="/css/swiper-bundle.min.css">
<div class="pt-5 gray-page">

<div class="container">
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<input type="hidden" name="service" id="service" value="">
<input type="hidden" name="slot" id="slot" value="">
<input type="hidden" name="user" id="user" value="">
<input type="hidden" name="user" id="customer" value="">

<div class="pages" id="first">
    <h1>Serviços</h1>
    <h2>Selecione um serviço.</h2>

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
                                    <a href="#" data-id="{{$service->id}}" data-title="{{$service->title}}">
                                    <span class="material-icons">radio_button_unchecked</span>
                                    <span>{{$service->title}}</span><br>
                                    <span style="font-size:0.8rem">@if($service->hours){{$service->hours}} h @endif {{$service->minutes}} min / {{$info->currency_sign}}{{\App\Helpers\Helpers::FormatPrice($info->currency_format, $service->price)}}</span>
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

</div>

<div class="pages" id="second">

    <h1>Selecione um colaborador</h1>
    <h2>Colaborador <span id="service-display"></span>. Esse são os colaboradores.</h2>
    <div class="d-none d-lg-block d-xl-block d-xxl-block">

        <div class="row">
            <div class="col-6">
                <div class="dropdown calendar-nav">
                    <a class="btn calendar-days" id="dropdownMenuButton1" data-bs-toggle="dropdown" style="height: 50px;" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <div style="width:2.5rem; border-radius:100%; background-position:center center; height:2.5rem; background-size:cover; background-image:url( /images/profile_images/98438ba6b29ea0d4b943adeef7c07e41c1bb0cf3.png);">
                            </div>
                            <div class="dropdown-toggle" style="margin:0 10px">Marlon Colaborador Paulo da Silva</div>
                        </div>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                            <li>
                                <a class="dropdown-item" href="/admin/reservations/?day=&amp;user=1">
                                    <div class="d-flex align-items-center">
                                        <div style="width:2.5rem; border-radius:100%; background-position:center center; height:2.5rem; background-size:cover; background-image:url( /images/profile_images/98438ba6b29ea0d4b943adeef7c07e41c1bb0cf3.png);">
                                        </div>
                                        <div style="margin:0 10px">Marlon Colaborador Paulo da Silva</div>
                                    </div>
                                </a>
                            </li>
                                                            <li>
                                <a class="dropdown-item" href="/admin/reservations/?day=&amp;user=2">
                                    <div class="d-flex align-items-center">
                                        <div style="width:2.5rem; border-radius:100%; background-position:center center; height:2.5rem; background-size:cover; background-image:url( /images/profile_images/98438ba6b29ea0d4b943adeef7c07e41c1bb0cf3.png);">
                                        </div>
                                        <div style="margin:0 10px">Marlon Colaborador Paulo da Silva</div>
                                    </div>
                                </a>
                            </li>
                                                    </ul>
                </div>
            </div>
            
        </div>
    </div>
    <h1>Selecione um período</h1>
    <h2>Serviço <span id="service-display"></span>. Os períodos disponíveis são mostrados abaixo.</h2>
      <div class="swiper mb-4 mySwiper">
        <div class="swiper-wrapper">
            @foreach($days as $day)
            <div data-date="{{$day['date_iso']}}" class="swiper-slide @if($day['disabled']){{'disabled'}}@endif @if($day['selected']){{'selected'}}@endif">
                <div class="weekday">{{$day['day_name']}}</div>
                <div class="day">{{$day['day']}}</div>
                <div class="month">@if($day['disabled']){{'Closed'}}@else{{$day['month']}}@endif</div>
                <div class="year" style="display:none">{{$day['year']}}</div>
            </div>
            @endforeach
        </div>
    </div>
    <div id="date" class="p-3"></div>
    <div id="terms" class="mb-4"></div>

    </div>

    <div class="pages" id="third">
        <div class="row mb-3">
            <div class="col-9">
                <div class="input">
                    <input type="text" class="form-control" autocomplete="off" id="name" placeholder="Procure o nome do cliente ou cadastre">
                    <span class="material-icons left" style="
                    top: 14px;
                    left: -25px;
                ">search</span>
                </div>
            </div>
            <div class="col-3">
            <a href="#" class="add-button add-customer-button" data-url="fourth"><span class="material-icons">add</span></a>
            </div>
        </div>
        <div id="customers-add"></div>
    </div>

    <div class="pages" id="fourth">
        <div id="customer-response"></div>
        <h1>Adicionar novo cliente</h1>
        <h2>Inserir nome, sobrenome e telefone.</h2>
        <form action="/admin/customers/store" method="post" id="add-customer">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-12">
                <label>Nome</label>
                <div class="input">
                    <input class="form-control" placeholder="Nome do cliente" id="form-name" autocomplete="off">
                    <span class="material-icons">badge</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label>Sobrenome</label>
                <div class="input">
                    <input class="form-control" placeholder="Sobrenome" autocomplete="off" id="form-surname">
                    <span class="material-icons">badge</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <label>Código da área</label>
                <div class="input">
                <select class="form-control" id="form-area-code">
                    @foreach($area_codes as $area_code)
                    <option value="{{$area_code->code}}"@if($info->area_code==$area_code->id) selected="selected"@endif>{{$area_code->country}} (+{{$area_code->code}})</option>
                    @endforeach
                </select>
            </div>
            </div>
            <div class="col-8">
                <label>Telefone</label>
                <div class="input">
                    <input type="tel" class="form-control" id="form-phone" autocomplete="off" placeholder="xx xxxxx xxxx">
                    <span class="material-icons">call</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <label>E-mail (não-obrigatório)</label>
                <div class="input">
                    <input class="form-control" type="email" placeholder="Email" id="form-email" autocomplete="off">
                    <span class="material-icons">alternate_email</span>
                </div>
            </div>
        </div>

    </div>

    <div class="pages" id="sixth"></div>
    <hr>

    <div id="navigation">
        <div class="container py-3">
            <div class="row">
                <div class="col-6">
                    <a href="#" id="cancel-button" class="cancel-button text-center">Voltar</a>
                </div>
                <div class="col-6">
                    <a href="#" id="save-button" class="save-button text-center" style="display:block" data-url="second">Continuar</a>
                </div>
            </div>

        </div>
    </div>

    <div id="myNav" class="overlay">
        <div class="overlay-content">
            <div class="text-center mb-3" style="font-size:0.9rem">Escolha um Integrante</div>
            <div id="employees"></div>
        </div>
    </div>

    @include('admin.layout.footer')
</div>
<script>
    var time_format = 1;
</script>
<script src="/js/admin/swiper8.min.js"></script>
<script src="/js/admin/reservations_add.js"></script>
@endsection
