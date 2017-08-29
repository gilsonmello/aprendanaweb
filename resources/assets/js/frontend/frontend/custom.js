$(window).load(function() {  document.getElementById("whiteHide").style.display = "none"; });

jQuery.getJSON('/busca/json-tags-cursos', function(data) {
    jQuery('.typeahead').typeahead({
        source: data,
        display: 'title',
        val: 'link',
        highlight: 'false',
        hint: 'true',
        itemSelected: function(item, val){
            window.location.href = ''+val+'';
        }
    });
});

$(document).ready(function(){

    //$('.login-form').on("shown.bs.collapse", function(){
    //    $('#username').focus();
    //});

    $(".ads-list").owlCarousel({
        items : 4,
        itemsMobile : [479,2],
        navigationText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        navigation:false
    });

    $("#courses-list-sidebar").owlCarousel({
      items : 1,
      itemsMobile : [479,2],
      navigationText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>']
    });

    $("#courses-master").find(" .row").owlCarousel({
        items : 4,
        itemsMobile : [479,2],
        navigationText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        navigation:false
    });


    $("#destaques-list").owlCarousel({
        items : 4,
        itemsMobile : [479,1],
        itemsTablet: [768,2],
        navigationText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        navigation:true,
        afterUpdate: function () {
            updateSize();
        },
        afterInit: function () {
            updateSize();
        }
    });

    $("#professores-bj-list").owlCarousel({
        items : 6,
        itemsMobile : [479,2],    
         itemsTablet: [768,4],
         navigationText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        navigation:true 
    });

    $("#articles-list").owlCarousel({
        items : 3,
        itemsMobile : [479,1],    
         itemsTablet: [768,2],
         navigationText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        navigation:true,
         afterUpdate: function () {
            updateSizeArticles();
        },
        afterInit: function () {
            updateSizeArticles();
        }
      });

    $("#news-list").owlCarousel({
        items : 4,
        itemsMobile : [479,1],    
         itemsTablet: [768,2],
         navigationText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
        navigation:true,
         afterUpdate: function () {
            updateSizeNews();
        },
        afterInit: function () {
            updateSizeNews();
        }
      });

    

      $(".slides").owlCarousel({
          singleItem:true,
          navigationText: ['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
          navigation:true,
          autoPlay : 5000,    
          autoplayHoverPause:true
        });

    $('#select-tab-courses').on('change', function (e) {
    
    $('#course-tabs li a').eq($(this).val()).tab('show');
    
});

    $( '#dl-menu' ).dlmenu({animationClasses : { classin : 'dl-animate-in-1', classout : 'dl-animate-out-1' }});

    $(".menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
        $("#overlay-transparent").show();
    });

    $("#close").click(function(e) {
     e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });

    $("#overlay-transparent").on('click',function(e){
      e.preventDefault();
      $("#wrapper").removeClass("toggled");
      $("#overlay-transparent").hide();
    });
        
      
      $(document).on('click', '.yamm .dropdown-menu', function(e) {e.stopPropagation()});
           

     $('.anchor').click(function(){      
      $('html, body').animate({
          scrollTop: $(this).offset().top
      }, 1000);      
    });
    $('.panel-heading a').click(function() {
      $('.panel-heading').removeClass('actives');
      $(this).parents('.panel-heading').addClass('actives');
      });
    });

$(document).on('click',function(){
  $('.collapse').collapse('hide');
});

function updateSize(){
    var heightsizeN = $("#noticias-destaque .owl-wrapper-outer").height();
    $("#noticias-destaque .owl-item").height(heightsizeN);
}

function updateSizeArticles(){
    var heightsizeA = $("#articles .owl-wrapper-outer").height();
    $("#articles .owl-item").height(heightsizeA);
}

function updateSizeNews(){
    var heightsizeNews = $(".notices-home .owl-wrapper-outer").height();
    $(".notices-home .owl-item").height(heightsizeNews);
}

//var offset_menu_init = $(".courses-category").offset();
//POSY_INIT = offset_menu_init.top - $(window).scrollTop();




$(window).scroll(function(event){

  $("#back-to-top").fadeIn(600);

  if(!/Android|webOS|iPhone|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
     
  }else{
    var elemento = $(".courses-category");
    //elemento.css('height', '100px');
    var offset = $(".courses-category").offset();
    var posY = offset.top - $(window).scrollTop();

    if($(window).scrollTop() >= POSY_INIT){
        elemento.css('bottom', '');
        elemento.css('position', 'fixed');
        elemento.css('top', 0);
  
  
    } else if($(window).scrollTop() < POSY_INIT){
        elemento.css('bottom', 0);
        elemento.css('position', 'relative');
        elemento.css('top', '');
  
    }
  }
});

