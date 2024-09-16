@extends('admin.layout.index')

@section('content')
<div class="main-page">
          <div class="container py-5">
        <div class="row">
            <div class="col-xl-1 col-lg-1 col-md-12">
                <div class="welcome-image mb-3" style="background-image:url(@if(Auth::user()->profile_image)/images/profile_images/{{Auth::user()->profile_image}}@else/images/admin/icons/user_color.png @endif)"></div>
            </div>
            <div class="col-xl-7 col-lg-5 col-md-12">

                <div class="welcome-message">
                    <h4>Bem vindo de volta,
                        @if(Auth::user()->name)
                            {{Auth::user()->name}} {{Auth::user()->surname}}
                        @else
                            {{Auth::user()->email}}
                        @endif
                    </h4>
                    <span class="material-icons">watch_later</span> Hoje você @if($reservations_today->count() == 0)
                                ainda não tem reservas
                            @elseif($reservations_today->count() == 1)
                                tem {{$reservations_today->count()}} reserva
                            @elseif($reservations_today->count() == 2)
                                tem {{$reservations_today->count()}} reservas
                            @elseif($reservations_today->count() == 3)
                                tem {{$reservations_today->count()}} reservas
                            @elseif($reservations_today->count() == 4)
                                tem {{$reservations_today->count()}} reservas
                            @else
                                tem {{$reservations_today->count()}} reservas
                            @endif e @if($customers->count() == 0)
                                nenhum cliente
                            @elseif($customers->count() == 1)
                            {{$customers->count()}} novo cliente
                            @elseif($customers->count() == 2)
                            {{$customers->count()}} novos clientes
                            @elseif($customers->count() == 3)
                            {{$customers->count()}} novos clientes
                            @elseif($customers->count() == 4)
                            {{$customers->count()}} novos clientes
                            @else
                            {{$customers->count()}} novos clientes
                            @endif
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-12 buttons text-end">
               <a href="/admin/reservations" class="btn-welcome-color">
                <span class="material-icons">watch_later</span> Reservas
               </a>
            </div>
        </div>
    </div>

      </div>
      <div class="pt-4 border-top">

        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-8">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4">
                            <div class="stat p-3 mb-4">
                            Reservas hoje
                            <div class="text-center mt-3">
                                <h1>{{$reservations_today->count()}}</h1>
                                <span>
                                @if($reservations_today->count() == 0)
                                    Reservas
                                @elseif($reservations_today->count() == 1)
                                    Reservas
                                @elseif($reservations_today->count() == 2)
                                    Reservas
                                @elseif($reservations_today->count() == 3)
                                    Reservas
                                @elseif($reservations_today->count() == 4)
                                    Reservas
                                @else
                                    Reservas
                                @endif

                                </span>
                                <h2 class="mt-3">Completados: <strong>{{$completed_reservations}}</strong></h2>
                            </div>
                        </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 d-none d-lg-block d-xl-block">
                            <div class="stat p-3 mb-3">
                            Clientes hoje
                            <div class="text-center mt-3">
                                <h1>{{$customers->count()}}</h1>
                                <span>@if($customers->count() == 0)
                                    Clientes
                                @elseif($customers->count() == 1)
                                    Clientes
                                @elseif($customers->count() == 2)
                                    Clientes
                                @elseif($customers->count() == 3)
                                    Clientes
                                @elseif($customers->count() == 4)
                                    Clientes
                                @else
                                    Clientes
                                @endif</span>
                                <h2 class="mt-3">Ontem: <strong>{{$customers_yesterday}}</strong></h2>
                            </div>
                        </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 d-none d-lg-block d-xl-block">
                            <div class="stat p-3 mb-3">
                            Serviços
                            <div class="text-center mt-3">
                                <h1>{{$services->count()}}</h1>
                                <span>@if($services->count() == 0)
                                    Serviços
                                @elseif($services->count() == 1)
                                    Serviços
                                @elseif($services->count() == 2)
                                    Serviços
                                @elseif($services->count() == 3)
                                    Serviços
                                @elseif($services->count() == 4)
                                    Services
                                @else
                                    Serviços
                                @endif</span>
                                <h2 class="mt-3">Categorias: <strong>{{$categories->count()}}</strong></h2>
                            </div>
                        </div>
                        </div>
                    </div>

                </div>
                <div class="col-xl-4 col-lg-4">
                <div class="stat p-3 mb-3">
                        <div class="row">
                                <div class="col-12">Reservas nos últimos 30 dias</div>
                        </div>
                        <div class="chart">
                        @if(count($y_axis) < 5)
                            <div class="range" style="bottom:calc(0% - 0.6rem);">{{$y_axis[0]}}</div>
                            <div class="range" style="bottom:calc(33% - 0.6rem);">{{$y_axis[1]}}</div>
                            <div class="range" style="bottom:calc(66% - 0.6rem);">{{$y_axis[2]}}</div>
                            <div class="range" style="bottom:calc(100% - 0.6rem);">{{$y_axis[3]}}</div>
                        @else
                            <div class="range" style="bottom:calc(0% - 0.6rem);">{{$y_axis[0]}}</div>
                            <div class="range" style="bottom:calc(25% - 0.6rem);">{{$y_axis[1]}}</div>
                            <div class="range" style="bottom:calc(50% - 0.6rem);">{{$y_axis[2]}}</div>
                            <div class="range" style="bottom:calc(75% - 0.6rem);">{{$y_axis[3]}}</div>
                            <div class="range" style="bottom:calc(100% - 0.6rem);">{{$y_axis[4]}}</div>
                        @endif

                            @foreach($chart_days as $day)
                                <div class="bar" style="height:{{$day}}%"></div>
                            @endforeach
                        </div>
                        <div class="mt-2" id="days">
                            <div>Seg</div>
                            <div>Ter</div>
                            <div>Qua</div>
                            <div>Qui</div>
                            <div>Sex</div>
                            <div>Sab</div>
                            <div>Dom</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-xl-8">
                    <div class="stat pt-3 px-3 mb-4">
                        @if($reservations_today->count())
                        <div class="row">
                            <div class="col-12">Reservas Hoje</div>
                        </div>
                        @foreach($reservations_today as $reservation)
                        <div class="reservations-cont py-3">
                        <div class="row reservations">
                            <div class="col-12">
                                <span class="customer">{{$reservation->service}}</span>
                            </div>
                        </div>
                        <div class="row reservations">
                            <div class="col-9">
                                <span class="mt-2 time @if($reservation->passed){{'passed'}}@endif">{{$reservation->start}}</span>
                                <span class="name"><strong>{{$reservation->name}} {{$reservation->surname}}</strong> será atendido por @if(!$reservation->employee_name){{'Employee'}}@else{{$reservation->employee_name}} {{$reservation->employee_surname}}@endif</span>
                            </div>
                            <div class="col-3 text-end">
                                <a href="tel:+{{$reservation->area_code}}{{$reservation->phone}}" class="delete"><span class="material-icons">call</span></a>
                            </div>
                        </div>
                        </div>
                        @endforeach
                        @else
                        <div class="row pb-3">
                            <div class="col-12">Ainda não tem reservas hoje.</div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-xl-4">
                <div class="stat pt-3 px-3 mb-4">
                        @if($customers->count())
                        <div class="row">
                            <div class="col-12">Novos Clientes Hoje</div>
                        </div>
                        @foreach($customers as $customer)
                        <div class="reservations-cont py-3">
                        <div class="row reservations">
                            <div class="col-9">
                                <span class="customer">{{$customer->name}} {{$customer->surname}}</span>
                                <span class="time">+{{$customer->area_code}}{{$customer->phone}}</span>
                            </div>
                            <div class="col-3 text-end">
                                <a href="tel:+{{$customer->area_code}}{{$customer->phone}}" class="delete"><span class="material-icons">Ligar</span></a>
                            </div>
                        </div>
                        </div>
                        @endforeach
                        @else
                        <div class="row pb-3">
                            <div class="col-12">Ainda não tem novos clientes hoje.</div>
                        </div>
                        @endif
                    </div>

            </div>
            @include('admin.layout.footer')
    </div>
    @endsection
