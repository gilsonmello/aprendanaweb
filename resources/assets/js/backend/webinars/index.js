$(function(){

	var id = null;


	$('.table #btn-webinars-users').on('click', function(e){
		e.preventDefault();

		id = $(this).attr('data-id');

		var modal = $('#modalUsersCourse').modal('toggle');

		$.ajax({
			method: 'GET',
			dataType: 'Json',
			url: '/admin/webinars/users_course?id='+id,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
			},
			success: function(data){
				if(data == false){
					$('#modalUsersCourse .modal-body').html("<h2>Nenhum aluno matriculado neste Curso.</h2>");
				}else {
					var html = '<table id="users-course" class="table table-striped table-bordered table-hover">';
							html += '<thead>';
								html += '<th>';
									html += 'E-mail';
								html += '</th>';
							html += '</thead>';

							html += '<tbody>';
								for (var i = 0; i < data.length; i++) {
									html += "<tr>";
										html += "<td>";
											html += '' + data[i].student_email + ',';
										html += "</td>";
									html += "</tr>";
								}
							html += '</tbody>';
					html += '</table>';
					$('#modalUsersCourse .modal-body').html(html);
				}
			}
		});

	});
});