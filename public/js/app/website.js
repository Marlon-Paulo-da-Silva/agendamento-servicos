$(document).ready(function (e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#file').on('change', function () {
        $('#photo-form').submit();
        $(this).val(null);
    });

    $("#photo-form").on('submit',(function(e) {

        e.preventDefault();
        var t = $(this);

        $.ajax({
            url: "/admin/website/photo-upload",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend : function() {
                t.find(".preview").css({
                        'background-image' : 'url(/images/admin/spinners/spinner.gif)',
                        'background-size' : 'auto'

                });
            },
            success: function(data)
            {   
                setTimeout(function () {
                    if(data=='invalid')
                    {
                        alert('Invalid File!');
                    }
                    else {
                        t.find(".preview").css({
                            'background-image' : 'url(/images/logos/'+data+')',
                            'background-size' : 'contain'
                        });
                    }
                },2000);

                },
            error: function(e) {
                console.log(e);
                $("#err").html(e).fadeIn();
            }          
        });
    }));
});