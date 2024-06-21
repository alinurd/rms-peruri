$(function(){

$(document).on("click","#proses, .show_data", function(){
    var bulan2 = $("#bulan option:selected").text();
    $("#bulan2").val(bulan2);
    var tahun = $("#periode_no option:selected").text();
    $("#tahun").val(tahun);
    var unit1 = $("#owner_no option:selected").text();
    var unit = unit1.trim();
    $("#unit").val(unit);
    var data=$("#form_grafik").serialize();
    var parent = $(this).parent();
    var target_combo = "";
    var url = modul_name+"/get-gr";
    
    cari_ajax_combo("post", parent, data, "", url, 'show_data');
  }) 
$(document).on("click","#coba", function(){
  var owner_no = $("#owner_no").val();
  var periode_no = $("#periode_no").val();
  var bulan = $("#bulan").val();
  var unit = $("#unit").val();
  var tahun = $("#tahun").val();
  var bulan2 = $("#bulan2").val();
  var data={'owner_no':owner_no,'periode_no':periode_no,'bulan':bulan,'unit':unit,'tahun':tahun,'bulan2':bulan2};
  // var data={'owner_no':owner_no,'periode_no':periode_no,'unit':unit,'tahun':tahun};
  var url = base_url + modul_name+"/cetak-register/pdf/"+ owner_no+"/"+periode_no+"/"+bulan+"/"+tahun+"/"+bulan2;
    window.open(url, '_blank');
})
});

function show_data(hasil){
 
  $("#modal_general").find(".modal-body").html(hasil.combo);
  $("#modal_general").find(".modal-title").html('Risk Monitoring');
  $("#modal_general").modal("show");
}
