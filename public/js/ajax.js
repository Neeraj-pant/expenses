$(".edit-detail").click(function(){
	var id = $(this).attr('data-id');
	$.ajax({
		url : "get-user-data/"+id,
		data : { id: id }
	})
	.done(function(data){
		$("input[name=id]").val(data['id']);
		$("input[name=name]").val(data['name']);
		$("input[name=email]").val(data['email']);
		$("select[name=role]").val(data['role']);
		if(data['status'] == 1){
			$("input[name=status]").attr('checked', true);
		}
	});
});


$(".delete-user").click(function(){
	delete_id = $(this).attr('data-id');
	$(".delete-id").val(delete_id);
});


$(".delete-group").click(function(){
	delete_id = $(this).attr('data-id');
	$(".delete-group-id").val(delete_id);
});


$(".product-entry").click(function(){
	id = $(this).attr('data-id');
	$(".product-group-id").val(id);
});







//save and continue for make entry

$("#add-product-ajax").click(function(){
	test = 1;
	$(".errors").text('');
	$(".saving").show();
	$(".errors").hide();
	$(".success").hide();
	$( "#save-product-form input" ).not("input[type=hidden]").each(function( index ) {
	  if($(this).val() == '' ){
	  	name = $(this).attr('name');
	  	$(".errors").append("The "+name+" Field is Required<br>");
	  	test = 0;
	  	$(".saving").hide();
	  }
	});
	if(test == 1){
		$(".saving").show();
		form = $("#save-product-form").serialize();
		$.ajax({
			method : 'post',
			url: 'ajax-save',
			data: form
		}).done(function(data){
			if(data == 1){
				$(".success").show();
				$(".success").text("product Saved Succfully");
				$("#save-product-form").find('input[name=name]').val('');
				$("#save-product-form").find('input[name=price]').val('');
			}
			else{
				$(".errors").text('');
				$(".errors").show();
				$.each(data, function(index, val) {
					$(".errors").append(val+'<br>');
				});
			}
			$("form")[0].reset();

			setTimeout($(".saving").hide(), 2000);

		}).fail(function() { 
			alert('request failed');
			setTimeout($(".saving").hide(), 2000);
		});
	}
	else{
		$(".errors").show();
	}
});






//	filter group data using start date and end date

$("#group-filter .start-date, #group-filter .end-date").change(function(){
	var gp_id = $(".gp-id").val();
	var start_date = $(".start-date").val();
	var end_date = $(".end-date").val();
	var _token = $('input[name=_token]').val();
	$.ajax({
		url : "filter-group",
		method: "post",
		data : { _token: _token, id: gp_id, start_date: start_date, end_date: end_date }
	})
	.done(function(data){
		$("body").html(data);
	});
});