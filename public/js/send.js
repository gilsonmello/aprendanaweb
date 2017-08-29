$(document).ready(function(){
	$("#sendAskTheTutor").submit(function () {
        var question = $('#question').val();
        var workshop_id = $('#workshop_id').val();
        $.ajax({
            method: 'POST',
            url: '/classroom/workshop/save-ask-the-tutor',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            data: {
                question: question,
                workshop_id: workshop_id
            },
            success: function (data) {
                if(data == "true"){
                    $('#addUser').removeClass("in");
                    $('.modal-backdrop').removeClass("in");
                    $('#askTheTutorModalClose').modal("toggle");
                    $('#askTheTutorModalClose h2').text("Sua dúvida foi enviada com sucesso!");
                }else{
                    $('#addUser').removeClass("in");
                    $('.modal-backdrop').removeClass("in");
                    $('#askTheTutorModalClose').modal("toggle");
                    $('#askTheTutorModalClose h2').text("Ocorreu um erro ou você não possui nenhum tutor disponível. Tente novamente!");
                }
            }
        });
        return false;
    });
});