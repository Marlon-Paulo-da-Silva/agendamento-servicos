@extends('admin.layout.index')

@section('content')
<div class="pt-5 gray-page">

<div class="container">

    <h1>My Website</h1>
    <h2>Preview of your website</h2>
    
    <div class="text-center">
        {{$qr_code}}
        <br>
        <a href="{{$domain}}" class="save-button my-5" target="_blank">Preview</a>
        <br>
        <div class="input-customer">
            <input type="text" id="clipboard" class="form-control" value="{{$domain}}">
            <span class="material-icons left">public</span>
            <a href="javascript:void(0)" onclick="copyToClipBoard()" title="Kopiraj"><span class="material-icons right">content_copy</span></a>
        </div>
    </div>
    <script>
        function copyToClipBoard() {
            /* Get the text field */
            var copyText = document.getElementById("clipboard");

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */

            /* Copy the text inside the text field */
            navigator.clipboard.writeText(copyText.value);
            
            /* Alert the copied text */
            alert("Copied!");
        }
    </script>
    @include('admin.layout.footer')
</div>
@endsection