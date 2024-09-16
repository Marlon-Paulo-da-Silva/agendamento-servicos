@extends('presentation.layout.index')
@section('content')
<!-- Contact Box -->
<div class="contact-box bg-white text-center rounded p-4 p-sm-5 my-5 shadow-lg">
                            <!-- Contact Form -->
                            <form id="register" method="POST" action="/register">
                                <div class="contact-top">
                                    <h3 class="contact-title">Preizkusite brezplačno</h3>
                                    <h5 class="text-secondary fw-3 py-3">Izpolnite svoje podatke za vstop v sistem.</h5>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope-open"></i></span>
                                              </div>
                                              <input id="email" type="email" autocomplete="off" placeholder="E-mail" class="form-control{{ $errors->has('email') ? ' has-error' : '' }}" name="email" value="{{ old('email') }}" required>
                                            </div>
                                            @if ($errors->has('email'))
                                            <div class="my-2">
                                                    {{ $errors->first('email') }}
                                            </div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
                                              </div>
                                              <input id="password" type="password" autocomplete="off" class="form-control{{ $errors->has('password') ? ' has-error' : '' }}" placeholder="Geslo (najmanj 6 znakov)" name="password" required>
                                            </div>
                                            @if ($errors->has('password'))
                                                <div class="my-2">
                                                    {{ $errors->first('password') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                              <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file-signature"></i></span>
                                              </div>
                                              <input id="name" class="form-control" type="text" autocomplete="off" placeholder="Ime salona (Nujno za spletni naslov)" value="{{ old('name') }}" name="name" required>
                                              <input type="hidden" id="hidden-url" name="url">
                                            </div>
                                            @if ($errors->has('url'))
                                                <div class="my-2">
                                                    {{ $errors->first('url') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div id="url" style="font-size:0.9rem">&nbsp;</div>
                                    </div>
                                    <div class="col-12">
                                    <script src="https://www.google.com/recaptcha/api.js"></script>
                                    <script>
                                    function onSubmit(token) {
                                        document.getElementById("register").submit();
                                    }
                                    </script>
                                    {{ csrf_field() }}
                                        <button class="btn btn-bordered w-100 mt-3 g-recaptcha"
        data-sitekey="{{ env('CAPTCHA_SITE_KEY') }}" 
        data-callback='onSubmit' 
        data-action='submit' type="submit">Registriraj se</button>
                                    </div>
                                    
                                </div>
                            </form>
                            <p class="form-message"></p>
                        </div>
@endsection