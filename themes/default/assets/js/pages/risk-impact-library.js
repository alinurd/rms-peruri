$(function(){
	$("#l_kel").change(function(){
		var parent = $(this).parent();
		var nilai = $(this).val();
		var data={'id':nilai};
		var target_combo = $("#l_risk_type_no");
		var url = "ajax/get_rist_type";
		cari_ajax_combo("post", parent, data, target_combo, url);
	})
});