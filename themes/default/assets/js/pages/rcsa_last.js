var asal_event;
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
	
	$(document).on("click","#cmdRisk_Register, .showRegister", function(){
		var id=$(this).data('id');
		var data = {'id':id};
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/get-register";
		
		cari_ajax_combo("post", parent, data, '', url, 'show_register');
	})
	
	if (mode=='add' || mode=='edit'){
	var url = base_url;
	CKEDITOR.replace("l_tujuan",
	{
		filebrowserBrowseUrl  : url + "ajax/media?type=Images",
		filebrowserUploadUrl  : url +  "ajax/upload?type=Images",
		toolbar : "Full", /* this does the magic */
		uiColor : "#9AB8F3"
	});

	CKEDITOR.replace("l_lingkup_pekerjaan",
	{
		filebrowserBrowseUrl  : url + "ajax/media?type=Images",
		filebrowserUploadUrl  : url +  "ajax/upload?type=Images",
		toolbar : "Full", /* this does the magic */
		uiColor : "#9AB8F3"
	});

	CKEDITOR.replace("l_pekerjaan_di_luar_ruang_lingkup",
	{
		filebrowserBrowseUrl  : url + "ajax/media?type=Images",
		filebrowserUploadUrl  : url +  "ajax/upload?type=Images",
		toolbar : "Full", /* this does the magic */
		uiColor : "#9AB8F3"
	});

	CKEDITOR.replace("l_kriteria_pekerjaan_diterima_owner",
	{
		filebrowserBrowseUrl  : url + "ajax/media?type=Images",
		filebrowserUploadUrl  : url +  "ajax/upload?type=Images",
		toolbar : "Full", /* this does the magic */
		uiColor : "#9AB8F3"
	});

	CKEDITOR.replace("l_asumsi",
	{
		filebrowserBrowseUrl  : url + "ajax/media?type=Images",
		filebrowserUploadUrl  : url +  "ajax/upload?type=Images",
		toolbar : "Full", /* this does the magic */
		uiColor : "#9AB8F3"
	});

	CKEDITOR.stylesSet.add( "my_styles_custom",
	[
		// Block-level styles
		{ name : "huruf", element : "body", styles : { "font-family" : "Helvetica,Arial,sans-serif" } },
		{ name : "Red Title" , element : "h3", styles : { "color" : "Red" } },
	]);
	}
	$(document).on("click",".add-couse", function(){
		var row = $(this).closest("tbody");
		row.append('<tr><td style="padding-left:0px;">'+riskCouse+riskCouse_no+'</td><td class="text-center"><i class="fa fa-search browse-couse text-primary pointer"></i> | <i class="fa fa-trash text-warning pointer" title="menghapus data" id="sip"></i></td></tr>');
	})
	$(document).on("click",".add-impact", function(){
		var row = $(this).closest("tbody");
		row.append('<tr><td style="padding-left:0px;">'+riskImpact+riskImpact_no+'</td><td class="text-center"><i class="fa fa-search browse-impact text-primary pointer"></i> | <i class="fa fa-trash text-warning pointer" title="menghapus data" id="sip"></i></td></tr>');
	})
	$(document).on("click",".add-attact", function(){
		var row = $(this).closest("tbody");
		row.append('<tr><td style="padding-left:0px;">'+attDetail+'</td><td class="text-center"><i class="fa fa-trash text-warning pointer" title="menghapus data" id="sip"></i></td></tr>');
	})
	$(document).on("click",".fa-trash", function(){
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
	$(document).on("click",".browse-couse, .browse-impact", function(){
		var event_no = $("#event_no").val();
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
	
	$(document).on("click",".pilih-Couse, .pilih-Impact", function(){
		var pilih=$(this).data("value");
		$("#modal_general").modal("hide");
		var data = pilih.split("#");
		if ($(this).hasClass("pilih-Couse")){
			asal_event.find('textarea[name="risk_couse[]"]').html(data[1]);
			asal_event.find('input[name="risk_couse_no[]"]').val(data[0]);
		}else if ($(this).hasClass("pilih-Impact")){
			asal_event.find('textarea[name="risk_impact[]"]').html(data[1]);
			asal_event.find('input[name="risk_impact_no[]"]').val(data[0]);
		}
	})
	
	$(document).on("change","#cboRiskType", function(){
		var id=$(this).val();
		var kel=$(this).data("kel");
		var event_no=$(this).data("event");
		var data = {'id':id,'kel':kel, 'event':event_no};
		var parent = $("#listEvent");
		asal_event=parent;
		var url = modul_name + "/get-library-part";
		
		cari_ajax_combo("post", parent, data, parent, url);
	})
	
	$("#inherent_impact, #inherent_likelihood").change(function(){
		var likelihood=$("#inherent_likelihood").val();
		var residual_likelihood=$("#residual_likelihood").val();
		var impact=$("#inherent_impact").val();
		var residual_impact=$("#residual_impact").val();
		var sts=false;
		cari_level(likelihood, impact, 1);
		return false;
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
		cari_ajax_combo("post", $(this).parent(), data, $("#tab_mitigasi"), url, "get_mitigasi");
		$("#identifikasi").closest('li').removeClass('disabled').addClass('disabled');
		$("#level").closest('li').removeClass('disabled').addClass('disabled');
	});
	
	$(document).on("click",".editMitigasi", function(){
		var url = modul_name+"/get-form-mitigasi";
		var parent_no=$('input[name="parent_no"]').val();
		var id_detail=$('input[name="id_edit"]').val();
		var id_edit=$(this).data('id');
		var data={'parent':parent_no, 'id':id_detail, 'id_edit':id_edit};
		cari_ajax_combo("post", $(this).parent(), data, $("#tab_mitigasi"), url, "get_mitigasi");
		$("#identifikasi").closest('li').removeClass('disabled').addClass('disabled');
		$("#level").closest('li').removeClass('disabled').addClass('disabled');
	});
	
	$(document).on("click","#closeMitigasi", function(){
		var url = modul_name + "/get-mitigasi";
		var parent_no=$('input[name="parent_mitigasi"]').val();
		var id_detail=$('input[name="id_detail_mitigasi"]').val();
		
		var data={'parent':parent_no, 'id':id_detail};
		cari_ajax_combo("post", $(this).parent(), data, $("#tab_mitigasi"), url);
		$("#identifikasi").closest('li').removeClass('disabled');
		$("#level").closest('li').removeClass('disabled');
	});
	
	$(document).on("click","#saveMitigasi", function(){
		var url = modul_name + "/save-mitigasi";
		var data=$("#form_risk_event").serialize();
		cari_ajax_combo("post", $(this).parent(), data, $("#tab_mitigasi"), url);
		$("#identifikasi").closest('li').removeClass('disabled');
		$("#level").closest('li').removeClass('disabled');
	});
});

function get_mitigasi(hasil){
	$("#tab_mitigasi").html(hasil.combo);
	$(".datepicker").datetimepicker({
		timepicker:false,
		format:'d-m-Y',
		closeOnDateSelect:true,
		validateOnBlur:true,
		 mask:false
	});
	$(".select2").select2({
		allowClear: false,
		placeholder: " - Select - ",
		width:'100%'
	});
}

function cari_level(likelihood, impact, asal){
	var label='-';
	var id=0;
	var color=0;
	var color_text=0;
	$.each(data_master_level, function(key, value){
		console.log(value);
		if (value.impact==impact && value.likelihood==likelihood){
			label = value.level_mapping;
			id = value.id_color;
			color = value.color;
			color_text = value.color_text;
		}
	});
	var text='<span style="background-color:'+color+';color:'+color_text+'">  &nbsp;&nbsp;'+label.toUpperCase()+' &nbsp;&nbsp;</span>';
	if (asal==2){
		$("#risk_level").val(id);
		$("#residual_level").html(text);
	}else if (asal==1){
		$('input[name="inherent_level"]').val(id);
		$("#inherent_level_label").html(text);
	}
}

function show_register(hasil){
	$("#modal_general").find(".modal-body").html(hasil.register);
	$("#modal_general").find(".modal-title").html('RIST REGISTER');
	$("#modal_general").modal("show");
}

function show_event(hasil){
	$("#modal_general").find(".modal-body").html(hasil.library);
	$("#modal_general").find(".modal-title").html(hasil.title);
	$("#modal_general").modal("show");
}