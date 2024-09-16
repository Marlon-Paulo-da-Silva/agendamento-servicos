@extends('admin.layout.index')

@section('content')
<div class="gray-page">

        


        <div class="container">
            <div class="row mb-5">
                <div class="col-xl-12 col-lg-12">

                    <div class="stat sms-show p-4">
                        <div id="info" class="active">
                            Sending SMS
                            <div class="text-center">
                                <h1 id="credits" class="my-3" data-count="{{ $sending_sms->ct }}">0</h1>
                                @if($alert)<div style="font-size:0.8rem">(Paused)<br> API Error!</div>@endif
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <div class="small">SMS sent</div>
                                    <div class="big">{{$sms_sent_count->ct}} <span>SMS</span></div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-8">
                                    <div class="small">Campaigns</div>
                                    <div class="big">{{$campaigns_count->ct}}</div>
                                </div>
                                <div class="col-4 text-end"><a href="/admin/marketing/list" class="action"><span class="material-icons">edit</span></a></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-8">
                                    <div class="small">New Campaign</div>
                                    <div class="big">Create</div>
                                </div>
                                <div class="col-4 text-end"><a href="/admin/marketing/new" class="action"><span class="material-icons">add</span></a></div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            
            @include('admin.layout.footer')

        </div>   
    <script>
    $(function() {


        const credits = parseInt($('#credits').data('count'));
        let count = 0;
        let speed;

        if(credits <= 50)
            speed = 1;
        else if(credits > 50 && credits <= 500)
            speed = 5;
        else if(credits > 500 && credits <= 1000)
            speed = 25;
        else
            speed = 50;

        setTimeout(() => {
            let int = setInterval(() => {
                count = count + speed;
                $('#credits').text(count);

                if(count + speed >= credits)
                {
                    clearInterval(int);
                    $('#credits').text(credits);
                }
            }, 10);            
        }, 500);

        
    });
    </script>
    @endsection