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
        "#id_detail, #identifikasi_kejadian, #kategori, #sumber_penyebab, #penyebab_kejadian, #penanganan, #kat_risiko, #hub_kejadian_risk_event, #status_asuransi, #nilai_premi, #nilai_klaim, #mitigasi_rencana, #mitigasi_realisasi, #rencana_perbaikan_mendatang, #pihak_terkait, #penjelasan_kerugian, #nilai_kerugian, #kejadian_berulang, #frekuensi_kejadian, #skal_dampak_in, #skal_prob_in, #target_res_dampak, #target_tes_prob"
      ).val("");
    });

    // ==========================================
    // Save Button - Data Validation & Submission
    // ==========================================
    $(document).on("click", "#btn-simpan", function () {
      const type = $(this).attr("data-type");
      const id_edit = $(this).attr("data-edit");

      // Validasi form
      let isValid = true;

      // Array of required fields with error messages
      const requiredFields = [
        {
          id: "#identifikasi_kejadian",
          errorId: "#error-identifikasi_kejadian",
          message: "Identifikasi Kejadian wajib diisi.",
        },
        {
          id: "#kategori",
          errorId: "#error-kategori",
          message: "Pilih kategori kejadian.",
        },
        {
          id: "#sumber_penyebab",
          errorId: "#error-sumber_penyebab",
          message: "Sumber penyebab wajib diisi.",
        },
        {
          id: "#penyebab_kejadian",
          errorId: "#error-penyebab_kejadian",
          message: "Penyebab kejadian wajib diisi.",
        },
        {
          id: "#penanganan",
          errorId: "#error-penanganan",
          message: "Penanganan wajib diisi.",
        },
        {
          id: "#kat_risiko",
          errorId: "#error-kat_risiko",
          message: "Pilih kategori risiko.",
        },
        {
          id: "#hub_kejadian_risk_event",
          errorId: "#error-hub_kejadian_risk_event",
          message: "Hubungan kejadian wajib diisi.",
        },
        {
          id: "#skal_dampak_in",
          errorId: "#error-skal_dampak_in",
          message: "Pilih skala dampak inheren.",
        },
        {
          id: "#skal_prob_in",
          errorId: "#error-skal_prob_in",
          message: "Pilih skala probabilitas inheren.",
        },
        {
          id: "#target_res_dampak",
          errorId: "#error-Target_Res_dampak",
          message: "Pilih skala dampak target residual.",
        },
        {
          id: "#target_res_prob",
          errorId: "#error-Target_Res_prob",
          message: "Pilih skala probabilitas target residual.",
        },
        {
          id: "#mitigasi_rencana",
          errorId: "#error-mitigasi_rencana",
          message: "Mitigasi yang direncanakan wajib diisi.",
        },
        {
          id: "#mitigasi_realisasi",
          errorId: "#error-mitigasi_realisasi",
          message: "Mitigasi realisasi wajib diisi.",
        },
        {
          id: "#status_asuransi",
          errorId: "#error-status_asuransi",
          message: "Status asuransi wajib diisi.",
        },
        {
          id: "#nilai_premi",
          errorId: "#error-nilai_premi",
          message: "Nilai premi wajib diisi.",
        },
        {
          id: "#nilai_klaim",
          errorId: "#error-nilai_klaim",
          message: "Nilai klaim wajib diisi.",
        },
        {
          id: "#rencana_perbaikan_mendatang",
          errorId: "#error-rencana_perbaikan_mendatang",
          message: "Rencana perbaikan wajib diisi.",
        },
        {
          id: "#pihak_terkait",
          errorId: "#error-pihak_terkait",
          message: "Pihak terkait wajib diisi.",
        },
        {
          id: "#penjelasan_kerugian",
          errorId: "#error-penjelasan_kerugian",
          message: "Penjelasan kerugian wajib diisi.",
        },
        {
          id: "#nilai_kerugian",
          errorId: "#error-nilai_kerugian",
          message: "Nilai kerugian wajib diisi.",
        },
        {
          id: "#frekuensi_kejadian",
          errorId: "#error-frekuensi_kejadian",
          message: "Pilih frekuensi kejadian.",
        },
      ];

      // Validate required fields
      requiredFields.forEach((field) => {
        const input = $(field.id);
        const errorDiv = $(field.errorId);

        if (input.val().trim() === "") {
          errorDiv.text(field.message); // Show error message
          input.addClass("is-invalid"); // Add invalid class
          isValid = false; // Mark as invalid
        } else {
          errorDiv.text(""); // Clear error message
          input.removeClass("is-invalid"); // Remove invalid class
        }
      });

      // Stop submission if validation fails
      if (!isValid) {
        return;
      }

      // Collect values from modal inputs into FormData
      const formData = new FormData();
      formData.append("id_edit", id_edit);
      formData.append("type", type);
      formData.append(
        "rcsa_no",
        type === "edit"
          ? $("#rcsa_no_e").val()
          : $("#filter_judul_assesment").val()
      );
      formData.append("event_no", $("#event_no").val());
      formData.append("nama_event", $("#peristiwabaru").val());
      formData.append("id_detail", $("#id_detail").val());
      formData.append(
        "identifikasi_kejadian",
        $("#identifikasi_kejadian").val()
      );
      formData.append("kategori", $("#kategori").val());
      formData.append("sumber_penyebab", $("#sumber_penyebab").val());
      formData.append("penyebab_kejadian", $("#penyebab_kejadian").val());
      formData.append("penanganan", $("#penanganan").val());
      formData.append("kat_risiko", $("#kat_risiko").val());
      formData.append(
        "hub_kejadian_risk_event",
        $("#hub_kejadian_risk_event").val()
      );
      formData.append("skal_dampak_in", $("#skal_dampak_in").val());
      formData.append("skal_prob_in", $("#skal_prob_in").val());
      formData.append("target_res_dampak", $("#target_res_dampak").val());
      formData.append("target_res_prob", $("#target_res_prob").val());
      formData.append("status_asuransi", $("#status_asuransi").val());
      formData.append("nilai_premi", $("#nilai_premi").val());
      formData.append("nilai_klaim", $("#nilai_klaim").val());
      formData.append("mitigasi_rencana", $("#mitigasi_rencana").val());
      formData.append("mitigasi_realisasi", $("#mitigasi_realisasi").val());
      formData.append(
        "rencana_perbaikan_mendatang",
        $("#rencana_perbaikan_mendatang").val()
      );
      formData.append("pihak_terkait", $("#pihak_terkait").val());
      formData.append("penjelasan_kerugian", $("#penjelasan_kerugian").val());
      formData.append("nilai_kerugian", $("#nilai_kerugian").val());
      formData.append(
        "kejadian_berulang",
        $('input[name="kejadian_berulang"]:checked').val()
      );
      formData.append("frekuensi_kejadian", $("#frekuensi_kejadian").val());
      formData.append("file_upload_lama", $("#file_upload_lama").val());

      // Append file data
      const fileInput = $("#file_upload")[0];
      if (fileInput.files.length > 0) {
        formData.append("file_upload", fileInput.files[0]);
      }

      // Using cari_ajax_combo to send the FormData
      const url = modul_name + "/simpan-lost-event";
      cari_ajax_combo_file(
        "post", // HTTP method
        $(this).parent(), // Context element
        formData, // Data to send
        "", // Any additional settings (empty for now)
        url, // The target URL
        "result_simpan_lost_event" // The callback to handle the result
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
      "#target_res_dampak, #target_res_prob",
      function () {
        updateRiskLevel(
          "#target_res_dampak",
          "#target_res_prob",
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
  if (hasil.status == 0) {
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
  } else {
    pesan_toastr(
      "Data Peristiwa sudah terdaftar...",
      "error",
      "error",
      "toast-top-center",
      true
    );
  }
}

function result_show_model(hasil) {
  $("#modal_general .modal-body").html(hasil.register);
  $("#modal_general .modal-title").html("LOSS EVENT DATABASE");
  $(".select2").select2();
  $("#modal_general").modal("show");
}
