$(function(){
	$("li.event").click(function(){
		idedit=$(this).attr('value');
		rcsa=$(this).attr('rcsa');
		url = base_url+"/rcsa/risk-event";
		url += '/' + rcsa + '/' + idedit;
		looding('light',$("#overlay_content"));
		window.location = url;
	});
	
	$("span.delete").click(function(){
		var url= $(this).attr('url');
		var ket = Globals.confirm_del_one;
		$('p.question').html(ket);
		$('#confirmDelete').modal('show');
		$('#confirm').on('click', function(){
			window.location.href=url;
		});
	});
	
	$("#tr_no, #srd_no, #bp_no, #lp_no, #cp_no, #occorunce_no, input[name='regulasi[]']").change(function(){
		var tr=$("#tr_no").val();
		var srd=$("#srd_no").val();
		var bp=$("#bp_no").val();
		var lp=$("#lp_no").val();
		var cp=$("#cp_no").val();
		var occorunce=$("#occorunce_no").val();
		// var data = {"tr":tr, "srd":srd, "bp":bp, "lp":lp, "cp":cp, "occorunce":occorunce}
		var data = $("#form_risk_event").serialize();
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/get-severity";
		
		cari_ajax_combo("post", parent, data, target_combo, url, "get_severity");
	});
	
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		var id=$(this).attr("id");
		if (id=='mitigasi'){
			$("#btnAdd").removeClass('hide').addClass('hide');
			$("#btnSave").removeClass('hide').addClass('hide');
		}else{
			$("#btnAdd").removeClass('hide');
			$("#btnSave").removeClass('hide');
		}
	});
	
	$('a[data-toggle="tab"]').on('click', function(){
	  if ($(this).parent('li').hasClass('disabled')) {
		return false;
	  };
	});

	$(document).on("click","#addMitigasi", function(){
		var url = modul_name+"/get-form-mitigasi";
		var parent_no=$('input[name="parent_no"]').val();
		var id_detail=$('input[name="id_edit"]').val();
		var id_edit=0;
		var data={'parent':parent_no, 'id':id_detail, 'id_edit':id_edit};
		cari_ajax_combo("post", $(this).parent(), data, $("#tab_mitigasi"), url);
		$("#identifikasi").closest('li').removeClass('disabled').addClass('disabled');
		$("#level").closest('li').removeClass('disabled').addClass('disabled');
	});
	
	$(document).on("click",".editMitigasi", function(){
		var url = modul_name+"/get-form-mitigasi";
		var parent_no=$('input[name="parent_no"]').val();
		var id_detail=$('input[name="id_edit"]').val();
		var id_edit=$(this).data('id');
		var data={'parent':parent_no, 'id':id_detail, 'id_edit':id_edit};
		cari_ajax_combo("post", $(this).parent(), data, $("#tab_mitigasi"), url);
		$("#identifikasi").closest('li').removeClass('disabled').addClass('disabled');
		$("#level").closest('li').removeClass('disabled').addClass('disabled');
	});
	
	$(document).on("click","#closeMitigasi", function(){
		var url = modul_name+"/get-mitigasi";
		var parent_no=$('input[name="parent_mitigasi"]').val();
		var id_detail=$('input[name="id_detail_mitigasi"]').val();
		
		var data={'parent':parent_no, 'id':id_detail};
		cari_ajax_combo("post", $(this).parent(), data, $("#tab_mitigasi"), url);
		$("#identifikasi").closest('li').removeClass('disabled');
		$("#level").closest('li').removeClass('disabled');
	});
	
	$(document).on("click","#saveMitigasi", function(){
		var pengendalian = $("#pengendalian").val();
		var mitigasi = $("#mitigasi_no").val();
		var parent_no=$('input[name="parent_mitigasi"]').val();
		var id_detail=$('input[name="id_detail_mitigasi"]').val();
		var id_edit=$('input[name="id_edit_mitigasi"]').val();
		
		var data = {'pengendalian':pengendalian,'mitigasi':mitigasi,'parent':parent_no,'id_detail':id_detail,'id_edit':id_edit};
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/save-mitigasi";
		cari_ajax_combo("post", $(this).parent(), data, $("#tab_mitigasi"), url);
		$("#identifikasi").closest('li').removeClass('disabled');
		$("#level").closest('li').removeClass('disabled');
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

function show_register(hasil){
	$("#modal_general").find(".modal-body").html(hasil.register);
	$("#modal_general").find(".modal-title").html('RIST REGISTER');
	$("#modal_general").modal("show");
}

function get_severity(hasil){
	$("#severity").val(hasil.severity);
	$("#score_resiko").val(hasil.score_resiko);
	$("#risk_impact").val(hasil.risk_impact);
	$("#resiko").html(hasil.resiko);
	$("#status_no").val(hasil.statusNo);
	$("#statusText").html(hasil.statusText);
}