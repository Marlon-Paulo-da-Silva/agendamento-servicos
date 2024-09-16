
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Password Reset</title>
    <link rel="icon" href="/images/presentation/favicon.png">
  </head>
  <body>
<style>
    @import url('https://fonts.googleapis.com/icon?family=Material+Icons');
    @import "/css/bootstrap.min.css" screen;
    body {
        margin:0;
        padding:0;
        background:#eff3f8;
    }
    .container {
        display:flex;
        justify-content:center;
        align-items:center;
        height:100vh
    }
    .input {
        position:relative;
        margin-bottom:1.5rem
    }
    .input span {
        position:absolute;
        color:#8999af;
        top:12px;
        left:14px
    }
    .input input
    {
        padding:14px;
        font-size:0.9rem;
        padding-left:46px;
        color:#000;
    }
    .input input.has-error {
        border: 1px solid #463de1
    }
    .save-button {
        border-radius: 100px;
        border: 1px solid #463de1;
        padding: 10px 14px;
        background: linear-gradient(-47deg, #8731E8 0%, #463de1 100%);
        color: #FFF;
        text-decoration: none;
        font-weight: bold;
        font-size: 0.9rem;
    }
    .link {
        font-size:0.9rem
    }
    .link a {
        color:#463de1;
        line-height:43px;
        text-decoration:none
    }
</style>
<div class="container">

                    


                 
                    <form class="form-horizontal" method="POST" action="/password/reset">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">


                        <div class="input">
                    <span class="material-icons">person</span>
                                <input id="email" type="email" placeholder="Email" class="form-control{{ $errors->has('email') ? ' has-error' : '' }}" name="email" value="{{ $email or old('email') }}" required autofocus>
                                </div>
                                
                            
              



                                <div class="input">
                        <span class="material-icons">lock</span>
                                <input id="password" type="password" placeholder="New Password" class="form-control{{ $errors->has('password') ? ' has-error' : '' }}" name="password" required>
</div>
               
                            
                  

<div class="input">
                        <span class="material-icons">lock</span>
                            
                                <input id="password-confirm" placeholder="Repeat Password" type="password" class="form-control{{ $errors->has('password_confirmation') ? ' has-error' : '' }}" name="password_confirmation" required>

</div>
                            
                      
<div class="row">
                            <div class="col-12">
                                <button type="submit" class="save-button">
                                    Reset Password
                                </button>

                        </div>
                            
                        </div>
                   
                        

                    </form>
                    </div>
</body>
</html>