$(function(){
	$("#l_type_project_no, #l_owner_no, #l_periode_no").change(function(){
		var type_dash = $("#l_type_project_no").val();
		var id_owner = $("#l_owner_no").val();
		var id_period = $("#l_periode_no").val();
		var id=parseFloat(id_owner) + "-" + parseFloat(id_period) + "-" + parseFloat(type_dash);
		
		var parent = $(this).parent();
		var data={'id':id};
		var target_combo = $("#l_rcsa_no");
		var url = "ajax/get_project_name";
		
		cari_ajax_combo("post", parent, data, target_combo, url);
	});
	
	$("#l_type_view_no").change(function(){
		nil=$(this).val();
		if (nil==0){
			$("#l_owner_no").removeAttr('disabled');
			$("#l_periode_no").removeAttr('disabled');
			$("#l_rcsa_no").attr('disabled', true);
		}else if (nil==1){
			$("#l_owner_no").removeAttr('disabled');
			$("#l_periode_no").removeAttr('disabled');
			$("#l_rcsa_no").removeAttr('disabled');
		}else if (nil==2){
			$("#l_owner_no").removeAttr('disabled');
			$("#l_periode_no").removeAttr('disabled');
			$("#l_rcsa_no").removeAttr('disabled').attr('disabled', true);
		}else{
			$("#l_owner_no").removeAttr('disabled');
			$("#l_periode_no").removeAttr('disabled');
			$("#l_rcsa_no").removeAttr('disabled');
		}
	})
});