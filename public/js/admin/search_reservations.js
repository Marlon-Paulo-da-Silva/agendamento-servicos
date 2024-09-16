var swiper = new Swiper(".mySwiper", {
    slidesPerView: "auto",
    spaceBetween: 10,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});

function timeFormatter(dateTime) {
    var date = new Date(dateTime);
    if (date.getHours() >= 12) {
        var substracted_hours = date.getHours() == 12 ? date.getHours() : parseInt(date.getHours()) - 12;
        var hour = substracted_hours;
        var amPm = "pm";
    } else {
        var hour = date.getHours();
        var amPm = "am";
    }
    var time = hour + ":" + (date.getMinutes() < 10 ? '0' : '') + date.getMinutes() + " " + amPm;
    return time;
}

$(document).ready(function () {

    $('.mySwiper .swiper-slide').on('click', function (e) {
        e.preventDefault();
        var t = $(this);

        if ($(this).hasClass('disabled'))
            return false;

        $('.mySwiper .swiper-slide').removeClass('selected');
        $(this).addClass('selected');

        $.getJSON("/admin/reservations/get-schedule-by-user", { date: $('.mySwiper .swiper-slide.selected').attr('data-date'), user: $('#employee').val() })
            .done(function (data) {

                if ($.isEmptyObject(data)) {
                    $('#date').text('There are no reservations.');
                    $('.letter-contacts').html('');

                } else {

                    $('#date').text(
                        t.find('.weekday').text() + ', ' + t.find('.day').text() + '. ' + t.find('.month').text() + ' ' + t.find('.year').text()
                    );

                    var body = '';

                    $.each(data, function (key, value) {

                        var timeFormat = time_format == 1 ? timeFormatter($('.mySwiper .swiper-slide.selected').attr('data-date') + ' ' + value.start + ':00') : key;

                        body +=
                            $('<div></div>').append(
                                $('<div></div>').addClass('letter-contacts container').append(
                                    $('<div></div>').addClass('customer-item p-3').append(
                                        $('<div></div>').addClass('').append(
                                            $('<div></div>').addClass('row customer').append(
                                                $('<div></div>').addClass('col-8').append(
                                                    $('<div></div>').addClass('name').text(
                                                        value.service
                                                    )
                                                ).append(
                                                    $('<div></div>').addClass('email').html(
                                                        '<span>' + timeFormat + '</span> ' + value.name + ' ' + value.surname
                                                    )
                                                )
                                            ).append(
                                                $('<div></div>').addClass('col-2 text-end').append(
                                                    $('<a></a>').addClass('delete').attr('href', '/admin/reservations/confirm-delete/' + value.id + '?return_url=/admin/reservations').append(
                                                        $('<span></span>').addClass('material-icons').text(
                                                            'delete'
                                                        )
                                                    )
                                                )
                                            ).append(
                                                $('<div></div>').addClass('col-2 text-end').append(
                                                    $('<a></a>').addClass('delete').attr('href', 'tel:+' + value.area_code + value.phone).append(
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

                    $('#reservations').html(body);

                }
            });


    });


    $('.swiper-slide.selected').trigger('click');

});

