var asal_event;
$(function(){

	$(document).on("click","#cmdRisk_Register, .showRegister", function(){
		var id=$(this).data('id');
		var data = {'id':id};
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/get-register";
		
		cari_ajax_combo("post", parent, data, '', url, 'show_register');
	})

	$(document).on("click","#add_peristiwa, .edit-peristiwa", function(){
		var id=$(this).data('rcsa');
		var edit_no=$(this).data('id');
		var data = {'id':id, 'edit':edit_no};
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/add-peristiwa";
		
		cari_ajax_combo("post", parent, data, '', url, 'show_peristiwa');
	})

	$(document).on("click",".edit-level", function(){
		var id=$(this).data('rcsa');
		var edit_no=$(this).data('id');
		var data = {'id':id, 'edit':edit_no};
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/edit-level";
		
		cari_ajax_combo("post", parent, data, '', url, 'show_peristiwa');
	})

	$(document).on("click",".show-mitigasi", function(){
		var id=$(this).data('rcsa');
		var edit_no=$(this).data('id');
		var data = {'id':id, 'edit':edit_no};
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/input-mitigasi";
		
		cari_ajax_combo("post", parent, data, '', url, 'show_peristiwa');
	})

	$(document).on("click",".show-realisasi", function(){
		var id=$(this).data('rcsa');
		var edit_no=$(this).data('id');
		var data = {'id':id, 'edit':edit_no};
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/list-realisasi";
		
		cari_ajax_combo("post", parent, data, '', url, 'show_peristiwa');
	})

	$(document).on("click",".delete-peristiwa", function(){
		var id=$(this).data('rcsa');
		var edit_no=$(this).data('id');
		var data = {'rcsa_no':id, 'edit':edit_no};
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/delete-peristiwa";
		
		cari_ajax_combo("post", parent, data, '', url, 'result_save_peristiwa');
	})

	$(document).on("click",".del_realisasi", function(){
		if(confirm("Yakin akan mengahpus data ini ?")){
			var id=$(this).data('rcsa');
			var edit_no=$(this).data('id');
			var data = {'rcsa_no':id, 'edit':edit_no};
			var parent = $(this).parent();
			var target_combo = "";
			var url = modul_name+"/delete-realisasi";
			asal_event=$(this).closest('tr');
			
			cari_ajax_combo("post", parent, data, '', url, 'result_delete_realisasi');
		}
	})

	$(document).on("click",".del_mitigasi", function(){
		if(confirm("Yakin akan mengahpus data ini ?")){
			var id=$(this).data('rcsa');
			var edit_no=$(this).data('id');
			var data = {'rcsa_no':id, 'edit':edit_no};
			var parent = $(this).parent();
			var target_combo = "";
			var url = modul_name+"/delete-mitigasi";
			asal_event=$(this).closest('tr');
			cari_ajax_combo("post", parent, data, '', url, 'result_delete_mitigasi');
		}
	})

	$(document).on("click",".add-couse", function(){
		var row = $(this).closest("tbody");
		row.append('<tr><td style="padding-left:0px;">'+riskCouse+riskCouse_no+'</td><td class="text-center"><i class="fa fa-search browse-couse text-primary pointer"></i> | <i class="fa fa-trash text-warning pointer" title="menghapus data" id="sip"></i></td></tr>');
	})
	$(document).on("click",".add-impact", function(){
		var row = $(this).closest("tbody");
		row.append('<tr><td style="padding-left:0px;">'+riskImpact+riskImpact_no+'</td><td class="text-center"><i class="fa fa-search browse-impact text-primary pointer"></i> | <i class="fa fa-trash text-warning pointer" title="menghapus data" id="sip"></i></td></tr>');
	})

	$(document).on("click","table.peristiwa .fa-trash", function(){
		var ada=true;
		if (confirm("Are you sure?")){
			if ($(this).hasClass("del-couse")){
				ada=false;
				$(this).closest("tr").find('textarea[name="risk_couse[]"]').html('');
				$(this).closest("tr").find('input[name="risk_couse_no[]"]').val(0);
			}else if ($(this).hasClass("del-impact")){
				ada=false;
				$(this).closest("tr").find('textarea[name="risk_impact[]"]').html('');
				$(this).closest("tr").find('input[name="risk_impact_no[]"]').val(0);
			}else if ($(this).hasClass("del-attact")){
				ada=false;
				$(this).closest("tr").find('td:first-child').html('').append(attDetail);
			}else if ($(this).hasClass("del-event")){
				var id = $(this).data('id');
				var data = {'id':id};
				var parent = $(this).closest("tr");
				asal_event=parent;
				var target_combo = "";
				var url = modul_name+"/delete-event";
				
				cari_ajax_combo("post", parent, data, '', url);
			}else if ($(this).hasClass("del-mitigasi")){
				var id = $(this).data('id');
				var data = {'id':id};
				var parent = $(this).closest("tr");
				asal_event=parent;
				var target_combo = "";
				var url = modul_name+"/delete-mitigasi";
				
				cari_ajax_combo("post", parent, data, '', url);
			}
			
			if (ada){
				var row = $(this).closest("tr");
				row.remove();
			}
		}
	})

	// $(document).on("change","#kategori",function(){
	// 	var parent = $(this).parent();
	// 	var nilai = $(this).val();
	// 	var data={'id':nilai};
	// 	var target_combo = $("#sub_kategori");
	// 	var url = "ajax/get_rist_type";
	// 	cari_ajax_combo("post", parent, data, target_combo, url);
	// })

	// $(document).on("change","#sub_kategori",function(){
	// 	var parent = $(this).parent();
	// 	var type = $("#kategori").val();
	// 	var nilai = $(this).val();
	// 	var data={'id':nilai,'type':type};
	// 	var target_combo = $("#peristiwa");
	// 	var url = modul_name+"/list-library";
	// 	cari_ajax_combo("post", parent, data, target_combo, url);
	// })

	$(document).on("click",".browse-couse, .browse-impact", function(){
		var event_no = $("#peristiwa").val();
		if (event_no=="0"){
			alert("Event Wajib dipilih!");
			return false;
		}
		var kel=0;
		if ($(this).hasClass("browse-couse")){
			kel=2;
		}else if ($(this).hasClass("browse-impact")){
			kel=3;
		}
		if (kel==0){
			alert("Salah Klik");
			return false;
		}
		var data = {'id':event_no,'kel':kel};
		var parent = $(this).closest("tr");
		asal_event=parent;
		var target_combo = "";
		var url = modul_name+"/get-library";
		
		cari_ajax_combo("post", parent, data, '', url, 'show_event');
	})

	$(document).on("click",".close-library",function(){
		$("#input_peristiwa").removeClass("hide");
		$("#input_library").addClass("hide");
	})

	$(document).on("click",".pilih-Couse, .pilih-Impact", function(){
		var pilih=$(this).data("value");
		var data = pilih.split("#");
		if ($(this).hasClass("pilih-Couse")){
			asal_event.find('textarea[name="risk_couse[]"]').html(data[1]);
			asal_event.find('input[name="risk_couse_no[]"]').val(data[0]);
		}else if ($(this).hasClass("pilih-Impact")){
			asal_event.find('textarea[name="risk_impact[]"]').html(data[1]);
			asal_event.find('input[name="risk_impact_no[]"]').val(data[0]);
		}

		$(".close-library").trigger("click");
	})

	$(document).on("click","#simpan_peristiwa", function(){
		var id=$(this).data('id');
		var data = $("form#form_peristiwa").serialize();
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/simpan-peristiwa";
		
		cari_ajax_combo("post", parent, data, '', url, 'result_save_peristiwa');
	})

	$(document).on("click","#simpan_level", function(){
		var id=$(this).data('id');
		var data = $("form#form_level").serialize();
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/simpan-level";
		
		cari_ajax_combo("post", parent, data, '', url, 'result_save_peristiwa');
	})

	$(document).on("change","#residual_impact, #residual_likelihood",function(){
		var likelihood=$("#residual_likelihood").val();
		var impact=$("#residual_impact").val();
		var data={'likelihood':likelihood,'impact':impact};
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/cek-level";
		
		cari_ajax_combo("post", parent, data, '', url, 'result_level');
	});

	$(document).on("change","#inherent_impact, #inherent_likelihood",function(){
		var likelihood=$("#inherent_likelihood").val();
		var impact=$("#inherent_impact").val();
		var data={'likelihood':likelihood,'impact':impact};
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/cek-level";
		
		cari_ajax_combo("post", parent, data, '', url, 'result_level');
	});
	
	$(document).on("click","#add_realisasi, .edit_realisasi",function(){
		var id=$(this).data('id');
		var rcsa_detail_no=$(this).data('parent');
		var rcsa_no=$(this).data('rcsa');
		var data={'id':id,'rcsa_detail_no':rcsa_detail_no, 'rcsa_no':rcsa_no};
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/input-realisasi";
		
		cari_ajax_combo("post", parent, data, '', url, 'show_realisasi');
	})

	$(document).on("click","#add_mitigasi, .edit_mitigasi",function(){
		var id=$(this).data('id');
		var rcsa_detail_no=$(this).data('parent');
		var rcsa_no=$(this).data('rcsa');
		var data={'id':id,'rcsa_detail_no':rcsa_detail_no, 'rcsa_no':rcsa_no};
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/input-mitigasi";
		
		cari_ajax_combo("post", parent, data, '', url, 'show_mitigasi');
	})
	
	$(document).on("click","#close_input_realisasi",function(){
		$("#list_realisasi").removeClass("hide");
		$("#input_realisasi").addClass("hide");
	});

	$(document).on("click","#simpan_realisasi", function(){
		var id=$(this).data('id');
		var data = $("form#form_realisasi").serialize();
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/simpan-realisasi";
		
		cari_ajax_combo("post", parent, data, target_combo, url, 'result_realisasi');
	})

	$(document).on("click","#close_input_mitigasi",function(){
		$("#modal_general").modal("hide");
	});

	$(document).on("click","#simpan_mitigasi", function(){
		var id=$(this).data('id');
		var data = $("form#form_mitigasi").serialize();
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/simpan-mitigasi";
		
		cari_ajax_combo("post", parent, data, target_combo, url, 'result_mitigasi');
	})

	$(document).on("click","#close_mitigasi", function(){
		var id=$(this).data('id');
		var rcsa_detail_no=$(this).data('parent');
		var rcsa_no=$(this).data('rcsa');
		var data={'id':id,'rcsa_detail_no':rcsa_detail_no, 'rcsa_no':rcsa_no};
		var parent = $("#list_peristiwa").parent();
		var target_combo = $("#list_peristiwa");
		var url = modul_name+"/close-mitigasi";
		
		cari_ajax_combo("post", parent, data, target_combo, url);
		$("#modal_general").modal("hide");
	})

	$(document).on("click","#close_realisasi", function(){
		var id=$(this).data('id');
		var rcsa_detail_no=$(this).data('parent');
		var rcsa_no=$(this).data('rcsa');
		var data={'id':id,'rcsa_detail_no':rcsa_detail_no, 'rcsa_no':rcsa_no};
		var parent = $("#list_peristiwa").parent();
		var target_combo = $("#list_peristiwa");
		var url = modul_name+"/close-realisasi";
		
		cari_ajax_combo("post", parent, data, target_combo, url);
		$("#modal_general").modal("hide");
	})

	$(document).on("click",".tab_lanjut", function(){
		var id=$(this).data('id');
		$('#' + id).tab('show');
	})

	$(document).on("change","input[name='status_loss']",function(){
		var nil = $("input[name='status_loss']:checked").val();
		if (nil==0){
			$('.mitigasi_1').removeClass('hide');
			$('.mitigasi_2').addClass('hide');
		}else if (nil==1){
			$('.mitigasi_1').addClass('hide');
			$('.mitigasi_2').removeClass('hide');
		}
	});

	// $(document).on('click', '.simpan_propose', function () {
	// 	var parent = $('.tbl-risk-register');
	// 	var data = [];
	// 	$('.table-risk-register > tbody > tr').each(function () {
	// 		var id = parseInt($(this).find('td button').attr('data-urgency'));
	// 		data.push(id);
	// 	});
	// 	var rcsa_no = $("#project_no").val();
	// 	var note = $("#note").val();
	// 	var data = {
	// 		data: data,
	// 		rcsa_no: rcsa_no,
	// 		note: note
	// 	};
	// 	var url = "rcsa/simpan-propose";
	// 	cari_ajax_combo("post", parent, data, $(".tbl-risk-register"), url, "get_register");
	// });
});

function show_register(hasil){
	$("#modal_general").find(".modal-body").html(hasil.register);
	$("#modal_general").find(".modal-title").html('RISK REGISTER');
	$("#modal_general").modal("show");
}

function show_peristiwa(hasil){
	$("#modal_general").find(".modal-dialog").removeClass('fullscreen').addClass('semi-fullscreen');
	$("#modal_general").find(".modal-body").html(hasil.peristiwa);
	$("#modal_general").find(".modal-title").html('Tambah Peristiwa');
	$("#modal_general").modal("show");

	$(".datepicker").datetimepicker({
		timepicker:false,
		format:'d-m-Y',
		closeOnDateSelect:true,
		validateOnBlur:true,
		 mask:false
	});

	$(".select2").select2({
		allowClear: false,
		width:'style'
	});
	$('.select2').on('select2:open', function(e){
		$('.custom-dropdown').parent().css('z-index', 99999);
		
	});
}

function show_event(hasil){
	$("#input_library").removeClass("hide");
	$("#input_peristiwa").addClass("hide");
	$("#input_library").find('.x_panel').find(".x_content").html(hasil.library);
}

function result_save_peristiwa(hasil){
	$("#list_peristiwa").html(hasil.combo);
	$("#modal_general").modal("hide");
}

function result_level(hasil){
	$("#inherent_level_label").html(hasil.level_text);
	$("input[name='inherent_level']").val(hasil.level_no);
	console.log(hasil.level_text);
}

function result_mitigasi(hasil){
	$("#modal_general").modal("hide");
}

function show_mitigasi(hasil){
	$("#input_mitigasi").removeClass("hide");
	$("#list_mitigasi").addClass("hide");
	$("#input_mitigasi").html(hasil.combo);
	$(".select2").select2();
	$(".datepicker").datetimepicker({
		timepicker:false,
		format:'d-m-Y',
		closeOnDateSelect:true,
		validateOnBlur:true,
		 mask:false
	});
}

function result_delete_realisasi(hasil){
	if(hasil.sts=="1"){
		asal_event.remove();
		console.log(asal_event);
	}
}

function result_delete_mitigasi(hasil){
	if(hasil.sts=="1"){
		asal_event.remove();
	}
}

function result_realisasi(hasil){
	$("#list_realisasi").removeClass("hide");
	$("#input_realisasi").addClass("hide");
	$("#list_realisasi").html(hasil.combo);
}

function show_realisasi(hasil){
	$("#input_realisasi").removeClass("hide");
	$("#list_realisasi").addClass("hide");
	$("#input_realisasi").html(hasil.combo);
	$(".select2").select2();
	$(".datepicker").datetimepicker({
		timepicker:false,
		format:'d-m-Y',
		closeOnDateSelect:true,
		validateOnBlur:true,
		 mask:false
	});
}