@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

        <div class="container">

        @if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
            <h1>Settings</h1>
            <h2>Change the title of your company, address and more.</h2>

            <form method="post" id="settings" action="/admin/settings/update">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-12">
                    <label>Company</label>
                    <div class="input">
                        <input class="form-control" name="company" value="{{$data->company}}" placeholder="My Saloon">
                        <span class="material-icons">storefront</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>Address</label>
                    <div class="input">
                        <input class="form-control" name="address" value="{{$data->address}}" placeholder="Carnaby Street 532">
                        <span class="material-icons">home</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>City</label>
                    <div class="input">
                        <input class="form-control" name="city" value="{{$data->city}}" placeholder="London">
                        <span class="material-icons">business</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>ZIP</label>
                    <div class="input">
                        <input class="form-control" name="zip" value="{{$data->zip}}" placeholder="1000">
                        <span class="material-icons">mail</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>VAT Number</label>
                    <div class="input">
                        <input class="form-control" name="taxid" value="{{$data->taxid}}" placeholder="SI111222333">
                        <span class="material-icons">euro_symbol</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>IBAN</label>
                    <div class="input">
                        <input class="form-control" name="trr" value="{{$data->trr}}" placeholder="SI56 0000 0000 0000 000">
                        <span class="material-icons">account_balance</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>Phone</label>
                    <div class="input">
                        <input class="form-control" name="site_phone" value="{{$data->site_phone}}" placeholder="+38640333111">
                        <span class="material-icons">call</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>E-mail For Display On Website</label>
                    <div class="input">
                        <input class="form-control" name="site_email" value="{{$data->site_email}}" placeholder="info@codeland.fun">
                        <span class="material-icons">alternate_email</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>Possibility To Book in Advance</label>
                    <div class="input">
                                <select class="form-control" name="booking">
                                    <option value="1"@if($data->booking==1) selected="selected"@endif>1 week</option>
                                    <option value="2"@if($data->booking==2) selected="selected"@endif>2 weeks</option>
                                    <option value="3"@if($data->booking==3) selected="selected"@endif>3 weeks</option>
                                    <option value="4"@if($data->booking==4) selected="selected"@endif>1 month (Default)</option>
                                    <option value="5"@if($data->booking==5) selected="selected"@endif>2 months</option>
                                    <option value="6"@if($data->booking==6) selected="selected"@endif>3 months</option>
                                    <option value="7"@if($data->booking==7) selected="selected"@endif>6 months</option>
                                </select>
                            </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>Show Only Next Available Term</label>
                    <div class="input">
                                <select class="form-control" name="slot_mode">
                                    <option value="1"@if($data->slot_mode==1) selected="selected"@endif>No (All terms - Default)</option>
                                    <option value="2"@if($data->slot_mode==2) selected="selected"@endif>Yes (Only next one available)</option>
                                </select>
                            </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>Show As</label>
                    <div class="input">
                                <select class="form-control" name="view">
                                    <option value="1"@if($data->view==1) selected="selected"@endif>Application Only (Default)</option>
                                    <option value="2"@if($data->view==2) selected="selected"@endif>Website</option>
                                </select>
                            </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>Currency Sign</label>
                    <div class="input">
                        <input class="form-control" name="currency_sign" value="{{$data->currency_sign}}" placeholder="$">
                        <span class="material-icons">attach_money</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>Currency Format</label>
                    <div class="input">
                                <select class="form-control" name="currency_format">
                                    <option value="1"@if($data->currency_format==1) selected="selected"@endif>99,00</option>
                                    <option value="2"@if($data->currency_format==2) selected="selected"@endif>99.00</option>
                                </select>
                            </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>Time Format</label>
                    <div class="input">
                                <select class="form-control" name="time_format">
                                    <option value="1"@if($data->time_format==1) selected="selected"@endif>AM/PM</option>
                                    <option value="2"@if($data->time_format==2) selected="selected"@endif>24H</option>
                                </select>
                            </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label>Preferred Phone Number Country</label>
                    <div class="input">
                                <select class="form-control" name="area_code">
                                    @foreach($area_codes as $area_code)
                                    <option value="{{$area_code->id}}"@if($data->area_code==$area_code->id) selected="selected"@endif>{{$area_code->country}} (+{{$area_code->code}})</option>
                                    @endforeach
                                </select>
                            </div>
                </div>
            </div>
            <hr>
            <div class="text-end">
                <a href="#" class="save-button" onclick="document.getElementById('settings').submit(); return false;">Save</a>
            </div>
            </form>

        @include('admin.layout.footer')
    </div>
@endsection