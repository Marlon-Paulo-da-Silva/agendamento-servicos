@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

<div class="container">
    <h1>Fotos</h1>
    <h2>Carregue até 10 fotos que serão exibidas no portfólio do site.</h2>
    @php for($i=1; $i<=10; $i++) { @endphp
    <div class="row">
        <div class="col-12">
            <label>Foto {{$i}}</label>
            <form class="photo-form" action="*" method="post" enctype="multipart/form-data">
                <div class="form-control mb-1 text-center preview" style="@php $r = 'photo_'.$i; @endphp @if($data->$r)background-size:cover; background-image:url(/images/website_photos/{{$data->$r}})@endif">

                    <a href="#" @if($data->$r) style="display:block" @endif class="remove-photo" data-id="{{$i}}">
                        <span class="material-icons">close</span>
                    </a>

                </div>
                <label class="add-button mb-4" for="file_{{$i}}">
                    <span class="material-icons">file_upload</span> Carregar
                </label>
                <input id="file_{{$i}}" class="file" type="file" accept="image/*" name="photo"></a>
                <input type="hidden" class="hidden_value" name="id" value="{{$i}}">
            </form>
        </div>
    </div>
    @php
    }
    @endphp
    <hr>

    @include('admin.layout.footer')
</div>

<script src="/js/admin/photos.js"></script>

@endsection
