<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Lure - Administration</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <script src="/js/admin/bootstrap.bundle.min.js"></script>
    <link href="/css/admin/custom.css" rel="stylesheet">
    <script src="/js/admin/jquery.min.js"></script>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/icon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">

    {{-- <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script> --}}


  </head>
  <body>

  <form id="logout-form" action="/logout" method="POST" style="display: none;">{{ csrf_field() }}</form>
  <div id="mobile-menu">
        <div class="navi">
            <div class="navi-header pt-3 px-3">
                <div class="row">
                  <div class="col-12 text-end">
                  <a href="#" class="d-inline" id="closeBtn">
                    <span class="material-icons">close</span>
</a>
                  </div>
                </div>
            </div>

            <div class="text-center profile p-3 mb-4">
                <a href="/admin/profile" class="profile-image" style="background-image:url(@if(Auth::user()->profile_image)/images/profile_images/{{Auth::user()->profile_image}}@else/images/admin/icons/user.png @endif)"></a>

            <div class="mt-3 name">{{Auth::user()->name}} {{Auth::user()->surname}}</div>
            <div class="email">{{Auth::user()->email}}</div>
            </div>

            <div class="title">Painel</div>
            <div class="subtitle mb-2">Reservas, Clientes</div>
            <!-- li class="selected" za izbran menu -->
            <ul>
            <li>
                    <a href="/admin/painel">
                        <span class="material-icons">home</span> Painel inicial
                    </a>
                </li>
                <li>
                    <a href="/admin/reservations">
                        <span class="material-icons">schedule</span> Reservas
                    </a>
                </li>
                @if(Auth::user()->privilege == 1)
                <li>
                    <a href="/admin/services">
                        <span class="material-icons">work_outline</span> Serviços
                    </a>
                </li>
                <li>
                    <a href="/admin/services-categories">
                        <span class="material-icons">category</span> Categorias
                    </a>
                </li>
                <li>
                    <a href="/admin/schedule">
                        <span class="material-icons">timelapse</span> Disponibilidades
                    </a>
                </li>
                @endif
                <li>
                    <a href="/admin/my-services">
                        <span class="material-icons">work_outline</span> Meus Serviços
                    </a>
                </li>
                <li>
                    <a href="/admin/customers">
                        <span class="material-icons">person</span> Clientes
                    </a>
                </li>
                @if(Auth::user()->privilege == 1)
                <li>
                    <a href="/admin/team">
                        <span class="material-icons">groups</span> Equipe
                    </a>
                </li>
                <li>
                    <a href="/admin/work-hours">
                        <span class="material-icons">timelapse</span> Horário de funcionamento
                    </a>
                </li>
                <li>
                    <a href="/admin/photos">
                        <span class="material-icons">photo_camera</span> Fotos
                    </a>
                </li>
                <li>
                    <a href="/admin/sms">
                        <span class="material-icons">settings_cell</span> Mensagens Sms
                    </a>
                </li>
                <li>
                    <a href="/admin/marketing">
                        <span class="material-icons">campaign</span> Marketing
                    </a>
                </li>
                <li>
                    <a href="/admin/reviews">
                        <span class="material-icons">forum</span> Avaliações
                    </a>
                </li>
                <li>
                    <a href="/admin/insights">
                        <span class="material-icons">insights</span> Insights
                    </a>
                </li>
                <li>
                    <a href="/admin/my-website">
                        <span class="material-icons">remove_red_eye</span> Meu Site
                    </a>
                </li>
                @endif
            </ul>


            <div class="title">Configurações</div>
            <div class="subtitle mb-2">Perfil, Configurações</div>
            <ul>
                <li>
                    <a href="/admin/profile">
                        <span class="material-icons">account_circle</span> Perfil
                    </a>
                </li>
                @if(Auth::user()->privilege == 1)
                <li>
                    <a href="/admin/settings">
                        <span class="material-icons">settings</span> Configurações
                    </a>
                </li>
                <li>
                    <a href="/admin/website">
                        <span class="material-icons">http</span> Site
                    </a>
                </li>
                @endif
            </ul>


        </div>

      </div>


        <div class="header">
            <div class="row">
                <div class="col-6">
                        <div id="burgerBtn"></div>
                </div>
                <div class="col-6 text-end">
                <ul>
                    <li>
                        <a href="/admin/customers">
                            <span class="material-icons">people_alt</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <span class="material-icons">logout</span>
                        </a>
                    </li>
                </ul>
                </div>
                </div>

            </div>

            @yield('content')


      </div>


<script src="/js/admin/swiped-events.js"></script>
<script src="/js/admin/admin.js"></script>
</body>
</html>
