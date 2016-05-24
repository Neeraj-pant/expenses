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

$("#add-product-ajax").click(function(){
	form = $("#save-product-form").serialize();
	$.ajax({
		url: 'product/save-ajax',
		data: form
	}).done(function(data){
		console.log(data);
	});
});
