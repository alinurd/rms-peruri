$(function(){
	$("#owner_no, #period_no").change(function(){
		var parent = $(this).parent();
		var id_owner = $("#owner_no").val();
		var id_period = $("#period_no").val();
		var id=parseFloat(id_owner) + "-" + parseFloat(id_period) + "-" + parseFloat(type_dash);
		var data={ 'id':id };
		var url = "ajax/get_project_name";
		cari_ajax_combo("post", parent, data, $("#project_no"), url);
	});
	
	$("#project_no").change(function(){
		var id_project = $(this).val();
		if (id_project>0){
			$("button#btn-search").removeClass('disabled');
			get_register(id_project);
		}
		else {
			$("button#btn-search").addClass('disabled');
		}
	});


		
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
		var rcsa_no = $("#project_no").val();
		var data = [];
		var url = base_url + 'propose-div/propose';
		$('.table-top-ten > tbody > tr').each(function(){
			var id = parseInt($(this).find('td button').attr('data-urgency'));
			data.push(id);
		});

		looding('light', '.table-top-ten');
		$.ajax({
			type: "post",
			url: url,
			data: {data:data, rcsa_no: rcsa_no},
			success: function(msg){
				stopLooding('.table-top-ten');
				pesan_toastr('Propose success','success',msg,'toast-top-right');
				get_register(rcsa_no);
			},
			failed: function(msg){
				pesan_toastr('Propose failed','err',msg,'toast-top-right');
			},
		});
	});


	function get_register(id)
	{	
		var parent =  $('.tbl-risk-register');
		well(parent, 'load data');

		looding('light', parent);
		$.ajax({
			type: "post",
			url: base_url + "propose-div/get-register",
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
				pesan_toastr('Error Load Database','err','Error','toast-top-center');
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

});