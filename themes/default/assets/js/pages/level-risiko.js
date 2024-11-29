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
    var owner = $('input[name="owner"]').val(); // Semester
    var periode = $('input[name="periode"]').val(); // Periode

    // Arrays untuk menyimpan nilai dari input yang diambil
    var rcsa_detail_no = [];
    var rcsa_action_no = [];
    var ids = [];
    var rcsa_no = [];
    var months = [];
    var id_edit = [];
    var inherent_level = [];
    var likehold = [];
    var impact = [];

    // Ambil nilai dari input hidden berdasarkan name="rcsa_detail_no[]", "rcsa_action_no[]", dll
    $('input[name="rcsa_detail_no[]"]').each(function () {
      rcsa_detail_no.push($(this).val());
    });

    $('input[name="rcsa_action_no[]"]').each(function () {
      rcsa_action_no.push($(this).val());
    });

    $('input[name="id[]"]').each(function () {
      ids.push($(this).val());
    });

    $('input[name="rcsa_no[]"]').each(function () {
      rcsa_no.push($(this).val());
    });

    $('input[name="month[]"]').each(function () {
      months.push($(this).val());
    });

    $('input[name="id_edit[]"]').each(function () {
      id_edit.push($(this).val());
    });

    $('input[name="inherent_level[]"]').each(function () {
      inherent_level.push($(this).val());
    });

    // Ambil nilai dari dropdown
    $('select[name="likehold[]"]').each(function () {
      likehold.push($(this).val());
    });

    $('select[name="impact[]"]').each(function () {
      impact.push($(this).val());
    });

    // Mengumpulkan data dalam objek data
    var data = {
      rcsa_detail_no: rcsa_detail_no,
      rcsa_action_no: rcsa_action_no,
      id: ids,
      rcsa_no: rcsa_no,
      month: months,
      id_edit: id_edit,
      inherent_level: inherent_level,
      likehold: likehold,
      impact: impact,
      owner: owner,
      periode: periode,
    };

    // Ambil elemen parent untuk digunakan dalam proses ajax
    var parent = $(this).parent();

    // URL untuk mengirimkan data
    var url = modul_name + "/save";

    // Panggil fungsi cari_ajax_combo_new untuk mengirimkan data
    cari_ajax_combo("post", parent, data, "", url, "result_realisasi");
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
