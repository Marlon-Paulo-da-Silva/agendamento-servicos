@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

<div class="container">
@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif
    <h1>Website</h1>
    <h2>Write your hello message and set social networks.</h2>
    <div class="row">
        <div class="col-12">
            <label>Logo</label>
            <form id="photo-form" action="*" method="post" enctype="multipart/form-data">
                <div class="form-control mb-1 text-center preview" style="@if($data->logo)background-size:contain; background-image:url(/images/logos/{{$data->logo}});@endif"></div>
                <label class="add-button mb-4" for="file">
                    <span class="material-icons">file_upload</span> Upload
                </label>
                <input id="file" type="file" accept="image/*" name="photo"></a>
            </form>
        </div>
    </div>
    <form method="post" id="website" action="/admin/website/update">
    {{ csrf_field() }}
    <div class="row">
        <div class="col-12">
            <label>Hello Title</label>
            <div class="input-plain">
                <input class="form-control" name="title" value="{{$data->title}}" placeholder="Welcome!">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Hello Message</label>
            <div class="input-plain">
                <textarea class="form-control" name="address" placeholder="Welcome on our hair salon website!">{{$data->address}}</textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Color Scheme</label>
            <div class="row">
                <div class="col-12">
                    <div class="input">
                        <select class="form-control" id="color" name="color">
                            <option value="1"@if($data->color==1) selected="selected"@endif>Pink</option>
                            <option value="2"@if($data->color==2) selected="selected"@endif>Black</option>
                            <option value="3"@if($data->color==3) selected="selected"@endif>Green</option>
                            <option value="4"@if($data->color==4) selected="selected"@endif>Purple (Default)</option>
                            <option value="5"@if($data->color==5) selected="selected"@endif>Blue</option>
                            <option value="6"@if($data->color==6) selected="selected"@endif>Turquoise</option>
                            <option value="7"@if($data->color==7) selected="selected"@endif>Yellow</option>
                            <option value="8"@if($data->color==8) selected="selected"@endif>Brown</option>
                            <option value="9"@if($data->color==9) selected="selected"@endif>Orange</option>
                            <option value="10"@if($data->color==10) selected="selected"@endif>Red</option>
                        </select>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Facebook address</label>
            <div class="input-plain">
                <input class="form-control" name="facebook" value="{{$data->facebook}}" placeholder="https://facebook.com/salon">
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Twitter address</label>
            <div class="input-plain">
                <input class="form-control" name="twitter" value="{{$data->twitter}}" placeholder="https://twitter.com/salon">
                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label>Instagram address</label>
            <div class="input-plain">
                <input class="form-control" name="instagram" value="{{$data->instagram}}" placeholder="https://instagram.com/salon">
                
            </div>
        </div>
    </div>
    <hr>
    <div class="text-end">
        <a href="#" class="save-button" onclick="document.getElementById('website').submit(); return false;">Save</a>
    </div>
    </form>
    @include('admin.layout.footer')
</div>

<script src="/js/admin/website.js"></script>

@endsection