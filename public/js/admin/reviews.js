$(document).ready(function() {

    $('.change-status').on('click', function (e) {
        e.preventDefault();

        let id = $(this).data('id');
        

        $('#myNav').addClass('active');

        $('#myNav .overlay-content').html(
            `<div class="reviews-overlay">   
                <a href="/admin/reviews/change-status/${id}/1" class="mb-2">To Waiting</a>
                <a href="/admin/reviews/change-status/${id}/2" class="mb-2">To Approved</a>
                <a href="/admin/reviews/change-status/${id}/3">Move To Bin</a>
            </div>`
        );

        setTimeout(function () {
            $('#myNav').find('.overlay-content').css({'display':'flex'});
        }, 700);
    });

    $('.reviews-overlay a').on('click', function (e) {
        e.preventDefault();
        $('#myNav').removeClass('active');
        $('#myNav').find('.overlay-content').css({'display':'none'});
    })
});