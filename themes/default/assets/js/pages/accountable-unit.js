$(function(){

$(document).on("click","#proses, .show_data", function(){
    
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
  var unit = $("#unit").val();
  var tahun = $("#tahun").val();
  var data={'owner_no':owner_no,'periode_no':periode_no,'unit':unit,'tahun':tahun};
  var url = modul_name+"/cetak-register/pdf/"+ owner_no+"/"+periode_no+"/"+tahun;
    window.open(url, '_blank');
})
});

function show_data(hasil){
  $("#modal_general").find(".modal-body").html(hasil.combo);
  $("#modal_general").find(".modal-title").html('Accountable Unit Mapping');
  $("#modal_general").modal("show");
}
