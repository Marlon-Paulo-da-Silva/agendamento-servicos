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
    var substracted_hours = date.getHours() == 12 ? date.getHours() :  parseInt(date.getHours()) - 12;
    var hour = substracted_hours;
    var amPm = "pm";
  } else {
    var hour = date.getHours();
    var amPm = "am";
  }
  var time = hour + ":" + (date.getMinutes()<10?'0':'') + date.getMinutes() + " " + amPm;
  return time;
}


$(document).ready(function () {

  $('.pages:first-of-type').addClass('active');

  $(".service a").on("click", function (e) {

    e.preventDefault();

    $('.service a').removeClass('sel');
    $('.service a').find('.material-icons').text('radio_button_unchecked');
    $(this).addClass('sel');

    $(this).find('.material-icons').text("check_circle_outline");

    $('#service').val($(this).attr('data-id'));
    $('#service-display').text($(this).attr('data-title'));

    if ($('.service a').length) {
      $('#navigation').show();
    } else {
      $('#navigation').hide();
    }

  });

  $('#save-button, #cancel-button, .add-customer-button').on('click', function (e) {

    e.preventDefault();
    var url = jQuery(e.currentTarget).data("url");

    var x = eval(url)
    //to handle the function reference
    if (typeof x == 'function') {
      x()
    }


    function first() {
      $('.pages').hide();
      $('#first').show();
      $('#cancel-button').hide();
      $('#save-button').data('url', 'second');

      if ($('.service a').length) {
        $('#save-button').show();
      }
    }

    function second() {

      $('.pages').hide();
      $('#second').show();
      $('#cancel-button').data('url', 'first').css({ 'display': 'block' });
      $('#save-button').hide();
      $('#save-button').data('url', 'third');
      $('.swiper-slide.selected').trigger('click');
    }

    function third() {
      $('.pages').hide();
      $('#third').show();


      $('#cancel-button').data('url', 'second').css({ 'display': 'block' });
      $('#save-button').hide();
      $('#save-button').data('url', 'fourth').text('Continuar');
    }

    function fourth() {
      $('.pages').hide();
      $('#fourth').show();


      $('#cancel-button').data('url', 'third').css({ 'display': 'block' });
      $('#save-button').data('url', 'fifth').text('Adicionar Cliente');
      $('#save-button').show();
    }

    function fifth() {

      $('#cancel-button').data('url', 'third').css({ 'display': 'block' });

      var request = $.ajax({
        type: 'POST',
        url: '/admin/customers/store-ajax',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: { name: $('#form-name').val(), surname: $('#form-surname').val(), area_code: $('#form-area-code').val(), phone: $('#form-phone').val(), email: $('#form-email').val() },
        dataType: 'json'
      });

      request.done(function (data) {
        var status = data;
        if (status.success) {
            $('.pages').hide();
            $('#third').show();

            $('#customer-response').html('<div class="alert alert-success">' + status.msg + '</div>');
            $('#navigation .save-button').data('url', 'sixth').text('Agendar Cliente');
            $('#customer').val(status.customer_id);



          // TODO depois daqui deve ser direcionado para a próxima tela

        } else {
          $('#customer-response').html('<div class="alert alert-success">There was unexpected error.</div>')
        }

      });

      request.fail(function (jqXHR, textStatus, errorThrown) {

        var errors = '';
        $.each(JSON.parse(jqXHR.responseText), function (key, value) {
          errors += value + '<br>';
        });

        $('#customer-response').html('<div class="alert alert-success">' + errors + '</div>');

      });

    }

    function sixth() {

      $loading = $('<div></div>').append(
            $('<h1></h1>').html('<img class="spinner" src="/images/admin/icons/loading.png" style="height: 50px;"></img> Verificando informações e agendando ...')
          );

      $('#sixth').html($loading);

      // Check if there are values else print out error
      if (
        $('#slot').val().length &&
        $('#user').val().length &&
        $('#service').val().length &&
        $('#customer').val().length
      ) {


        var request = $.ajax({
          type: 'POST',
          url: '/admin/reservations/store-ajax',
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
          data: {
            reservation_slot: $('#slot').val(),
            reservation_service: $('#service').val(),
            reservation_customer: $('#customer').val(),
            reservation_user: $('#user').val()
          },
          dataType: 'json'
        });

        request.done(function (data) {

          var status = data;
          if (status.success) {

            var avatar = status.data.profile_image;
            if (avatar == null)
              avatar = '/images/admin/icons/user_color.png';
            else
              avatar = '/images/profile_images/' + avatar;

            var success = $('<div></div>').append(
              $('<h1></h1>').text('Agendado com sucesso')
            ).append(
              $('<h2></h2>').text(status.data.service)
            ).append(
              $('<div></div>').addClass('form-completion').append(
                $('<div></div>').addClass('completion-profile').css({ 'background-image': 'url(' + avatar + ')' })
              ).append(
                $('<div></div>').addClass('completion-title').append(
                  $('<div></div>').addClass('title').text(status.data.name)
                ).append(
                  $('<div></div>').addClass('occupation').text(status.data.occupation)
                )
              ).append(
                $('<div></div>').addClass('completion-data p-3 mt-3 mb-4').append(
                  $('<div></div>').html('<span class="material-icons">today</span> ' + status.data.date)
                ).append(
                  $('<div></div>').addClass('text-end').html(
                    '<span class="material-icons">schedule</span> ' + status.data.time
                  )
                )
              )
            )
              .append(
                $('<a></a>').attr('href', '/admin/reservations/add').addClass('save-button mb-3').text('Agendar novo horário')
              ).html();

            $('#sixth').html(success);

          } else {

          }

        });

        request.fail(function (jqXHR, textStatus, errorThrown) {

          var errors = '';
          $.each(JSON.parse(jqXHR.responseText), function (key, value) {
            errors += value + '<br>';
          });

          var error = $('<div></div>').append(
            $('<h1></h1>').text('Term unfortunately cannot be added')
          ).append(
            $('<h2></h2>').text('Why has this happened?')
          ).append(
            $('<div></div>').html('<div class="alert alert-success">' + errors + '</div>')
          ).append(
            $('<a></a>').attr('href', '/admin/reservations/add').addClass('save-button mb-3').text('Try again')
          ).html();

          $('#sixth').html(error);

        });

      } else {
        var error = $('<div></div>').append(
          $('<h1></h1>').text('Term unfortunately cannot be added.')
        ).append(
          $('<h2></h2>').text('Required values are not selected. Please start again.')
        ).append(
          $('<a></a>').attr('href', '/admin/reservations/add').addClass('save-button mb-3').text('Start again')
        ).html();

        $('#sixth').html(error);
      }


      $('.pages').hide();
      $('#sixth').show();
      $('#navigation').hide();
    }
  });



  $('#name').on('input', function () {

    var input = $(this).val();

    if (!input.length) {
      return false;

    }

    $.getJSON("/admin/customers/ajax", { search_term: input })
      .done(function (data) {

        if ($.isEmptyObject(data)) {
          $('#customers-add').html('Cliente não encontrado.');
          $('#customer').val('');
          $('#save-button').hide();

        } else {

          var body = '';

          $.each(data, function (key, value) {

            $.each(value, function (n_key, n_value) {

              var checked = $('#customer').val().length && n_value.id == $('#customer').val() ? 'check_circle_outline' : 'radio_button_unchecked';
              body +=
                $('<div></div>').append(

                  $('<div></div>').addClass('customer-item p-3').attr('data-customer', n_value.id).append(

                    $('<div></div>').addClass('row customer').append(
                      $('<div></div>').addClass('col-10').append(
                        $('<div></div>').addClass('name').text(
                          n_value.name + ' ' + n_value.surname
                        )
                      ).append(
                        $('<div></div>').addClass('email').html(
                          '+' + n_value.area_code +'0' + n_value.phone
                        )
                      )

                    ).append(
                      $('<div></div>').addClass('col-2').append(
                        $('<div></div>').addClass('name line-height text-end').html(
                          '<span class="material-icons">' + checked + '</span>'
                        )
                      )

                    )
                  )
                ).html();


            });

            $('#customers-add').html(body);

            $('#customers-add .customer-item').on('click', function () {
              $('#customers-add .customer-item .col-2 .name span').text('radio_button_unchecked');
              $(this).find('.col-2 .name span').text('check_circle_outline');
              $('#customer').val($(this).data('customer'));
              $('#save-button').data('url', 'sixth').show();

            })

          });

          html = '';

        }
      });
  });


  $('.service-title').on('click', function (e) {
    e.preventDefault();

    if ($(this).parent().find('.rows').is(':visible')) {
      $(this).parent().find('.rows').hide();
      $(this).find('.material-icons').text('expand_more');
    } else {
      $(this).parent().find('.rows').show();
      $(this).find('.material-icons').text('expand_less');
    }

  });



  $('.mySwiper .swiper-slide').on('click', function (e) {

    e.preventDefault();



    if ($(this).hasClass('advance') || $(this).hasClass('disabled'))
      return false;

    $('#date').html('<img class="spinner" src="/images/admin/icons/loading.png" style="height: 34px;"></img> Buscando períodos disponíveis ...');

    // $('.mySwiper .swiper-slide .weekday').removeClass('testandoAdicionar');
    // $(this .weekday).addClass('testandoAdicionar');

    $('.mySwiper .swiper-slide').removeClass('selected');
    $(this).addClass('selected');

    $('#user').val('');
    $('#slot').val('');

    $('#navigation .save-button').hide();
    var t = $(this);
    var date_var = $(this).attr('data-date');

    $.getJSON("/admin/reservations/get-terms", { date: date_var, service: $('#service').val() })
      .done(function (data) {
        // TODO da pra colocar um rotate load enquanto aguarda a resposta
        if ($.isEmptyObject(data.slots)) {
          $('#date').text('Não há períodos disponíveis na data selecionada.');
          $('#terms').html('');

        } else {

          $('#date').text(
            t.find('.weekday').text() + ', ' + t.find('.day').text() + '. ' + t.find('.month').text() + ' ' + t.find('.year').text()
          );

          var body = '';
          $.each(data.slots, function (key, value) {

            var employees = '';

            $.each(value, function (employees_keys, employees_ids) {

              console.log(data.employees[5])
              console.log(employees_keys)
              console.log(employees_ids)

              var user_image = '';
              if (employees_keys == 0)
                user_image = 'user';
              else
                user_image = 'user' + (employees_keys + 1);


              var avatar = data.employees[employees_ids].avatar;
              if (avatar == null)
                avatar = '/images/admin/icons/user_color.png';
              else
                avatar = '/images/profile_images/' + avatar;

              employees += $('<div></div>').append(
                $('<div style="background-image:url(' + avatar + ')"></div>')
                  .addClass(user_image)
              ).html();

            });

            var timeFormat = time_format == 1 ? timeFormatter(date_var + ' ' + key + ':00') : key;

            body +=
              $('<div></div>').append(
                $('<div></div>').addClass('term p-3').attr('data-slot', date_var + ' ' + key + ':00').attr('data-key', key).append(
                  $('<div></div>').addClass('term-cont').append(
                    $('<div>').addClass('time').text(timeFormat)
                  ).append(
                    employees
                  )
                )
              ).html();


          });

          $('#terms').html(body);


          $('.term').on('click', function (e) {
            e.preventDefault();

            $('.term').removeClass('selected');
            $(this).addClass('selected');
            $('#slot').val($(this).data('slot'));


            var slots = data.slots[$(this).data('key')];

            var employees = '';
            $.each(slots, function (key, value) {

              var avatar = data.employees[value].avatar;
              if (avatar == null)
                avatar = '/images/admin/icons/user_color.png';
              else
                avatar = '/images/profile_images/' + avatar;

              var name = data.employees[value].name;
              var occupation = data.employees[value].occupation;

              if (occupation == null)
                occupation = '';

              employees += $('<div></div>').append(
                $('<div></div>').addClass('select-user p-3').attr('data-id', value).append(
                  $('<div style="background-image: url(' + avatar + ')"></div>').addClass('image')
                ).append(
                  $('<div></div>').addClass('user-width').append(
                    $('<div><div>').addClass('name').text(name)
                  ).append(
                    $('<div></div>').addClass('ocupation').text(occupation)
                  )
                ).append(
                  $('<div></div>').addClass('tick').append(
                    $('<span></span>').addClass('material-icons').text('check_circle')
                  )
                )
              ).html();

            });

            $('#employees').html(employees);

            $('.overlay-content .select-user').on('click', function (e) {
              e.preventDefault();
              $(this).parent().find('.select-user .tick').hide();
              $(this).find('.tick').show();
              $('#user').val($(this).data('id'));
              setTimeout(function () {
                $('.overlay').removeClass('active');
                $('.overlay-content').hide();
                $('.overlay-content').find('.select-user .tick').hide();
                $('#save-button').show();
              }, 500);
            });

            $('#myNav').addClass('active');

            setTimeout(function () {
              $('#myNav').find('.overlay-content').css({ 'display': 'flex' });
            }, 700);

          });


        }
      });

  });





});

