$(document).ready(function(){
	$(".layout-type").find("a").click(function(){
		$(".layout-type a").removeClass('active');
		$(this).addClass('active');
		type = $(this).attr('data-type');
		if(type == 'panels'){
			$(".main").addClass('back');
			$(".tables").hide('puff', 500, function(){
				$(".panels").show( "clip", 500 );
			});
		}
		else{
			$(".main").removeClass('back');
			$(".panels").hide("clip", 500, function(){
				$(".tables").show( "clip", 500 )
			});
		}
	});

});