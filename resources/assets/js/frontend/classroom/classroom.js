var progress = [];
var progress_changed = false;
var view_id;
var view_count = null;
var view_like_content;
var view_like_teaching;
var view_max;
var block_changing = false;
var is_set = false;
var is_rated = false;
var watched_time = 0;
var is_watching = false;
var current_content = 0;
var once = 0;
var watched_time_interval = undefined;
var view_progress_interval = undefined;
var ready = 0;


$("#show-menu-header").on('click', function () {
    $("#menu-dashboard").slideToggle(500);
});

function block_change() {
    $(".block").not('#classroomExamButton').on('click', function () {
        $(".block.active").removeClass("active");
        $(this).addClass("active");
    });
    /*  $(".block").on('click',function(){
     
     
     
     ready  = 0;
     $(".block.active").removeClass("active");
     $(this).addClass("active");
     $("#show-view").html("Carregando...");
     progress = [];
     progress_changed = false;
     
     var lesson_id = $("[name='lesson-content']").data("lesson");
     var target_block = $(this).data("block");
     
     var current_selected_progress = $(".lesson-progress .label.active");
     current_selected_progress.tooltip('hide');
     current_selected_progress.siblings(":nth-of-type(" + target_block + ")").addClass("active").tooltip({title: "Ativo"});
     current_selected_progress.removeClass("active");
     
     
     $("[name='lesson-content']").hide();
     
     
     $.ajax({
     url: "/classroom/get-video-block",
     type: "POST",
     data: {lesson: lesson_id,
     block: target_block},
     ifModified: true,
     headers: {
     'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
     },
     cache: false,
     success: function(data){
     if(watched_time != 0){
     save_watched_time();
     }
     
     
     var obj = JSON.parse(data);
     //console.log(obj);
     $("[name='lesson-content']").attr('data-content',obj.id);
     $("[name='lesson-content']").data('content',obj.id);
     
     $("[name='lesson-content']").attr('src',obj.url);
     
     
     }
     });
     
     
     
     });
     
     */
}


var normalized = false;

$(document).ready(function () {
    if ($("[name='lesson-content']").length > 0) {
        block_change();

        vimeo_events();
        content_tree_events();

        $('.lesson-progress .label.active').tooltip();
    }

    if ($("[id='ticket-count-mail']").length > 0) {
        $('#ticket-count-mail').html($('.li-mail').length);
        $('#ticket-count-mail-finished').html($('.li-finished').length);
        $('#ticket-count-mail-replied').html($('.li-replied').length);
        $('#ticket-count-mail-not-replied').html($('.li-not-replied').length);
    }

    $("#clickSaap").click(function () {
        $("#classroomExamButton").click();
    });


    if ($("#welcomeModal").length > 0) {
        $("#welcomeModal").modal('toggle');
    }


    if ($('#question-lesson-filter').length > 0) {
        $("#question-lesson-filter").change(function () {
            var target_lesson = ".lesson-" + this.value;
            $(".post").css("display", 'none');
            $(target_lesson).css('display', 'flex');

        });
    }

    if ($(".parent-pill").length > 0 && normalized == false) {



        $(window).resize(normalize_cards(".course-pill"));

        var default_tab = $("#tabs-section").data('default');
        if(default_tab != '0'){

            default_tab = '#' + default_tab;
            $(default_tab + ' a').tab('show');
        };

        $(".course-pill").click(function () {
            $('html, body').animate({
                scrollTop: $("#tabs-content").offset().top - 150
            }, 500);
        });
    }

});



function with_view(callback) {

    var view = $("#actual-content").data('view');


    if (view != null && view != undefined && view.id != null && view.id != undefined) {
        view_id = view.id;
        view_count = view.view;
        view_like_content = view.like_content;
        view_like_teaching = view.like_teaching;
        view_max = view.max_view;
        if (view.state != null) {
            progress = view.state.split(",").map(Number);

            $(".lesson-progress .label").tooltip();
            window.setTimeout(function () {
                if (view_count > 0) {
                    var view_title_name = "visualização";
                    if (view_count > 1)
                        view_title_name = "visualizações";

                    $(".lesson-progress .label.active").attr('title', view_count + " " + view_title_name).tooltip('fixTitle').tooltip();
                } else {
                    $(".lesson-progress .label.active").attr('title', (progress.length % 100) + "% assistido").tooltip('fixTitle').tooltip();
                }
            }, 1000);
        }

        callback();


    } else if (current_content == $("[name='lesson-content']").data('content')) {
        callback();
    } else {
        current_content = $("[name='lesson-content']").data('content');
        $.ajax({
            url: "/classroom/get-view",
            type: "POST",
            data: {
                enrollment: $("[name='lesson-content']").data('enrollment'),
                content: $("[name='lesson-content']").data('content')
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function (view) {


                console.log('view successfuly acquired: ' + view.id);
                if (!view.content_id == $("[name='lesson-content']").data('content'))
                    console.log('difference');
                view_id = view.id;
                view_count = view.view;
                view_like_content = view.like_content;
                view_like_teaching = view.like_teaching;
                view_max = view.max_view;
                if (view.state != null) {
                    progress = view.state.split(",").map(Number);

                    $(".lesson-progress .label").tooltip();
                    window.setTimeout(function () {
                        if (view_count > 0) {
                            var view_title_name = "visualização";
                            if (view_count > 1)
                                view_title_name = "visualizações";

                            $(".lesson-progress .label.active").attr('title', view_count + " " + view_title_name).tooltip('fixTitle').tooltip();
                        } else {
                            $(".lesson-progress .label.active").attr('title', (progress.length % 100) + "% assistido").tooltip('fixTitle').tooltip();
                        }
                    }, 1000);
                }

                callback();

            },
            error: function () {
                timeout_handling(this);
            }


        });
    }
}




function vimeo_events() {

    with_view(function () {
        //load_comments($("[name='lesson-content']").data('content'));

        var enrollment_id = $("[name='lesson-content']").data('enrollment');
        var content_id = $("[name='lesson-content']").data('content');

        if ($("[name='lesson-content']").attr('src') == '' && once == 0) {
            $("[name='lesson-content']").attr('src', $("[name='lesson-content']").data('url'));
            once = 1;
        }


        if ($("#actual-content").data('lesson-exam') == true || $("#actual-content").attr("data-lesson-exam") == true) {
            open_classroom_exam();
        }


        $("[name='lesson-content']").load(function () {
            $(this).slideDown();
            $("#note-panel").scroll();

            var iframe = $("[name='lesson-content']")[0];
            var player = new Vimeo.Player(iframe);

            var starting_time;
            is_set = false;



            if (ready == 0) {
                ready = 1;
                console.log('ready');
                $("#exceeded").html('');

                //console.log('aqui');
                block_changing = false;
                player.on('timeupdate', onPlayProgress);
                player.on('pause', onPause);
                player.on('play', onPlay);
                //console.log('depois');

                load_notes($("[name='lesson-content']").data('content'));

                function onPlayProgress(data, id) {
                    if (view_count >= view_max) {
                        player.unload().then(function () {
                            $("#exceeded").html("<i class='fa fa-hand-stop-o' style='color:red'></i>&nbsp;<b>Você excedeu o limite de visualizações para essa aula</b>");
                        }).catch(function (error) {
                            $("[name='lesson-content']").html('O número máximo de visualizações para esse vídeo foi excedido');
                        });
                    }

                    var item = $("[data-time='" + Math.floor(data.seconds) + "']");

                    if (item.length) {
                        item.css('background-color', '#F5F3C9');
                        // $('#note-panel').animate({scrollTop: item.first().position().top});
                    }
                    //console.log(data.percent);
                    var percentual = (Math.floor(data.percent * 100) + (100 * view_count));
                    if (progress.indexOf(percentual) == -1 && !isNaN(percentual) && percentual % 100 != 0) {
                        //console.log(progress);
                        progress.push(percentual);
                        progress_changed = true;


                        if (view_count == 0) {
                            $(".lesson-progress .label.active").attr('title', (progress.length % 100) + "% assistido").tooltip('fixTitle').tooltip('show');

                        }
                    }


                    if (percentual == (100 + (100 * view_count)) && block_changing == false) {
                        block_changing = true;

                        if ($(".block.active").next().length == 0)
                            window.location = $(".lesson-list.active").next().find('a').first().attr('href');
                        else
                            window.location = $(".block.active").next().attr('href');

                    }


                    //Descomentar apenas em caso de teste
                    /*
                     if(data.seconds > 60 && test == true){
                     test = false;
                     alert(progress.toStri  ng());
                     }
                     */


                }


                is_rated = false;

                with_view(function (id, count, max) {

                    if (watched_time_interval != 0)
                        window.clearInterval(watched_time_interval);


                    view_progress_interval = setInterval(function () {
                        save_state(enrollment_id);
                    }, 30000);
                    watched_time_interval = setInterval(function () {
                        if (is_watching === true) {
                            watched_time = +watched_time + 1;
                            //console.log(watched_time);
                        }
                    }, 1000);


                    load_view_info(count, max);
                    goto_last_spot(player);
                    like();
                    rate(enrollment_id);


                    $(window).on('beforeunload', function () {
                        save_watched_time();
                    });
                });


                $("#text-todo").off('keypress').on('keypress', function (e) {
                    if (e.which == 13)
                        $("#add-todo").click();
                });


                $("#add-todo").click(function () {
                    player.getCurrentTime().then(function (value) {
                        if (is_set == false) {
                            is_set = true;
                            var val = $("#text-todo").val();
                            var actual_time = value;

                            console.log(actual_time);
                            console.log(val);

                            save_notes(actual_time, val, $("[name='lesson-content']").data('content'));


                            $("#text-todo").val('');
                        }
                    });

                });


            }


        });
    });

    $(".btn_ticket_send").on('click', function () {
        $("#ticket_return").html('');
        if ($("#ticket_message").val() == '') {
            $("#ticket_return").html('É necessário informar a mensagem.');
            return;
        }
        $(".btn_ticket_send").text("Enviando...");
        $.ajax({
            url: "/classroom/open-ticket",
            type: "POST",
            data: {
                'sector_id': $('#ticket_sector_id').val(),
                'content_id': $('#ticket_content_id').val(),
                'enrollment_id': $("#ticket_enrollment_id").val(),
                'message': $("#ticket_message").val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function (data) {
                $(".btn_ticket_send").text("Enviar");
                if (data.trim() === '1') {
                    $("#ticket_return").html('Mensagem enviada com sucesso! Acompanhe na seção Fale Conosco');
                    $("#ticket_message").val("");
                } else {
                    $("#ticket_return").html('Ocorreu um erro ao enviar a sua mensagem!');
                }
            },
            error: function (data) {
                $("#ticket_return").html('Ocorreu um erro ao enviar a sua mensagem!');
            }
        });
    });

}

function onPause(data, id) {
    console.log('paused');
    is_watching = false;
    save_watched_time();
}

function onPlay(data, id) {
    is_watching = true;
}


function goto_last_spot(player) {


    if (progress != null && progress.length > 3) {
        var duration = player.getDuration().then(function (value)
        {
            console.log("duration" + value);
            var final_percentage = progress[progress.length - 1];
            console.log(final_percentage);
            var second_seek = Math.floor((value * (final_percentage - (100 * view_count))) / 100);
            // if(second_seek > 20){
            //    second_seek = second_seek - 20;
            // }
            console.log('Segundo: ' + second_seek);
            player.setCurrentTime(second_seek).then(function (seconds) {
                // seconds = the actual time that the player seeked to
            }).catch(function (error) {
                switch (error.name) {
                    case 'RangeError':
                        console.log('Alcance fora do comprimento do vídeo');
                        break;

                    default:

                        console.log('Um erro inesperado aconteceu: ' + error.name);
                        break;
                }
            });


        }).catch(function (error) {
            console.log(error.name);
            player.play();

        });



    }
}


function rate(enrollment_id) {

    $.ajax({
        url: "/classroom/needs-rating",
        type: "POST",
        data: {
            enrollment: enrollment_id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function (needs) {
            //console.log("need" + needs);

            if (needs == 'true' && is_rated == false) {
                //  console.log("open it");
                rating_hover_events();
                rating_click_event();
                $("#ratingModal").modal('toggle');
                is_rated = true;
            }


        }


    });
}


function save_notes(starting_time, note, content) {
    $.ajax({
        url: "/classroom/save-notes",
        type: "POST",
        data: {
            'starting_time': starting_time,
            'note': note,
            'content': content
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        success: function (data) {
            load_notes($("[name='lesson-content']").data('content'));
            // $("#user-note").after('<div class="panel-body" style="border-style: solid; border-width: 1px; border-radius: 5px; background-color: white;">' + minutes  + ":" + seconds + " -> "  + mensagem + '</div>');



        }


    });
}

function remove_notes(note_id) {
    $.ajax({
        url: "/classroom/remove-notes",
        type: "POST",
        data: {
            'note': note_id,
        },
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function (data) {
            load_notes($("[name='lesson-content']").data('content'));



        }


    });
}



function publish_comments() {

}

function load_comments(content_id) {


    $('#comments-content').comments({
        profilePictureURL: 'https://app.viima.com/static/media/user_profiles/user-icon.png',
        newestText: 'Recentes',
        oldestText: 'Velhos',
        sendText: 'Enviar',
        noCommentsText: 'Ainda não há nenhum comentário',
        textareaPlaceholderText: 'Deixe um comentário',
        enableUpvoting: false,
        enableReplying: false,
        enableEditing: false,
        youText: 'Você',
        getComments: function (success, error) {
            console.log('Loading comments...');
            var comments = [];

            $.ajax({
                url: "/classroom/get-video-comments",
                type: "POST",
                data: {
                    content: content_id,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                cache: false,
                success: function (data) {
                    try {
                        response = JSON.parse(data);

                        $.each(response, function (i, value) {


                            var match = value.created_at.match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/);
                            var date = new Date(match[1], match[2] - 1, match[3], match[4], match[5], match[6]);

                            var matchUpdate = value.updated_at.match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/);
                            var dateUpdate = new Date(matchUpdate[1], matchUpdate[2] - 1, matchUpdate[3], matchUpdate[4], matchUpdate[5], matchUpdate[6]);



                            var photo_url = value.photo != null ? value.photo : "";
                            var photo = image_url('users', value.user_id, photo_url);

                            var fields =
                                    {
                                        id: value.id,
                                        created: date.toISOString(),
                                        modified: dateUpdate.toISOString(),
                                        content: value.comment,
                                        fullname: value.user_name,
                                        profile_picture_url: photo, //'/img/system/generic_size50.png',
                                        createdByCurrentUser: true
                                    };

                            comments.push(fields);


                        });

                        success(comments);

                    } catch (e) {
                        console.log('Data is not a json');
                    }
                },
            });


        },
        postComment: function (commentJSON, success, error) {
            $.ajax({
                type: 'GET',
                url: '/classroomx/post-video-comment/',
                data: {
                    content: content_id,
                    comment: commentJSON,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function (comment) {
                    console.log('Registering comment...');
                    // console.log(comment);
                    success(comment);
                },
                error: error
            });
        }
    });

    /*
     $.ajax({
     url: "/classroom/get-lesson-comments",
     type: "POST",
     data: {
     content: lesson_id,
     
     },
     headers: {
     'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
     },
     cache: false,
     success: function(data){
     response = JSON.parse(data);
     $('#note-panel').html('');
     $.each(response, function(i,value){
     
     
     $("#note-panel").append('<div class="panel-body" style="border-style: solid; border-width: 1px; border-radius: 5px; background-color: white;" data-time="'+ value.video_index_seconds +'">' +  value.video_index_seconds.toString() + " -> "  + value.note + '</div>');
     
     
     });
     }
     
     }); */
}


function load_notes(content_id) {

    $.ajax({
        url: "/classroom/get-video-notes",
        type: "POST",
        data: {
            content: content_id,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        success: function (data) {
            console.log("Loading notes...");
            is_set = false;


            response = JSON.parse(data);
            $('#note-panel').html('');
            $.each(response, function (i, value) {

                console.log(value);

                var minutes = Math.floor(value.video_index_seconds / 60);
                var seconds = Math.floor(value.video_index_seconds - (minutes * 60));



                $("#note-panel").append('<li><div> <label class="todo-label" style="margin-left:14px" for="todoListItem2"><strong>' + ("0" + minutes).slice(-2) + ':' + ("0" + seconds).slice(-2) + '</strong> | <span>' + value.note + '</span></label> </div> <div class="todo-actions"> <a class="todo-remove exclude-note" data-note-id="' + value.id + '" href="#"> <i class="fa fa-times"></i> </a> </div> </li>');

            });

            $(".exclude-note").click(function () {
                var note_id = $(this).data('note-id');
                remove_notes(note_id);
            });

            $("#note-panel").animate({scrollTop: $('#note-panel').prop("scrollHeight")}, 1000);
        }

    });

}

function load_view_info() {
    console.log(view_count + ' ' + view_max + ' views');
    console.log('loading view info...');
    if (view_count >= view_max) {
        $("#show-view").html("<span style='color:red;'>nenhuma restante</span>");
        //$("#current-view").html("<b style='color:red;'>" + view_max + "</b>");
        //$("#max-view").html("<b style='color:red;'>" + view_max + "</b>");
    } else {
        console.log(view_count);
        var available = +view_max - +view_count;
        $("#show-view").html(+available + " restante" + (available != 1 ? "s" : ""));
        //$("#current-view").html(+view_count +1);
        //$("#max-view").html(view_max);
    }
    switch_like(view_like_content, 'content');
    switch_like(view_like_teaching, 'teaching');

}

function switch_like(up_down, criteria) {
    console.log(up_down);
    if (up_down == 1) {
        if ($("#thumbs-up-" + criteria).hasClass('fa-thumbs-o-up')) {
            $("#thumbs-up-" + criteria).removeClass('fa-thumbs-o-up');
            $("#thumbs-up-" + criteria).addClass('fa-thumbs-up');
            $("#thumbs-down-" + criteria).removeClass('fa-thumbs-down');
            $("#thumbs-down-" + criteria).addClass('fa-thumbs-o-down');
        }
    } else if (up_down == -1) {
        if ($("#thumbs-down-" + criteria).hasClass('fa-thumbs-o-down')) {
            $("#thumbs-down-" + criteria).removeClass('fa-thumbs-o-down');
            $("#thumbs-down-" + criteria).addClass('fa-thumbs-down');
            $("#thumbs-up-" + criteria).removeClass('fa-thumbs-up');
            $("#thumbs-up-" + criteria).addClass('fa-thumbs-o-up');
        }
    } else {
        $("#thumbs-up-" + criteria).removeClass('fa-thumbs-up');
        $("#thumbs-up-" + criteria).addClass('fa-thumbs-o-up');
        $("#thumbs-down-" + criteria).removeClass('fa-thumbs-down');
        $("#thumbs-down-" + criteria).addClass('fa-thumbs-o-down');
    }

}

function like() {
    $("#thumbs-up-content").on('click', function () {
        view_like_content = 1;
        save_like(view_like_content, 'content');
    });
    $("#thumbs-down-content").on('click', function () {
        view_like_content = -1;
        save_like(view_like_content, 'content');
    });
    $("#thumbs-up-teaching").on('click', function () {
        view_like_teaching = 1;
        save_like(view_like_teaching, 'teaching');
    });
    $("#thumbs-down-teaching").on('click', function () {
        view_like_teaching = -1;
        save_like(view_like_teaching, 'teaching');
    });



}

function save_like(up_down, criteria) {
    $.ajax({
        url: '/classroom/save-like',
        type: 'POST',
        data: {
            view: view_id,
            up_down: up_down,
            criteria: criteria
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        success: function (data) {
            switch_like(up_down, criteria);
        }

    });
}


var test = true;





function content_tree_events() {
    $("#treeBasic").on("activate_node.jstree", function (e) {
        e.preventDefault();//stop the browser from following
        window.open($(this).find(".jstree-clicked").attr('href'), '_blank');
    });

}


function save_state(enrollment_id) {
    if ((progress.length == 1 && progress[0] % 100 == 0)) {
        progress[0] = 0;
    }
    if (progress_changed) {
        var content_id = $("[name='lesson-content']").data('content');
        if (content_id == undefined || content_id == null || content_id == '') {
            content_id = $("[name='lesson-content']").attr('data-content');
        }


        $.ajax({
            url: "/classroom/save-state",
            type: "POST",
            data: {
                state: insertion_sort(progress).toString(),
                percentual: progress.length,
                content: content_id,
                enrollment: enrollment_id,
                count: view_count

            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function (data) {
                console.log('Saving...');
                progress_changed = false;
                return true;
            },
            error: function () {
                console.log('enrollment_id:' + enrollment_id + ' content: ' + $("[name='lesson-content']").data('content'));
            }
        });

    }
}

function save_watched_time() {
    $.ajax({
        url: "/classroom/save-watched-time",
        type: "POST",
        async: false,
        data: {
            'watched_time': watched_time,
            'content': $("[name='lesson-content']").data('content'),
            'enrollment': $("[name='lesson-content']").data('enrollment'),
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        success: function (data) {
            watched_time = 0;
        },
        error: function () {
        }
    });


}

$('#treeBasic').jstree({
    'core': {
        'themes': {
            'responsive': false
        }
    },
    'types': {
        'default': {
            'icon': 'fa fa-folder'
        },
        'file': {
            'icon': 'fa fa-file'
        }
    },
    'plugins': ['types']
});
$(".panel").on("show.bs.collapse hide.bs.collapse", function (e) {
    if (e.type == 'show') {
        $(this).find('.panel-heading').addClass('active');
    } else {
        $(this).find('.panel-heading').removeClass('active');
    }
});
$(".row-classroom").owlCarousel({
    items: 2,
    itemsMobile: [479, 2],
    navigationText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
    navigation: false,
    pagination: true
});

$("#nav-classroom").hover(function () {
    $(this).animate({opacity: 1}, 500);
}, function () {
    $(this).animate({opacity: 0.6}, 500);
});


function openCourseModal(course_id, title, url) {

    $("#courseContentLabel").html(title);
    $("#courseContentDiv").html('');
    $("#courseContentModal").modal('toggle');
    $("#courseContentWait").css("display", "block");
    $.ajax({
        url: url,
        type: "POST",
        data: {
            course: course_id
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function (html) {
            $("#courseContentWait").css("display", "none");
            $("#courseContentDiv").html(html);
        }
    });
}

function courseContent(course_id) {
    openCourseModal(course_id, '<strong>Conteúdo programático</strong>', "/classroom/course-content");
}

function courseTerms(course_id) {
    openCourseModal(course_id, '<strong>Termos de uso</strong>', "/classroom/course-terms");
}

function courseAlerts(course_id) {
    openCourseModal(course_id, '<strong>Quadro de Avisos</strong>', "/classroom/course-alerts");
}

function courseCalendar(course_id) {
    openCourseModal(course_id, '<strong>Calendário</strong>', "/classroom/course-calendar");
}

function courseModules(course_id) {
    openCourseModal(course_id, '<strong>Disciplinas</strong>', "/classroom/course-modules");
}

$(".button-askTheTeacherClassroom").on('click', function () {
    $(".button-askTheTeacherClassroom").text("Enviando...");
    $.ajax({
        url: "/classroom/save-ask-the-teacher",
        type: "POST",
        data: {
            'lesson_id': $('#askTheTeacher_lesson_id').val(),
            'question': $("#questionAskTheTeacher").val()
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        success: function (data) {
            if (data.trim() === '1') {
                $("#questionAskTheTeacher").val('');
                $(".button-askTheTeacherClassroom").text("Enviar");
                $("#asktheteacher_return").html('Mensagem enviada com sucesso! Acompanhe na seção Minhas Duvidas');
            } else {
                $("#asktheteacher_return").html('Ocorreu um erro ao enviar a sua mensagem!');
            }

        },
        error: function (data) {
            $("#asktheteacher_return").html('Ocorreu um erro ao enviar a sua mensagem!');
        }
    });
});

$(document).ready(function () {
    $(".planstudy_hours").TouchSpin({
        min: 1,
        max: 24,
        step: 1,
        decimals: 0,
        postfix: 'horas'
    });

    handleCounterup(); // handle counterup instances
});

// Handles counterup plugin wrapper
var handleCounterup = function () {
    if (!$().counterUp) {
        return;
    }

    $("[data-counter='counterup']").counterUp({
        delay: 10,
        time: 1000
    });
};



function open_classroom_exam(player) {
    $("#classroomExamButton").click(function () {

        console.log('success entering here');

        $.ajax({
            url: "/classroom/classroom-exam",
            type: "POST",
            data: {
                'lesson': $("[name='lesson-content']").data('lesson'),
                'enrollment': $("[name='lesson-content']").data('enrollment')
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function (data) {

                $("#classroom-modal-main-container").html(data);

                $("#classroomExamModal").modal('toggle');


                init();

                $("#questionContentModal").off('hidden.bs.modal').on('hidden.bs.modal', function () {
                    $("body").addClass('modal-open');
                });

                $("#abandonModal").off('shown.bs.modal').on("shown.bs.modal", function () {
                    $("#continue-exam").off('click').click(function () {



                        $("#abandonModal").modal('hide');
                        $("#abandonModal").off('hidden.bs.modal').on('hidden.bs.modal', function () {
                            $("body").addClass('modal-open');
                        });
                    });


                    $("#finish-exam").off('click').click(function () {
                        $("#abandonModal").modal('hide');
                        $("#abandonModal").off('hidden.bs.modal').on('hidden.bs.modal', function () {
                            $.ajax({
                                url: "/exam/finish-exam",
                                type: "POST",
                                data: {
                                    'lesson': $("[name='lesson-content']").data('lesson'),
                                    'enrollment': $("[name='lesson-content']").data('enrollment'),
                                    'execution': $("#exam-panel").data('execution-id'),
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                },
                                cache: false,
                                success: function (data) {
                                    is_next = true;
                                    prepare_for_next();
                                    $("#confirmation").click();
                                    $("body").addClass('modal-open');

                                }
                            });

                        });
                    });

                });

                $('#classroomExamModal').off('shown.bs.modal').on("shown.bs.modal", function () {




                    $('#classroomExamModal').data('bs.modal').handleUpdate();





                    if ($("#panel-summary").length > 0) {
                        console.log('summary');
                        $("#exam-modal-header #modal-title").css('display', 'none');
                        //parse_explanation(player);



                        create_classroom_right_chart("#class-exam-percentage");
                        explanation_modal_events();

                        $("#explanationModal").off('hidden.bs.modal').on('hidden.bs.modal', function () {
                            $("body").addClass('modal-open');
                            $("#explanationContentDiv").html('');

                        });

                        $("#a")
                    }
                });

            },
            error: function (data) {
                $("#asktheteacher_return").html('Ocorreu um erro ao enviar a sua mensagem!');
            }
        });




    });

}





function classroom_exam() {
    $("#question").on('hover', function () {

    });
}


function parse_explanation(player) {
    $(".explanation-text").each(function () {
        var explanation_text = $(this).text();

        var index = explanation_text.indexOf('<seekto>');
        index += 8;

        var point = explanation_text.substring(index);

        $(this).next('.explanation-point').text('Clique aqui para revisar no vídeo');

        $(this).text(explanation_text.substring(0, index));


        $(this).next('.explanation-point').click(function () {
            $("#classroomExamModal").modal('toggle');
            seek_to_spot(player, point);
        });

    });
}

function seek_to_spot(player, time) {


    var second_seek = parse_time_to_sec(time);

    player.api('seekTo', second_seek);


}



function normalize_cards(selector) {

    var heights = $(selector).map(function ()
    {
        return $(this).height();
    }).get();
    var maxHeight = Math.max.apply(null, heights);
    console.log(maxHeight);
    $(selector).css('height', maxHeight * 1.6);
}