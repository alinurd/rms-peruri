var asal_event;
$(function () {
  $(document).ready(function () {
    // Event listener for changes on likehold and impact dropdowns
    $(document).on("change", ".select2", function () {
      var id = $(this).data("id");
      var month = $(this).data("month");
      var likeholdValue = $("#likehold" + id + "_" + month).val();
      var impactValue = $("#impact" + id + "_" + month).val();
      // Memastikan month dan impactValue terdefinisi
      if (month !== undefined && impactValue !== undefined) {
        var data = {
          likelihood: likeholdValue,
          impact: impactValue,
          month: month,
          id: id,
        };
        var parent = $(this).parent();
        var url = modul_name + "/cek-level";

        cari_ajax_combo("post", parent, data, "", url, "Level_risiko_result");
      } else {
        console.error(
          "Error: month atau impact tidak terdefinisi dengan benar."
        );
      }
    });
  });

  $("#log_validasi").click(function () {
    var periode = $("#filter_periode").val();
    var owner = $("#filter_owner").val();
    var triwulan = $("#filter_triwulan").val();
    var url = modul_name + "/get_log_modal";

    var data = {
      periode: periode,
      owner: owner,
      triwulan: triwulan,
    };
    var parent = $(this).parent();

    // // Trigger AJAX function to retrieve modal content
    cari_ajax_combo("get", parent, data, "", url, "result_show_model");
  });

  $("#simpan_validasi").on("click", function () {
    // Ambil nilai dari elemen input
    var owner = $("#filter_owner").val();
    var periode = $("#filter_periode").val();

    // Ambil elemen parent untuk digunakan dalam proses ajax
    var parent = $(this).parent();

    // URL untuk mengirimkan data
    var url = modul_name + "/save";

    // Ambil form berdasarkan ID
    // var form = document.querySelector("#level"); // Mengambil form dengan ID 'level'
    // var formData = new FormData($("#level")[0]);
    var form = $("#level").get(0);
    var data = new FormData(form);

    // Membuat objek FormData dari form yang dipilih
    // var formData = new FormData(form);

    // Menambahkan data tambahan ke FormData
    data.append("owner", owner); // Menambahkan data owner
    data.append("periode", periode); // Menambahkan data periode

    // Panggil fungsi cari_ajax_combo_new untuk mengirimkan data
    cari_ajax_combo_new("post", parent, data, "", url, "result_realisasi");
  });

  //
});

$(".select2").select2({
  allowClear: false,
  // width: 'style',
  // dropdownParent:	$('#modal_general')
  // dropdownParent: $('#modal_general .modal-content')
});
// 	$('select').select2({
//     dropdownParent: $('#modal_general')
// });

// $(".hoho").select2({

// 	// allowClear: false,
// 	// width:'style',
// 	dropdownParent:	$('#modal_general')
// 	});

function result_realisasi(hasil) {
  pesan_toastr(
    "Berhasil disimpan...",
    "success",
    "Success",
    "toast-top-center",
    true
  );
  location.reload();
}

function Level_risiko_result(hasil) {
  if (hasil.mode === 1 || hasil.mode === 2) {
    $(`#targetResidualLabel${hasil.id}${hasil.month}`).html(hasil.level_text);
  } else {
    console.log(hasil.level_no);
    // Mengisi field inherent_level
    $(`#inherent_level${hasil.id}_${hasil.month}`).val(hasil.level_no);

    // Updating the label text
    $(`#targetResidualLabel${hasil.id}${hasil.month}`).html(hasil.level_text);
  }
}

function result_show_model(hasil) {
  $("#modal_general .modal-body").html(hasil.register);
  $("#modal_general .modal-title").html("Log Validasi Level Risiko");
  $(".select2").select2();
  $("#modal_general").modal("show");
}
