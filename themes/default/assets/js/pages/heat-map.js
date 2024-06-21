$(function(){
	$("#owner_no, #period_no").change(function(){
		var id_owner = $("#owner_no").val();
		var id_period = $("#period_no").val();
		var id=parseFloat(id_owner) + "-" + parseFloat(id_period) + "-" + parseFloat(type_dash);
		$("button#btn-search").addClass('disabled');
		
		var parent = $(this).parent();
		var data={'id_owner':id_owner,'id_period':id_period};
		var target_combo = $("#mapping");
		var url = modul_name+"/get_map";
		
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
	
	$(".peta").click(function(){
		var nilai = $(this).data('nilai');
		if (nilai>0){
		var id = $(this).data('id');
		var tahun = $("#period_no").val();
		var data={'id':id,'tahun':tahun};
		var target_combo = $("#detail_map");
		var url = modul_name+"/get-detail-map";
		
		cari_ajax_combo("post", parent, data, target_combo, url);
		}
	})
});