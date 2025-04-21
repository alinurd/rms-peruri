$(function () {
  $("#owner_no, #period_no,#bulan,#bulanx,#datetimepickerx").change(
    function () {
      var id_owner = $("#owner_no").val();
      var id_period = $("#period_no").val();
      var bulan = $("#bulan").val();
      // var bulanxx = $("#bulanx").val();
      var tanggalxx = $("#datetimepickerx").val();
      var date = new Date(tanggalxx);
      var tanggal =
        date.getFullYear() +
        "-" +
        ("0" + (date.getMonth() + 1)).slice(-2) +
        "-" +
        ("0" + date.getDate()).slice(-2) +
        " " +
        ("0" + date.getHours()).slice(-2) +
        ":" +
        ("0" + date.getMinutes()).slice(-2);
      // console.log(formattedDate);

      var tua = $("#owner_no option:selected").text();
      var owner = tua.trim();
      // var tanggal = $("#datetimepicker option:selected").text();
      // var bulanx = $("#bulanx option:selected").text();
      var bulan2 = $("#bulan option:selected").text();
      var tahun2 = $("#period_no option:selected").text();
      var id =
        parseFloat(id_owner) +
        "-" +
        parseFloat(id_period) +
        "-" +
        parseFloat(bulan) +
        // "-" +
        // parseFloat(bulanxx) +
        "-" +
        parseFloat(tanggal) +
        "-" +
        parseFloat(type_dash);
      $(".tahun2").text(tahun2);
      $(".bulan2").text(bulan2);
      // $(".bulanx").text(bulanx);
      $(".tanggal").text(tanggal);
      $(".owner").text(owner);
      var parent = $(this).parent();
      // var data={'id_owner':id_owner,'id_period':id_period,'bulan':bulan};
      var data = {
        id_owner: id_owner,
        id_period: id_period,
        bulan: bulan,
        // bulanx: bulanxx,
        tanggal: tanggal,
      };
      console.log(data);
      var target_combo = $("#mapping");
      var url = modul_name + "/get_map";
      var url2 = modul_name + "/map_residual2";

      cari_ajax_combo("post", parent, data, target_combo, url, "result_map");
      // cari_ajax_combo("post", parent, data, target_combo, url2, "result_map1");
      // cari_ajax_combo("post", parent, data, target_combo, url1, "result_map2");
    }
  );
  $(document).ready(function () {
    var id_owner = "";
    var id_period = 14;
    var bulan = 1;
    // var bulanxx = 12;
    var tanggal = 1;

    var data = {
      id_owner: id_owner,
      id_period: id_period,
      bulan: bulan,
      tanggal: tanggal,
      // bulanx: bulanxx,
    };
    console.log(data);
    var target_combo = $("#mapping");
    var url = modul_name + "/get_map";
  });

  $(document).on("click", ".detail-aksi", function () {
    var id = $(this).data("id");
    var data = { id: id };
    var parent = $(this).parent();
    var target_combo = "";
    var url = modul_name + "/get-detail-rcsa";

    cari_ajax_combo("post", parent, data, "", url, "show_register");
  });
  $(document).on("click", ".sub_detail", function () {
    var parent = $(this).parent().parent();
    var id = $(this).data("id");
    var kel = $(this).data("kel");
    var data = { id: id };
    var target_combo = $("#sub_detail");
    var url = modul_name + "/get-subdetail";
    if (kel == "Target") {
      var bulan = $(this).data("bulan");
      var data = { id: id, bulan: bulan };
      var target_combo = $("#sub_detail_target");
      var url = modul_name + "/get-subdetailTarget";
    }

    cari_ajax_combo("post", parent, data, target_combo, url);
  });
});
function hoho(e) {
  var parent = $(e).parent();
  var nilai = $(e).data("norut1");

  var id = $(e).data("id");
  var kel = $(e).data("kel");
  var owner = $("#owner_no").val();
  var tahun = $("#period_no").val();
  var bulan = $("#bulan").val();
  var bulanx = $("#bulanx").val();
  var like = $(e).data("like");
  var impact = $(e).data("impact");
  // console.log(kel + '2')
  var norut = [];
  var target_combo = $("#detail_map");
  var url = modul_name + "/get-detail-map";

  if (kel == "Inherent") {
    norut = $(e).data("norut1");
    var target_combo = $("#detail_map");
    var url = modul_name + "/get-detail-map";
  }
  if (kel == "Current") {
    norut = $(e).data("norut3");
    var target_combo = $("#detail_map");
    var url = modul_name + "/get-detail-map-res";
    // kel = "Residual";
  }
  if (kel == "Residual") {
    kel = "Target";
    norut = $(e).data("norut2");
    var target_combo = $("#detail_map");
    var url = modul_name + "/get-detail-map-target";
    // get_detail_map_res
  }

  var data = {
    id: id,
    norut: norut,
    owner: owner,
    like: like,
    impact: impact,
    tahun: tahun,
    bulanx: bulanx,
    bulan: bulan,
    kel: kel,
  };
  console.log(data);

  cari_ajax_combo("post", parent, data, target_combo, url, "show_detail");
}
function result_map(hasil) {
  $("#mapping_inherent").html(hasil.inherent);
  $("#mapping_current").html(hasil.current);
  $("#mapping_residual").html(hasil.residual);
}

function result_map1(hasil) {
  $("#mapping_residual1").html(hasil.residual1);
}

function show_detail(hasil) {
  $("#modal_general").find(".modal-body").html(hasil.combo);
  $("#modal_general").find(".modal-title").html("CORPORATE RISK");
  $("#modal_general").modal("show");
}

function show_register(hasil) {
  $("#modal_general").find(".modal-body").html(hasil.detail);
  $("#modal_general").find(".modal-title").html("");
  $("#modal_general").modal("show");
}
