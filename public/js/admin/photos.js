$(document).ready(function (e) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.file').on('change', function () {
        $(this).parent().parent().find('.photo-form').submit();
        $(this).val(null);
    });

    $('.photo-form .remove-photo').on('click', function (e) {
        e.preventDefault();
        const t = $(this);

        var request = $.ajax({
            type:'POST',
            url:'/admin/photos/delete',
            data: { 
              id: t.data('id'),
            },
            dataType : 'json'
          });
    
          request.done(function (data) {

             if(data.success)
             {
                t.parent().css({
                    'background-size': 'auto',
                    'background-image' : 'url(/images/admin/icons/photo.png)'
                });

                t.hide();

             }

          });
    
          request.fail(function (jqXHR, textStatus, errorThrown) {

            $.each(JSON.parse(jqXHR.responseText), function (key, value) {
              console.log(value);
            });
    
          });
    });

    $(".photo-form").on('submit',(function(e) {

        e.preventDefault();
        var t = $(this);

        $.ajax({
            url: "/admin/photos/photo-upload/"+t.find('.hidden_value').val(),
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
                        alert('Neveljavna datoteka!');
                    }
                    else {
                        t.find(".preview").css({
                            'background-image' : 'url(/images/website_photos/'+data+')',
                            'background-size' : 'cover'
                        });
                        t.find('.preview').find('.remove-photo').show();
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