$(function () {
	$("#carousel").owlCarousel({
 		autoPlay: 6000,
 		stopOnHover : true,
 		singleItem:true,
 		slideSpeed : 500,
 		navigation : true,
		navigationText: ["<i class='fa fa-arrow-left'></i>","<i class='fa fa-arrow-right'></i>"],
 	});
	$(".owl-buttons").css('display','none');


});