<div id="mobile-menu">
        <div id="burgerBtn" class="d-block d-lg-none d-xl-none d-xxl-none"></div>

        <div class="navi">


            <div class="title">Menu</div>
            <ul>
            <li>
                    <a href="/" title="Home">
                        <span class="material-icons">home</span> Inicial
                    </a>
                </li>
                <li>
                    <a href="/team" title="Team">
                        <span class="material-icons">person</span> Equipe
                    </a>
                </li>
                <li>
                    <a href="/working-hours" title="Working Hours">
                        <span class="material-icons">timelapse</span> Horário de Funcionamento
                    </a>
                </li>
                <li>
                    <a href="/reviews" title="Reviews">
                        <span class="material-icons">forum</span> Depoimentos
                    </a>
                </li>
                <li>
                    <a href="/services" title="Services">
                        <span class="material-icons">work_outline</span> Serviços
                    </a>
                </li>
                <li>
                    <a href="/booking" title="Book an appointment">
                        <span class="material-icons">schedule</span> Agendar
                    </a>
                </li>
                <li>
                    <a href="/contact" title="Contact">
                        <span class="material-icons">alternate_email</span> Contato
                    </a>
                </li>
            </ul>


        </div>

      </div>


<div class="header text-center">
    <div class="container">
          <ul class="d-none d-lg-block d-xl-block d-xxl-block">
            <li>
                <a href="/" title="Home">Inicial</a>
            </li>
            <li>
                <a href="/team" title="Team">Equipe</a>
            </li>
            <li>
                <a href="/services" title="Services">Serviços</a>
            </li>
            <li>
                <a href="/working-hours" title="Working Hours">Horário de Funcionamento</a>
            </li>
            <li>
                <a href="/reviews" title="Reviews">Depoimentos</a>
            </li>
            <li>
                <a href="/contact" title="Contact">Contato</a>
            </li>
            <li>
                <a href="/booking" title="Book an appointment" class="reserve">Agendar</a>
            </li>
            @if($website->facebook)
            <li>
                <a href="{{$website->facebook}}" target="_blank" class="fb"><img height="16" width="16" src="/images/app/templates/default/app/facebook.svg"></a>
            </li>
            @endif
            @if($website->twitter)
            <li>
                <a href="{{$website->twitter}}" target="_blank" class="tw"><img height="16" width="16" src="/images/app/templates/default/app/twitter.svg"></a>
            </li>
            @endif
            @if($website->instagram)
            <li>
                <a href="{{$website->instagram}}" target="_blank" class="ins"><img height="16" width="16" src="/images/app/templates/default/app/instagram.svg"></a>
            </li>
            @endif
          </ul>
          <ul class="d-block d-lg-none d-xl-none d-xxl-none">
            <li>
                <a href="/booking" title="Book an appointment" class="reserve">Agendar</a>
            </li>
          </ul>
    </div>
</div>
