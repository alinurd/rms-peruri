$(function(){
	$("#owner_no, #period_no").change(function(){
		var parent = $(this).parent();
		var owner_no = $("#owner_no").val();
		var period_no = $("#period_no").val();
		var data={'owner_no':owner_no, 'period_no':period_no};
		var url = "ajax/get_project_hiradc_name";
		cari_ajax_combo("post", parent, data, $("#project_no"), url);
	});
	
	$(document).on("click", "#kirim_propose", function(){
		var parent = $(this).parent();
		var edit_no=$('input[name="edit_no"]').val();
		var data={'edit_no':edit_no};
		var url = modul_name+"/send-propose";
		cari_ajax_combo("post", parent, data, "", url, "proses_propose");
	})
	
	$("#btn-search").click(function(){
		var id=$("#project_no").val();
		var data = {'id':id};
		var parent = $(this).parent();
		var target_combo = $("#hiradc_register");
		var url = modul_name+"/get-register";
		
		cari_ajax_combo("post", parent, data, target_combo, url);
	})
});

function proses_propose(hasil){
	$("#btn-search").trigger("click");
}