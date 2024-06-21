$(function(){
	$("#owner_no, #period_no,#bulan").change(function(){
		var id_owner = $("#owner_no").val();
		var id_period = $("#period_no").val();
		var bulan = $("#bulan").val();
		var tua = $("#owner_no option:selected").text();
		var owner = tua.trim();
		var bulan2 = $("#bulan option:selected").text();
		var tahun2 = $("#period_no option:selected").text();
		var id=parseFloat(id_owner) + "-" + parseFloat(id_period) + "-" + parseFloat(bulan) + "-" + parseFloat(type_dash);
		$(".tahun2").text(tahun2);
		$(".bulan2").text(bulan2);
		$(".owner").text(owner);
		var parent = $(this).parent();
		// var data={'id_owner':id_owner,'id_period':id_period,'bulan':bulan};
		var data={'id_owner':id_owner,'id_period':id_period, 'bulan':bulan};
		var target_combo = $("#mapping");
		var url = modul_name+"/get_map";

		cari_ajax_combo("post", parent, data, target_combo, url, 'result_map');
	});
 $(document).on("click","#export_data, .show_detail", function(){
		var owner = $("#owner_no").val();
		var tahun = $("#period_no").val();
		var tahun2 = $("#period_no option:selected").text();
		var bulan = $("#bulan").val();
		var bulan2 = $("#bulan option:selected").text();
		var data={'owner':owner,'tahun':tahun, 'bulan':bulan,'bulan2':bulan2,'tahun2':tahun2};
    var parent = $(this).parent();
    var target_combo = "";
    var url = modul_name+"/get-export-data";
    
    cari_ajax_combo("post", parent, data, "", url, 'show_detail');
  })

  $(document).on("click","#coba", function(){
	var owner1 = $("#owner1").val();
	var tahun1 = $("#tahun1").val();
	var bulan1 = $("#bulan1").val();
	var bulan2 = $("#bulan2").val();
	var tahun2 = $("#tahun2").val();
	var data={'owner1':owner1,'tahun1':tahun1,'bulan1':bulan1,'bulan2':bulan2,'tahun2':tahun2};
    var url = base_url + modul_name+"/cetak-corporate/pdf/"+ owner1+"/"+tahun1+"/"+bulan1+"/"+bulan2+"/"+tahun2;
    // console.log(url);
    window.open(url, '_blank');
    // console.log(url);
  })
 
	$(document).on("click",".sub_detail",function(){
		var parent = $(this).parent().parent();
		var id = $(this).data('id');
		var data={'id':id};
		var target_combo = $("#sub_detail");
		var url = modul_name+"/get-subdetail";
		
		cari_ajax_combo("post", parent, data, target_combo, url);

	})
});
	function hoho(e) {
		var parent = $(e).parent();
		var nilai = $(e).data('nilai');
			
		if (nilai>0){
		var id = $(e).data('id');
		var kel = $(e).data('kel');
		var owner = $("#owner_no").val();
		var tahun = $("#period_no").val();
		var bulan = $("#bulan").val();

		var data={'id':id,'owner':owner,'tahun':tahun, 'bulan':bulan,'kel':kel};
		var target_combo = $("#detail_map");
		var url = modul_name+"/get-detail-map";
		
		cari_ajax_combo("post", parent, data, target_combo, url, 'show_detail');
		}
	}
function result_map(hasil){
    $("#mapping_inherent").html(hasil.inherent);
    $("#mapping_residual").html(hasil.residual);
}
// function joni(hasil){
// 	$(".tahun2").text(hasil.tahun2);
// 	console.log(hasil.tahun2);
// }

function show_detail(hasil){
	$("#modal_general").find(".modal-body").html(hasil.combo);
	$("#modal_general").find(".modal-title").html('CORPORATE RISK');
	$("#modal_general").modal("show");
}
