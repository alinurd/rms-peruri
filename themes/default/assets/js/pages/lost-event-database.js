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
      var filter_owner = $("#filter_owner").val();
      var filter_periode = $("#filter_periode").val();
      var data = {
        id_edit: id,
        type: type,
        rcsa: rcsa_no,
        filter_owner: filter_owner,
        filter_periode: filter_periode,
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
      // if (validateInputs()) {
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
      // }
      // return false;
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
  // console.log(hasil);
  $("#mitigasi_rencana").val(hasil.proaktif);
  // $("#level_risiko_inher_label").html(hasil.level_text);
}

// ==========================================
// Validation Function for Input Fields
// ==========================================
// function validateInputs() {
//   $(".text-danger").empty(); // Clear previous error messages
//   let hasError = false;

//   const requiredFields = [
//     { id: "#id_detail", errorMsg: "Nama Kejadian harus diisi." },
//     {
//       id: "#identifikasi_kejadian",
//       errorMsg: "Identifikasi Kejadian harus diisi.",
//     },
//     // Add more fields with specific error messages here
//   ];

//   requiredFields.forEach((field) => {
//     if (!$(field.id).val()) {
//       $(field.id).siblings(".text-danger").text(field.errorMsg);
//       hasError = true;
//     }
//   });

//   return !hasError; // Return false if any validation failed
// }

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
