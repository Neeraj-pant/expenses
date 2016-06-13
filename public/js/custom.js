$(document).ready(function(){
	$("#graph-view").hide();


	$(".layout-type").find("a").click(function(){
		$(".layout-type a").removeClass('active');
		$(this).addClass('active');
		type = $(this).attr('data-type');
		if(type == 'panels'){
			$(".tables").hide('puff', 500, function(){
				$(".panels").show( "clip", 500 );
			});
		}
		else{
			$(".panels").hide("clip", 500, function(){
				$(".tables").show( "clip", 500 )
			});
		}
	});

	$(".del").click(function(){
		$("#search").val('');
	});

	$("#graph").click(function(event) {
		$("#table-view").hide('puff', 500, function(){
			$("#graph-view").show('bounce', 500);
		});
	});

	$("#table").click(function(event) {
		$("#graph-view").hide('explode', 500, function(){
				$("#table-view").show( "puff", 500 );
			});
		//$("#graph-view").slideUp('slow');
		//$("#table-view").slideDown('500');
	});

});