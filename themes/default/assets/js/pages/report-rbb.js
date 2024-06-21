var asal_event;
$(function(){
	
	$(document).on("click","#cmdRisk_Register, .showRegisterrbb", function(){
		var id=$(this).data('id');
		var owner=$(this).data('owner');
		var data = {'id':id,'owner_no':owner};
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/get-register";
		
		cari_ajax_combo("post", parent, data, '', url, 'show_register');
	})

	});

	$(document).on("click", ".showFile", function () {
		var id = $(this).data('file');
		var nama = $(this).data('nama');
		// var owner = $(this).data('owner');
		var data = { 'file': id, 'nama': nama};
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name + "/getView";

		cari_ajax_combo("post", parent, data, '', url, 'show_file');
	})


function show_file(hasil){
	$("#modal_general").find(".modal-body").html(hasil.register);
	$("#modal_general").find(".modal-title").html('Dokument Lainnya');
	$("#modal_general").modal("show");
}
function show_register(hasil){
	$("#modal_general").find(".modal-body").html(hasil.register);
	$("#modal_general").find(".modal-title").html('RISK BASED BUDGETING');
	$("#modal_general").modal("show");
}
