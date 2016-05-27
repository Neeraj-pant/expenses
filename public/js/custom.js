$(document).ready(function(){
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

});