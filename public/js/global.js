$(document).ready(function() {
	
	/*
	##### Modal
	*/
	$(".openModal").click(function() {
		var modal = $("#"+$(this).attr("modal-id"));
		modal.show();
		$(".overlay").show();
	});
	
	$(".modalClose").click(function() {
		$(this).parent().hide();
		$(".overlay").hide();
	});

});