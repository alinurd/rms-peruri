$(document).ready(function () {
    
 
    $('.skala-dropdown').each(function () {
        calculateDropdown($(this));
    });
 
    $('.skala-dropdown').on('change', function () {
        calculateDropdown($(this));
    });

    $("#simpan").click(function () {
        var ids = [];
        var penjelasans = [];
        var evidences = [];
        var realisasi = [];
        var urut = [];
 
        $('input[name="id[]"]').each(function () {
            ids.push($(this).val());
        });
        $('input[name="urut[]"]').each(function () {
            urut.push($(this).val());
        });
 
        $('textarea[name="penjelasan[]"]').each(function () {
            penjelasans.push($(this).val());
        });
 
        $('textarea[name="evidence[]"]').each(function () {
            evidences.push($(this).val());
        });
 
        $('select[name="realisasi[]"]').each(function () {
            var selectedOption = $(this).find('option:selected').val();
            realisasi.push(selectedOption);
        });
 
        var owner = $('input[name="owner"]').val();
        var tw = $('input[name="tw"]').val();
        var periode = $('input[name="periode"]').val();

        var data = {
            'id': ids,
            'urut': urut,
            'penjelasan': penjelasans,
            'evidence': evidences,
            'realisasi': realisasi,
            'owner': owner,
            'tw': tw,
            'periode': periode,
        };
         var parent = $(this).parent();
        var url = modul_name + "/simpan";

        cari_ajax_combo("post", parent, data, parent, url, "result");
    });
});

function result(res){
    pesan_toastr('Proses Simpan Berhasil...', 'info', 'Prosess', 'toast-top-center', true);
}

function calculateDropdown(element) {
    var selectedOption = element.find(':selected');
    var bobot = parseFloat(selectedOption.data('bobot')) || 0;
    var penilaian = parseFloat(selectedOption.data('penilaian')) || 0;
    var hasil = bobot > 0 ? (bobot / 100 * penilaian) : penilaian;
    var inputId = element.data('input-id');
    var rumusId = element.data('input-rumus-id');
    var idParent = element.data('id-parent');
    var nc = element.data('nc');

    $('#' + inputId).val(hasil.toFixed(2));

    var rumus = bobot > 0 ? `${bobot}% X ${penilaian}` : penilaian;
    $('#' + rumusId).val(rumus);

    var totalDetail = 0;
    $('.subTotalDetail-' + nc).each(function () {
        totalDetail += parseFloat($(this).val()) || 0;
    });
	
    $('#totalDetail-' + nc).val(totalDetail.toFixed(2));

    var totalPerhitungan = 0;
    $('.perhitungan').each(function () {
        totalPerhitungan += parseFloat($(this).val()) || 0;
    });
    $('#totalPerhitungan').val(totalPerhitungan.toFixed(2));
    $('#totalPerhitunganText').html(totalPerhitungan.toFixed(2));
}
