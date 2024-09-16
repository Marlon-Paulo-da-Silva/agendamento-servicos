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

    <h1>SMS Campaign</h1>  
    <h2>Enable or edit campaign.</h2>
    @if(!$campaigns->count())
    You have no campaigns
    @endif
    <hr>

    @foreach($campaigns as $campaign)
    <div class="row sms-campaign mb-3">
        <div class="col-7">
            <div class="name">{{$campaign->title}} ({{$campaign->sent}}/{{$campaign->all}})</div>
        </div>
        <div class="col-3 text-end settings">
            <label class="switch">
                <input type="checkbox" class="sending" value="1" @if($campaign->enabled){{'checked'}}@endif>
                <span class="slider round"></span>
                <input type="hidden" class="id" value="{{$campaign->id}}">
            </label>
        </div>
        <div class="col-2 text-end">
            <a href="/admin/marketing/edit/{{$campaign->id}}" class="option-delete"><span class="material-icons">chevron_right</span></a>
        </div>
    </div>
    <hr>
    @endforeach
    <div class="text-end">
                <a href="/admin/marketing" class="cancel-button">Back to marketing</a>
    </div>

    @include('admin.layout.footer')
</div>
<script>
    $(function() {

        $('.sending').on('change', function (e) {

            e.preventDefault();
            let checked = $(this).is(":checked") ? 1 : 0;
            let id = $(this).parent().find('.id').val();
            
            var request = $.ajax({
                type:'POST',
                url:'/admin/marketing/enable/' + id,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: { 
                    status: checked
                },
                dataType : 'json'
            });

            request.done(function (data) {
            });

        });
  
    });
    </script>
@endsection