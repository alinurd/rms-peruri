var asal_event;
$(function () {
  $(document).ready(function () {
    $(".openModal").click(function () {
      var id = $(this).data("id");
      var month = $(this).data("month");
      var type = $(this).data("type");
      var url = modul_name + "/get_detail_modal";

      var data = {
        id_detail: id,
        month: month,
        type: type,
      };
      var parent = $(this).parent();

      cari_ajax_combo("post", parent, data, "", url, "result_show_model");
    });
  });

  $(document).ready(function () {
    $("#modal_general").on("hidden.bs.modal", function () {
      console.log("Modal closed"); // Debugging

      // Kosongkan nilai input ketika modal ditutup
      $("#btn-simpan").removeAttr("data-id");
      $("#btn-simpan").removeAttr("data-month");
      $("#identifikasi_kejadian").val("");
      $("#kategori").val("");
      $("#sumber_penyebab").val("");
      $("#penyebab_kejadian").val("");
      $("#penanganan").val("");
      $("#kat_risiko").val("");
      $("#hub_kejadian_risk_event").val("");
      $("#status_asuransi").val("");
      $("#nilai_premi").val("");
      $("#nilai_klaim").val("");
      $("#mitigasi_rencana").val("");
      $("#mitigasi_realisasi").val("");
      $("#rencana_perbaikan_mendatang").val("");
      $("#pihak_terkait").val("");
      $("#penjelasan_kerugian").val("");
      $("#nilai_kerugian").val("");
      $("#kejadian_berulang").val("");
      $("#frekuensi_kejadian").val("");
      $("#skal_dampak_in").val("");
      $("#skal_prob_in").val("");
      $("#Target_Res_dampak").val("");
      $("#Target_Res_prob").val("");
    });
  });

  $(document).on("click", "#btn-simpan", function () {
    // Validasi input
    if (validateInputs()) {
      var id = $(this).attr("data-id");
      var id_edit = $(this).attr("data-edit");
      var month = $(this).attr("data-month");
      var type = $(this).attr("data-type");

      // Ambil nilai input tambahan dari modal
      var identifikasi_kejadian = $("#identifikasi_kejadian").val();
      var kategori = $("#kategori").val();
      var sumber_penyebab = $("#sumber_penyebab").val();
      var penyebab_kejadian = $("#penyebab_kejadian").val();
      var penanganan = $("#penanganan").val();
      var kat_risiko = $("#kat_risiko").val();
      var hub_kejadian_risk_event = $("#hub_kejadian_risk_event").val();
      var status_asuransi = $("#status_asuransi").val();
      var nilai_premi = $("#nilai_premi").val();
      var nilai_klaim = $("#nilai_klaim").val();
      var mitigasi_rencana = $("#mitigasi_rencana").val();
      var mitigasi_realisasi = $("#mitigasi_realisasi").val();
      var rencana_perbaikan_mendatang = $("#rencana_perbaikan_mendatang").val();
      var pihak_terkait = $("#pihak_terkait").val();
      var penjelasan_kerugian = $("#penjelasan_kerugian").val();
      var nilai_kerugian = $("#nilai_kerugian").val();
      var kejadian_berulang = $("#kejadian_berulang").val();
      var frekuensi_kejadian = $("#frekuensi_kejadian").val();
      var skal_dampak_in = $("#skal_dampak_in").val();
      var skal_prob_in = $("#skal_prob_in").val();
      var target_res_dampak = $("#Target_Res_dampak").val();
      var target_res_prob = $("#Target_Res_prob").val();

      // Tambahkan data input ke objek data untuk dikirim
      var data = {
        id: id,
        id_edit: id_edit,
        month: month,
        type: type,
        identifikasi_kejadian: identifikasi_kejadian,
        kategori: kategori,
        sumber_penyebab: sumber_penyebab,
        penyebab_kejadian: penyebab_kejadian,
        penanganan: penanganan,
        kat_risiko: kat_risiko,
        hub_kejadian_risk_event: hub_kejadian_risk_event,
        status_asuransi: status_asuransi,
        nilai_premi: nilai_premi,
        nilai_klaim: nilai_klaim,
        mitigasi_rencana: mitigasi_rencana,
        mitigasi_realisasi: mitigasi_realisasi,
        rencana_perbaikan_mendatang: rencana_perbaikan_mendatang,
        pihak_terkait: pihak_terkait,
        penjelasan_kerugian: penjelasan_kerugian,
        nilai_kerugian: nilai_kerugian,
        kejadian_berulang: kejadian_berulang,
        frekuensi_kejadian: frekuensi_kejadian,
        skal_dampak_in: skal_dampak_in,
        skal_prob_in: skal_prob_in,
        target_res_dampak: target_res_dampak,
        target_res_prob: target_res_prob,
      };

      console.log("ID yang diambil:", id); // Debugging ID unik
      console.log(data);

      var parent = $(this).parent();
      var target_combo = "";
      var url = modul_name + "/simpan_lost_event";

      cari_ajax_combo(
        "post",
        parent,
        data,
        target_combo,
        url,
        "result_simpan_lost_event"
      );

      return false; // Untuk mencegah reload halaman
    }
  });

//   $(document).on("change", "#skal_dampak_in, #skal_prob_in", function () {
//     var likelihood = $("#skal_dampak_in").val();
//     var month = $("#skal_dampak_in").data("month");
//     var impact = $("#skal_prob_in").val();

//     var data = {
//       likelihood: likelihood,
//       impact: impact,
//       month: month,
//     };
//     var parent = $(this).parent();
//     var url = modul_name + "/cek-level";

//     cari_ajax_combo("post", parent, data, "", url, "LevelAnalisisInheren");
//   });

//   $(document).on("change", "#Target_Res_dampak, #Target_Res_prob", function () {
//     var likelihood = $("#Target_Res_dampak").val();
//     var month = $("#skal_dampak_in").data("month");
//     var impact = $("#Target_Res_prob").val();

//     var data = {
//       likelihood: likelihood,
//       impact: impact,
//       month: month,
//     };
//     var parent = $(this).parent();
//     var url = modul_name + "/cek-level";

//     cari_ajax_combo("post", parent, data, "", url, "LevelAnalisisIResidual");
//   });
// });

function LevelAnalisisInheren(hasil) {
  $("#level_risiko_inher_label").html(hasil.level_text);
}
function LevelAnalisisIResidual(hasil) {
  $("#level_risiko_res_label").html(hasil.level_text);
}

function result_modal_data(hasil) {
  console.log(hasil);
  $("#modalUpdate").modal("show");
}

// Fungsi untuk melakukan validasi
function validateInputs() {
  // Kosongkan pesan kesalahan sebelumnya
  $(".text-danger").empty();

  // Ambil nilai input dari modal
  var identifikasi_kejadian = $("#identifikasi_kejadian").val();
  var kategori = $("#kategori").val();
  var sumber_penyebab = $("#sumber_penyebab").val();
  var penyebab_kejadian = $("#penyebab_kejadian").val();
  var penanganan = $("#penanganan").val();
  var kat_risiko = $("#kat_risiko").val();
  var hub_kejadian_risk_event = $("#hub_kejadian_risk_event").val();
  var status_asuransi = $("#status_asuransi").val();
  var nilai_premi = $("#nilai_premi").val();
  var nilai_klaim = $("#nilai_klaim").val();
  var mitigasi_rencana = $("#mitigasi_rencana").val();
  var mitigasi_realisasi = $("#mitigasi_realisasi").val();
  var rencana_perbaikan_mendatang = $("#rencana_perbaikan_mendatang").val();
  var pihak_terkait = $("#pihak_terkait").val();
  var penjelasan_kerugian = $("#penjelasan_kerugian").val();
  var nilai_kerugian = $("#nilai_kerugian").val();
  var kejadian_berulang = $("#kejadian_berulang").val();
  var frekuensi_kejadian = $("#frekuensi_kejadian").val();
  var skal_dampak_in = $("#skal_dampak_in").val();
  var skal_prob_in = $("#skal_prob_in").val();
  var target_res_dampak = $("#Target_Res_dampak").val();
  var target_res_prob = $("#Target_Res_prob").val();

  // Flag untuk menandai jika ada kesalahan
  var hasError = false;

  // Validasi input
  if (!identifikasi_kejadian) {
    $("#error-identifikasi_kejadian").text(
      "Identifikasi Kejadian harus diisi."
    );
    hasError = true;
  }
  if (!kategori) {
    $("#error-kategori").text("Kategori harus diisi.");
    hasError = true;
  }
  if (!sumber_penyebab) {
    $("#error-sumber_penyebab").text("Sumber Penyebab harus diisi.");
    hasError = true;
  }
  if (!penyebab_kejadian) {
    $("#error-penyebab_kejadian").text("Penyebab Kejadian harus diisi.");
    hasError = true;
  }
  if (!penanganan) {
    $("#error-penanganan").text("Penanganan harus diisi.");
    hasError = true;
  }
  if (!kat_risiko) {
    $("#error-kat_risiko").text("Kategori Risiko harus diisi.");
    hasError = true;
  }
  if (!hub_kejadian_risk_event) {
    $("#error-hub_kejadian_risk_event").text("Hubungan Kejadian harus diisi.");
    hasError = true;
  }
  if (!status_asuransi) {
    $("#error-status_asuransi").text("Status Asuransi harus diisi.");
    hasError = true;
  }
  if (!nilai_premi) {
    $("#error-nilai_premi").text("Nilai Premi harus berupa angka.");
    hasError = true;
  }
  if (!nilai_klaim) {
    $("#error-nilai_klaim").text("Nilai Klaim harus berupa angka.");
    hasError = true;
  }
  if (!mitigasi_rencana) {
    $("#error-mitigasi_rencana").text(
      "Mitigasi Yang Direncanakan harus diisi."
    );
    hasError = true;
  }
  if (!mitigasi_realisasi) {
    $("#error-mitigasi_realisasi").text("Realisasi Mitigasi harus diisi.");
    hasError = true;
  }
  if (!rencana_perbaikan_mendatang) {
    $("#error-rencana_perbaikan_mendatang").text(
      "Rencana Perbaikan Mendatang harus diisi."
    );
    hasError = true;
  }
  if (!pihak_terkait) {
    $("#error-pihak_terkait").text("Pihak Terkait harus diisi.");
    hasError = true;
  }
  if (!penjelasan_kerugian) {
    $("#error-penjelasan_kerugian").text("Penjelasan Kerugian harus diisi.");
    hasError = true;
  }
  if (!nilai_kerugian) {
    $("#error-nilai_kerugian").text("Nilai Kerugian harus berupa angka.");
    hasError = true;
  }
  if (!kejadian_berulang) {
    $("#error-kejadian_berulang").text("Kejadian Berulang harus diisi.");
    hasError = true;
  }
  if (!frekuensi_kejadian) {
    $("#error-frekuensi_kejadian").text(
      "Frekuensi Kejadian harus berupa angka."
    );
    hasError = true;
  }

  // Kembalikan status validasi
  return !hasError; // Jika ada kesalahan, kembalikan false
}

function result_simpan_lost_event(hasil) {
  pesan_toastr(
    "Berhasil disimpan...",
    "success",
    "Success",
    "toast-top-center",
    true
  );
  // console.log(hasil);
  location.reload();
  // alert('Pengisian Progress Treatment Berhasil')
  // location.reload();

  // $("#list_realisasi").removeClass("hide");
  // $("#input_realisasi").addClass("hide");
  // $("#list_realisasi").html(hasil.combo);
}
function result_show_model(hasil) {
  $("#modal_general").find(".modal-body").html(hasil.register);
  $("#modal_general").find(".modal-title").html("LOST EVENT DATABASE");
  $("#modal_general").modal("show");
  // $(
  //   "#skal_dampak_in, #skal_prob_in, #Target_Res_dampak, #Target_Res_prob"
  // ).change();
}

$(document).ready(function () {
  // Fungsi untuk format angka ke Rupiah
  function formatRupiah(angka) {
    var number_string = angka.replace(/[^,\d]/g, "").toString(),
      split = number_string.split(","),
      sisa = split[0].length % 3,
      rupiah = split[0].substr(0, sisa),
      ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    // Tambahkan titik setiap 3 angka
    if (ribuan) {
      var separator = sisa ? "." : "";
      rupiah += separator + ribuan.join(".");
    }

    return split[1] !== undefined ? rupiah + "," + split[1] : rupiah;
  }

  // Event input untuk input nilai
  $("#nilai_premi, #nilai_klaim,#nilai_kerugian").on("input", function () {
    var input = $(this);
    var value = input.val();

    // Format nilai menjadi Rupiah
    var formattedValue = formatRupiah(value);

    // Set nilai terformat kembali ke input
    input.val(formattedValue);
  });
});
