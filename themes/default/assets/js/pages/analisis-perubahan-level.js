$(document).on("click", "[id^=simpan_realisasi_]", function () {
  var id = $(this).data('id');
  var month = $(this).data('month');

  // Ambil nilai input berdasarkan ID unik
  var keterangan = $("textarea[name='keterangan_" + id + month + "']").val();

  var data = {'id': id, 'month': month, 'keterangan': keterangan };

  console.log(data)
 
  var parent = $(this).parent();
  
  var target_combo = "";
  var url = modul_name + "/save";
  cari_ajax_combo("post", parent, data, target_combo, url, 'result_realisasi_kri');


});

function result_realisasi_kri(hasil) {
  // console.log(hasil)
  if(hasil.res>0) {
    pesan_toastr('Berhasil disimpan...', 'success', 'Success', 'toast-top-center', true);
 }
}