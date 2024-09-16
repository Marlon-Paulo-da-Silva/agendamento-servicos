$(document).ready(function() {

    var field = '';

    $('#date_from, #date_to').on('click', function (e) {
          e.preventDefault();
          $('#myNav').addClass('active');
          field = $(this).attr('id');
          setTimeout(function () {
            $('#myNav').find('.overlay-content').css({'display':'flex'});
          }, 700);
          
        });

      /* Close */
      function closeNav() {
          $('#myNav').removeClass('active');
          $('.overlay-content').hide();
      }

      var today = new Date();
    var currentMonth = today.getMonth();
    var currentYear = today.getFullYear();


    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var days = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

    var dayHeader = "<tr>";
    for (day in days) {
    dayHeader += "<th data-days='" + days[day] + "'>" + days[day] + "</th>";
    }
    dayHeader += "</tr>";

    document.getElementById("thead-month").innerHTML = dayHeader;


    monthPresent = document.getElementById("month-present");
    yearPresent = document.getElementById("year-present");
    showCalendar(currentMonth, currentYear);


    $('#next').on('click', function () {
        currentYear = (currentMonth === 11) ? currentYear + 1 : currentYear;
        currentMonth = (currentMonth + 1) % 12;
        showCalendar(currentMonth, currentYear);
    });

    $('#previous').on('click', function () {
        currentYear = (currentMonth === 0) ? currentYear - 1 : currentYear;
        currentMonth = (currentMonth === 0) ? 11 : currentMonth - 1;
        showCalendar(currentMonth, currentYear);
    });

    function showCalendar(month, year) {

    var firstDay = ( new Date( year, month ) ).getDay();

    tbl = document.getElementById("calendar-body");

    tbl.innerHTML = "";
    
    monthPresent.innerHTML = months[month];
    yearPresent.innerHTML = year;

    var date = 1;
    for ( var i = 0; i < 6; i++ ) {
        var row = document.createElement("tr");

        for ( var j = 0; j < 7; j++ ) {
            if ( i === 0 && j < firstDay ) {
                cell = document.createElement( "td" );
                cellText = document.createTextNode("");
                cell.appendChild(cellText);
                row.appendChild(cell);
            } else if (date > daysInMonth(month, year)) {
                break;
            } else {
                cell = document.createElement("td");
                cell.className = "date-picker";
                const zeroPad = (num, places) => String(num).padStart(places, '0')

                cell.setAttribute('data-date', zeroPad(date, 2) + '.' + zeroPad(month+1, 2) + '.' + year);
                cell.innerHTML = "<span>" + date + "</span>";

                if ( date === today.getDate() && year === today.getFullYear() && month === today.getMonth() ) {
                    cell.className = "date-picker selected";
                }
                row.appendChild(cell);
                date++;
            }


        }

        tbl.appendChild(row);
    }

    document.querySelectorAll('#calendar td')
    .forEach(e => e.addEventListener("click", function(el) {

        var elems = document.querySelectorAll('#calendar td');

        [].forEach.call(elems, function(el) {
            el.classList.remove("selected");
        });

        this.classList.add('selected');
        var attributeValue = this.getAttribute('data-date');
        $('#'+field).val(attributeValue);
        setTimeout(function () {
            closeNav();
        }, 500);
        

    }));

    }

    function daysInMonth(iMonth, iYear) {
    return 32 - new Date(iYear, iMonth, 32).getDate();
    }

});