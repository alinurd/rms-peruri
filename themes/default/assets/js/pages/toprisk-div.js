$(function(){
	$(document).on('click','.move',function () {
	    var row = $(this).closest("tr");
	    var table = $(this).closest("table");
	    row.detach();
	 	var tbl_top = $(".tbl-top-ten");
	 	var tbl_risk = $(".tbl-risk-register");
	    if (table.is(".tbl-risk-register")) {
	    	$(this).text('drop');
	        tbl_top.append(row);
	    }
	    else {
	    	$(this).text('select');
	        tbl_risk.append(row);
	    }
    	var l = $(".tbl-top-ten tbody tr").length;
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
		var url = base_url + 'toprisk-div/propose';
		$('.tbl-top-ten > tbody > tr').each(function(){
			var id = parseInt($(this).find('td button').attr('data-urgency'));
			var rcsa = parseInt($(this).find('td button').attr('data-rcsa'));
			data.push(id);
			rcsa_no.push(rcsa);
		});

		looding('light', '.tbl-top-ten');
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
			url: base_url + "approve-div/get-register",
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

});