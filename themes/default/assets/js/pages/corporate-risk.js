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
		// var url = modul_name + "/get_map";
		var url1 = modul_name + "/map_residual1";
		var url2 = modul_name + "/map_residual2";

    //   cari_ajax_combo("post", parent, data, target_combo, url, "result_map");
      cari_ajax_combo("post", parent, data, target_combo, url2, "result_map1");
      cari_ajax_combo("post", parent, data, target_combo, url1, "result_map2");

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
 
	// $(document).on("click",".sub_detail",function(){
	// 	var parent = $(this).parent().parent();
	// 	var id = $(this).data('id');
	// 	var data={'id':id};
	// 	var target_combo = $("#sub_detail");
	// 	var url = modul_name+"/get-subdetail";
		
	// 	cari_ajax_combo("post", parent, data, target_combo, url);

	// })

	$(document).on("click", ".sub_detail", function () {
		var parent = $(this).parent().parent();
		var id = $(this).data("id");
		var kel =  $(this).data("kel");
		var data = { id: id };
		var target_combo = $("#sub_detail");
		var url = modul_name + "/get-subdetail";
		if(kel == "Target"){
		  var bulan =  $(this).data("bulan");
		  var data = { id: id , bulan:bulan };
		  var target_combo = $("#sub_detail_target");
		  var url = modul_name + "/get-subdetailTarget";
		}
	
		cari_ajax_combo("post", parent, data, target_combo, url);
	  });
});
	// function hoho(e) {
	// 	var parent = $(e).parent();
	// 	var nilai = $(e).data('nilai');
			
	// 	if (nilai>0){
	// 	var id = $(e).data('id');
	// 	var kel = $(e).data('kel');
	// 	var owner = $("#owner_no").val();
	// 	var tahun = $("#period_no").val();
	// 	var bulan = $("#bulan").val();

	// 	var data={'id':id,'owner':owner,'tahun':tahun, 'bulan':bulan,'kel':kel};
	// 	var target_combo = $("#detail_map");
	// 	var url = modul_name+"/get-detail-map";
		
	// 	cari_ajax_combo("post", parent, data, target_combo, url, 'show_detail');
	// 	}
	// }

	function hoho(e) {
		var parent = $(e).parent();
		var nilai = $(e).data("nilai");
	  
		if (nilai > 0) {
		  var id = $(e).data("id");
		  var kel = $(e).data("kel");
		  var like = $(e).data("like");
		  var impact = $(e).data("impact");
		  var owner = $("#owner_no").val();
		  var tahun = $("#period_no").val();
		  var bulan = $("#bulan").val();
		  // var bulanx = $("#bulanx").val();
		  // console.log(kel + '2')
		  var data = {
			id: id,
			owner: owner,
			tahun: tahun,
			// bulanx: bulanx,
			bulan: bulan,
			kel: kel,
			like: like,
			impact: impact,
		  };
		  // console.log(data)
		  var target_combo = $("#detail_map");
		  var url = modul_name + "/get-detail-map";
	  
		  if (kel == "residual1" || kel == "residual2") {
			var target_combo = $("#detail_map2");
			var url = modul_name + "/get-detail-map2";
			// console.log('masuk ke =>residual2')
		  }
		  if (kel == "residual") {
			var target_combo = $("#detail_map");
			var url = modul_name + "/get-detail-map-res";
			// get_detail_map_res
		  }
	  
		  if (kel == "Target") {
			var target_combo = $("#detail_map");
			var url = modul_name + "/get-detail-map-target";
			// get_detail_map_res
		  }
		  console.log(kel);
	  
		  cari_ajax_combo("post", parent, data, target_combo, url, "show_detail");
		}
	  }
function result_map(hasil){
    $("#mapping_inherent").html(hasil.inherent);
    $("#mapping_residual").html(hasil.residual);
}

  function result_map2(hasil) {
	$("#mapping_residual2").html(hasil.residual2);
  }
  function result_map1(hasil) {
	$("#mapping_residual1").html(hasil.residual1);
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
