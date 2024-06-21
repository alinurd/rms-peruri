$(function(){
	
	$("span.delete").click(function(){
		var url= $(this).attr('url');
		var ket = Globals.confirm_del_one;
		$('p.question').html(ket);
		$('#confirmDelete').modal('show');
		$('#confirm').on('click', function(){
			window.location.href=url;
		});
	});
	

	$(document).on("click","#addDetailMitigasi, #addMitigasi", function(){
		$("#edit_detail_mitigasi").removeClass("hide");
		$("#list_detail_mitigasi").addClass("hide");
		$("#progress_date").val("");
		$("#owner_no").val("");
		$("#description").val("");
		$("#note").val("");
		$("#progress").val("0");
		$(".select2-selection__rendered").html("");
	});
	
	$(document).on("click","#closeMitigasi", function(){
		$("#edit_detail_mitigasi").addClass("hide");
		$("#list_detail_mitigasi").removeClass("hide");
	});
	
	$(document).on("click",".editMitigasi", function(){
		var url = modul_name+"/get-form-mitigasi";
		var id=$(this).data("id");
		var data={'id':id};
		cari_ajax_combo("post", $(this).parent(), data, "", url, "get_mitigasi");
	});

	$(document).on("click","#saveMitigasi", function(){
		var progress_date  = $("#progress_date").val();
		var owner_no  = $("#owner_no").val();
		var description  = $("#description").val();
		var note  = $("#note").val();
		var progress  = $("#progress").val();
		var parent_no=$('input[name="parent_no"]').val();
		var edit_no=$('input[name="edit_no"]').val();
		
		var data = {'progress_date':progress_date,'owner_no':owner_no,'description':description,'note':note,'progress':progress,'parent_no':parent_no,'edit_no':edit_no};
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/save-mitigasi";
		cari_ajax_combo("post", $(this).parent(), data, '', url, 'proses_save');
	});
	
	$(document).on("click","#cmdRisk_Register, .showRegister", function(){
		var id=$(this).data('id');
		var data = {'id':id};
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/get-register";
		
		cari_ajax_combo("post", parent, data, '', url, 'show_register');
	})
});


function proses_save(hasil){
	$("#edit_detail_mitigasi").addClass("hide");
	$("#list_detail_mitigasi").removeClass("hide");
	$("table#tbl_event tbody").html(hasil.combo);
}

function get_mitigasi(hasil){
	$("#edit_detail_mitigasi").removeClass("hide");
	$("#list_detail_mitigasi").addClass("hide");
	$("#progress_date").val(hasil.progress_date);
	$("#owner_no").val(hasil.owner);
	$("#description").val(hasil.description);
	$("#note").val(hasil.notes);
	$("#progress").val(hasil.progress);
	$('input[name="parent_no"]').val(hasil.mitigasi_no);
	$('input[name="edit_no"]').val(hasil.id);
	$(".select2").select2({
		allowClear: false,
		width:'style'
	});
}