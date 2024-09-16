@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

<div class="container">
@if ($errors->any())
    <div class="alert alert-success">
        @foreach ($errors->all() as $error)
        {{ $error }}<br>
        @endforeach
    </div>
@endif
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
<h1>Change Password</h1>
            <h2>Set up strong password with at least 6 characters.</h2>
            <form method="post" id="new-user" action="/admin/profile/update-password">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-12">
                    <label>Current Password</label>
                    <div class="input-customer">
                        <input type="password" id="old-password" class="form-control" name="profile_old_password" placeholder="">
                        <span class="material-icons left">lock</span>
                        <a href="#" id="show-old-password"><span class="material-icons right">visibility_off</span></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>New Password</label>
                    <div class="input-customer">
                        <input type="password" id="password" class="form-control" name="profile_new_password" placeholder="At least 6 characters">
                        <span class="material-icons left">lock</span>
                        <a href="#" id="show-password"><span class="material-icons right">visibility_off</span></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>Repeat New Password</label>
                    <div class="input-customer">
                        <input type="password" id="repeat-password" class="form-control" name="profile_new_password_confirmation" placeholder="Repeat Password">
                        <span class="material-icons left">lock</span>
                        <a href="#" id="show-repeat-password"><span class="material-icons right">visibility_off</span></a>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-end">
                <a href="/admin/profile" class="cancel-button">Back to profile</a>
                <a href="#" class="save-button" onclick="document.getElementById('new-user').submit(); return false;">Save</a>
            </div>
            </form>
            <script type="text/javascript">
                $(document).ready(function() {

                    $('#show-old-password').on('click', function (e) {
                        e.preventDefault();
                        if($('#old-password').hasClass('visible')) {
                            $('#old-password').prop('type', 'password');
                            $(this).find('.material-icons').text('visibility_off');
                        } else {
                            $('#old-password').prop('type', 'text');
                            $(this).find('.material-icons').text('visibility');
                        }

                        $('#old-password').toggleClass('visible');
                    });

                    $('#show-password').on('click', function (e) {
                        e.preventDefault();
                        if($('#password').hasClass('visible')) {
                            $('#password').prop('type', 'password');
                            $(this).find('.material-icons').text('visibility_off');
                        } else {
                            $('#password').prop('type', 'text');
                            $(this).find('.material-icons').text('visibility');
                        }

                        $('#password').toggleClass('visible');
                    });

                    $('#show-repeat-password').on('click', function (e) {
                        e.preventDefault();
                        if($('#repeat-password').hasClass('visible')) {
                            $('#repeat-password').prop('type', 'password');
                            $(this).find('.material-icons').text('visibility_off');
                        } else {
                            $('#repeat-password').prop('type', 'text');
                            $(this).find('.material-icons').text('visibility');
                        }

                        $('#repeat-password').toggleClass('visible');
                    });

                });

            </script>

    @include('admin.layout.footer')
</div>
@endsection