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

// $("#add-product-ajax").click(function(){
// 	test = 1;
// 	$(".errors").text('');
// 	$(".errors").hide();
// 	$(".success").hide();
// 	$( "#save-product-form input" ).not("input[type=hidden]").each(function( index ) {
// 	  if($(this).val() == '' ){
// 	  	name = $(this).attr('name');
// 	  	$(".errors").append("The "+name+" Field is Required<br>");
// 	  	test = 0;
// 	  }
// 	});
// 	if(test == 1){
// 		form = $("#save-product-form").serialize();
// 		$.ajax({
// 			method : 'post',
// 			url: 'ajax-save',
// 			data: form
// 		}).done(function(data){
// 			if(data == 1){
// 				$(".success").show();
// 				$(".success").text("product Saved Succfully");
// 				$("#save-product-form input").not("#datepicker").val('');
// 			}
// 			else{
// 				$(".errors").text('');
// 				$(".errors").show();
// 				$.each(data, function(index, val) {
// 					$(".errors").append(val+'<br>');
// 				});
// 			}
// 			$("form")[0].reset();
// 		});
// 	}
// 	else{
// 		$(".errors").show();
// 	}
// });