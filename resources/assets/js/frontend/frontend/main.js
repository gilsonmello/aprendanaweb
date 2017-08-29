jQuery(function ($) {

    'use strict';

    /*==============================================================*/
    // Table of index
    /*==============================================================*/

    /*==============================================================
     # sticky-nav
     # Date Time
     # language Select
     # Search Slide
     # Breaking News
     # Owl Carousel
     # magnificPopup
     # newsletter
     # weather
     
     ==============================================================*/
//COMPARTILHAMENTO PELO FACEBOOK
//==========================================================
    $.ajaxSetup({cache: true});
    $.getScript('//connect.facebook.net/en_US/sdk.js', function () {
        FB.init({
            appId: '{1088274097890420}',
            version: 'v2.7' // or v2.1, v2.2, v2.3, ...
        });
        $('#loginbutton,#feedbutton').removeAttr('disabled');
        FB.getLoginStatus(updateStatusCallback);
    });
//=============================================================
    /*==============================================================*/
    // Search terms
    /*==============================================================*/

    $.getJSON('/busca/json-tags-cursos', function (data) {
        jQuery('.typeahead').typeahead({
            source: data,
            display: 'title',
            val: 'link',
            highlight: 'false',
            hint: 'true',
            itemSelected: function (item, val) {
                if (val === undefined) {
                    window.location.href = '/busca?s=' + $('#search-form').val();
                } else {
                    window.location.href = '' + val + '';
                }
            }
        });
    });


//    $(".entry-thumbnail").on('mouseover', function () {
//        console.log(this);
//        //$(this).src = "/img/frontend/ticket_black_friday.png";
//    });

    /*==============================================================*/
    // # sticky-nav
    /*==============================================================*/
    (function () {
        var windowWidth = $(window).width();
        if (windowWidth > 1000) {
            $(window).scroll(function () {
                var sT = $(this).scrollTop();
                if (sT >= 120) {
                    $('.homepage .navbar, .homepage-two.fixed-nav .navbar').addClass('sticky-nav')
                } else {
                    $('.homepage .navbar, .homepage-two.fixed-nav .navbar').removeClass('sticky-nav')
                }
                ;
            });
        } else {
            $('.homepage .navbar, .homepage-two.fixed-nav .navbar').removeClass('sticky-nav')
        }
        ;
        if (windowWidth > 1000) {
            $(window).scroll(function () {
                var sT = $(this).scrollTop();
                if (sT >= 120) {
                    $('.homepage #menubar, .homepage-two.fixed-nav #navigation').removeClass('container')
                    $('.homepage #menubar, .homepage-two.fixed-nav #navigation').addClass('container-fluid')
                } else {
                    $('.homepage #menubar, .homepage-two.fixed-nav #navigation').removeClass('container-fluid')
                    $('.homepage #menubar').addClass('container')
                }
            });
        } else {
            $('.homepage #menubar, .homepage-two.fixed-nav #navigation').removeClass('container-fluid')
        }
        ;

    }());



    /*==============================================================*/
    // # language Select
    /*==============================================================*/
    (function () {
        $('.language-dropdown').on('click', '.language-change a', function (ev) {
            if ("#" === $(this).attr('href')) {
                ev.preventDefault();
                var parent = $(this).parents('.language-dropdown');
                parent.find('.change-text').html($(this).html());
            }
        });
    }());

    /*==============================================================*/
    // Search Slide
    /*==============================================================*/

    $('.search-icon').on('click', function () {
        $('.searchNlogin').toggleClass("expanded");
    });


    /*==============================================================*/
    // Breaking News
    /*==============================================================*/
    (function () {
        $('.breaking-news-scroll').easyTicker({
            direction: 'up',
            easing: 'swing',
            speed: 'slow',
            interval: 3000,
            height: 'auto',
            visible: 1,
            mousePause: 1,
            controls: {
                up: '',
                down: '',
                toggle: '',
                playText: 'Play',
                stopText: 'Stop'
            }
        });

    }());


    /*==============================================================*/
    // sticky
    /*==============================================================*/
    (function () {
        $("#sticky").stick_in_parent();
    }());

    /*==============================================================*/
    // Owl Carousel
    /*==============================================================*/
    $("#home-slider").owlCarousel({
        pagination: true,
        autoPlay: true,
        singleItem: true,
        stopOnHover: true,
    });

    $("#latest-news").owlCarousel({
        items: 4,
        pagination: true,
        autoPlay: true,
        stopOnHover: true,
    });

    $(".twitter-feeds").owlCarousel({
        items: 1,
        singleItem: true,
        pagination: false,
        autoPlay: true,
        stopOnHover: true,
    });

    $("#main-slider").owlCarousel({
        items: 3,
        pagination: false,
        navigation: false,
        autoPlay: true,
        stopOnHover: true

    });




    /*==============================================================*/
    // Magnific Popup
    /*==============================================================*/

    (function () {
        $('.image-link').magnificPopup({
            gallery: {
                enabled: true
            },
            type: 'image'
        });
        $('.feature-image .image-link').magnificPopup({
            gallery: {
                enabled: false
            },
            type: 'image'
        });
        $('.image-popup').magnificPopup({
            type: 'image'
        });
        $('.video-link').magnificPopup({type: 'iframe'});
    }());


    /*=====================================================*/
    /* Custom Functions                                    */
    /*=====================================================*/

    if ($(".tell-a-friend-button").length > 0) {
        $(".tell-a-friend-button").click(function () {
            $("#tellAFriendModal").remove();
            if ($("#tellAFriendModal").length > 0) {
                $("#tellAFriendModal").modal('toggle');
            } else {
                $.ajax({
                    url: '/opentellafriend',
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    data: {
                        id: $(this).data('id'),
                        type: $(this).data('type'),
                        title: $(this).data('title'),
                    },
                    success: function (data) {
                        if ($("#tellAFriendModal").length <= 0) {
                            $("#main-content").append(data);
                            $("#tellAFriendModal").modal('toggle');
                            $("#tellAFriendModal").off('shown.bs.modal').on('shown.bs.modal', function () {
                                $(window).keydown(function (event) {
                                    if (event.keyCode == 13) {
                                        event.preventDefault();
                                    }
                                });

                                $('#friends').multipleInput();
                                $(".e-mail").blur(function () {


                                    if (!isEmail($(this).val())) {
                                        if ($(".fa-warning").length <= 0) {
                                            $(this).css('background-color', '#DDD');
                                            $(this).parent().find('label').after('&nbsp;<i data-toggle="tooltip" title="E-mail inválido" class="fa fa-warning" style="color: red"></i>');
                                        }
                                    } else {
                                        $(this).css('background-color', 'initial');
                                        $(".fa-warning").remove();

                                    }
                                });


                                $('#tellAFriendForm').submit(function (e) {
                                    console.log($(this).serialize());
                                    e.preventDefault();
                                    $(".btn-tell").val('Enviando...');
                                    $.ajax({
                                        url: '/tellafriend',
                                        type: 'post',
                                        target: 'blank',
                                        headers: {
                                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                        },
                                        data: $(this).serialize(),
                                        success: function (data) {

                                            $("#tellAFriendModalClose").modal('toggle');
                                            $("#tellAFriendModal").css('display', 'none');
                                            $('.modal-backdrop').hide();
                                            $("#tellAFriendModal").remove();
                                            //$("#tell-a-friend-form").html("<div class='row'><div class='col-md-11'><h2 style='padding:20px'>Sua indicação foi enviada com sucesso!</h2></div><div class='col-md-1'>  <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div></div>");
                                        },
                                        error: function () {
                                            $("#tellAFriendModal").remove();
                                        }

                                    });
                                });


                            });
                        }
                    }

                });
            }
        });

    }

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }

    (function ($) {
        $.fn.multipleInput = function () {
            return this.each(function () {
                var $list;
                $list = $('<ul />');
                var $input = $('<input type="text" />').keyup(function (event) {
                    if (event.which == 32 || event.which == 188) {
                        var val = $(this).val().slice(0, -1); // remove space/comma from value
                        $list.append($('<li class="multipleInput-email"><span>' + val + '</span></li>')
                                .append($('<a href="#" class="multipleInput-close" title="Remove" />')
                                        .click(function (e) {
                                            $(this).parent().remove();
                                            e.preventDefault();
                                        })
                                        )
                                );
                        $(this).attr('placeholder', '');
                        $(this).val('');
                    }
                });

                var $container = $('<div class="multipleInput-container" />').click(function () {
                    $input.focus();
                });

                $container.append($list).append($input).insertAfter($(this));

                var $orig = $(this);
                $(this).closest('form').submit(function (e) {
                    var emails = new Array();
                    $('.multipleInput-email span').each(function () {
                        emails.push($(this).html());
                    });
                    emails.push($input.val());
                    $orig.val(emails.join());
                });
                return $(this).hide();
            });
        };
    })(jQuery);



});

