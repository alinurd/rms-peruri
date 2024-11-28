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
    var target_combo = "";
    var parent = $(this).parent();
    var url = modul_name + "/save"; // URL untuk mengirimkan data

    // Ambil elemen form berdasarkan ID
    var form = document.querySelector("#level"); // Mengambil form dengan ID 'myForm'
    // Membuat FormData dari form yang dipilih
    var formData = new FormData(form);

    cari_ajax_combo_new("post", parent, formData, "", url, "result_realisasi");
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


