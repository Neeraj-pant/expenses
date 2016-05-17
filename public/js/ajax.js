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



