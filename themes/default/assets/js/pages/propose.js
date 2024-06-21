$(function(){
	$("#owner_no, #period_no").change(function(){
		var parent = $(this).parent();
		var id_owner = $("#owner_no").val();
		var id_period = $("#period_no").val();
		var id=parseFloat(id_owner) + "-" + parseFloat(id_period) + "-" + parseFloat(type_dash);
		var data={'id':id};
		var url = "ajax/get_project_name";
		cari_ajax_combo("post", parent, data, $("#project_no"), url);
	});
	
	$("#project_no").change(function(){
		var id_project = $(this).val();
		if (id_project>0)
			$("button#btn-search").removeClass('disabled');
		else
			$("button#btn-search").addClass('disabled');
	});
	
	$("form#propose").submit(function(){
		pesan_toastr('Mohon Tunggu','info','Prosess','toast-top-center');
		looding('light',$("#overlay_content"));
		return true;
	});
		
	$('#confirm_send').on('click', function (e) {
		var url=base_url+'/propose/send_email';
		var rsca=rcsa_tmp;
		var sts=sts_tmp;
		var project=parseFloat($("#project_no").val());
		var x = $('#email_address').val();
		if (IsEmail(x)){
			var lanjut=true;
			if (sts=='1'){
				lanjut=confirm(Globals.tips_propose_again);
			}else if(project<=0){
				alert(Globals.tips_no_propose_select);
				lanjut=false;
			}
			if (lanjut) {
				var form={'email':x,'rsca':project};
				$("#loading").removeClass('hide');
				$.ajax({
					type: "GET",
					url: url,
					data: form,
					success: function(msg){
						alert(msg);
						$("#loading").addClass('hide');
					},
					failed: function(msg){
						$("#loading").addClass('hide');
						alert(Globals.tips_failed_send_email);
					},
				});
			}
		}else{
			alert(Globals.tips_wrong_email_address);
		}
	});
});