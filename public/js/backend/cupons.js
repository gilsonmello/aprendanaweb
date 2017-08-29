$(function () {
    
    //Escuta do botão gerar pdf
	$(document).on('mouseover','#btnGenerationPDF', function(){
		//Verificar se o botão de gerar pdf está ativo
	    if($(this).attr('href') == '#'){
    	}else{
    		//Escondendo tooltip
	    	$('.tooltip').hide();
	    }
	});

	//Escuta Mudança de Estado do campo
    $("#name").on("keyup", function (e) {
    	e.preventDefault();
    	//Trocar propiedade css do botão de gerar pdf e desativar o link
        $('#btnGenerationPDF').css({
        	'background-color': '#babfc2',
        	'border-color': '#babfc2'
        }).attr('href', '#');
	});

    //Escuta Mudança de Estado do campo
	$("#code").on("keyup", function (e) {
    	e.preventDefault();
    	//Trocar propiedade css do botão de gerar pdf e desativar o link
        $('#btnGenerationPDF').css({
        	'background-color': '#babfc2',
        	'border-color': '#babfc2'
        }).attr('href', '#');
	});

	//Escuta Mudança de Estado do campo
	$("#start_date").on("keyup", function (e) {
    	e.preventDefault();
    	//Trocar propiedade css do botão de gerar pdf e desativar o link
        $('#btnGenerationPDF').css({
        	'background-color': '#babfc2',
        	'border-color': '#babfc2'
        }).attr('href', '#');
	});
	
	//Escuta Mudança de Estado do campo
	$("#due_date").on("keyup", function (e) {
    	e.preventDefault();
    	//Trocar propiedade css do botão de gerar pdf e desativar o link
        $('#btnGenerationPDF').css({
        	'background-color': '#babfc2',
        	'border-color': '#babfc2'
        }).attr('href', '#');
	});

	//Escuta Mudança de Estado do campo
	$("#students").on("change", function (e) {
    	e.preventDefault();
    	//Trocar propiedade css do botão de gerar pdf e desativar o link
        $('#btnGenerationPDF').css({
        	'background-color': '#babfc2',
        	'border-color': '#babfc2'
        }).attr('href', '#');
	});

	//Escuta Mudança de Estado do campo
	$("#tesge").select2();













		"change", function (e) {
    	e.preventDefault();
    	//Trocar propiedade css do botão de gerar pdf e desativar o link
        $('#btnGenerationPDF').css({
        	'background-color': '#babfc2',
        	'border-color': '#babfc2'
        }).attr('href', '#');
	});
	
});