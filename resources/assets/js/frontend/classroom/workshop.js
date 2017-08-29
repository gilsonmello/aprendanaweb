/**
 * Created by ambiente on 08/08/16.
 */
var chrono_timer;
var chrono_incremental_timer = 0;

var chronometer = undefined;
var chronometer_color = 'rgb(30, 55, 109)';
;
var integral_time;

$(document).ready(function () {
    if ($("#chronometer").length > 0) {
        chrono_incremental_timer = $("#chronometer-time").data("incremental-time");
        init_chronometer($("#chronometer-time").data("time"), $("#chrono-display"), $("#chrono-incremental-display"), $("#chronometer-time").data("duration"));
        chrono_buttons();

        $(window).on('beforeunload', function () {
            saveOrUpdateTime();
        });
    }

    $('#calendar-tab').hide();

    $(".noCalendar").click(function () {
        $('#calendar-tab').hide();
    });

    $("#calendar-pill").click(function () {
        $('#calendar-tab').show();
        setTimeout(function () {
            var objectCalendar = "#calendar";

            $(objectCalendar).fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listWeek'
                },
                locale: 'pt-br',
                buttonIcons: true,
                defaultDate: $(objectCalendar).data('today'),
                navLinks: true, // can click day/week names to navigate views
                selectable: false, //Abre caixa para edição da data
                selectHelper: true,
                editable: false,
                select: function (start, end) {
                    var title = prompt('Titulo do Evento:');
                    var eventData;
                    if (title) {
                        eventData = {
                            title: title,
                            start: start,
                            end: end
                        };
                        $(objectCalendar).fullCalendar('renderEvent', eventData, true); // stick? = true
                    }
                    $(objectCalendar).fullCalendar('unselect');
                },
                eventLimit: true, // allow "more" link when too many events
                events: $(objectCalendar).data('events')
            });
        }, 1000);

    });


});



function openModal(title, date, str) {
    $(".modal-title").html('Dia:' + date + '<br/>' + title);
    $(".modal-body").html(str);
    $("#myModal").modal();
}

function init_chronometer(total_time, display, incremental_display, integral_time) {
    chrono_timer = total_time;
    if (integral_time == undefined) {
        integral_time = total_time;
    } else {
        integral_time = integral_time;
    }

    var hours, minutes, seconds;

    var ctx = document.getElementById("chrono-canvas").getContext("2d");

    ctx.canvas.width = 200;
    ctx.canvas.height = 200;
    chronometer = create_workshop_clock(ctx);



    setInterval(function () {
        if ($("#chronometer").data("active") == "1") {
            hours = Math.floor(parseInt(chrono_timer / 3600, 10));
            console.log(hours);
            minutes = parseInt((chrono_timer - (hours * 3600)) / 60, 10);
            console.log(minutes);
            seconds = parseInt(chrono_timer % 60, 10);
            console.log(seconds);

            hours = hours < 10 ? "0" + hours : hours;
            console.log(hours);
            minutes = minutes < 10 ? "0" + minutes : minutes;
            console.log(minutes);
            seconds = seconds < 10 ? "0" + seconds : seconds;
            console.log(seconds);

            display.text(hours + ":" + minutes + ":" + seconds);

            if (incremental_display != undefined) {
                incremental_hours = Math.floor(parseInt(chrono_incremental_timer / 3600, 10));
                incremental_minutes = parseInt((chrono_incremental_timer - (incremental_hours * 3600)) / 60, 10);
                incremental_seconds = parseInt(chrono_incremental_timer % 60, 10);

                incremental_hours = incremental_hours < 10 ? "0" + incremental_hours : incremental_hours;
                incremental_minutes = incremental_minutes < 10 ? "0" + incremental_minutes : incremental_minutes;
                incremental_seconds = incremental_seconds < 10 ? "0" + incremental_seconds : incremental_seconds;

                incremental_display.text(incremental_hours + ":" + incremental_minutes + ":" + incremental_seconds);

                chrono_incremental_timer++;
            }


            if (is_less_target_percentage(chrono_timer, integral_time, 20)) {
                chronometer_color = "red";
                display.css("color", "red");
            } else if (is_less_target_percentage(chrono_timer, integral_time, 40)) {
                chronometer_color = "purple";
                display.css("color", "purple");
            } else {
                chronometer_color = "rgb(30, 55, 109)";
                display.css("color", "rgb(30, 55, 109)");
            }

            if (--chrono_timer < 0) {
                chrono_timer = 0;
                display.fadeOut(500);
                display.fadeIn(500);
                if (incremental_display != undefined) {
                    if (incremental_display != undefined) {
                        display.fadeOut(500);
                        display.fadeIn(500);
                    }
                }
                if (is_over == false && chrono_timer == 0) {
                    time_over();
                    is_over = true;
                }
            }
            if (chronometer != undefined) {


                console.log(chronometer.segments[1].value);
                chronometer.segments[1].value = chrono_timer;
                chronometer.segments[0].value = integral_time - chrono_timer;
                chronometer.segments[0].fillColor = chronometer_color;
                chronometer.update();
            }
        }
    }, 1000);
}

function chrono_buttons() {
    $("#chrono-button-play").click(function () {
        $("#chronometer").data("active", "1");
    });

    $("#chrono-button-pause").click(function () {
        $("#chronometer").data("active", "0");

        saveOrUpdateTime();

    });
}

function saveOrUpdateTime() {
    $.ajax({
        url: "/classroom/workshops/save-or-update-time",
        type: "POST",
        data: {
            'activity': $("#chronometer").data('activity'),
            'enrollment': $("#chronometer").data('enrollment'),
            'time_spent': $("#chrono-incremental-display").text(),
            'time_left': $("#chrono-display").text(),
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        success: function (data) {

        },
        error: function (data) {


        }
    });
}