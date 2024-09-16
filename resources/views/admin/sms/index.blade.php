@extends('admin.layout.index')

@section('content')
<div class="gray-page">

        


        <div class="container">
            <div class="row mb-5">
                <div class="col-xl-12 col-lg-12">

                    <div class="stat sms-show p-4">
                        <div id="info" class="active">
                            Balance
                            <div class="text-center">
                                <h1 id="credits">{{\App\Helpers\Helpers::FormatPrice($info->currency_format, $response->balance)}}</h1>
                                <span>{{$response->currency}}</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
            

            <div class="row customer">
                <div class="col-10">
                    <div class="name">Settings</div>
                    <div class="email">Enable messaging, API</div>
                </div>
                <div class="col-2 text-end">
                <a href="/admin/sms/settings" class="delete"><span class="material-icons">chevron_right</span></a>
                </div>
            </div>
            <hr>
            @include('admin.layout.footer')

        </div>   

    @endsection