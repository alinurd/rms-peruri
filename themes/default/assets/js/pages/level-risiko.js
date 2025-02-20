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

    // Mendapatkan parameter 'page' dari URL
    var urlParams = new URLSearchParams(window.location.search);
    var page = urlParams.get("page") || 1; // Jika tidak ada, set halaman default ke 1

    var url = modul_name + "/get_log_modal";

    // Menyiapkan data yang akan dikirim ke server
    var data = {
      periode: periode,
      owner: owner,
      triwulan: triwulan,
      page: page, // Menambahkan page dari URL
    };

    var parent = $(this).parent();

    // // Trigger AJAX function to retrieve modal content
    cari_ajax_combo("get", parent, data, "", url, "result_show_model");
  });

  $(".nilai_impact, .nilai_likelihood").on("input", function () {
    var id = $(this).data("id");
    var month = $(this).data("month");
    calculateExposure(id, month);
  });

  function calculateExposure(id, month) {
    var nilai_impact = $("#nilai_impact" + id + "_" + month)
      .val()
      .replace(/[^0-9.-]+/g, ""); // Menghapus semua karakter kecuali angka dan tanda minus
    nilai_impact = parseFloat(nilai_impact) || 0; // Mengonversi ke float

    var nilai_likelihood =
      parseFloat($("#nilai_likelihood" + id + "_" + month).val()) || 0;
    nilai_likelihood = nilai_likelihood / 100; // Mengonversi likelihood dari persen ke desimal
    var nilai_exposure = nilai_impact * nilai_likelihood;

    $("#nilai_exposure" + id + "_" + month).val(
      nilai_exposure
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",") // Menambahkan koma sebagai pemisah ribuan
        .replace(".", ",") // Mengganti titik dengan koma untuk desimal
    );
  }

  $("#simpan_validasi").on("click", function () {
    var owner = $('select[name="owner"]').val(); // Semester
    var periode = $('select[name="periode"]').val(); // Get selected value from 'periode' dropdown

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
    var nilai_impact = [];
    var nilai_likelihood = [];
    var nilai_exposure = [];

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

    $('input[name="nilai_impact[]"]').each(function () {
      nilai_impact.push($(this).val());
    });

    $('input[name="nilai_likelihood[]"]').each(function () {
      nilai_likelihood.push($(this).val());
    });

    $('input[name="nilai_exposure[]"]').each(function () {
      nilai_exposure.push($(this).val());
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
      nilai_impact: nilai_impact,
      nilai_likelihood: nilai_likelihood,
      nilai_exposure: nilai_exposure,
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
