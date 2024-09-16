@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

<div class="container">
    <div class="text-center">
        <h1>Licenca</h1>
        <h2>Začnite brezplačno za 7 dni, nato nadgradite.</h2>
    </div>
    <div class="row">
  <div class="col-xxl-4 col-xl-4 col-lg-3"></div>
  <div class="col-xxl-4 col-xl-4 col-lg-6">
    <div class="pricing p-4">
        <h3>Letna naročnina</h3>
        <h2>Nadgradite svojo spletno stran s našim rezervacijskim sistemom in omogočite vašim strankam naročanje na vaše storitve.</h2>
        <div class="features">
            <div class="text">Vsebuje možnosti</div>
            <div class="line"></div>
        </div>
        <ul class="features-items">
            <li><span class="material-icons">check_circle</span> Neomejeno možnosti v sistemu</li>
            <li><span class="material-icons">check_circle</span> SEO optimizacija</li>
            <li><span class="material-icons">check_circle</span> Podpora preko različnih virov</li>
            <li><span class="material-icons">check_circle</span> Dnevne varnostne kopije</li>
        </ul>
    </div>
    <div class="price px-4 py-5 mb-5">
        <div class="big-number">&euro;<?php echo number_format(env('APP_PRICE'), 2, ',', '.'); ?> <span>EUR</span></div>
        <h2>Samo <?php echo number_format(env('APP_PRICE')/12, 2, ',', '.'); ?> EUR na mesec.</h2>
        <a href="/admin/select-payment" class="save-button">Nadgradite zdaj</a>
    </div>
    <div class="faq">
    <h1>Pogosto zastavljena vprašanja</h1>
    <h2>Kako lahko podaljšam svojo licenco?</h2>
    <div>
        Licenco lahko trenutno sklenete ali podaljšate preko PayPal-a ali preko standardnega UPN plačilnega naloga.
    </div>
    <h2>Koliko časa traja podaljšanje licence pri plačilu preko UPN naloga</h2>
    <div>
        Običajno licenco podaljšamo takoj, ko prejmemo plačilo na naš transakcijski račun, lahko pa se zgodi, da zaradi
        bančnih zamud ali dni ko se ne izvajajo bančne transakcije licenco podaljšamo kasneje. Priporočamo podaljšanje preko
        PayPal-a, ki podpira skoraj vse kreditne kartice in preko katerega je licenca podaljšana takoj po plačilu.
    </div>
    <h2>Ali lahko v primeru nezadovoljstva dobim povrnjeno kupnino?</h2>
    <div>
        V primeru da vam naš produkt ne ustreza, vam kupnino povrnemo, če produkta niste uporabljali več kot 30 dni od dneva nakupa
        licence.
    </div>
    </div>
</div>
<div class="col-xxl-4 col-xl-4 col-lg-3"></div>
</div>
    @include('admin.layout.footer')
</div>
@endsection