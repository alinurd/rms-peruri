$(function(){
	$("#lbl_option").click(function(){
        $("#option").toggle();
    })

    $("#proses").click(function(){
		var parent = $(this).parent();
		var data=$("#form_grafik").serialize();
		var target_combo = $("#content_detail");
		var url = modul_name+"/get-grafik";

		cari_ajax_combo("post", parent, data, target_combo, url);
	});
	
	$("#owner_no,#periode_no").change(function(){
		var owner = $("#owner_no").val();
        var period = $("#periode_no").val();
        var data={'owner':owner, 'period':period};
        var target_combo = $("#risk_context");
		var url = modul_name+"/get-riskcontext";
		
		cari_ajax_combo("post", parent, data, target_combo, url);
	})
});

$(document).ready(function(){
    $("#owner_no").trigger('change');
})


