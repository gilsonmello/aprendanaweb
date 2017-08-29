/**
 * Created by ambiente on 04/02/16.
 */

var is_answered = false;
var is_next = false;
var is_over = false;
var timer;
var question_timer;

var clock = undefined;
var clock_color = 'rgb(30, 55, 109)';
var time_type;
var fontSizeQuestion = 1.6;
var isHighlighting = "";
var htmlPreHighlight = "";
var highlightId = "";
var idle_time = 0;
var idle_toggle = false;
var integral_time;
var exam_title = "";
var simulation = false;
var iframe;
var player;

$(document).ready( function(){
    $("#toggle-info").one('click', function(){
        $(".exam-explanation").slideToggle();
    });

    $(".exam-begin").on('click',function(e){
        if($(this).data('first-time') != 0) {
            e.preventDefault();
            $("#displayModal").modal('toggle');
            $("#assisted-mode").attr('href','/exam/' + $(this).data('enrollment'));
            $("#simulation-mode").attr('href','/exam/' + $(this).data('enrollment') + '/1');

        }
    });

    $(document).bind("mouseup", bj.Selector.mouseup);

    if($(".explanationModal").length > 0){

        $('.explanationModal').on('hidden.bs.modal', function () {
            console.log("teste");
            $("#explanationContentDiv").html('');
        });
    }





    $("#finish-exam").on('click',function(e){
        $("#choice-message").html( "<div id= style='padding: 20px; display: none;'><img src='/img/system/wait.gif' border='0'></div><br/>Aguarde...");

        if(!simulation){
        e.preventDefault();
            $.ajax({
                url: "/exam/end-time",
                type: "POST",
                data: {
                    'question': $('#question').data('question-exec')
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                cache: false,
                timeout: 30000,
                success: function (data) {

                    window.location = "/exam/result/" + $("#exam-panel").data('execution-id');
                },
                error: function(data){
                    timeout_handling(this);
                }
            });

        }
    });

    $("#start-exam").on('click',function(e){

       if($("#start-exam").data('order') == 1){
           if($("#exam-panel").data('display-explanation') == 1) {
               e.preventDefault();
               $("#displayModal").modal('toggle');
           }
       }


    });
    init();
} );





if($(".best-result-graph").length > 0){
    create_dashboard_right_chart();
}


function draw_charts_complete_results(){
    create_dashboard_enemies_chart();
    create_dashboard_expected_chart();
    swap_result();
    create_dashboard_result_chart();
    create_mini_expected_charts();
    create_mini_right_charts();

    create_mini_previous_charts();
    add_to_cart_event_handler();

}


if($("#study-plan-continuous").length > 0){
    create_dashboard_progress_charts();
    if($("#enemy-canvas").length > 0){
    create_dashboard_enemies_chart();
    create_dashboard_expected_chart();
    swap_result();
    create_dashboard_result_chart();
    }
}else   if($("#enemy-canvas").length > 0 && $("#my-exams").length > 0){
    create_dashboard_enemies_chart();
    create_dashboard_expected_chart();
    swap_result();
    create_dashboard_result_chart();
}


if($("#study-achievements").length > 0){
    //create_dashboard_study_charts();
}


function init_question_clock(total_time, display) {
    question_timer = total_time;
    var minutes, seconds;

    var ctx = document.getElementById("clock").getContext("2d");

    ctx.canvas.width = 40;
    ctx.canvas.height = 40;

    clock = create_clock(ctx);
    setInterval(function () {
        if (is_answered == false) {
            minutes = parseInt(question_timer / 60, 10);
            seconds = parseInt(question_timer % 60, 10);

            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.text(minutes + ":" + seconds);

            question_timer++;
            idle_time++;
            if( is_more_target_percentage(idle_time, $("#time").data("by-question") * 60, 10)){
                if(idle_toggle == false && $("#exam-panel").data("simulation-mode") == 0){
                    idle_toggle = true;
                    is_answered = true;
                    $("#continueModal").modal('toggle');



                }
            }



        }
    }, 1000);
}







function init_clock(total_time, display) {
    timer = total_time;
    var hours, minutes, seconds;

    var ctx = document.getElementById("clock").getContext("2d");

    ctx.canvas.width = 40;
    ctx.canvas.height = 40;

    clock = create_clock(ctx);

    setInterval(function () {
        if (is_answered == false) {
            hours = Math.floor(parseInt(timer / 3600, 10));
            minutes = parseInt((timer - (hours * 3600)) / 60, 10);
            seconds = parseInt(timer % 60, 10);

            hours = hours < 10 ? "0" + hours : hours;
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;

            display.text(hours + ":" + minutes + ":" + seconds);


            if (is_less_target_percentage(timer, integral_time, 20)) {
                clock_color = "red";
                display.css("color", "red");
            } else if (is_less_target_percentage(timer, integral_time, 40)) {
                clock_color = "purple";
                display.css("color", "purple");
            } else {
                clock_color = "rgb(30, 55, 109)";
                display.css("color", "rgb(30, 55, 109)");
            }

            if (--timer < 0) {
                timer = 0;
                display.fadeOut(500);
                display.fadeIn(500);
                if(is_over == false && $("#time").data("by-question") != 0){
                    time_over();
                    is_over = true;
                }
            }
            if(clock != undefined){


                clock.segments[1].value = timer;
                clock.segments[0].value = integral_time - timer;
                clock.segments[0].fillColor = clock_color;
                clock.update();
            }
        }else if(is_answered == true && timer == 0){
            display.fadeOut(500);
            display.fadeIn(500);
        }
    }, 1000);
}

function is_less_target_percentage(timer, total_time, target) {
    return ((100 * timer) / total_time) < target;
}

function is_more_target_percentage(timer, total_time, target) {
    if (((100 * timer) / total_time) > target) {
        return true;
    } else {
        return false;
    }

}


function init_countdown(total_time) {
    time_type = $("#time-type");
    var display = $('#time');
    init_clock(total_time, display);
    if(time_type != 'by-question'){
        init_question_clock(parse_time_to_sec($("#crescent-time").data('crescent-time')),$("#crescent-time"));

        $('#continueModal').on('shown.bs.modal', function (e) {
            console.log('mostrando');
            $(".modal-backdrop").css({ opacity: 0.9 });
        });


        $('.panel').mousemove(function(){
            idle_time = 0;
            if(idle_toggle == true){
                idle_toggle = false;
                $("#continueModal").modal('toggle');
                is_answered = false;
            }
        });
        integral_time = $("#time").data("by-question") * 60;
    }


}


function init(){
    console.log('begin');
if($("#exam-presentation").length > 0 && $("#complete-result").length == 0){
    $(".explanation-tabs").css("display","none");
    htmlPreHighlight = $("#question").html();
    applyHighlightCapture();

    $(window).on('beforeunload',function(){
        if($("#classroomExamModal").length < 1){
            save_current_time();
            save_question_time();
        }
    });

    console.log('this once');
    answer_question();
    next_question();
    if($("#classroomExamModal").length < 1) {
        init_countdown(parse_time_to_sec($("#time").data('time')));
    }
    jump_to_next();

}else if($("#complete-result").length > 0){
    //$(".detail-column").css("display","none");
    $(".detail-column").css("display","none");

    $(".button-askTheTeacher").on('click', function () {
        $.ajax({
            url: "/exam/save-ask-the-teacher",
            type: "POST",
            data: {
                'question_id': $('#askTheTeacher_question_id').val(),
                'question': $("#questionAskTheTeacher").val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function (data) {
                $('#askTheTeacherContentModal').modal('toggle');
                $("#questionAskTheTeacher").val('');
            },
            error: function (data) {
                timeout_handling(this);

            }
        });
    });

    $(".rating-thumb").click(function(){
        if($(this).hasClass('fa-thumbs-o-down')) {
            $(this).removeClass('fa-thumbs-o-down');
            $(this).addClass('fa-thumbs-down');
            $(this).next().removeClass('fa-thumbs-up');
            $(this).next().addClass('fa-thumbs-o-up');
        }else if($(this).hasClass('fa-thumbs-down')) {
            $(this).removeClass('fa-thumbs-down');
            $(this).addClass('fa-thumbs-o-down');
        }else if($(this).hasClass('fa-thumbs-o-up')){
            $(this).removeClass('fa-thumbs-o-up');
            $(this).addClass('fa-thumbs-up');
            console.log($(this));
            $(this).prev().removeClass('fa-thumbs-down');
            $(this).prev().addClass('fa-thumbs-o-down');
        }else{
            $(this).removeClass('fa-thumbs-up');
            $(this).addClass('fa-thumbs-o-up');
        }

        $.ajax({
            url: "/exam/save-teacher-rating",
            type: "POST",
            data: {
                'execution': $('#results-section').data("execution"),
                'rating': $(this).index(),
                'teacher': $(this).parent().parent().parent().data("teacher"),
                'rating-type': $(this).parent().data("type")
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function (data) {
                console.log("nota salva");
            },
            error: function (data) {

            }
        });


    });


    $(".rating-star").click(function(){

        $(this).removeClass("fa-star-o").addClass("fa-star");
        $(this).nextAll().removeClass("fa-star").addClass("fa-star-o");
        $(this).prevAll().removeClass("fa-star-o").addClass("fa-star");
        $(".fa-star").css('color',"#ffc332");

        $.ajax({
            url: "/exam/save-rating",
            type: "POST",
            data: {
                'execution': $('#results-section').data("execution"),
                'rating': $(this).index() + 1
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function (data) {
                $(".teachers-rating").css("display","block");
            },
            error: function (data) {
            }
        });

    });




        $("#send-rating-comment").click(
            function() {
                if(  $(".teachers-rating").css("display") == "block"){
                save_rating_comment(function () {
                    $(".comment-rating-form").html("<h2>Obrigado pela sua avaliação!</h2>");
                });
                }
            });


    $(".btn-filter").not(".detail").click(function(){
       $(this).siblings().not(".detail").removeClass("active");
    });

    $(".all").click(function(){
        if(!$(this).hasClass("active")){

            $(".subject-line").css("display","table-row");

        }
    });


    $(".good").click(function(){
        if(!$(this).hasClass("active")){

            $(".bad-line").css("display","none");
            $(".good-line").css("display","table-row");
;
        }
    });

    $(".bad").click(function(){
        if(!$(this).hasClass("active")){
            $(".good-line").css("display","none");
            $(".bad-line").css("display","table-row");

        }
    });

    $(".detail").click(function(){
        if($(this).hasClass("active")){
            $(".detail-column").css("display","none");
            $(this).find('.toggle-active').removeClass('fa-check-square-o');
            $(this).find('.toggle-active').addClass('fa-square-o');

        }else{
            $(".detail-column").css("display","table-cell");
            $(this).find('.toggle-active').addClass('fa-check-square-o');
            $(this).find('.toggle-active').removeClass('fa-square-o');
            $(this).addClass("toggled-active");

        }
    });


    $(".all-button").click(function(){
        $(".fail-line").css("display","table-row");
        $(".check-line").css("display","table-row");
    });

    $(".check-button").click(function(){
            $(".fail-line").css("display","none");
            $(".check-line").css("display","table-row");
    });

    $(".fail-button").click(function(){

            $(".check-line").css("display","none");
            $(".fail-line").css("display","table-row");


    });



    result_flip_events();
    draw_charts_complete_results();
}else if($(".intro-result-graph").length > 0){
    create_intro_results_chart();
}else if($("#general_performance").length > 0){
    create_mini_right_charts();

    var ctxTotal = document.getElementById("right-percentage-chart").getContext("2d");

    ctxTotal.canvas.width = 160;
    ctxTotal.canvas.height = 160;

    $(".subject-line").click(function(){
       open_discipline_modal($(this).data('id'), $(this).data('name'));
    });




    create_total_chart(ctxTotal,true);
    console.log('nothing changed');
   create_performance_results_chart();
}
}


function open_discipline_modal(discipline_id,discipline_name){

    $.ajax({
        url: 'performance-geral/disciplina',
        type: "POST",
        data: {
            'discipline': discipline_id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        success: function(data){


            $("#disciplineStatisticModal").html(data);
            $("#disciplineStatisticModalTitle").html(discipline_name);
            $("#disciplineStatisticModal").modal('toggle');
            $(document).on('shown.bs.modal','#disciplineStatisticModal', function () {

                create_mini_right_charts(".mini-subject-right-chart");
            });

        },
        error: function (data) {

        }
    });


}



function pause_clock() {

}

function save_rating_comment(after_save){
    $.ajax({
        url: '/result/rating-comment',
        type: "POST",
        data: {
            'execution': $("#results-section").data("execution"),
            'comment': $('#rating-comment').val()
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        success: function(data){
            if(after_save != undefined) after_save();
        },
        error: function (data) {

        }
    });
}

function parse_time_to_sec(time) {

    if (String(time).indexOf(':') === -1) {
        return Number(time) * 60;
    } else {

        var split = time.split(":").map(Number);
        if(split.length == 3) return (split[0] * 3600) + (split[1] * 60) + split[2];
        return (split[0] * 60) + split[1];
    }
}

function time_over(){
    is_next = true;
    is_answered = true;
    $("#options input").prop('disabled', true);
    $("#button-answer").prop('disabled', true);

    $("#correct").html('<b style="color: red;">Tempo Esgotado!</b>');
    $("#explanation .panel-title").html('<strong>TEMPO ESGOTADO!</strong> - Veja o comentário.');
    $("#explanation").addClass('panel-danger');
    if ($( document ).width() > 1024) {
        $("#blade-question").animate({
            width: "50%",
        }, 700, function () {
            $("#explanation").css("display", "block");
        });
    }
    $(".button-answer").addClass("button-result");
    setNoteToQuestionContent();

    save_right_answer(0,[]);
    open_explanation_video();
        if(time_type != "by-question"){
            $.ajax({
                url: "/exam/end-time",
                type: "POST",
                data: {
                    'question': $('#question').data('question-exec')
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                cache: false,
                timeout: 30000,
                success: function (data) {
                    $("#confirmation").text("Resultado");

                    $(".button-next").text("Ir para resultados");
                    $(".button-next").css("background-color","#0077b3");

                },
                error: function(data){
                    timeout_handling(this);
                }
            });
        }


}
//O campo right define se aquela resposta é correta ou não. Se o campo right dividido pelo código da question_execution
// equivalente, o resto da divisão será 1 caso a alternativa esteja correta e 0 caso não seja
function answer_question() {

    setFontSize();

    $("#explanation-wait").css("display", "block");
    $("#explanation-teacher").css("display", "none");

    $(".button-answer").off();
    var is_clicked = false;
    var is_clicked_note = false;

    $(".button-note").on('click', function () {
        $(".button-note").text("Salvando...");
        if (is_clicked_note === false){
            is_clicked_note = true;
            $.ajax({
                url: "/exam/save-user-note",
                type: "POST",
                data: {
                    'question': $('#question_id').val(),
                    'note': $("#questionnote").val()
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                cache: false,
                success: function (data) {
                    is_clicked_note = false;
                    $(".button-note").text("Salvar");
                },
                error: function (data) {
                    is_clicked_note = false;
                }
            });
        }
    });

    $(".button-askTheTeacher").on('click', function () {
        if (is_clicked_note === false){
            is_clicked_note = true;
            $.ajax({
                url: "/exam/save-ask-the-teacher",
                type: "POST",
                data: {
                    'question_id': $('#askTheTeacher_question_id').val(),
                    'question': $("#questionAskTheTeacher").val()
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                cache: false,
                success: function (data) {
                    $('#askTheTeacherContentModal').modal('toggle');
                    is_clicked_note = false;
                    $("#questionAskTheTeacher").val('');
                },
                error: function (data) {
                    is_clicked_note = false;
                }
            });
        }
    });

    $(".button-answer").not('.button-next').on('click', function () {
        if($('input:checked').length == 0 && $("#classroom-modal-main-container").length == 0){
            $("#correct").html('<b style="color: red;">É necessário selecionar ao menos uma alternativa!</b>');
        }else if (!is_next) {
            is_next = true;
            is_answered = true;


            $("#time").addClass("time-stop");
            var right_answers = [];
            var selected_answers = [];
            var total_options = 0;
            $(".answer").each(function () {
                    total_options++;
                    console.log($(this));
                    if ($(this).data("right") % $("#question").data('question-exec') == 0) {
                        if($("#exam-panel").data("simulation-mode") == 0) {
                            $(this).css('color', 'lightgrey');
                        }
                        if ($(this).parent().parent().find('input:checked').length <= 0) {
                            right_answers.push($(this).attr('id'));
                        }

                    } else {
                        if($("#exam-panel").data("simulation-mode") == 0) {
                            $(this).css('color', 'black');
                            $(this).parent().parent().parent().css("background-color", "palegreen");
                        }
                        if ($(this).parent().parent().find('input:checked').length > 0) {
                            right_answers.push($(this).attr('id'));
                        }
                    }
                }
            );

            selected_answers = $("#options").find('input:checked').val().toString();

            console.log("right: " + right_answers);
            var value;
            if ($("#options").data("type") == "S" || $("#options").data("type") == "M" || $("#options").data("type") == "CESPE") {
                if (total_options == right_answers.length) {
                    value = 1;
                } else {
                    value = 0;
                }
            } else if ($("#options").data("type") == "MP") {
                value = total_options / right_answers.length;
            } else if ($("#options").data("type") == "ME") {
                value = right_answers - total_options + 1;
            }


            $("#explanation").removeClass('panel-danger');
            $("#explanation").removeClass('panel-success');
            $("#explanation").removeClass('panel-info');


            
            
            var top = document.getElementById('explanation').offsetTop; //Getting Y of target element
            window.scrollTo(0, top);
            if (value == 1) {
                $("#explanation .panel-title").html('<strong>PARABÉNS! VOCÊ ACERTOU</strong> - Veja o comentário.');

                $("#explanation").addClass('panel-success');
                //before('<h5 style="color: green;">Correto!</h5>');
                save_right_answer(1, selected_answers);
            } else {
                $("#explanation .panel-title").html('<strong>RESPOSTA INCORRETA</strong> - Veja o comentário.');
                $("#explanation").addClass('panel-danger');
                if($("#options").data("type") == "CESPE"){
                    save_right_answer(-1, selected_answers);
                } else {
                    save_right_answer(0, selected_answers);
                }
            }

            $("#options input").prop('disabled', true);
            $("#button-answer").prop('disabled', true);



        }
    });
    /*
     $.ajax({
     url: "/exam/get-right-answers",
     type: "POST",
     data: {'question': $('#question').data('question-id'),
     'answers': $("#options input").serialize()},
     headers: {
     'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
     },
     cache: false,
     success: function(data){

     var right_answers = [];
     var total_options = 0;
     $.each(data,function(id,is_right){
     total_options++;
     if(is_right == '1'){
     $("#" + id).css('color','green');
     if($("#" + id).parent().find('input:checked').length > 0){
     right_answers.push(id);
     }

     }else{
     $("#" + id).css('color','red');
     if($("#" + id).parent().find('input:checked').length <= 0){
     right_answers.push(id);
     }
     }

     });

     var value;
     if($("#options").data("type") == "S" || $("#options").data("type") == "M"){
     if(total_options == right_answers.length){
     value = 1;
     }else{
     value = 0;
     }
     }else if($("#options").data("type") == "MP"){
     value = total_options / right_answers.length;
     }else if($("#options").data("type") == "ME"){
     value =  right_answers - total_options + 1;
     }

     if(value == 1){
     $("#options").before("Correto!");
     }else{
     $("#options").before("Incorreto.");
     }

     $("#options input").prop('disabled',true);
     open_explanation_video();
     next_question($("#question").data("question-exec"));

     }
     });
     });
     */
}

function save_right_answer(is_right, selected_answers) {

    var right_answers = selected_answers.toString();
    if(selected_answers.length == 0){
        right_answers = ""
    }

    console.log(is_right);
    console.log($("#time").text());

    $.ajax({
        url: "/exam/save-user-answer",
        type: "POST",
        data: {
            'question': $('#question').data('question-exec'),
            'answers': right_answers,
            'time': $("#time").text(),
            'crescent-time': $("#crescent-time").text(),
            'is_right': is_right
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        timeout: 30000,
        success: function (data) {
            if($("#question").data("question-answered") == 0){
                $("#exam-panel").data("not-answered",+$("#exam-panel").data("not-answered") - 1);
            }

            if($("#exam-panel").data("display-explanation") == 1){
                setNoteToQuestionContent();

                if ($( document ).width() > 1024) {
                    $("#blade-question").animate({
                        width: "50%",
                    }, 700, function () {
                        $("#explanation").css("display", "block");
                    });
                } else {

                }

                open_explanation_video();
            }else{
                prepare_for_next();
            }
        },
        error: function(xhr, textStatus, errorThrown ) {

                timeout_handling(this);

        }

    });
}


function open_explanation_video() {

    $("#explanation-result").html('');
    $("#explanation-result").css("display", "none");

    $("#toolsDiv").css("display", "none");

    $("#explanation-content").html("");
    $("#explanation-text").html("");
    $("#explanation-teacher").html("");

    $.ajax({
        url: "/exam/get-explanation-url",
        type: "POST",
        data: {'question': $('#question').data('question-exec')},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        timeout: 30000,
        success: function (data) {
         prepare_for_next();

            $("#explanation").css("display", "block");
            $("#explanation .panel-title").css('display', 'block');
            $("#explanation-wait").css("display", "none");

            if (data[0] != "" && data[0] != "expired") {

                $("#explanation-content").attr('src', data[0]);

                 iframe = $("#explanation-content")[0];
                 player = new Vimeo.Player(iframe);



                    }else if(data[0] == "expired"){
                $("#explanation-content").html("<p style='color: lightgrey'>Você assistiu esse vídeo o máximo de vezes permitido para essa execução</p>")
            }else {
                $("#explanation-content").html("");
            }
            console.log('Eis os dados');
            console.log(data);
            if (data[1] != "") {
                $("#explanation-text").html(data[1]);
            } else {
                $("#explanation-text").html("");
            }
            if (data[2] != "") {
                $("#explanation-teacher").css("display", "block");
                $("#explanation-teacher").html("<b>Professor(a): </b>" + data[2]);
            } else {
                $("#explanation-teacher").html("");
            }
            //alert($('#explanation').offset().top);
            //$("html,body").animate({ 'scrollTop':   $('#explanation').offset().top }, 2000);

            $(".button-note").on('click', function () {
                $(".button-note").text("Salvando...");
                $.ajax({
                    url: "/exam/save-user-note",
                    type: "POST",
                    data: {
                        'question': $('#question_id').val(),
                        'note': $("#questionnote").val()
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    cache: false,
                    success: function (data) {
                        $(".button-note").text("Salvar");
                    },
                    error: function (data) {
                        $(".button-note").text("Erro!");
                    }
                });
            });


        },
        error: function(data){
            timeout_handling(this);
        }
    });

}

//function onPlay(){
//
//        console.log('play');
//        $.ajax({
//            url: "/exam/increment-explanation-view",
//            type: "POST",
//            data: {'question': $('#question').data('question-exec')},
//            headers: {
//                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
//            },
//            cache: false,
//            success: function (data) {
//                console.log("views incremented");
//            }
//        });
//
//}

function prepare_for_next(){

    $(".button-answer").addClass('button-next');
    $(".button-next").removeClass('button-answer');
    if($("#exam-panel").data("not-answered") > 0){
        $(".button-next").text('Próxima Questão');
        $(".button-next").css("background-color","#0077b3");

    }else{
        $(".button-next").text("Ir para o resultado");
        $(".button-next").css("background-color","#0077b3");

    }
    next_question();

    $("#button-answer").prop('disabled', false);
}


function next_question() {

    $(".button-next").off();
    var is_clicked = false;
    $(".button-next").not('.button-answer').on('click', function () {
        if (is_next) {

            $(".button-next").addClass('button-answer');
            $(".button-answer").removeClass('button-next');
            $(".button-answer").text('Aguarde...');
            $("#divButtonJump").css("display", "none");
            $("#crescent-time").css("display", "none");

            $("#explanation-content").attr('src', '');


            $("#explanation").css("display", "none");

            var next;
            if($("#next").length > 0){
                console.log("De grupo");
                next = $("#next").data("next");
            }else{
                next = $("#question").data("question-exec");

            }

            var from_result = '';
            if($(this).hasClass("button-from-result")){
                console.log('tem classe');
                from_result = 't';
                $(this).removeClass("button-from-result");
            }

            $("#exam-presentation").html("");
            $("#question-wait").css("display", "block");

            $.ajax({
                url: "/exam/get-next-question",
                type: "POST",
                data: {'question': next,

                    'from-result': from_result},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                cache: false,
                timeout: 30000,
                success: function (data) {
                    if (data == 'end') {
                        window.location = "/exam/result/" + $("#exam-panel").data('execution-id');
                        return;
                    } else if(data[0] == 'end-classroom'){
                        if($("#classroom-modal-main-container").length > 0){
                        $("#classroom-modal-main-container").html(data[1]);
                        create_classroom_right_chart("#class-exam-percentage");
                        explanation_modal_events();




                        $("#explanationModal").off('hidden.bs.modal').on('hidden.bs.modal',function(){
                            $("body").addClass('modal-open');
                            $("#explanationContentDiv").html('');

                        });

                        }else{
                            window.location = "/exam/result/" + $("#exam-panel").data('execution-id');
                            return;
                        }
                    } else {


                        var page_content = data;
                        if ($.isArray(data)) {
                            page_content = data[0];
                        }

                        $("#question-wait").css("display", "none");
                        $("#exam-presentation").html(page_content);

                        setFontSize();

                        $("#correct").html('');
                        $("#exam-presentation").fadeIn();

                        if ($("#results").length > 0) {

                            $("#time-space").html('');
                            $("#time").html('');


                            $("#explanation-result").html(data[1]);
                            $("#explanation-result").css("display", "block");
                            $("#explanation").css("display", "block");
                            $("#explanation-content").attr('src', '');
                            $("#explanation .panel-title").html('<strong>Resultados por subtema</strong> ');
                            $("#explanation").removeClass('panel-danger');
                            $("#explanation").removeClass('panel-success');
                            $("#explanation").addClass('panel-info');
                            $("#explanation .panel-heading").css('background', '#d8eceb');
                            $("#explanation .panel-heading").css('border-left', '8px solid #253885');
                            $("#explanation .panel-heading").css('border-right', '8px solid #253885');
                            $("#explanation .panel-heading").css('border-bottom', '0');
                            $("#explanation .panel-heading .panel-title").css('color', '#253885');
                            $("#toggle-info").css("display", "none");

                            $("#explanation-teacher").css("display", "none");

                            $("#explanation-wait").css("display", 'none');

                            if ($(document).width() > 1024) {
                                $("#blade-question").animate({
                                    width: "50%",
                                }, 700, function () {
                                    $("#explanation").css("display", "block");
                                });

                                setNoteToQuestionContent();

                            } else {

                            }


                            if ($("#next").length <= 0) {
                                $(".button-answer").css('display', 'none');
                                $(".button-jump").css('display', 'none');
                                $("#clock").css('display', 'none');

                                $("#explanation .panel-title").html('<div class="row"><div id="result-title" class="col-md-8"> <strong>Resultados por tema</strong> </div> <div id="by-flip" class="col-md-4 text-right" style="cursor: pointer;">Por Subtema &nbsp<i class="fa fa-angle-right"></i></div> </div>');
                                $("#explanation-text").html(data[2]);
                                $("#explanation-text").css("display", "block");
                                $("#explanation-result").css("display", "none");
                                $("#explanation-content").css("display", "none");
                                $("#explanation").css("display", "block");
                                var flip = "theme";

                                $("#by-flip").click(function () {
                                    if (flip == "theme") {
                                        $("#explanation-text").css("display", "none");
                                        $("#explanation-result").css("display", "block");
                                        $("#explanation-content").css("display", "block");
                                        $("#result-title").html('<strong>RESULTADOS POR SUBTEMA</strong>');
                                        $("#by-flip").html('<i class="fa fa-angle-left"></i>&nbsp Por Tema');
                                        flip = "subject";
                                    } else {
                                        $("#explanation-text").css("display", "block");
                                        $("#explanation-result").css("display", "none");
                                        $("#explanation-content").css("display", "none");
                                        $("#result-title").html('<strong>RESULTADOS POR TEMA</strong>');
                                        $("#by-flip").html(' Por Subtema&nbsp<i class="fa fa-angle-right"></i>');
                                        flip = "theme";
                                    }
                                });


                                $(".detail-column").css("display", "none");



                                $(".all").click(function () {
                                    $(".btn-filter").not('.detail').removeClass("active");
                                    $(".subject-line").css("display","table-row");


                                });

                                $(".good").click(function () {
                                    $(".btn-filter").removeClass("active");
                                        $(".subject-line").css("display","none");
                                        $(".good-line").css("display", "table-row");

                                });

                                $(".bad").click(function () {
                                    $(".btn-filter").not('.detail').removeClass("active");
                                    $(".subject-line").css("display","none");
                                        $(".bad-line").css("display", "table-row");
                                });

                                $(".detail").click(function () {
                                    if ($(this).hasClass("active")) {
                                        $(".detail-column").css("display", "none");
                                    } else {
                                        $(".detail-column").css("display", "table-cell");

                                    }
                                });

                                $(".check-button").click(function () {
                                    if ($(this).hasClass("active")) {
                                        $(".check-line").css("display", "none");
                                    } else {
                                        $(".check-line").css("display", "table-row");

                                    }
                                });

                                $(".fail-button").click(function () {
                                    if ($(this).hasClass("active")) {
                                        $(".fail-line").css("display", "none");
                                    } else {
                                        $(".fail-line").css("display", "table-row");

                                    }
                                });


                                draw_charts();


                            } else {
                                console.log('Para adicionar classe');
                                $(".button-answer").addClass('button-next');
                                $(".button-next").addClass("button-from-result");
                                $(".button-next").removeClass('button-answer');
                                $(".button-next").text('Próxima Questão');
                                $(".button-next").css("background-color","#0077b3");

                            }
                        } else {
                            $("#blade-question").css("width", "100%");
                            $(".explanation-tabs").css("display","none");

                            $(".button-answer").text('Responder');
                            $(".button-answer").css('background-color','#47a447');
                            $("#divButtonJump").css("display", "block");
                            $("#crescent-time").css("display", "block");


                            is_next = false;
                            is_answered = false;
                            $("#time").removeClass("time-stop");
                            answer_question();

                            htmlPreHighlight = $("#question").html();
                            if (isHighlighting == 'B') {
                                $("#highlightBtBlue").html("<i class='fa fa-close'>&nbsp;</i>");
                            } else if (isHighlighting == 'R') {
                                $("#highlightBtRed").html("<i class='fa fa-close'>&nbsp;</i>");
                            } else if (isHighlighting == 'Y') {
                                $("#highlightBtYellow").html("<i class='fa fa-close'>&nbsp;</i>");
                            }

                            applyHighlightCapture();

                            if ($("#time").data("by-question") != "0") {
                                if (time_type == "by-question") {
                                    timer = parse_time_to_sec($("#time").data("by-question"));
                                } else {
                                    question_timer = 0;
                                }
                                is_over = false;
                            }
                        }

                    }
                },
                error: function(xhr, textStatus, errorThrown ) {


                        timeout_handling(this);

                }
            });
        }

    });


}

function explanation_modal_events(){

    $(".modal-explanation").off('click').click(function(){
        if(!$("#explanationModal").hasClass('in')) {
            $("#explanationContentWait").css("display", "block");
            $("#explanationContentDiv").css("display", "none");
            $("#explanationContentDiv").html("");
            $("#explanationModal").modal('toggle');
            $.ajax({
                url: "/exam/question-explanation",
                type: "POST",
                data: {'question': $(this).data('question'), 'execution': $('#panel-summary').data("execution"),},
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                cache: false,
                success: function (data) {

                    $("#explanationContentDiv").html(data);
                    $(".explanation-tabs").css("display", "block");
                    $("#explanationContentDiv").css("display", "block");
                    $("#explanationContentWait").css("display", "none");
                    $("#explanation-question").find('span').css('border-left','0');
                    $("#explanation-question").find('span').filter(function(){
                       return $(this).css('background-color') != "#d7ffd5";
                    }).css('background-color','transparent');


                    $("#panel-comment").find('span').css('border-left','0');

                    $('.close').click(function(){
                        $(this).closest(".modal").modal('hide');
                    });
                    $(".tab-button").click(function () {
                        if ($(this).hasClass("tab-question")) {
                            $("#explanation-question").css("display", "block");
                            $("#exam-note-info").css("display", "none");

                        } else {
                            $("#exam-note-info").css("display", "block");
                            $("#exam-note-info").html($(this).data("note") + " <br/>");

                            $("#explanation-question").css("display", "none");

                        }
                        $(".tab-button.active").removeClass("active");
                        $(this).addClass('active');

                    });


                    $(".button-note").on('click', function () {
                        $(".button-note").text("Salvando...");
                        $.ajax({
                            url: "/exam/save-user-note",
                            type: "POST",
                            timeout: 30000,
                            data: {
                                'question': $('#question_id').val(),
                                'note': $("#questionnote").val()
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            },
                            cache: false,
                            success: function (data) {
                                $(".button-note").text("Salvar");
                            },
                            error: function (data) {
                                timeout_handling(this);

                            }
                        });
                    });

                }
            });
        }
    });

}

function jump_to_next(){
    $("#jumpback").click(function(){
      //  if($(".button-answer").length > 0) {
            is_answered = true;
            save_current_time();
            return_question();
     //   }
    });
    $("#jump").click(function(){
      //  if($(".button-answer").length > 0) {
            is_answered = true;
            save_current_time();
            advance_question();
     //   }
    });
    $("#jumpto").click(function(){
      //  if($(".button-answer").length > 0) {
            showQuestionsNotAnswered( $("#jumpto").attr('data'));
     //   }
    });
    
}

function jump_to_question(question_exec_id){
    is_answered = true;
    $("#questionContentModal").modal('hide');
    $('.modal-backdrop').remove();

    save_current_time();
    $(".button-next").addClass('button-answer');
    $(".button-answer").removeClass('button-next');
    $(".button-answer").text('Aguarde...');

    $("#explanation-content").attr('src', '');

    $("#explanation").css("display", "none");



    var next;
    if($("#next").length > 0){
        console.log("De grupo");
        next = $("#next").data("next");
    }else{
        console.log("De questão");
        next = $("#question").data("question-exec");
    }

    var from_result = '';
    if($(this).hasClass("button-from-result")){
        from_result = 't';
        $(this).removeClass("button-from-result");
    }

    $("#exam-presentation").html("");
    $("#question-wait").css("display", "block");

    $.ajax({
        url: "/exam/get-question",
        type: "POST",
        data: {'question_exec_id': question_exec_id},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        timeout: 30000,
        success: function (data) {
            $("#blade-question").css("width", "100%");
            $(".explanation-tabs").css("display","none");


            var page_content = data;
            if($.isArray(data)){
                page_content = data[0];
            }

            $("#question-wait").css("display", "none");
            var resulting_html = $("#exam-presentation").html(page_content);

            setFontSize();

            $("#correct").html('');
            $("#exam-presentation").fadeIn();

            $(".button-answer").text('Responder');
            $(".button-answer").css('background-color','#47a447');


            htmlPreHighlight = $("#question").html();
            if (isHighlighting == true){
                $("#highlightBt").css("color","#ffc332");
            }

            is_next = false;
            is_answered = false;
            $("#time").removeClass("time-stop");
            answer_question();
            if($("#time").data("by-question") != "0"){
                if(time_type == "by-question"){
                    timer = parse_time_to_sec($("#time").data("by-question"));
                }else{
                    question_timer = 0;
                }
                is_over = false;
            }

            if(resulting_html != '' &&  $("#question").data('question-answered') == 1 && $("#exam-panel").data("simulation-mode") == 0 ) {
                $(".button-answer").click();
            }

            $("#blade-question").css("width", "100%");
            $(".explanation-tabs").css("display","none");


        },
        error: function(data){
            timeout_handling(this);
        }
    });
}

function return_question(question_exec_id){
    is_answered = true;
    $("#questionContentModal").modal('hide');
    $('body').removeClass('modal-open');
    $('.modal-backdrop').remove();

    save_current_time();
    $(".button-next").addClass('button-answer');
    $(".button-answer").removeClass('button-next');
    $(".button-answer").text('Aguarde...');

    $("#explanation-content").attr('src', '');

    $("#explanation").css("display", "none");

    var next;
    if($("#next").length > 0){
        console.log("De grupo");
        next = $("#next").data("next");
    }else{
        console.log("De questão");
        next = $("#question").data("question-exec");
    }

    var from_result = '';
    if($(this).hasClass("button-from-result")){
        from_result = 't';
        $(this).removeClass("button-from-result");
    }

    $("#exam-presentation").html("");
    $("#question-wait").css("display", "block");

    $.ajax({
        url: "/exam/get-prev-question",
        type: "POST",
        data: {'question': next},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        timeout: 30000,
        success: function (data) {
            var page_content = data;
            if($.isArray(data)){
                page_content = data[0];
            }

            $("#question-wait").css("display", "none");
            var resulting_html = $("#exam-presentation").html(page_content);

            setFontSize();

            $("#correct").html('');
            $("#exam-presentation").fadeIn();

            $("#blade-question").css("width", "100%");

            $(".button-answer").text('Responder');
            $(".button-answer").css('background-color','#47a447');


            htmlPreHighlight = $("#question").html();
            if (isHighlighting == true){
                $("#highlightBt").css("color","#ffc332");
            }

            is_next = false;
            is_answered = false;
            $("#time").removeClass("time-stop");
            answer_question();
            if($("#time").data("by-question") != "0"){
                if(time_type == "by-question"){
                    timer = parse_time_to_sec($("#time").data("by-question"));
                }else{
                    question_timer = 0;
                }
                is_over = false;
            }

            if(resulting_html != '' &&  $("#question").data('question-answered') == 1 && $("#exam-panel").data("simulation-mode") == 0 ) {
                $(".button-answer").click();
            }
        },
        error: function(data){
            timeout_handling(this);
        }
    });
}


function save_current_time(){
    $.ajax({
        url: "/exam/save-current-time",
        type: "POST",
        async : false,
        data: {
            'question': $('#question').data('question-exec'),
            'current-time': $("#time").text(),
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },

        cache: false,
        success: function (data) {
        }
    });
}

function save_question_time(){
    $.ajax({
        url: "/exam/save-question-time",
        type: "POST",
        async : false,
        data: {
            'question': $('#question').data('question-exec'),
            'current-time': $("#crescent-time").text(),
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },

        cache: false,
        success: function (data) {
        }
    });
}





function advance_question(){
    $(".button-next").addClass('button-answer');
    $(".button-answer").removeClass('button-next');
    $(".button-answer").text('Aguarde...');
    $("#divButtonJump").css("display", "none");
    $("#crescent-time").css("display", "none");


    $("#explanation-content").attr('src', '');


    $("#explanation").css("display", "none");

    var next;
    if($("#next").length > 0){
        console.log("De grupo");
        next = $("#next").data("next");
    }else{
        console.log("De questão");
        next = $("#question").data("question-exec");
    }

    var from_result = '';
    if($(this).hasClass("button-from-result")){
        console.log('tem classe');
        from_result = 't';
        $(this).removeClass("button-from-result");
    }

    $("#exam-presentation").html("");
    $("#question-wait").css("display", "block");



    $.ajax({
        url: "/exam/get-next-question-with-answered",
        type: "POST",
        data: {'question': next,

            'from-result': from_result},
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        timeout: 30000,
        success: function (data) {
            var page_content = data;
            if($.isArray(data)){
                page_content = data[0];
            }

            $("#question-wait").css("display", "none");
            $("#exam-presentation").html(page_content);

            setFontSize();

            $("#correct").html('');
            $("#exam-presentation").fadeIn();

            if ($("#results").length > 0) {

                $("#time-space").html('');
                $("#time").html('');


                $("#explanation-result").html(data[1]);
                $("#explanation-result").css("display", "block");
                $("#explanation").css("display", "block");
                $("#explanation-content").attr('src', '');
                $("#explanation .panel-title").html('<strong>Resultados por subtema</strong> ');
                $("#explanation").removeClass('panel-danger');
                $("#explanation").removeClass('panel-success');
                $("#explanation").addClass('panel-info');
                $("#explanation .panel-heading").css('background','#d8eceb');
                $("#explanation .panel-heading").css('border-left','8px solid #253885');
                $("#explanation .panel-heading").css('border-right','8px solid #253885');
                $("#explanation .panel-heading").css('border-bottom','0');
                $("#explanation .panel-heading .panel-title").css('color','#253885');
                $("#toggle-info").css("display","none");

                $("#explanation-teacher").css("display", "none");


                if($("#next").length <= 0) {
                    $(".button-answer").css('display', 'none');
                    $(".button-jump").css('display', 'none');
                    $("#crescent-time").css("display", "block");
                    $("#clock").css('display','none');

                    $("#explanation .panel-title").html('<div class="row"><div id="result-title" class="col-md-8"> <strong>Resultados por tema</strong> </div> <div id="by-flip" class="col-md-4 text-right" style="cursor: pointer;">Por Subtema &nbsp<i class="fa fa-angle-right"></i></div> </div>');
                    $("#explanation-text").html(data[2]);
                    $("#explanation-text").css("display", "block");
                    $("#explanation-result").css("display", "none");
                    $("#explanation-content").css("display", "none");
                    $("#explanation").css("display", "block");
                    var flip =  "theme";

                    $("#by-flip").click(function(){
                        if(flip == "theme"){
                            $("#explanation-text").css("display", "none");
                            $("#explanation-result").css("display", "block");
                            $("#explanation-content").css("display", "block");
                            $("#result-title").html('<strong>RESULTADOS POR SUBTEMA</strong>');
                            $("#by-flip").html('<i class="fa fa-angle-left"></i>&nbsp Por Tema' );
                            flip = "subject";
                        }else{
                            $("#explanation-text").css("display", "block");
                            $("#explanation-result").css("display", "none");
                            $("#explanation-content").css("display", "none");
                            $("#result-title").html('<strong>RESULTADOS POR TEMA</strong>');
                            $("#by-flip").html(' Por Subtema&nbsp<i class="fa fa-angle-right"></i>' )     ;
                            flip = "theme";
                        }
                    });




                    draw_charts();


                }else{
                    console.log('Para adicionar classe');
                    $(".button-answer").addClass('button-next');
                    $(".button-next").addClass("button-from-result");
                    $(".button-next").removeClass('button-answer');
                    $(".button-next").text('Próxima Questão');
                    $(".button-next").css("background-color","#0077b3");

                }
            } else {
                $("#blade-question").css("width", "100%");

                $(".button-answer").text('Responder');
                $(".button-answer").css('background-color','#47a447');

                $("#divButtonJump").css("display", "block");
                $("#crescent-time").css("display", "block");

                htmlPreHighlight = $("#question").html();
                if (isHighlighting == true){
                    $("#highlightBt").css("color","#ffc332");
                }

                is_next = false;
                is_answered = false;
                $("#time").removeClass("time-stop");
                answer_question();
                if($("#time").data("by-question") != "0"){
                    if(time_type == "by-question"){
                        timer = parse_time_to_sec($("#time").data("by-question"));
                    }else{
                        question_timer = 0;
                    }
                    is_over = false;
                }
            }




        },
        error: function(data){
            timeout_handling(this);
        }
    });

}



function result_flip_events(){

    $("#by-subtheme").click(function(){
            $("#explanation-text").css("display", "none");
            $("#explanation-result").css("display", "block");
            $("#explanation-content").css("display", "block");
            $("#explanation-summary").css("display","none");


        var title = "POR SUBTEMA";
        if($("#result-title").data('level') == 1){
            title = "POR TEMA";


        }


            $("#result-title").html('<strong>RESULTADOS '+ title + '</strong>');
        if($("#result-title").data('level') == 1){
            create_mini_right_charts();

            create_mini_previous_charts();
            create_mini_expected_charts();
        }
        //    $("#by-flip").html('<i class="fa fa-object-group"></i>&nbsp Por Tema' );
        });

        $("#by-theme").click(function(){
            $("#explanation-text").css("display", "block");
            $("#explanation-result").css("display", "none");
            $("#explanation-content").css("display", "none");
            $("#explanation-summary").css("display","none");

            var title = "POR TEMA";
            if($("#result-title").data('level') == 1){
                title = "POR DISCIPLINA";
            }

            $("#result-title").html('<strong>RESULTADOS '+ title +'</strong>');
          //  $("#by-flip").html(' Por Subtema&nbsp<i class="fa fa-object-ungroup"></i>' )     ;
        });



    if($(".course-link").length > 0){
        $(".theme-line").not(":has(.fa-thumbs-up)").css('cursor','pointer');
        $(".fa-thumbs-down").siblings('.misplaced-warning').css('display','block');
        $("#scrollToGroup").css('cursor','pointer').click(function(){ $("#result-title").scrollTop(); });
        $(".theme-line").not(":has(.fa-thumbs-up)").addClass('clickable-line');
        $(".theme-line").not(":has(.fa-thumbs-up)").click(function(){
            $.ajax({
                url: "/exam/get-course-suggestion",
                type: "POST",
                timeout: 30000,
                data: {
                    'subject': $(this).data('group-id'),
                    'execution': $("#results-section").data('execution')
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                cache: false,
                success: function (data) {

                    if(data [0] == "redirection") window.location = data[1];
                    else if(data[0] == "suggestion"){
                        $("#suggestionModal").html(data[1]);
                        $("#suggestionModal").modal('toggle');
                    }else{
                        $(this).css('cursor','none');
                    }
                },
                error: function (data) {
                    timeout_handling(this);

                }
            });

        });
    }


    $(".choice-subject").click(function(e){

        console.log($(this).parent().parent());
        $("#theme-menu").text($(this).text());
        $(".p-bj-course").css("opacity","1.0");
        $(".p-bj-course").not(".subject-" + $(this).data("subject-id")).not('.toggled').css("opacity",'0.3');
        //$(".p-bj-course").not(".subject-" + $(this).data("subject-id")).not('.toggled').addClass('toggled');
    });

    $(".modal-explanation").click(function(){
        $("#explanationContentWait").css("display", "block");
        $("#explanationContentDiv").css("display", "none");
        $("#explanationContentDiv").html("");
        $("#explanationModal").modal('toggle');
        $.ajax({
            url: "/exam/question-explanation",
            type: "POST",
            data: {'question': $(this).data('question'), 'execution': $('#results-section').data("execution"),},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function (data) {

                $("#explanationContentDiv").html(data);
                $(".explanation-tabs").css("display","block");
                $("#explanationContentDiv").css("display", "block");
                $("#explanationContentWait").css("display", "none");


                $(".tab-button").click(function(){
                    if($(this).hasClass("tab-question")){
                        $("#explanation-question").css("display", "block");
                        $("#exam-note-info").css("display","none");

                    }else{
                        $("#exam-note-info").css("display","block");
                        $("#exam-note-info").html($(this).data("note") + " <br/>");

                        $("#explanation-question").css("display", "none");

                    }
                    $(".tab-button.active").removeClass("active");
                    $(this).addClass('active');

                });


                $(".button-note").on('click', function () {
                    $(".button-note").text("Salvando...");
                    $.ajax({
                        url: "/exam/save-user-note",
                        type: "POST",
                        timeout: 30000,
                        data: {
                            'question': $('#question_id').val(),
                            'note': $("#questionnote").val()
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        cache: false,
                        success: function (data) {
                            $(".button-note").text("Salvar");
                        },
                        error: function (data) {
                            timeout_handling(this);

                        }
                    });
                });

            }
        });
    });






    $(".summary-line").click(function(){
        if($(this).next().first().hasClass("out")) {
            $(this).next().first().addClass("in");
            $(this).next().first().removeClass("out");
        } else {
            $(this).next().first().addClass("out");
            $(this).next().first().removeClass("in");
        }
    });

    $("#summary").click(function(){
        $("#explanation-text").css("display", "none");
        $("#explanation-result").css("display", "none");
        $("#explanation-content").css("display", "none");
        $("#explanation-summary").css("display","block");
        $("#result-title").html("<strong>GABARITO ANALÍTICO</strong>");
    });
}


function draw_charts(){
    var ctx = document.getElementById("performance-rights-graph").getContext("2d");

    ctx.canvas.width = 150;
    ctx.canvas.height = 150;

    create_right_chart(ctx);

    var ctxTime = document.getElementById("performance-time-graph").getContext("2d");

    ctxTime.canvas.width = 150;
    ctxTime.canvas.height = 150;

    create_time_chart(ctxTime);



    var ctxAvgTime = document.getElementById("performance-average-time-graph").getContext("2d");

    ctxAvgTime.canvas.width = 150;
    ctxAvgTime.canvas.height = 150;

    create_average_time_chart(ctxAvgTime);


    var ctxTotal = document.getElementById("performance-total-graph").getContext("2d");

    ctxTotal.canvas.width = 150;
    ctxTotal.canvas.height = 150;

    create_total_chart(ctxTotal);



}

function setFontSize(){
    $("#question").css("fontSize", fontSizeQuestion + "rem");
    $("#options").css("fontSize", fontSizeQuestion + "rem");

    $(".increase_font").click(function(e) {
        e.preventDefault();
        if (fontSizeQuestion < 2.4) {
            fontSizeQuestion = fontSizeQuestion + 0.2;
        }

        $("#question").css("fontSize", fontSizeQuestion + "rem");
        $("#options").css("fontSize", fontSizeQuestion + "rem");
    });

    $(".reduce_font").click(function(e) {
        e.preventDefault();
        if (fontSizeQuestion > 1.4) {
            fontSizeQuestion = fontSizeQuestion - 0.2;
        }

        $("#question").css("fontSize", fontSizeQuestion + "rem");
        $("#options").css("fontSize", fontSizeQuestion + "rem");

    });


}

function menuIntro(divToShow){
    $("#info_exam").css('display','none');
    $("#mandatory_read_exam").css('display','none');
    $("#360_exam").css('display','none');
    $("#extra_reading_exam").css('display','none');

    $("#" + divToShow).css('display','block');
}



/*

 highlight v5

 Highlights arbitrary terms.

 <http://johannburkard.de/blog/programming/javascript/highlight-javascript-text-higlighting-jquery-plugin.html>

 MIT license.

 Johann Burkard
 <http://johannburkard.de>
 <mailto:jb@eaio.com>

 */

jQuery.fn.highlight = function(pat) {
    function innerHighlight(node, pat) {
        var skip = 0;
        if (node.nodeType == 3) {
            var pos = node.data.toUpperCase().indexOf(pat);
            pos -= (node.data.substr(0, pos).toUpperCase().length - node.data.substr(0, pos).length);
            if (pos >= 0) {
                var spannode = document.createElement('span');
                spannode.className = "fhighlight_" + isHighlighting;
                var middlebit = node.splitText(pos);
                var endbit = middlebit.splitText(pat.length);
                var middleclone = middlebit.cloneNode(true);
                spannode.appendChild(middleclone);
                middlebit.parentNode.replaceChild(spannode, middlebit);
                skip = 1;
            }
        }
        else if (node.nodeType == 1 && node.childNodes && !/(script|style)/i.test(node.tagName)) {
            for (var i = 0; i < node.childNodes.length; ++i) {
                i += innerHighlight(node.childNodes[i], pat);
            }
        }
        return skip;
    }
    return this.length && pat && pat.length ? this.each(function() {
        innerHighlight(this, pat.toUpperCase());
    }) : this;
};

//jQuery.fn.removeHighlight = function() {
//    return this.find("span.fhighlight").each(function() {
//        this.parentNode.firstChild.nodeName;
//        alert(this.parentNode.firstChild.nodeName);
//        with (this.parentNode) {
//            replaceChild(this.firstChild, this);
//            normalize();
//        }
//    }).end();
//};

jQuery.fn.removeHighlight = function() {

}


function activeHighlightRed(){
    if (isHighlighting == 'R') {
        $("#highlightBtRed").html("&nbsp;");
        isHighlighting = '';
    } else {
        isHighlighting = 'R';
        $("#highlightBtYellow").html("&nbsp;");
        $("#highlightBtBlue").html("&nbsp;");
        $("#highlightBtRed").html("<i class='fa fa-close'> </i>");
    }
}

function activeHighlightBlue(){
    if (isHighlighting == 'B') {
        $("#highlightBtBlue").html("&nbsp;");
        isHighlighting = '';
    } else {
        isHighlighting = 'B';
        $("#highlightBtYellow").html("&nbsp;");
        $("#highlightBtBlue").html("<i class='fa fa-close'> </i>");
        $("#highlightBtRed").html("&nbsp;");
    }
}

function activeHighlightYellow(){
    if (isHighlighting == 'B') {
        $("#highlightBtYellow").html("&nbsp;");
        isHighlighting = '';
    } else {
        isHighlighting = 'Y';
        $("#highlightBtYellow").html("<i class='fa fa-close'> </i>");
        $("#highlightBtBlue").html("&nbsp;");
        $("#highlightBtRed").html("&nbsp;");
    }
}


function cleanHighlight() {
    isHighlighting = '';
    $("#highlightBtYellow").html("&nbsp;");
    $("#highlightBtBlue").html("&nbsp;");
    $("#highlightBtRed").html("&nbsp;");
    var sel = "";
    if ($("#options").find('input:checked').length > 0) {
        var sel = $("#options").find('input:checked').val().toString();
    }
    $("#question").html(htmlPreHighlight);
    if (sel != ""){
        $("#checkbox" + sel).attr("checked", true);
    }
    applyHighlightCapture();
}

if(!window.bj){
    bj = {};
}
bj.Selector = {};
bj.Selector.getSelected = function(){
    var t = '';
    if(window.getSelection){
        t = window.getSelection();
    }else if(document.getSelection){
        t = document.getSelection();
    }else if(document.selection){
        t = document.selection.createRange().text;
    }
    return t;
}

bj.Selector.mouseup = function(){
    var st = bj.Selector.getSelected();
    if (((st + '').trim()!='') && (isHighlighting != '')){
        $('#' + highlightId).highlight(st + '');
    }
}



function showQuestionNote( question_id, note, noteTitle){

    $("#questionContentLabel").html( noteTitle );

    $("#questionContentDiv").html('');
    $("#questionContentModal").modal('toggle');
    $("#questionContentWait").css("display", "block");

    $("#questionContentDiv").html();
    $.ajax({
        url: "/exam/question-note",
        type: "POST",
        data: {
            question: question_id,
            note: note,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function (html) {
            $("#questionContentWait").css("display", "none");

            if (html.trim() === '') html = 'Não existe informação para este item.';

            $("#questionContentDiv").html(html);
        }
    });
}

function setNoteToQuestionContent(){

    $(".question-attributes").css("display","none");
    $(".explanation-tabs").css("display","flex");





    $(".tab-button").click(function(){
        if($(this).hasClass("tab-question")){
            $("#panel-question").children().css("display", "block");
            $("#exam-table-info").css("display","none");
        }else{
            $("#exam-table-info").html('<table class="table mb-none"><tbody><tr><td>' + $(this).data("note") + '</td></tr></tbody></table>');
            $("#panel-question").children().css("display", "none");
            $("#exam-table-info").css("display","block");
        }
        $(".tab-button.active").removeClass("active");
        $(this).addClass('active');
        // if (html.trim() === '') html = 'Não existe informação para este item.';


    });


}


function showQuestionsNotAnswered( execution_id ){

    $("#questionContentLabel").html( '<strong>Índice de Questões</strong>' );

    $("#questionContentDiv").html('');
    $("#questionContentModal").modal('toggle');
    $("#questionContentWait").css("display", "block");

    $("#questionContentDiv").html();
    $.ajax({
        url: "/exam/questions-not-answered",
        type: "POST",
        data: {
            execution: execution_id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function (html) {
            $("#questionContentWait").css("display", "none");

            if (html.trim() === '') html = 'Todas as questões já foram respondidas.';

            $("#questionContentDiv").html(html);


        }
    });
}


function add_to_cart_event_handler(){
    console.log("event added");
    $(".add-to-cart").click(function(){
    $.ajax({
        url: "/exam/add-item",
        type: "POST",
        data: {
            item: $(this).data("item"),
            type: $(this).data("type")
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function (data) {
            $("#cart-count").text(data["count"] + " itens");
            $("#cart-price").css("display","inline-flex");
            console.log(data);
            $("#cart-price").text("R$ " + data["total"]);
            $("#cart-discount").css("display","inline-flex");
            console.log(data);
            $("#cart-discount").text("Desconto de R$ " + data["discount"]);
        }
    });
    });
}



function showAskTheTeacher( question_id, teacherName) {
    $("#askTheTeacherContentLabel").html("Tira dúvida");
    if (teacherName != '') $("#askTheTeacherContentLabel").html("Tira dúvida com o professor <strong>" + teacherName + "</strong>");
    $("#askTheTeacher_question_id").val(question_id);
    $("#askTheTeacherContentModal").modal('toggle');
}

function showExamNote( exam_id, note, noteTitle){

    $("#examContentLabel").html( noteTitle );

    $("#examContentDiv").html('');
    $("#examContentDiv").html('');
    $("#examContentModal").modal('toggle');
    $("#examContentWait").css("display", "block");

    $("#examContentDiv").html();
    $.ajax({
        url: "/exam/exam-note",
        type: "POST",
        data: {
            exam: exam_id,
            note: note,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function (html) {
            $("#examContentWait").css("display", "none");

            if (html.trim() === '') html = 'Não existe informação para este item.';

            $("#examContentDiv").html(html);
        }
    });
}

function applyHighlightCapture(){
    $(".question_div").mousedown(function() {
        highlightId = $(this).attr("id");
    });
}


function clickQuestionButton(){
    $(".button-next").css("display", "block");
    $(".button-answer").css("display", "block");
    $("#divButtonJump").css("display", "block");
    $("#btnTabQuestion").html("<strong><i class='fa fa-pencil-square-o'></i> Questão</strong>");
}

function clickNoteButton(){
    $(".button-next").css("display", "none");
    $(".button-answer").css("display", "none");
    $("#divButtonJump").css("display", "none");
    $("#btnTabQuestion").html("<strong><i class='fa fa-pencil-square-o'></i> Voltar para<br> a questão</strong>");
}

