$(function(){
	$("#l_id_prop, #q_l_id_prop").change(function(){		
		var parent = $(this).parent();
		var nilai = $(this).val();
		var data={'id':nilai};
		var id = $(this).attr('id');
		if (id=='l_id_prop')
			var target_combo = $("#l_id_kota");
		else
			var target_combo = $("#q_l_id_kota");
			
		var url = "ajax/get_kota";
		cari_ajax_combo("post", parent, data, target_combo, url);
	})
	
	$("#l_id_kota, #q_l_id_kota").change(function(){		
		var parent = $(this).parent();
		var nilai = $(this).val();
		var data={'id':nilai};
		var id = $(this).attr('id');
		var id = $(this).attr('id');
		if (id=='l_id_kota')
			var target_combo = $("#l_id_distrik");
		else
			var target_combo = $("#q_l_id_distrik");
		var url = "ajax/get_distrik";
		cari_ajax_combo("post", parent, data, target_combo, url);
	})
	
	$("#l_sop").click(function(){		
		var parent = $("#l_diagnosa_no_parent");
		var nilai = $("#l_diagnosa_no").val();
		var data={'id':nilai};
		var target_combo = $("#l_id_distrik");
		var url = modul_name + "/get_sop";
		cari_ajax_combo("post", parent, data, target_combo, url, 'show_sop');
	})
	
	$(document).on('click','.up, .down', function(){
		var row = $(this).parents("tr:first");
		$(".up,.down").show();
		if ($(this).is(".up")) {
			row.insertBefore(row.prev());
		} else {
			row.insertAfter(row.next());
		}
		// $("tbody tr:last .down").hide();
		$(this).closest('table').find('tbody tr:last').find('.down').hide();
		$(this).closest('table').find('tbody tr:first').find('.up').hide();
	});
	
	$(document).on('click','.tambah', function(){
		
		var row = $(this).closest("tr");
		row.after('<tr><td>&nbsp;</td><td class="text-center"><i class="icon icon-square-up pointer text-success up" title="Naik"></i> &nbsp;<i class="icon icon-square-down pointer text-warning down" title="Turun"></i></td><td>'+edit+file+'</td><td>'+kelompok+'</td><td>'+title+'</td><td class="text-center"><span class="text-primary" nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span> &nbsp;<i class="icon icon-plus2 pointer text-success tambah" title="Tambah"></i></td></tr>');
	});
	
	$("#l_klb").change(function(){
		var nil = $(this).val();
		if (nil==1){
			$("#l_tgl_mulai_label").text("Tgl dimulai KLB : ");
			$("#l_tgl_akhir_label").text("Tgl berakhir KLB : ");
			$("#l_tgl_diketahui_label").text("Tgl KLB Diketahui : ");
			$("#l_tgl_ditanggulangi_label").text("Tgl KLB ditanggulangi: ");
		}else {
			$("#l_tgl_mulai_label").text("Tgl dimulai Kejadian : ");
			$("#l_tgl_akhir_label").text("Tgl berakhir Kejadian : ");
			$("#l_tgl_diketahui_label").text("Tgl Kejadian diketahui: ");
			$("#l_tgl_ditanggulangi_label").text("Tgl Kejadian ditanggulangi: ");
		}
	})
});

function add_install(){
	var row = $("table#detail_file tbody");
		row.append('<tr><td>&nbsp;</td><td class="text-center"><i class="icon icon-square-up pointer text-success up" title="Naik"></i> &nbsp;<i class="icon icon-square-down pointer text-warning down" title="Turun"></i></td><td>'+edit+file+'</td><td>'+kelompok+'</td><td>'+title+'</td><td class="text-center"><span class="text-primary" nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span> &nbsp;<i class="icon icon-plus2 pointer text-success tambah" title="Tambah"></i></td></tr>');
}

function show_sop(hasil){
	$("#modal_general").find(".modal-body").html(hasil.sop);
	$("#modal_general").find("#myModalLabel").html("SOP -  Standar Operasional Prosedur");
	$("#modal_general").modal("show");	
}