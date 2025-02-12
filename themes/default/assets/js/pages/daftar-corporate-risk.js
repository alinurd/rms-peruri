$(function () {
   
  $(document).on("click", "#ModalEditEvent", function () {
    var id = $(this).data("id");
    var data = { id: id };
    var parent = $(this).parent();
    var target_combo = "";
    var url = modul_name + "/get-detail-edit";

    cari_ajax_combo("post", parent, data, "", url, "show_register");
  });

  $(document).on("click", "#simpan_event_name", function () {
  
    data = $("form#form_event").serialize();

    var parent = $(this).parent();
    var target_combo = "";
    var url = modul_name + "/Simpan-Risk-event";
    //cari_ajax_singgle("post", data, url,);
    cari_ajax_combo("post", parent, data, "", url, "result_save_risk_event");
  });
 
});


function show_detail(hasil) {
  $("#modal_general").find(".modal-body").html(hasil.combo);
  $("#modal_general").find(".modal-title").html("CORPORATE RISK");
  $("#modal_general").modal("show");
}

function show_register(hasil) {
  $("#modal_general").find(".modal-body").html(hasil.detail);
  $("#modal_general").find(".modal-title").html("EDIT RISK EVENT");
  $("#modal_general").modal("show");
}

function result_save_risk_event(hasil) {
  if(hasil.id !== ""){
    pesan_toastr(
      "Berhasil menyimpan data..",
      "success",
      "success",
      "toast-top-center",
      true
    );
    setTimeout(function() {
      window.location.reload();
    }, 1000);
  }else{
   
    pesan_toastr(
      "Gagal menyimpan data..",
      "err",
      "Error",
      "toast-top-center",
      true
    );
    setTimeout(function() {
      window.location.reload();
    }, 1000);
  }
}