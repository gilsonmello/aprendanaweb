/**
 * Created by ambiente on 07/04/16.
 */

/*
error : function(xhr, textStatus, errorThrown ) {
    if (textStatus == 'timeout') {



    }

  */

var unsent_requests = [];


function timeout_handling(request){
    unsent_requests.push(request);

    if(!$('#connectionTimeoutModal').is(':visible'))
        $("#connectionTimeoutModal").modal("toggle");
}

function request_retry(){

    var is_toggled;
    if($('#connectionTimeoutModal').is(':visible')){
       is_toggled = $("#connectionTimeoutModal").modal("toggle");
    }


    if(is_toggled != undefined){
    $.each(unsent_requests,function(index, value){
        $.ajax(value);
    });
    }


}