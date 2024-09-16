@extends('admin.layout.index')

@section('content')
    <link rel="stylesheet" href="/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="/css/admin/calendar.css">
    <div class="pt-5 gray-page">
        {{-- {{ dd($reservations) }} --}}


        <div class="container">
            @if (Auth::user()->privilege == 1)
                <h1>Reservas</h1>
                <h2>Adicionar ou procurar uma reserva.</h2>
                <div class="row mb-4">
                    <div class="col-12">
                        <a href="/admin/reservations/add" class="add-button"><span class="material-icons">add</span> Adicionar</a>
                    </div>
                </div>
            @else
            <h1>Reservas</h1>
            <h2>Procurar Reservas.</h2>
            @endif
            <input type="hidden" id="employee" value="{{ $selected_user->id }}">

            <div class="d-block d-lg-none d-xl-none d-xxl-none mb-4">
                <div class="dropdown calendar-nav" >
                    <a class="btn calendar-days" id="dropdownMenuButton1" style="width: 100%;" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="d-flex align-items-center">
                            <div
                                style="width:2.5rem; border-radius:100%; background-position:center center; height:2.5rem; background-size:cover; background-image:url(@if ($selected_user->profile_image) /images/profile_images/{{ $selected_user->profile_image }}@else/images/admin/icons/user_color.png @endif);">
                            </div>
                            <div class="dropdown-toggle" style="margin:0 10px">@if(!strlen($selected_user->name)){{'User'}}@else{{ $selected_user->name }} {{ $selected_user->surname }}@endif</div>
                        </div>
                    </a>
                    <ul class="dropdown-menu" style="width: 100%" aria-labelledby="dropdownMenuButton1">
                        @foreach ($users as $user)
                            <li>
                                <a class="dropdown-item"
                                    href="/admin/reservations/?day={{ $request_day }}&user={{ $user->id }}">
                                    <div class="d-flex align-items-center">
                                        <div
                                            style="width:2.5rem; border-radius:100%; background-position:center center; height:2.5rem; background-size:cover; background-image:url(@if ($user->profile_image) /images/profile_images/{{ $user->profile_image }}@else/images/admin/icons/user_color.png @endif);">
                                        </div>
                                        <div style="margin:0 10px">@if(!strlen($user->name)){{'User'}}@else{{ $user->name }} {{ $user->surname }}@endif</div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="d-none d-lg-block d-xl-block d-xxl-block">

                <div class="row">
                    <div class="col-6">
                        <div class="dropdown calendar-nav">
                            <a class="btn calendar-days" id="dropdownMenuButton1" data-bs-toggle="dropdown" style="height: 50px;"
                                aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <div
                                        style="width:2.5rem; border-radius:100%; background-position:center center; height:2.5rem; background-size:cover; background-image:url(@if ($selected_user->profile_image) /images/profile_images/{{ $selected_user->profile_image }}@else/images/admin/icons/user_color.png @endif);">
                                    </div>
                                    <div class="dropdown-toggle" style="margin:0 10px">@if(!strlen($selected_user->name)){{'User'}}@else{{ $selected_user->name }} {{ $selected_user->surname }}@endif</div>
                                </div>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                @foreach ($users as $user)
                                    <li>
                                        <a class="dropdown-item"
                                            href="/admin/reservations/?day={{ $request_day }}&user={{ $user->id }}">
                                            <div class="d-flex align-items-center">
                                                <div
                                                    style="width:2.5rem; border-radius:100%; background-position:center center; height:2.5rem; background-size:cover; background-image:url(@if ($user->profile_image) /images/profile_images/{{ $user->profile_image }}@else/images/admin/icons/user_color.png @endif);">
                                                </div>
                                                <div style="margin:0 10px">@if(!strlen($user->name)){{'User'}}@else{{ $user->name }} {{ $user->surname }}@endif</div>
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-end mb-5 calendar-nav">
                            <div class="calendar-days p-3">{{ $first_day }} - {{ $last_day }}</div>
                            <a href="?day={{ $previous_week }}&user={{ $selected_user->id }}" class="p-3"><span
                                    class="material-icons">chevron_left</span></a>
                            <a href="?day={{ $next_week }}&user={{ $selected_user->id }}" class="p-3"><span
                                    class="material-icons">chevron_right</span></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-none d-lg-block d-xl-block d-xxl-block">
                <div style="display:flex; padding-left:60px;">
                    <div class="cd-schedule__top-info">Segunda</div>
                    <div class="cd-schedule__top-info">Terça</div>
                    <div class="cd-schedule__top-info">Quarta</div>
                    <div class="cd-schedule__top-info">Quinta</div>
                    <div class="cd-schedule__top-info">Sexta</div>
                    <div class="cd-schedule__top-info">Sábado</div>
                    <div class="cd-schedule__top-info">Domingo</div>
                </div>
            </div>

            <div id="scrollable-div" class="js d-none d-lg-block d-xl-block d-xxl-block">

                <div class="cd-schedule">
                    <div class="cd-schedule__timeline">
                        <div class="cd-schedule__now" data-now="{{ $now }}">
                            <span></span>
                        </div>
                        <ul>
                            @if($info->time_format == 1)
                            <li><span>0:00am</span></li>
                            <li><span>0:30am</span></li>
                            <li><span>1:00am</span></li>
                            <li><span>1:30am</span></li>
                            <li><span>2:00am</span></li>
                            <li><span>2:30am</span></li>
                            <li><span>3:00am</span></li>
                            <li><span>3:30am</span></li>
                            <li><span>4:00am</span></li>
                            <li><span>4:30am</span></li>
                            <li><span>5:00am</span></li>
                            <li><span>5:30am</span></li>
                            <li><span>6:00am</span></li>
                            <li><span>6:30am</span></li>
                            <li><span>7:00am</span></li>
                            <li><span>7:30am</span></li>
                            <li><span>8:00am</span></li>
                            <li><span>8:30am</span></li>
                            <li><span>9:00am</span></li>
                            <li><span>9:30am</span></li>
                            <li><span>10:00am</span></li>
                            <li><span>10:30am</span></li>
                            <li><span>11:00am</span></li>
                            <li><span>11:30am</span></li>
                            <li><span>12:00pm</span></li>
                            <li><span>12:30pm</span></li>
                            <li><span>1:00pm</span></li>
                            <li><span>1:30pm</span></li>
                            <li><span>2:00pm</span></li>
                            <li><span>2:30pm</span></li>
                            <li><span>3:00pm</span></li>
                            <li><span>3:30pm</span></li>
                            <li><span>4:00pm</span></li>
                            <li><span>4:30pm</span></li>
                            <li><span>5:00pm</span></li>
                            <li><span>5:30pm</span></li>
                            <li><span>6:00pm</span></li>
                            <li><span>6:30pm</span></li>
                            <li><span>7:00pm</span></li>
                            <li><span>7:30pm</span></li>
                            <li><span>8:00pm</span></li>
                            <li><span>8:30pm</span></li>
                            <li><span>9:00pm</span></li>
                            <li><span>9:30pm</span></li>
                            <li><span>10:00pm</span></li>
                            <li><span>10:30pm</span></li>
                            <li><span>11:00pm</span></li>
                            <li><span>11:30pm</span></li>
                            <li><span>12:00pm</span></li>
                            @else
                            <li><span>00:00</span></li>
                            <li><span>00:30</span></li>
                            <li><span>01:00</span></li>
                            <li><span>01:30</span></li>
                            <li><span>02:00</span></li>
                            <li><span>02:30</span></li>
                            <li><span>03:00</span></li>
                            <li><span>03:30</span></li>
                            <li><span>04:00</span></li>
                            <li><span>04:30</span></li>
                            <li><span>05:00</span></li>
                            <li><span>05:30</span></li>
                            <li><span>06:00</span></li>
                            <li><span>06:30</span></li>
                            <li><span>07:00</span></li>
                            <li><span>07:30</span></li>
                            <li><span>08:00</span></li>
                            <li><span>08:30</span></li>
                            <li><span>09:00</span></li>
                            <li><span>09:30</span></li>
                            <li><span>10:00</span></li>
                            <li><span>10:30</span></li>
                            <li><span>11:00</span></li>
                            <li><span>11:30</span></li>
                            <li><span>12:00</span></li>
                            <li><span>12:30</span></li>
                            <li><span>13:00</span></li>
                            <li><span>13:30</span></li>
                            <li><span>14:00</span></li>
                            <li><span>14:30</span></li>
                            <li><span>15:00</span></li>
                            <li><span>15:30</span></li>
                            <li><span>16:00</span></li>
                            <li><span>16:30</span></li>
                            <li><span>17:00</span></li>
                            <li><span>17:30</span></li>
                            <li><span>18:00</span></li>
                            <li><span>18:30</span></li>
                            <li><span>19:00</span></li>
                            <li><span>19:30</span></li>
                            <li><span>20:00</span></li>
                            <li><span>20:30</span></li>
                            <li><span>21:00</span></li>
                            <li><span>21:30</span></li>
                            <li><span>22:00</span></li>
                            <li><span>22:30</span></li>
                            <li><span>23:00</span></li>
                            <li><span>23:30</span></li>
                            <li><span>24:00</span></li>
                            @endif
                        </ul>
                    </div>

                    <div class="cd-schedule__events">
                        <ul>
                            <li class="cd-schedule__group">

                                <ul>
                                    @foreach ($reservations['Mon'] as $mon)
                                        <li class="cd-schedule__event">
                                            <a href="/admin/reservations/reservation/{{ $mon['id'] }}" data-start_e="{{ $mon['start_e'] }}" data-end_e="{{ $mon['end_e'] }}" data-start="{{ $mon['start'] }}" data-end="{{ $mon['end'] }}"
                                                data-content="event-abs-circuit" data-event="event-1">
                                                <span class="cd-schedule__name">{{ $mon['title'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>
                            </li>

                            <li class="cd-schedule__group">

                                <ul>
                                    @foreach ($reservations['Tue'] as $tue)
                                        <li class="cd-schedule__event">
                                            <a href="/admin/reservations/reservation/{{ $tue['id'] }}" data-start_e="{{ $tue['start_e'] }}" data-end_e="{{ $tue['end_e'] }}" data-start="{{ $tue['start'] }}" data-end="{{ $tue['end'] }}"
                                                data-content="event-abs-circuit" data-event="event-1">
                                                <span class="cd-schedule__name">{{ $tue['title'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>

                            <li class="cd-schedule__group">

                                <ul>
                                    @foreach ($reservations['Wed'] as $wed)
                                        <li class="cd-schedule__event">
                                            <a href="/admin/reservations/reservation/{{ $wed['id'] }}" data-start_e="{{ $wed['start_e'] }}" data-end_e="{{ $wed['end_e'] }}" data-start="{{ $wed['start'] }}" data-end="{{ $wed['end'] }}"
                                                data-content="event-abs-circuit" data-event="event-1">
                                                <span class="cd-schedule__name">{{ $wed['title'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>

                            <li class="cd-schedule__group">

                                <ul>
                                    @foreach ($reservations['Thu'] as $thu)
                                        <li class="cd-schedule__event">
                                            <a href="/admin/reservations/reservation/{{ $thu['id'] }}" data-start_e="{{ $thu['start_e'] }}" data-end_e="{{ $thu['end_e'] }}" data-start="{{ $thu['start'] }}" data-end="{{ $thu['end'] }}"
                                                data-content="event-abs-circuit" data-event="event-1">
                                                <span class="cd-schedule__name">{{ $thu['title'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>

                            <li class="cd-schedule__group">

                                <ul>
                                    @foreach ($reservations['Fri'] as $fri)
                                        <li class="cd-schedule__event">
                                            <a href="/admin/reservations/reservation/{{ $fri['id'] }}" data-start_e="{{ $fri['start_e'] }}" data-end_e="{{ $fri['end_e'] }}" data-start="{{ $fri['start'] }}" data-end="{{ $fri['end'] }}"
                                                data-content="event-abs-circuit" data-event="event-1">
                                                <span class="cd-schedule__name">{{ $fri['title'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="cd-schedule__group">

                                <ul>
                                    @foreach ($reservations['Sat'] as $sat)
                                        <li class="cd-schedule__event">
                                            <a href="/admin/reservations/reservation/{{ $sat['id'] }}" data-start_e="{{ $sat['start_e'] }}" data-end_e="{{ $sat['end_e'] }}" data-start="{{ $sat['start'] }}" data-end="{{ $sat['end'] }}"
                                                data-content="event-abs-circuit" data-event="event-1">
                                                <span class="cd-schedule__name">{{ $sat['title'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                            </li>
                            <li class="cd-schedule__group">

                                <ul>
                                    @foreach ($reservations['Sun'] as $sun)
                                        <li class="cd-schedule__event">
                                            <a href="/admin/reservations/reservation/{{ $sun['id'] }}" data-start_e="{{ $sun['start_e'] }}" data-end_e="{{ $sun['end_e'] }}" data-start="{{ $sun['start'] }}" data-end="{{ $sun['end'] }}"
                                                data-content="event-abs-circuit" data-event="event-1">
                                                <span class="cd-schedule__name">{{ $sun['title'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </div>



                </div>
            </div>


            <div class="swiper mb-4 mySwiper d-block d-lg-none d-xl-none d-xxl-none">
                <div class="swiper-wrapper">
                    @foreach ($days as $day)
                        <div data-date="{{ $day['date_iso'] }}"
                            class="@if ($day['disabled']) {{ 'disabled' }} @endif @if ($day['scheduled']) {{ 'scheduled' }} @endif swiper-slide @if ($day['selected']) {{ 'selected' }} @endif">
                            <div class="weekday">{{ $day['day_name'] }}</div>
                            <div class="day">{{ $day['day'] }}</div>
                            <div class="month">
                                @if ($day['disabled'])
                                    {{ 'Closed' }}@else{{ $day['month'] }}
                                @endif
                            </div>
                            <div class="year" style="display:none">{{ $day['year'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <div class="letter d-block d-lg-none d-xl-none d-xxl-none">
            <div class="container py-1"><span id="date"></span></div>
        </div>
        <div id="reservations" class="d-block d-lg-none d-xl-none d-xxl-none"></div>

    </div>

    @include('admin.layout.footer')
    </div>
    <script>
        var time_format = {{$info->time_format}};
    </script>
    <script src="/js/admin/swiper8.min.js"></script>
    <script src="/js/admin/search_reservations.js"></script>
    <script src="/js/admin/js-calendar.js"></script>
@endsection
