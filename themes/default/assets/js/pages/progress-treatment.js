var asal_event;
$(function () {
  // $(document).on("click", "[id^=simpan_realisasi_]", function () {
  //   var id = $(this).data("id");
  //   var month = $(this).data("month");

  //   // Ambil nilai input berdasarkan ID unik
  //   var target_progress = $(
  //     "input[name='target_progress" + id + month + "']"
  //   ).val();
  //   var target_damp_loss = $(
  //     "input[name='target_damp_loss" + id + month + "']"
  //   ).val();
  //   var progress = $("input[name='progress" + id + month + "']").val();
  //   var damp_loss = $("input[name='damp_loss" + id + month + "']").val();

  //   var data = {
  //     id_edit: id,
  //     month: month,
  //     target_progress: target_progress,
  //     target_damp_loss: target_damp_loss,
  //     progress: progress,
  //     damp_loss: damp_loss,
  //   };

  //   var parent = $(this).parent();
  //   var target_combo = "";
  //   var url = modul_name + "/simpan-realisasi";

  //   cari_ajax_combo(
  //     "post",
  //     parent,
  //     data,
  //     target_combo,
  //     url,
  //     "result_realisasi"
  //   );

  //   // return false;  // Untuk mencegah reload halaman
  // });

  $("#simpan_validasi").on("click", function () {
    var owner = $('select[name="owner"]').val(); // Semester
    var periode = $('select[name="periode"]').val(); // Get selected value from 'periode' dropdown

    // Arrays to store the values
    var rcsa_detail_no = [];
    var rcsa_action_no = [];
    var ids = [];
    var rcsa_no = [];
    var months = [];
    var id_edit = [];
    var inherent_level = [];
    var likehold = [];
    var impact = [];
    var target_progress = [];
    var progress = [];
    var target_damp_loss = [];
    var damp_loss = [];

    // Collect values from hidden inputs based on name attributes
    $('input[name="id_edit[]"]').each(function () {
      id_edit.push($(this).val());
    });

    $('input[name="id_detail[]"]').each(function () {
      ids.push($(this).val());
    });

    $('input[name="id_action[]"]').each(function () {
      rcsa_action_no.push($(this).val());
    });

    $('input[name="bulan[]"]').each(function () {
      months.push($(this).val());
    });

    // Collect values for target_progress and progress
    $('input[name="target_progress[]"]').each(function () {
      target_progress.push($(this).val());
    });

    $('input[name="progress[]"]').each(function () {
      progress.push($(this).val());
    });

    // Collect values for target_damp_loss and damp_loss
    $('input[name="target_damp_loss[]"]').each(function () {
      target_damp_loss.push($(this).val());
    });

    $('input[name="damp_loss[]"]').each(function () {
      damp_loss.push($(this).val());
    });

    // Collect other necessary data
    $('input[name="rcsa_no[]"]').each(function () {
      rcsa_no.push($(this).val());
    });

    $('input[name="inherent_level[]"]').each(function () {
      inherent_level.push($(this).val());
    });

    // Collect dropdown values likehold and impact
    $('select[name="likehold[]"]').each(function () {
      likehold.push($(this).val());
    });

    $('select[name="impact[]"]').each(function () {
      impact.push($(this).val());
    });

    // Collecting final data in an object
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
      target_progress: target_progress,
      progress: progress,
      target_damp_loss: target_damp_loss,
      damp_loss: damp_loss,
      owner: owner,
      periode: periode,
    };

    var target_combo = "";
    var parent = $(this).parent();
    var url = modul_name + "/save"; // URL for submitting the data

    // Call the custom function to send the data via AJAX
    cari_ajax_combo("post", parent, data, "", url, "result_realisasi");
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
});

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

function result_show_model(hasil) {
  $("#modal_general .modal-body").html(hasil.register);
  $("#modal_general .modal-title").html("Log Validasi Progress Treatment");
  $(".select2").select2();
  $("#modal_general").modal("show");
}
