$(function(){
	
});

$(document).ready(function() {
	$("#datatables").on("click","span.detail",function(){
		var id=$(this).attr("data-id");
		var data={"id":id};
		var url=base_url + "ajax/get-detail-action";
		looding('light',$(this).parent());
		$.ajax({
			type:"POST",
			url:url,
			data:data,
			success:function(msg){
				stopLooding($(this).parent());
				$("#general_modal").find(".modal-body").html(msg);
				$("#general_modal").modal("show");
			},
			failed: function(msg){
				stopLooding($(this).parent());
				pesan_toastr("Error Load Database","err","Error","toast-top-center");
			},
			error: function(msg){
				stopLooding($(this).parent());
				pesan_toastr("Error Load Database","err","Error","toast-top-center");
			},
		});
		return false;
	})
})