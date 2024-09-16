$(function() {

    $('#name').on('input', function () {
        $.getJSON( "/admin/sms-renewals/ajax", { id: $(this).val() } )
        .done(function( data ) {

            if($.isEmptyObject(data))
            {
                $('#customers').html(
                    $('<div></div>').addClass('letter').html(
                        $('<div></div>').addClass('container py-1').html(
                            'Ni rezultatov.'
                        )
                    )
                );
            } else {

                var body = '';

                body += 
                $('<div></div>').append(
                    $('<div></div>').addClass('letter').html(
                        $('<div></div>').addClass('container py-1').html(
                            'Rezultati'
                        )
                    )
                ).html();


                $.each(data, function( key, value ) {

                        body +=
                        $('<div></div>').append(
                            $('<div></div>').addClass('letter-contacts').append(
                                $('<div></div>').addClass('customer-item').append(
                                    $('<div></div>').addClass('container').append(
                                        $('<div></div>').addClass('row customer py-3').append(
                                            $('<div></div>').addClass('col-2 col-xl-1').append(
                                                $('<div></div>').addClass('customer-image').css({
                                                    'background-image' : 'url(/images/admin/icons/user_color.png)'
                                                })
                                            )
                                        ).append(
                                            $('<div></div>').addClass('col-8 col-xl-9').append(
                                                $('<div></div>').addClass('name').text(
                                                    value.name + ' ' + value.surname
                                                )
                                            ).append(
                                                $('<div></div>').addClass('email').text(
                                                    value.email
                                                )
                                            )
                                        ).append(
                                            $('<div></div>').addClass('col-2 text-end').append(
                                                $('<a></a>').addClass('delete').attr('href', '/admin/sms-renewals/renew/' + value.id).append(
                                                    $('<span></span>').addClass('material-icons').text(
                                                        'restore'
                                                    )
                                                )
                                            )
                                        )
                                    )
                                )
                            )
                        ).html();

                    $('#customers').html(body);

                });

                html = '';
                
            }
        });                
    });


});