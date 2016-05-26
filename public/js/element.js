$(document).ready(function() {
    var list_items = 1;
    var selected_items = [];
    var total_options = $("#group-members").find("select[name=group_member_1]").children("option").length;
    var list = $("#group-members").find(".form-group")
    $("#create-user").click(function() {
        total_lists = $("#group-members").children(".form-group").length;
        if (total_lists < total_options - 1) {
            list_items += 1;
             var user_list = "<div class='form-group' id='" + list_items + "'><select class='form-control' name='group_member_"+ list_items + "' required=''><option value=''>--Select--</option></select></div>";
            $("#group-members").append(user_list);

            //get users nside list 
            $.ajax({
                url: 'get-users',
                type: 'GET',
            })
            .done(function(data) {
                for (var i = 0 ; i < data.length; i++) {
                    option = "<option value='"+data[i]['id']+"'>"+data[i]['name']+"</option>";
                    $("#"+list_items).find("select").append(option);
                }
            })
            .fail(function() {
                alert("error");
            })            
        }
    });

    $("#delete-user").click(function() {
    	is_list = $("#group-members").find("#" + list_items).length;
    	if(is_list > 0){
	        $("#group-members").find("#" + list_items).remove();
	        list_items -= 1;
	    }
    });

    $("#submit-group").click(function() {
    	result = true;
        $.each($("#group-members select"), function(index, val) {
            selected_items[index] = $(this).val();
        	old_value = selected_items[index - 1];
        	if( old_value == $(this).val() ){
        		$("#error").text("Error: use different user");
        		result = false;
        	}
        });
        return result;
    });

});