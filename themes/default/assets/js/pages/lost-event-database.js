// ================================
// Variable Declarations
// ================================
var asal_event;

// ================================
// Document Ready - Initial Setup
// ================================
$(function () {
  $(document).ready(function () {
    // ==========================================
    // Event Listener for Opening Modal
    // ==========================================
    $(".openModal").click(function () {
      var id = $(this).data("id");
      var type = $(this).data("type");
      var url = modul_name + "/get_detail_modal";
      var rcsa_no = $("#filter_judul_assesment").val();
      if (rcsa_no === "" && type === "add") {
        alert("Pilih judul assesment terlebih dahulu !!!");
        return false;
      }

      var data = {
        id_edit: id,
        type: type,
        rcsa: rcsa_no,
      };
      var parent = $(this).parent();

      // Trigger AJAX function to retrieve modal content
      cari_ajax_combo("post", parent, data, "", url, "result_show_model");
    });

    // ==========================================
    // Clear Modal Inputs on Close
    // ==========================================
    $("#modal_general").on("hidden.bs.modal", function () {
      // Reset input fields when modal is closed
      $(
        "#id_detail, #identifikasi_kejadian, #kategori, #sumber_penyebab, #penyebab_kejadian, #penanganan, #kat_risiko, #hub_kejadian_risk_event, #status_asuransi, #nilai_premi, #nilai_klaim, #mitigasi_rencana, #mitigasi_realisasi, #rencana_perbaikan_mendatang, #pihak_terkait, #penjelasan_kerugian, #nilai_kerugian, #kejadian_berulang, #frekuensi_kejadian, #skal_dampak_in, #skal_prob_in, #Target_Res_dampak, #Target_Res_prob"
      ).val("");
    });

    // ==========================================
    // Save Button - Data Validation & Submission
    // ==========================================
    $(document).on("click", "#btn-simpan", function () {
      const type = $(this).attr("data-type");
      const id_edit = $(this).attr("data-edit");

      // Collect values from modal inputs
      const data = {
        id_edit,
        type,
        rcsa_no:
          type === "edit"
            ? $("#rcsa_no_e").val()
            : $("#filter_judul_assesment").val(),
        event_no: $("#event_no").val(),
        nama_event: $("#peristiwabaru").val(),
        id_detail: $("#id_detail").val(),
        identifikasi_kejadian: $("#identifikasi_kejadian").val(),
        kategori: $("#kategori").val(),
        sumber_penyebab: $("#sumber_penyebab").val(),
        penyebab_kejadian: $("#penyebab_kejadian").val(),
        penanganan: $("#penanganan").val(),
        kat_risiko: $("#kat_risiko").val(),
        hub_kejadian_risk_event: $("#hub_kejadian_risk_event").val(),
        status_asuransi: $("#status_asuransi").val(),
        nilai_premi: $("#nilai_premi").val(),
        nilai_klaim: $("#nilai_klaim").val(),
        mitigasi_rencana: $("#mitigasi_rencana").val(),
        mitigasi_realisasi: $("#mitigasi_realisasi").val(),
        rencana_perbaikan_mendatang: $("#rencana_perbaikan_mendatang").val(),
        pihak_terkait: $("#pihak_terkait").val(),
        penjelasan_kerugian: $("#penjelasan_kerugian").val(),
        nilai_kerugian: $("#nilai_kerugian").val(),
        kejadian_berulang: $('input[name="kejadian_berulang"]:checked').val(),
        frekuensi_kejadian: $("#frekuensi_kejadian").val(),
        skal_dampak_in: $("#skal_dampak_in").val(),
        skal_prob_in: $("#skal_prob_in").val(),
        target_res_dampak: $("#Target_Res_dampak").val(),
        target_res_prob: $("#Target_Res_prob").val(),
      };

      const url = modul_name + "/simpan_lost_event";
      cari_ajax_combo(
        "post",
        $(this).parent(),
        data,
        "",
        url,
        "result_simpan_lost_event"
      );
    });

    // ==========================================
    // Update Risk Level Analysis on Change
    // ==========================================
    $(document).on("change", "#skal_dampak_in, #skal_prob_in", function () {
      updateRiskLevel(
        "#skal_dampak_in",
        "#skal_prob_in",
        "LevelAnalisisInheren"
      );
    });

    $(document).on(
      "change",
      "#Target_Res_dampak, #Target_Res_prob",
      function () {
        updateRiskLevel(
          "#Target_Res_dampak",
          "#Target_Res_prob",
          "LevelAnalisisIResidual"
        );
      }
    );

    // Trigger delete confirmation modal
    $("li.delete").on("click", null, function () {
      $("#id_lost").val($(this).data("id"));
      $("#confirmDelete").modal("show"); // Show the confirmation modal
    });

    // Confirm delete action
    $("#confirm").one("click", function () {
      var id = $("#id_lost").val(); // Get the URL from data attribute
      const data = {
        id: id,
      };
      cari_ajax_combo(
        "post",
        $(this).parent(),
        data,
        "",
        modul_name + "/delete-data",
        "resultDelete"
      );
    });

    function updateRiskLevel(
      likelihoodSelector,
      impactSelector,
      resultFunction
    ) {
      const data = {
        likelihood: $(likelihoodSelector).val(),
        impact: $(impactSelector).val(),
      };
      cari_ajax_combo(
        "post",
        $(likelihoodSelector).parent(),
        data,
        "",
        modul_name + "/cek-level",
        resultFunction
      );
    }

    $(document).on("change", "#filter_owner,#filter_periode", function () {
      UpdateJudulAssesment(
        "#filter_owner",
        "#filter_periode",
        "resultJudulAssesment"
      );
    });

    function UpdateJudulAssesment(
      filter_owner,
      filter_periode,
      resultFunction
    ) {
      const data = {
        owner_no: $(filter_owner).val(),
        tahun: $(filter_periode).val(),
      };
      cari_ajax_combo(
        "post",
        $(filter_owner).parent(),
        data,
        "",
        modul_name + "/get-judul-assesment",
        resultFunction
      );
    }
  });

  $(document).on("change", "#id_detail", function () {
    getDataMitigasi("#id_detail", "resultGetmitigasi");
  });

  function getDataMitigasi(id_detail, resultFunction) {
    const data = {
      id_detail: $(id_detail).val(),
    };
    cari_ajax_combo(
      "post",
      $(id_detail).parent(),
      data,
      "",
      modul_name + "/get-mitigasi",
      resultFunction
    );
  }
});

// ==========================================
// Modal Functions to Display Results
// ==========================================
function LevelAnalisisInheren(hasil) {
  $("#level_risiko_inher_label").html(hasil.level_text);
}

function LevelAnalisisIResidual(hasil) {
  $("#level_risiko_res_label").html(hasil.level_text);
}

function result_modal_data(hasil) {
  $("#modalUpdate").modal("show");
}

function resultGetmitigasi(hasil) {
  $("#mitigasi_rencana").val(hasil.proaktif);
  $("#event_no").val(hasil.event_no);
}

function resultJudulAssesment(hasil) {
  // Mengganti opsi di dalam #filter_judul_assesment
  $("#filter_judul_assesment").html(hasil.options);

  // Inisialisasi ulang select2 jika diperlukan
  $("#filter_judul_assesment").select2();
}
function resultDelete(hasil) {
  pesan_toastr(
    "Berhasil dihapus...",
    "success",
    "Success",
    "toast-top-center",
    true
  );
  // Tambahkan waktu penundaan sebelum halaman di-reload
  setTimeout(function () {
    location.reload();
  }, 5000); // 3000 ms = 3 detik (sesuaikan sesuai kebutuhan)
}

// ==========================================
// Result Display Functions
// ==========================================
function result_simpan_lost_event(hasil) {
  pesan_toastr(
    "Berhasil disimpan...",
    "success",
    "Success",
    "toast-top-center",
    true
  );
  // Tambahkan waktu penundaan sebelum halaman di-reload
  setTimeout(function () {
    location.reload();
  }, 5000); // 3000 ms = 3 detik (sesuaikan sesuai kebutuhan)
}

function result_show_model(hasil) {
  $("#modal_general .modal-body").html(hasil.register);
  $("#modal_general .modal-title").html("LOSS EVENT DATABASE");
  $(".select2").select2();
  $("#modal_general").modal("show");
}
