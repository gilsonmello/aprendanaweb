$(document).ready(function(){
	
	var workshop_id;

	$('.myworkshoptutors tr').on('click', function(){

		//Adicionando o nome do usuário ao text field
		$('#name-user').val($(this).children()[0].innerText);
		
		//Adicionando o nome do workshop ao text field
		$('#name-workshop').val($(this).children()[2].innerText);
		
		//Abrindo modal
		$('#modalAddTutor').modal('toggle');
		
		//Pegando o id do workshop
		workshop_id = $(this).attr('data-workshop');
		
		//Atribuindo ao input hidden o id do workshop
		$('#workshop').val(workshop_id);

		//Atribuindo ao input hidden o id da matrícula
		$('#enrollment').val($(this).attr('data-enrollment'));

		$("#modalAddTutor").on('shown.bs.modal',function(){
			createSelect("tutor", undefined, $("#modalAddTutor"));
			createSelect("criteria", undefined, $("#modalAddTutor"), workshop_id);
			createSelect("activity", undefined, $("#modalAddTutor"), workshop_id);
		});
	});

	$('#group-form').submit(function(e){
		e.preventDefault();
		$.ajax({
			method: 'POST',
			url: '/admin/myworkshoptutors/store',
			dataType: 'Json',
			data: $(this).serialize(),
			headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
            	if(data == true){
            		flash_success('Tutor associado ao aluno com sucesso.');
            		setTimeout(function(){
				        window.location.reload();
				    },2000);
				}else{
					flash_warning('Erro ao associador tutor ao aluno. Tente novamente');
				}
            }
		});
	});
});