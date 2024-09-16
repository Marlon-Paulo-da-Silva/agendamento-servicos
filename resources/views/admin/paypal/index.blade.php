@extends('admin.layout.index')

@section('content')

<div class="pt-5 gray-page">

<div class="container">


@if ($message = Session::get('success'))
<h1>PayPal plačilo uspelo</h1>
<h2>Licenca je podaljšana do {{$message}}. Informacije o licenci si lahko ogledate v razdelku plačila.</h2>
<a href="/admin" class="save-button">Nadaljujte na prvo stran</a>
<?php Session::forget('success');?>
@elseif($message = Session::get('error'))
<h1>Plačilo spodletelo</h1>
<h2>Prosimo poskusite ponovno.</h2>
<a href="/admin/paywithpaypal" class="save-button">Poskusite ponovno</a>
<?php Session::forget('error');?>
@else

<h1>PayPal plačilo</h1>
<h2>Plačajte licenco preko PayPal-a</h2>
<div class="row">
  <div class="col-xxl-4 col-xl-4 col-lg-3"></div>
  <div class="col-xxl-4 col-xl-4 col-lg-6">
<div class="pricing p-4">
                <h3>Plačilo letne naročnine</h3>
                <h2 class="mb-2">Po opravljenem plačilu boste račun za storitev prejeli po e-pošti.</h2>
            </div>
            <div class="price px-4 py-5 mb-5">
                <div class="big-number">&euro;<?php echo number_format(env('APP_PRICE'), 2, ',', '.'); ?> <span>EUR</span></div>
                <h2>Samo <?php echo number_format(env('APP_PRICE')/12, 2, ',', '.'); ?> EUR na mesec.</h2>
                <form id="paypal" method="POST" action="/admin/paypal">
                  {{ csrf_field() }}
                  <input type="hidden" name="amount" value="<?php echo env('APP_PRICE'); ?>">    
                </form>
                <a href="#" class="save-button" onclick="document.getElementById('paypal').submit(); return false;">Plačajte preko Paypal</a>
            </div>
            <div class="text-center"><a href="/admin/select-payment" class="cancel-button">Nazaj na izbiro plačila</a></div>
      </div>
      <div class="col-xxl-4 col-xl-4 col-lg-3"></div>
</div>        
@endif

</div>
</div>
                </div>
@endsection
