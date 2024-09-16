@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

<div class="container">
<h1>Ali želite napolniti SMS kredite?</h1>
            <h2>SMS krediti za {{$user->name}} {{$user->surname}} </h2>
            
            <hr>
            <form method="post" action="/admin/sms-renewals/renew/update" id="renew">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$id}}">
                    <select name="credits" class="form-control mb-5">
                        <option value="250">250 kreditov</option>
                        <option value="500">500 kreditov</option>
                        <option value="1000">1000 kreditov</option>
                        <option value="5000">5000 kreditov</option>
                    </select>
                </form>
            <hr>
            
            <div class="text-end">
                <a href="/admin/sms-renewals" class="cancel-button">Prekliči</a>
                <a href="#" class="save-button" onclick="document.getElementById('renew').submit(); return false;">Napolni</a>
                
            </div>

    @include('admin.layout.footer')
</div>
@endsection