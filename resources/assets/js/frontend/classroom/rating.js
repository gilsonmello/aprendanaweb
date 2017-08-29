/**
 * Created by ambiente on 20/06/16.
 */

function rating_hover_events(){
    $(".rate-star").not('.voted').hover(function(){
        if(!$(this).hasClass('voted')){
            $(this).removeClass("fa-star-o");
            $(this).prevAll('.rate-star').removeClass('fa-star-o');
            $(this).nextAll('.rate-star').removeClass('fa-star');
            $(this).addClass("fa-star");
            $(this).prevAll('.rate-star').addClass('fa-star');
            $(this).nextAll('.rate-star').addClass('fa-star-o');
        }
    });

    $(".stars").not(".rate-star").hover(function(){
        if(!$(this).hasClass('voted')){
            $(".rate-star").not('.voted').removeClass("fa-star");
            $(".rate-star").not('.voted').addClass("fa-star-o");
        }
    });
}

function rating_click_event(){
    $(".rate-star").click(function(){
        if(!$(this).hasClass('voted')){
            var enrollment_id = $("[name='lesson-content']").data('enrollment');
            var rating = $(this).index() + 1;
            var criteria = $(this).parent().data("criteria");
            $(this).removeClass('fa-star-o');
            $(this).addClass('voted');
            $(this).addClass('fa-star');
            $(this).prevAll('.rate-star').removeClass('fa-star-o');
            $(this).nextAll('.rate-star').removeClass('fa-star');
            $(this).prevAll('.rate-star').addClass('fa-star');
            $(this).nextAll('.rate-star').addClass('fa-star-o');
            console.log('Avaliação feita com sucesso');
            $(this).css("color","gold");
            $(this).siblings(".fa-star").css("color","gold")
            $(this).siblings(".rate-star").addClass('voted');


            $.ajax({
                url: "/classroom/save-rating",
                type: "POST",
                data: {
                    enrollment: enrollment_id,
                    rating: rating,
                    criteria: criteria
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                cache: false,

                success: function (data) {




                    if($(".rate-star").not(".voted").length <= 0)
                    $(".modal-body").append("<br><p style='color:#075890;'>Agradecemos a sua avaliação!</p>");
                },
                error: function () {

                    //  console.log('enrollment_id:' + enrollment_id + ' content: ' + $("[name='lesson-content']").data('content'));
                }
            });
        }
    });
}