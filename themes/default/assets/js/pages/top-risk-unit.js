$(function () {
  $("#owner_no, #period_no,#bulan").change(function () {
    var id_owner = $("#owner_no").val();
    var id_period = $("#period_no").val();
    var bulan = $("#bulan").val();
    var bulan = $("#bulan").val();
    var tua = $("#owner_no option:selected").text();
    var owner = tua.trim();
    var bulan2 = $("#bulan option:selected").text();
    var tahun2 = $("#period_no option:selected").text();
    var id =
      parseFloat(id_owner) +
      "-" +
      parseFloat(id_period) +
      "-" +
      parseFloat(bulan) +
      "-" +
      parseFloat(type_dash);
    $("button#btn-search").addClass("disabled");
    $(".tahun2").text(tahun2);
    $(".bulan2").text(bulan2);
    $(".owner").text(owner);
    var parent = $(this).parent();
    var data = { id_owner: id_owner, id_period: id_period, bulan: bulan };
    var target_combo = $("#mapping");
    var url = modul_name + "/get_map";
    var url2 = modul_name + "/map_residual2";

    cari_ajax_combo("post", parent, data, target_combo, url, "result_map");
    cari_ajax_combo("post", parent, data, target_combo, url2, "result_map1");
  });
   
});

$(".current, .inherent, .residual").click(function () {
  let className = $(this).attr("class").split(" ")[0];  
  let elementsx = $("." + className + "Map[data-norut]:not([data-norut=''])");
  let textElement = $("#" + className + "Text"); 

  if (elementsx.is(":visible")) {
      elementsx.hide();
      textElement.css({
          "opacity": "0.5",
          "text-decoration": "line-through"
      });
  } else {
      elementsx.show();
      textElement.css({
          "opacity": "1",
          "text-decoration": "none"
      });
  }
});

function result_map(hasil) {
  $("#mapping_inherent").html(hasil.inherent);
  $("#mapping_residual").html(hasil.residual);
}

function result_map1(hasil) {
  $("#mapping_residual1").html(hasil.residual1);
}

function show_detail(hasil) {
  $("#modal_general").find(".modal-body").html(hasil.combo);
  $("#modal_general").find(".modal-title").html("TOP RISK");
  $("#modal_general").modal("show");
}
