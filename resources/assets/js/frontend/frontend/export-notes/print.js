//Escuta o botão de exportar anotações
$('#btn-export').on('click', function(e){
	//Abrindo nova aba e escrendo o HTML no documento
	newWindow = window.open();
	newWindow.document.open();
	newWindow.document.write(getHtmlForPrint());
	
	//2 milisegundos para dar tempo da função escrever o HTML no documento
	setTimeout(function(){ 
		//Se for firefox, pausar o carregamento do documento após já ter escrito HTML
		if(jQuery.browser.mozilla){
			newWindow.stop();
		}
		newWindow.print(); 
	}, 200);
});

//Função para pegar o contéudo que quero imprimir pro usuário
function getContentForPrint(element){
	var htmlToPrint = document.getElementById(element).outerHTML;
	return htmlToPrint;
}

//Função para concatenar o HTML que deverá ser escrito no documento
function getHtmlForPrint(){
	
	var html = '<!doctype html><html>';
		
		html += '<head>';
			html += '<!--[if IE]><link rel="shortcut icon" href="/favicon.ico"><![endif]-->';
			html += '<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">';
			html += '<title> Exportar Anotações </title>'
			html += '<meta charset="utf-8">';
        	html += '<meta http-equiv="X-UA-Compatible" content="IE=edge">';
        	html += '<meta name="viewport" content="width=device-width, initial-scale=1">';
			html += '<style type="text/css">';
				html += 'body{font-size: 12px !important}';
			html += '</style>';
			html += css;
		html += '</head>';

		html += '<body>';
			html += '<section class="body">';
	        	html += '<div class="inner-wrapper" style="padding-top: 0;">';
	            	html += '<section role="main" class="content-body">';
	                	html += '<div id="course" class="container">';
	                    	html += '<div class="row">';
	                        	html += '<div class="col-md-12" >';
	                            	html += '<div id="tabs-content" class="tab-content">';
	                                	html += '<div id="module-tab" class="tab-pane fade in active">';
	                                		html+= '<section id="content-export" class="panel">';
		                                    	html += getContentForPrint('content-export');
		                                    html += '</section>';
	                                    html += '</div>';
	                           	 	html += '</div>';
	                        	html += '</div>';
	                    	html += '</div>';
	                	html += '</div>';
	            	html += '</section>'; 
	        	html += '</div>';
	   	 	html += '</section>';
		html += '</body>';

	html += '</html>';
	
	return html;
}