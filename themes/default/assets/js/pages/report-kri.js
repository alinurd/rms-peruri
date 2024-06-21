var asal_event;
$(function(){
	
	$(document).on("click","#cmdRisk_Register, .showRegister, #filter_bulan", function(){
		var id=$(this).data('id');
		var owner=$(this).data('owner');
		var bulan=$("#bulan").val();
		console.info(bulan)
		var data = {'id':id,'owner_no':owner,'bulan':bulan};
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/get-register";
		
		cari_ajax_combo("post", parent, data, '', url, 'show_register');
	})

	$(document).on("click","#filter_bulan, .showRegister", function(){
		
	})
	  
	
	});


function show_register(hasil){
	$("#modal_general").find(".modal-body").html(hasil.register);
	$("#modal_general").find(".modal-title").html('RISK REGISTER [KEY RISK INDIKATOR]');
	$("#modal_general").modal("show");
}
