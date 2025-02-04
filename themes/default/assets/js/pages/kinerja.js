$(document).ready(function () {
    
 
    $('.skala-dropdown').each(function () {
        calculateDropdown($(this));
    });
 
    $('.skala-dropdown').on('change', function () {
        calculateDropdown($(this));
 
    });
   
    $('input[name="idx[]"]').each(function() {
         var id = $(this).val();
        updatePercentage(id);
    });

    
  

    $("#simpan").click(function () {
        var ids = [];
         var realisasi = [];
        var urut = [];
        var target = [];
        var realisasitw = [];
        var absolut = [];
    
        $('input[name="id[]"]').each(function () {
            ids.push($(this).val());
        });
    
        $('input[name="urut[]"]').each(function () {
            urut.push($(this).val());
        });
     
        $('input[name="target[]"]').each(function () {
            target.push($(this).val());
        });
     
        $('input[name="realisasitw[]"]').each(function () {
            realisasitw.push($(this).val());
        });
     
        $('input[name="absolut[]"]').each(function () {
            if ($(this).is(':checked')) {
                absolut.push($(this).val()); 
            } else {
                absolut.push("0");  
            }
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
             'target': target,
            'realisasitw': realisasitw, 
            'absolut': absolut,
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
    // console.log("jalan")
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


function updatePercentage(id) {
    console.log(id)
    const targetInput = document.getElementById(`target-${id}`);
    const isAbsolute = document.getElementById(`isAbsolute-${id}-1`).checked;
    const realisasiInput = document.getElementById(`realisasitw-${id}`);
    const persentaseSpan = document.getElementById(`persentase-${id}`);
     let targetValue = targetInput.value.replace(/\./g, '').replace(',', '.');
    let realisasiValue = realisasiInput.value.replace(/\./g, '').replace(',', '.');

    targetInput.value = _formatNumber(targetValue.replace('.', ','));
    realisasiInput.value = _formatNumber(realisasiValue.replace('.', ','));

    targetValue = parseFloat(targetValue);
    realisasiValue = parseFloat(realisasiValue);

    let percentage = 0;

    if (isAbsolute) {
        console.log("isAbsolute=>"+ isAbsolute)
        if (targetValue !== 0) {
            percentage = ((realisasiValue - (targetValue - realisasiValue)) / realisasiValue) * 100;
        }
        console.log("percentage=>"+ percentage)
        console.log("percentage=>"+ percentage)
        console.log("targetValue=>"+ targetValue)
    } else {
        if (targetValue !== 0) {
            percentage = (targetValue /  realisasiValue) * 100;
        }
    }
    console.log(percentage)
    persentaseSpan.textContent = (percentage > 0 ? percentage.toFixed(2) : 0) + " %";
}
 