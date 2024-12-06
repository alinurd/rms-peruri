$(document).ready(function () {
  $(".skala-dropdown").each(function () {
    calculateDropdown($(this));
  });

  $(".skala-dropdown").on("change", function () {
    calculateDropdown($(this));
  });

  $("#simpan").click(function () {
    var ids = [];
    var penjelasans = [];
    var evidences = [];
    var realisasi = [];
    var urut = [];
    var data = new FormData();  // Use FormData for file uploads

    // Collect data from input fields
    $('input[name="id[]"]').each(function () {
        ids.push($(this).val());
    });
    $('input[name="urut[]"]').each(function () {
        urut.push($(this).val());
    });
    $('textarea[name="penjelasan[]"]').each(function () {
        penjelasans.push($(this).val());
    });
    $('select[name="realisasi[]"]').each(function () {
        var selectedOption = $(this).find("option:selected").val();
        realisasi.push(selectedOption);
    });

    // Collect file inputs
    $('input[name="evidence[]"]').each(function () {
        var file = $(this)[0].files[0]; // Get the first uploaded file
        if (file) {
            data.append('evidence[]', file); // Append file to FormData
        } else {
            data.append('evidence[]', null); // Append null if no file
        }
    });

    // Collect other data fields
    var owner = $('input[name="owner"]').val();
    var tw = $('input[name="tw"]').val();
    var periode = $('input[name="periode"]').val();

    // Append all collected data to FormData
    data.append('id', JSON.stringify(ids));
    data.append('urut', JSON.stringify(urut));
    data.append('penjelasan', JSON.stringify(penjelasans));
    data.append('realisasi', JSON.stringify(realisasi));
    data.append('owner', owner);
    data.append('tw', tw);
    data.append('periode', periode);

    // Define the parent and URL for AJAX request
    var parent = $(this).parent();
    var url = modul_name + "/simpan";

    // Use cari_ajax_combo_file to handle the request
    cari_ajax_combo_file(
        "post",          // HTTP method
        parent,          // Parent element (used for handling UI during request)
        data,            // Send FormData object
        parent,          // This could also be the element where response will be placed
        url,             // The URL to send the request to
        "result"         // The container element to display the result or error
    );
});

});

function result(res) {
  console.log(res);
  pesan_toastr(
    "Proses Simpan Berhasil...",
    "info",
    "Prosess",
    "toast-top-center",
    true
  );
}

function calculateDropdown(element) {
  var selectedOption = element.find(":selected");
  var bobot = parseFloat(selectedOption.data("bobot")) || 0;
  var penilaian = parseFloat(selectedOption.data("penilaian")) || 0;
  var hasil = bobot > 0 ? (bobot / 100) * penilaian : penilaian;
  var inputId = element.data("input-id");
  var rumusId = element.data("input-rumus-id");
  var idParent = element.data("id-parent");
  var nc = element.data("nc");

  $("#" + inputId).val(hasil.toFixed(2));

  var rumus = bobot > 0 ? `${bobot}% X ${penilaian}` : penilaian;
  $("#" + rumusId).val(rumus);

  var totalDetail = 0;
  $(".subTotalDetail-" + nc).each(function () {
    totalDetail += parseFloat($(this).val()) || 0;
  });

  $("#totalDetail-" + nc).val(totalDetail.toFixed(2));

  var totalPerhitungan = 0;
  $(".perhitungan").each(function () {
    totalPerhitungan += parseFloat($(this).val()) || 0;
  });
  $("#totalPerhitungan").val(totalPerhitungan.toFixed(2));
  $("#totalPerhitunganText").html(totalPerhitungan.toFixed(2));
}
