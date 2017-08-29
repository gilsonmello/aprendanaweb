$(function(){

	var id = null;

	$('.table #btn-edit-tutor-activity').on('click', function(e){
		e.preventDefault();

		createSelect("tutor", 'myworkshopevaluations/tutor/select', $("#modalEditTutorActivity"));

		$('#modalEditTutorActivity').modal('toggle');

		id = $(this).parent().parent()[0].children[8].getAttribute('id');

		//Adicionando o nome do usuário ao text field
		$('#name-user').val($(this).parent().parent()[0].children[0].innerText);

		//Adicionando descrição e atividade do workshop ao text field
		$('#description-workshop').val($(this).parent().parent()[0].children[2].innerText);

	});

	$('#editTutorActivity').submit(function(e){
		e.preventDefault();
		console.log($(this).serialize());
		$.ajax({
			method: 'POST',
			url: '/admin/myworkshopevaluations/updateTutor/'+id,
			dataType: 'Json',
			data: $(this).serialize(),
			headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
            	if(data == true){
            		flash_success('Tutor da atividade alterado com sucesso.');
            		setTimeout(function(){
				        window.location.reload();
				    },1500);
				}else{
					flash_warning('Erro ao alterar tutor da atividade. Tente novamente.');
				}
            }
		});
	});

});