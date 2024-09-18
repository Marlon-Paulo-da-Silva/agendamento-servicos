$(function() {

    $('#name').on('input', function () {
        $.getJSON( "/admin/customers/ajax", { search_term: $(this).val() } )
        .done(function( data ) {

            if($.isEmptyObject(data))
            {
                $('#customers').html(
                    $('<div></div>').addClass('letter').html(
                        $('<div></div>').addClass('container py-1').html(
                            'No results.'
                        )
                    )
                );
            } else {

                var body = '';

                $.each(data, function( key, value ) {

                    body += 
                    $('<div></div>').html(
                        $('<div></div>').addClass('letter').html(
                            $('<div></div>').addClass('container py-1').html(
                                key
                            )
                        )                                
                    ).html();
                    
                    $.each(value, function (n_key, n_value) {

                        var email = n_value.email && n_value.email.length > 0 ? n_value.email : 'No Email Address';

                        body +=
                        $('<div></div>').append(
                            $('<div></div>').addClass('letter-contacts').append(
                                $('<div></div>').addClass('customer-item').append(
                                    $('<div></div>').addClass('container').append(
                                        $('<div></div>').addClass('row customer py-3').append(
                                            $('<div></div>').addClass('col-8 col-xl-9').append(
                                                $('<div></div>').addClass('name').text(
                                                    n_value.name + ' ' + n_value.surname
                                                )
                                            ).append(
                                                $('<div></div>').addClass('email').text(
                                                    email
                                                )
                                            )
                                            .append(
                                                $('<div></div>').addClass('email').text(
                                                    '+'+ n_value.area_code + n_value.phone
                                                )
                                            )
                                        ).append(
                                            $('<div></div>').addClass('col-2 col-xl-1 text-end').append(
                                                $('<a></a>').addClass('delete').attr('href', '/admin/customers/edit/' + n_value.id).append(
                                                    $('<span></span>').addClass('material-icons').text(
                                                        'edit'
                                                    )
                                                )
                                            )
                                        ).append(
                                            $('<div></div>').addClass('col-2 col-xl-1 text-end').append(
                                                $('<a></a>').addClass('delete').attr('href', 'tel:+' + n_value.area_code + n_value.phone).append(
                                                    $('<span></span>').addClass('material-icons').text(
                                                        'call'
                                                    )
                                                )
                                            )
                                        )
                                    )
                                )
                            )
                        ).html();


                    });

                    $('#customers').html(body);

                });

                html = '';
                
            }
        });                
    });


});