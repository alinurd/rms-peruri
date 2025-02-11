$(document).ready(function () {
    
 
    $('.skala-dropdown').each(function () {
        calculateDropdown($(this));
    });
 
    $('.skala-dropdown').on('change', function () {
        calculateDropdown($(this));
 
    });
   
    $('input[name="idx[]"]').each(function() {
         var id = $(this).val();
         console.log(id)
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
    var bobotParent = element.data('bobot-parent');
    var idParent = element.data('id-parent');
    var nc = element.data('nc');
    // console.log("jalan")
    $('#' + inputId).val(hasil.toFixed(2));

    if(inputId=="perhitungan-A55"){
        $('#skor-' + inputId).val(bobotParent/100*hasil.toFixed(2));
    }else if(inputId=="perhitungan-A65"){
        $('#skor-' + inputId).val(bobotParent/100*hasil.toFixed(2));
    }else{
        $('#skor-' + inputId).val(hasil.toFixed(2));
    }

    var rumus = bobot > 0 ? `${bobot}% X ${penilaian}` : penilaian;
    $('#' + rumusId).val(rumus);

    var totalDetail = 0;
    $('.subTotalDetail-' + nc).each(function () {
        totalDetail += parseFloat($(this).val()) || 0;
    });
	
    $('#totalDetail-' + nc).val(totalDetail.toFixed(2));
    $('#skor-totalDetail-' + nc).val(bobotParent/100*totalDetail.toFixed(2));

    var totalPerhitungan = 0;
    $('.skor-perhitungan').each(function () {
        totalPerhitungan += parseFloat($(this).val()) || 0;
    });
    $('#totalPerhitungan').val(totalPerhitungan.toFixed(2));
    $('#totalPerhitunganText').html(totalPerhitungan.toFixed(2));
}

function updatePercentage(id) {

    const x = document.getElementById(`target-${id}`);
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
        // console.log("isAbsolute=>"+ isAbsolute)
        if (targetValue !== 0) {
            if(id==16){ 
                percentage = ((targetValue - (realisasiValue - targetValue)) / targetValue) * 100;
            }else if(id==19){ 
                percentage = ((realisasiValue - (targetValue - realisasiValue)) / realisasiValue) * 100;
             }else{
                percentage = ((targetValue - (realisasiValue - targetValue)) / targetValue) * 100;
            }
        }
        // console.log("percentage=>"+ percentage)
        // console.log("percentage=>"+ percentage)
        // console.log("targetValue=>"+ targetValue)
    } else { 
        if (targetValue !== 0) {
            percentage = (targetValue /  realisasiValue) * 100;

            if(id==55){
                percentage = (realisasiValue /targetValue  ) * 100;
            }
           else if(id==65){
                percentage = (realisasiValue /targetValue  ) * 100;
            }
           else if(id==13){
                percentage = (realisasiValue /targetValue  ) * 100;
              }
           else if(id==10){
                percentage = (realisasiValue /targetValue  ) * 100;
             }
             else if(id==16){
                percentage = (realisasiValue /targetValue  ) * 100;
                // console.log("id 13")
             }
             else if(id==19){
                percentage = ( targetValue/realisasiValue  ) * 100;
                // console.log("id 13")
             }
        }
    }
     persentaseSpan.textContent = (percentage > 0 ? percentage.toFixed(2) : 0) + " %";
    changePersentase(id, (percentage > 0 ? percentage.toFixed(2) : 0))
}


function changePersentase(id, percentage) {
    var data = {
        'id': id,
        'percentage': percentage
    };
     var parent = $(this).parent();
     var url = "ajax/getPersentaseKomposit";
     cari_ajax_combo("post", parent, data, parent, url, "changePersentaseResp");
}

function changePersentaseResp(res) {
    
console.log(res.skala, res.head.id)
    // Pastikan res dan res.head ada
    if (!res || !res.head || !res.skala || !res.head.urut || !res.head.id) {
        console.warn("Data tidak lengkap dalam response:", res);
        return;
    }

    // Bentuk ID select berdasarkan urutan dan ID dari res.head
    let selectId = "skala-" + res.head.urut + res.head.id;
    let selectElement = document.getElementById(selectId);

    // Coba cari dengan querySelector jika getElementById gagal
    if (!selectElement) {
        selectElement = document.querySelector(`[id^="skala-${res.head.urut}${res.head.id})"]`);
    }

    if (selectElement) {
        let options = selectElement.options;
        let found = false;

        // Loop semua opsi dalam select untuk mencocokkan skala
        for (let i = 0; i < options.length; i++) {
            if (options[i].value == res.skala) {
                options[i].selected = true;
                found = true;
                break;
            }
        }

        if (found) {
            // Trigger event change supaya perubahan terdeteksi
            selectElement.dispatchEvent(new Event("change"));
        } else {
            console.warn("Skala tidak ditemukan dalam dropdown:", res.skala);
        }
    } else {
        console.warn("Dropdown tidak ditemukan dengan ID:", selectId);
    }
}

