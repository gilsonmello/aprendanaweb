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
	$(".students-select").select2({
        minimumInputLength: 3,
        ajax: {
            type: 'POST',
            url: '/admin/students/select',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            data: function(params) {
                return {
                    term: params.term
                };
            },
            processResults: function(data) {
                return { results: data };
            }
        }
    }).on("change", function (e) {
        e.preventDefault();
        //Trocar propiedade css do botão de gerar pdf e desativar o link
        $('#btnGenerationPDF').css({
            'background-color': '#babfc2',
            'border-color': '#babfc2'
        }).attr('href', '#');
    });

	//Escuta Mudança de Estado do campo
	$(".courses-select").select2({
        minimumInputLength: 3,
        ajax: {
            type: 'POST',
            url: '/admin/courses/select',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            data: function(params) {
                return {
                    term: params.term
                };
            },
            processResults: function(data) {
                return { results: data };
            }
        }
    }).on("change", function (e) {
        e.preventDefault();
        //Trocar propiedade css do botão de gerar pdf e desativar o link
        $('#btnGenerationPDF').css({
            'background-color': '#babfc2',
            'border-color': '#babfc2'
        }).attr('href', '#');
    });
	
    
    $(".textarea-description").wysihtml5({
        events: {
            //Escuta Mudança de Estado do campo
            change: function(){
                //Trocar propiedade css do botão de gerar pdf e desativar o link
                $('#btnGenerationPDF').css({
                    'background-color': '#babfc2',
                    'border-color': '#babfc2'
                }).attr('href', '#');
            }
        },
        toolbar:{
            html: true,
        },
        parserRules: {
            tags: {
                strong: {},
                em: {},
                table: {
                    check_attributes: {
                        width: "any",
                        style: "any",
                        colspan: "any",
                    }
                },
                td: {
                    check_attributes: {
                        width: "any",
                        style: "any",
                        colspan: "any",
                    }
                },
                tr: {
                    check_attributes: {
                        width: "any",
                        style: "any",
                        colspan: "any",
                    }
                },
                th: {
                    check_attributes: {
                        width: "any",
                        style: "any",
                        colspan: "any",
                    }
                },
                img:{
                    check_attributes: {
                        src: "src",
                    }
                }
            },
        },
    });
});