/**
 * Created by ambiente on 09/03/16.
 */


console.log('calling notify');
add_read_notify();

function add_read_notify(){
$(".notification-item").click(function(){
    console.log('clicado');
    $.ajax({
        url: "/notification/read-notification",
        type: "POST",
        data: { 'notification': $(this).data('notification-id')
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        cache: false,
        success: function(data){
            console.log('Comentário lido');
        }
    });
});
}

