@extends('admin.layout.index')

@section('content')
<div class="gray-page">

        <div class="container">
            <h1>Sms Settings</h1>
            <h2>Enable messaging, Twilio API</h2>
            <form method="post" id="settings" action="/admin/sms/settings/update">
                {{ csrf_field() }}
            <div class="row mb-5">
                <div class="col-xl-12 col-lg-12">
                    <div class="settings">
                        <div class="row mb-3">
                            <div class="col-7"><span>Enable SMS Messaging</span></div>
                            <div class="col-5 text-end">
                                <label class="switch">
                                    <input type="checkbox" id="sending" value="1" @if($settings->enabled){{'checked'}}@endif>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <hr>
                        <h2>Twilio API Credentials</h2>
                        <div class="row align-items-center mb-3">
                            <div class="col-7"><div class="input-plain"><span>Account SID</span></div></div>
                            <div class="col-5 text-end">
                                <div class="input-plain"><input type="text" name="account_sid" class="form-control" placeholder="ACXXXXXXXXXXXXXX" value="{{$settings->account_sid}}"></div>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-7"><div class="input-plain"><span>Auth Token</span></div></div>
                            <div class="col-5 text-end">
                                <div class="input-plain"><input type="text" name="auth_token" class="form-control" value="{{$settings->auth_token}}" placeholder="ddb4b161d5763ef0c27c77a42216d0i4"></div>
                            </div>
                        </div>
                        <div class="row align-items-center mb-3">
                            <div class="col-7"><div class="input-plain"><span>From Number</span></div></div>
                            <div class="col-5 text-end">
                                <div class="input-plain"><input type="text" name="number" class="form-control" value="{{$settings->number}}" placeholder="+38640111333"></div>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-7"><span>Notify customers before appointment</span></div>
                            <div class="col-5 text-end">
                                <select class="form-control modified-select" id="notify">
                                    <option value="1" @if($settings->notify == 15){{'selected="selected"'}}@endif>15 mins</option>
                                    <option value="2" @if($settings->notify == 30){{'selected="selected"'}}@endif>30 mins</option>
                                    <option value="3" @if($settings->notify == 45){{'selected="selected"'}}@endif>45 mins</option>
                                    <option value="4" @if($settings->notify == 60 OR !$settings->notify){{'selected="selected"'}}@endif>1 hour</option>
                                    <option value="5" @if($settings->notify == 120){{'selected="selected"'}}@endif>2 hours</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="row align-items-center mb-3">
                            <div class="col-7"><div class="input-plain"><span>CRON Job Entry</span></div></div>
                            <div class="col-5 text-end">
                                <div class="input-plain"><input type="text" class="form-control" value="curl -k {{$domain}}/sms/send" disabled></div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-end">
                        <a href="/admin/sms" class="cancel-button">Back</a>
                        <a href="#" class="save-button" onclick="document.getElementById('settings').submit(); return false;">Save</a>
                    </div>
                </div>

            </div>
            </form>

            @include('admin.layout.footer')

        </div>   
    <script>
    $(function() {

        $('#sending').on('change', function (e) {

            e.preventDefault();
            let checked = $(this).is(":checked") ? 1 : 0;
            
            var request = $.ajax({
                type:'POST',
                url:'/admin/sms/settings/enable',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: { 
                    status: checked
                },
                dataType : 'json'
            });

            request.done(function (data) {
                
            });

        });

        $('#notify').on('change', function (e) {

            e.preventDefault();
            
            var request = $.ajax({
                type:'POST',
                url:'/admin/sms/settings/notify',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: { 
                    notify: $('#notify').val()
                },
                dataType : 'json'
            });

            request.done(function (data) {
                
            });

        });

  
    });
    </script>
    @endsection