$(function(){
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
	$(document).on("click", "#simpanreject", function () {
		var note = $("#note").val();
		if(!note){
					alert('Catatan tidak boleh kosong')
					return false;
		}
		var rcsa_no = $("#rcsa_no").val();
		var data = {
			'rcsa_no': rcsa_no,
 			'note': note,

		};
		//  console.log(data)

		var parent = $(this).parent();
		var url = modul_name + "/simpan_reject";
		cari_ajax_combo("post", parent, data, parent, url, "proses_simpan_library");
		pesan_toastr('Mohon Tunggu', 'info', 'Prosess', 'toast-top-center', true);
		alert('Reject Risk Assesment ?')
		location.reload();
	});
	$(document).on("click","#show_info", function(){
		var id=$(this).data('id');
		var data = {'id':id};
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name+"/show-riskRisContext";
		
		cari_ajax_combo("post", parent, data, '', url, 'show_riskcontext');
	})


	$(document).on('click','.propose',function () {
		var data = [];
		var rcsa_no = [];
		var url = base_url + 'approve-admin/propose';
		$('.table-top-ten > tbody > tr').each(function(){
			var id = parseInt($(this).find('td button').attr('data-urgency'));
			var rcsa = parseInt($(this).find('td button').attr('data-rcsa'));
			data.push(id);
			rcsa_no.push(rcsa);
		});
		var rcsa_no=$(this).data('id');
		looding('light', '.table-top-ten');
		$.ajax({
			type: "post",
			url: url,
			data: {data:data, rcsa_no: rcsa_no},
			success: function(msg){
				stopLooding('.table-top-ten');
				window.location.href=base_url + 'approve-admin';
				// window.location.href=base_url;
				pesan_toastr('Propose success','success',msg,'toast-top-right');
				// get_register(rcsa_no);
			},
			failed: function(msg){
				pesan_toastr('Propose failed','err',msg,'toast-top-right');
			},
		});


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
			type: "post",
			url: base_url + "approve-admin/get-register",
			data: {"id":id},
			dataType: "json",
			success:function(result){
				if (result.length == 0) {
					alert();
				} else {
					$('.tbl-risk-register').html(result);
					stopLooding(parent);
				}
			},
			error:function(msg){ 
				pesan_toastr('Jaringan sedang bermasalah !','err','Error','toast-top-center');
			},
			complate:function(){
				
			}
		})



	}

	function well(parent, string)
	{
		parent.empty();
		parent.append('<div class="well">'+string+'<div>');
	}

	function show_riskcontext(hasil){
		$("#modal_general").find(".modal-body").html(hasil.combo);
		$("#modal_general").find(".modal-title").html('RISK REGISTER');
		$("#modal_general").modal("show");
	}