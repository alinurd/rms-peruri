$(function(){
	$("li.event").click(function(){
		idedit=$(this).attr('value');
		rcsa=$(this).attr('rcsa');
		url = base_url+"/rcsa/risk-event";
		url += '/' + rcsa + '/' + idedit;
		looding('light',$("#overlay_content"));
		window.location = url;
	});
	
	$("#term_aktif").click(function(){
		var url="ajax/cek-term";
		cari_ajax_combo("post", $("body"), {}, "", url, "proses_term");
	});
});

function proses_term(hasil){
	if (hasil.combo!==""){
		$("#modal_general").find(".modal-dialog").removeClass("fullscreen");
		$("#modal_general").find(".modal-title").html(hasil.ket);
		$("#modal_general").find(".modal-body").html(hasil.combo);
		$("#modal_general").find(".modal-footer").removeClass("hide");
		$("#modal_general").modal("show");
	}
}