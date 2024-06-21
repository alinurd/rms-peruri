$(function(){
	$("#owner_no, #period_no").change(function(){
		var id_owner = $("#owner_no").val();
		var id_period = $("#period_no").val();
		var id=parseFloat(id_owner) + "-" + parseFloat(id_period) + "-" + parseFloat(type_dash);
		$("button#btn-search").addClass('disabled');
		
		var parent = $(this).parent();
		var data={'id':id};
		var target_combo = $("#project_no");
		var url = "ajax/get_project_name";
		
		cari_ajax_combo("post", parent, data, target_combo, url);
	});
	
	$("#project_no").change(function(){
		var id_project = $(this).val();
		if (id_project>0)
			$("button#btn-search").removeClass('disabled');
		else
			$("button#btn-search").addClass('disabled');
	});
	
	$("form#dashboard-operational").submit(function(){
		pesan_toastr('Mohon Tunggu','info','Prosess','toast-top-center');
		loading(true,'overlay_content');
		return true;
	});
	
	$(document).on("click", ".detail-map", function(){
		var id=$(this).attr('value');
		var rcsa=$(this).attr('rcsa');
		
		var parent = $(this).parent();
		var data={'id':id, rcsa:rcsa};
		var target_combo = $("#detail_map");
		var url = modul_name+"/get-detail-map";
		
		cari_ajax_combo("post", parent, data, target_combo, url);
				
	})
});