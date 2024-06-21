$(function(){	
	$(document).on("click","#edit_register", function(){	
	
		$(".input_register").removeClass("hide");
		$(".statis").addClass("hide");
		$("#simpan_register").removeClass("hide");
		$("#cancel_register").removeClass("hide");
		$("#edit_register").addClass("hide");
	})
	
	$(document).on("click","#show_info", function(){
		var id=$(this).data('id');
		var data = {'id':id};
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/show-riskRisContext";
		
		cari_ajax_combo("post", parent, data, '', url, 'show_riskcontext');
	})
	$(document).on("click","#simpan_register", function(){

		$(".input_register").addClass("hide");
		$(".statis").removeClass("hide");
		$("#simpan_register").addClass("hide");
		$("#cancel_register").addClass("hide");
		$("#edit_register").removeClass("hide");
		
		var data = [];
		var like = [];
		var impact = [];
		var proaktif = [];
		var reaktif = [];
		var detail_no = [];
		var action_no = [];
		var level = [];
		var url = base_url + 'propose-div/simpan-register';
		$('.table-risk-register > tbody > tr').each(function(){
			var idx = parseInt($(this).find('td button').attr('data-rcsa'));
			var likex = $(this).find('select[name="likelihood[]"]').val();
			var impactx = $(this).find('select[name="impact[]"]').val();
			var proaktifx = $(this).find('textarea[name="proaktif[]"]').val();
			var reaktifx = $(this).find('textarea[name="reaktif[]"]').val();
			var detail_nox = $(this).find('input[name="detail_no[]"]').val();
			var action_nox = $(this).find('input[name="action_no[]"]').val();
			var levelx = $(this).find('input[name="inherent_level[]"]').val();
			data.push(idx);
			like.push(likex);
			impact.push(impactx);
			proaktif.push(proaktifx);
			reaktif.push(reaktifx);
			detail_no.push(detail_nox);
			action_no.push(action_nox);
			level.push(levelx);
			
			
		});
		looding('light', '.table-risk-register');
	
		$.ajax({
			type: "post",
			url: url,
			data: {data:data,like: like,impact: impact, proaktif:proaktif,reaktif:reaktif,detail:detail_no, aksi:action_no,level:level},
			success: function(msg){
				
				stopLooding('.table-risk-register');
				pesan_toastr('Update success','success',msg,'toast-top-right');
				var id = data[0];
				get_register(id);				

			},
			failed: function(msg){
				pesan_toastr('Update failed','err',msg,'toast-top-right');
			},
		});
	})
	$(document).on("click","#cancel_register", function(){
		$(".input_register").addClass("hide");
		$(".statis").removeClass("hide");
		$("#simpan_register").addClass("hide");
		$("#cancel_register").addClass("hide");
		$("#edit_register").removeClass("hide");
	})
	
	$(document).on('click','.move',function () {
	    var row = $(this).closest("tr");
	    var table = $(this).closest("table");
	    row.detach();
	 	
	 	var tbl_top = $(".table-top-ten");
	 	var tbl_risk = $(".table-risk-register");
	    if (table.is(".table-risk-register")) {
	    	$(this).text('drop');
	        tbl_top.append(row);
	    }
	    else {
	    	$(this).text('select');
	        tbl_risk.append(row);
	    }
    	var l = $(".table-top-ten tbody tr").length;
    	if (l == 0){
    		tbl_top.fadeOut();
    		$('.propose').addClass('hide');
    	}
    	else{
    		tbl_top.removeClass('hide');
    		tbl_top.fadeIn();
    		$('.propose').removeClass('hide');
    	}

	    row.hide();
	    row.fadeIn();
	});



	$(document).on('click','.propose',function () {
		var data = [];
		var rcsa_no = [];
		var url = base_url + 'propose-div/save-propose';
		$('.table-risk-register > tbody > tr').each(function(){
			var id = parseInt($(this).find('td button').attr('data-urgency'));
			var rcsa = parseInt($(this).find('td button').attr('data-rcsa'));
			data.push(id);
			rcsa_no.push(rcsa);
		});
		var rcsa_no=$(this).data('id');
		var note = $("#note").val();
		looding('light', '.table-top-ten');
		$.ajax({
			type: "post",
			url: url,
			data: {data:data, rcsa_no: rcsa_no,note: note},
			success: function(msg){
				stopLooding('.table-top-ten');
				window.location.href=base_url + 'propose-div';
				// window.location.href=base_url;
				pesan_toastr('Propose success','success',msg,'toast-top-right');
				// get_register(rcsa_no);
			},
			failed: function(msg){
				pesan_toastr('Propose failed','err',msg,'toast-top-right');
			},
		});
	});
	
	$(document).on('click','.revisi-propose',function () {
		var data = [];
		var rcsa_no = [];
		var url = base_url + 'propose-div/revisi-propose';
		$('.table-risk-register > tbody > tr').each(function(){
			var id = parseInt($(this).find('td button').attr('data-urgency'));
			// var rcsa = parseInt($(this).find('td button').attr('data-rcsa'));
			data.push(id);
			// rcsa_no.push(rcsa);
		});
		// var rcsa = parseInt($(this).find('td button').attr('data-rcsa'));
		// rcsa_no.push(rcsa);
		var rcsa_no=$(this).data('id');
		console.log(data);
		var note = $("#note").val();
		looding('light', '.table-top-ten');
		$.ajax({
			type: "post",
			url: url,
			data: {data:data, rcsa_no: rcsa_no,note: note},
			success: function(msg){
				stopLooding('.table-top-ten');
				window.location.href=base_url + 'propose-div';
				// window.location.href=base_url;
				pesan_toastr('Revisi success','success',msg,'toast-top-right');
				// get_register(rcsa_no);
			},
			failed: function(msg){
				pesan_toastr('Revisi failed','err',msg,'toast-top-right');
			},
		});
	});

	
	$(".likelihood").change(function(){
		var likelihood=$(this).val();
		var impact=$(this).closest('tr').find('.impact').val();
		cari_level(likelihood, impact, $(this).closest('tr'));
		return false;
	});
	
	$(".impact").change(function(){
		var impact=$(this).val();
		var likelihood=$(this).closest('tr').find('.likelihood').val();
		cari_level(likelihood, impact, $(this).closest('tr'));
		return false;
	});

	$(document).on("click","#cmdRisk_Register, .showRegister", function(){
		var id=$(this).data('id');
		var owner=$(this).data('owner');
		var data = {'id':id,'owner_no':owner};
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/get-register";
		
		cari_ajax_combo("post", parent, data, '', url, 'show_register');
	})
});

function show_register(hasil){
	$("#modal_general").find(".modal-body").html(hasil.register);
	$("#modal_general").find(".modal-title").html('RISK REGISTER');
	$("#modal_general").modal("show");
}

function get_register(id)
{	
	var parent =  $('.tbl-risk-register');
	well(parent, 'load data');

	looding('light', parent);
	$.ajax({
		type: "get",
		url: base_url + 'propose-div/propose/' + id,
		data: {"id":id},
		
		success:function(result){
var a = $(result).find('.tbl-risk-register').html();
			if (result.length == 0) {
				alert();
			} else {
				$('.tbl-risk-register').html(a);
				stopLooding(parent);





			}
		},
		error:function(msg){ 
			pesan_toastr('Jaringan sedang bermasalah !','err','Error','toast-top-center');
		},		
		})
}

function cari_level(likelihood, impact, asal){
	var label='-';
	var id=0;
	var color=0;
	var color_text=0;
	$.each(data_master_level, function(key, value){
		if (value.impact==impact && value.likelihood==likelihood){
			label = value.level_mapping;
			id = value.id_color;
			color = value.color;
			color_text = value.color_text;
		}
	});
	var text='<span style="background-color:'+color+';color:'+color_text+'">  &nbsp;&nbsp;'+label.toUpperCase()+' &nbsp;&nbsp;</span>';
	
	asal.find('input[name="inherent_level[]"]').val(id);
	asal.find(".mapping").html(text);
}

function well(parent, string)
{
	parent.empty();
	parent.append('<div class="well">'+string+'<div>');
}


function show_riskcontext(hasil){
	$("#modal_general").find(".modal-body").html(hasil.combo);
	$("#modal_general").find(".modal-title").html('RISK CONTEXT');
	$("#modal_general").modal("show");
}