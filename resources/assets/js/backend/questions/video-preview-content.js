$(document).ready(function(){
	$('.content-preview').on('click', function(e){
		e.preventDefault();
		$('#vimeoPreviewModal').modal('toggle');
	});
});