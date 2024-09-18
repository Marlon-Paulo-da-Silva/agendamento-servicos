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
            url: "/admin/profile/photo-upload",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend : function() {
                t.find(".profile-image").css({
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
                        t.find(".profile-image").css({
                            'background-image' : 'url(/images/profile_images/'+data+')',
                            'background-size' : 'cover'
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