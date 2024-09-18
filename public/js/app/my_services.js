$(document).ready(function() {

    $(".service a").on("click", function(e) {

        e.preventDefault();

        var text = $(this).find('.material-icons').text();

        $(this).find('.material-icons').text(
            text == "radio_button_unchecked" ? "check_circle_outline" : "radio_button_unchecked"
        );

        $(this).toggleClass('sel');

        if($(this).hasClass('sel')) {
            $(this).parent().find('input[type="checkbox"]').prop( "checked", true );
        } else {
            $(this).parent().find('input[type="checkbox"]').prop( "checked", false );
        }

    });

    $('#mark-all').on('click', function(e) {
        
        e.preventDefault();
        
        $('.service a').each(function() {
            
            $(this).addClass('sel');
            $(this).find('.material-icons').text('check_circle_outline');
            $(this).parent().find('input[type="checkbox"]').prop( "checked", true );
        });
    });

    $('#unmark-all').on('click', function(e) {
        
        e.preventDefault();
        
        $('.service a').each(function() {
            
            $(this).removeClass('sel');
            $(this).find('.material-icons').text('radio_button_unchecked');
            $(this).parent().find('input[type="checkbox"]').prop( "checked", false );
        });
    });

    $('.service-title').on('click', function (e) {
        e.preventDefault();

        if($(this).parent().find('.rows').is(':visible'))
        {
            $(this).parent().find('.rows').hide();
            $(this).find('.material-icons').text('expand_more');
        } else {
            $(this).parent().find('.rows').show();
            $(this).find('.material-icons').text('expand_less');
        }

    })
});