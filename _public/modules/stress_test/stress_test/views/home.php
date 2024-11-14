<?php
// Mengambil bulan dan tahun saat ini
$bulan = date('n');
$tahun = date('Y');

// Menentukan semester berdasarkan bulan
$selectedSemester = ($bulan >= 1 && $bulan <= 6) ? '1' : '2';
?>
<style>
    .form-control{
	border-radius: 10px;
}
 
</style>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-sm-8 panel-heading">
                <h3 style="padding-left:10px;"><?= lang("msg_title") ?></h3>
            </div>
            <div class="col-sm-4 text-right">
                <ul class="breadcrumb">
                    <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
                    <li><a href="#">Index Komposit</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="x_panel">
    <div class="x_title">
        <span>Stress Test</span>
    </div>
    <div class="clearfix"></div>

    <form method="GET" action="<?= site_url(_MODULE_NAME_REAL_ . '/index'); ?>">
        <div class="row">
            <!-- Dropdown Tahun -->
            <div class="col-md-2 col-sm-4 col-xs-6">
                <label for="filter_periode">Tahun</label>
                <select name="periode" id="filter_periode" class="form-control select2" style="width: 100%;">
                    <?php foreach ($cboPeriod as $key => $value): ?>
                        <option value="<?= $key == 0 ? '0' : $value; ?>" <?= $periode == $value ? 'selected' : ''; ?>>
                            <?= $value; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Dropdown Semester -->
            <div class="col-md-2 col-sm-2 col-xs-2">
                <label for="filter_semester">Semester</label>
                <select name="semester" id="filter_semester" class="form-control select2" style="width: 80%;">
                    <option value="1" <?= $selectedSemester == $semester ? 'selected' : ''; ?>>Semester 1</option>
                    <option value="2" <?= $selectedSemester == $semester ? 'selected' : ''; ?>>Semester 2</option>
                </select>
            </div>

            <!-- Tombol Filter -->
            <div class="col-md-2 col-sm-2 col-xs-2 mt-3">
                <button type="submit" class="btn btn-success text-white" style="margin-top: 25px;">
                    <span class="glyphicon glyphicon-search"></span> Filter
                </button>
            </div>
        </div>
    </form>
</section>

<?php
// Menentukan apakah tabel harus disembunyikan
$hide = $periode ? "" : "hide";
?>
<input type="hidden" name="periode" value="<?= $periode ?>">
<input type="hidden" name="semester" value="<?= $semester ?>">

<!-- Tabel Event -->
<div class="table-responsive">
    <table class="display table table-bordered" id="tbl_event">
        <thead>
            <tr style="background-color: #0a47a1; color: #ffffff;">
                <th rowspan="2" class="text-center" width="5%">NO</th>
                <th rowspan="2" class="text-center" width="40%">Indikator</th>
                <th rowspan="2" class="text-center">RKAP <?= $tahun; ?></th>
                <th rowspan="2" class="text-center">Satuan</th>
                <th colspan="3" class="text-center">SKENARIO STRESS TEST</th>
            </tr>
            <tr style="background-color: #0a47a1; color: #ffffff;">
                <th width="5%" class="text-center">BEST</th>
                <th width="5%" class="text-center">BASE</th>
                <th width="5%" class="text-center">WORST</th>
            </tr>
        </thead>
        <tbody class="<?= $hide ?>">


    <?php
    if($indikatorData){
        $no = 1;

        // Mengambil semua data detail sekaligus untuk menghindari N+1 problem
        $detailDataAll = $this->db->where_in('id_parent', array_column($indikatorData, 'id'))
            ->get('bangga_indikator_stress_test_detail')
            ->result_array();

        // Mengelompokkan data detail berdasarkan id_parent
        $detailGrouped = [];
        foreach ($detailDataAll as $detail) {
            $detailGrouped[$detail['id_parent']][] = $detail;
        }

        foreach ($indikatorData as $ID):
            // Ambil data detail yang terkait dengan id_parent
            $detailData = isset($detailGrouped[$ID['id']]) ? $detailGrouped[$ID['id']] : [];
            $detailCount = count($detailData);

            // Jika hanya ada satu detail
            if ($detailCount === 1):
                $dd = $detailData[0];
                $resDetail = $this->db
                 ->where('id_indikator_detail', $dd['id'])
                 ->where('urut', $dd['urut'])
                 ->where('semester', $semester)
                 ->where('periode', $periode)
                 ->order_by('urut')
                 ->get('bangga_stress_test')
                 ->row_array();    
    ?>
            <tr>
                <td class="text-center"><?= $no++; ?></td>
                <td><?= $ID['judul']; ?></td>
                <td class="text-center"><?= $dd['rkap']; ?></td>
                <td class="text-center"><?= $dd['satuan']; ?></td>
                <td>
                    <input name="id[]" style="width: 100px;" type="hidden" value="<?= $dd['id']; ?>" class="form-control form-control-sm">
                    <input name="urut[]" style="width: 100px;" type="hidden" value="<?= $dd['urut']; ?>" class="form-control form-control-sm">
                    <input style="width: 100px;background-color:<?=$resDetail['color_best'];?>; <?= ($resDetail['color_best']) ? 'color:white' : '';?>" type="text" class="form-control form-control-sm best" data-id="<?= $dd['id']; ?>"
                           name="best[]" value="<?= ($resDetail['best']) ? $resDetail['best'] : "";?>"
                           id="best_<?= $dd['id']?>" 
                           placeholder="Best">
                    <input style="width: 40px;" name="color_best[]" value="<?=($resDetail['color_best']) ? $resDetail['color_best'] : '';?>" type="hidden" class="color-picker" data-id="<?= $dd['id']; ?>" 
                    id="color_best_<?= $dd['id']; ?>" >
                </td>
                <td>
                    
                    <input style="width: 100px;background-color:<?=$resDetail['color_base'];?>; <?= ($resDetail['color_base']) ? 'color:white' : '';?>" type="text" class="form-control form-control-sm base" data-id="<?= $dd['id']; ?>"
                           name="base[]" value="<?= ($resDetail['base']) ? $resDetail['base'] : "";?>"
                           id="base_<?= $dd['id']?>" 
                           placeholder="Base">
                    <input style="width: 40px;" name="color_base[]" type="hidden" value="<?=($resDetail['color_base']) ? $resDetail['color_base'] : '';?>" class="color-picker" data-id="<?= $dd['id']; ?>" 
                    id="color_base_<?= $dd['id']; ?>" >
                </td>
                <td>
                    <input style="width: 100px;background-color:<?=$resDetail['color_worst'];?>; <?= ($resDetail['color_worst']) ? 'color:white' : '';?>" type="text" class="form-control form-control-sm worst" data-id="<?= $dd['id']; ?>"
                           name="worst[]" value="<?= ($resDetail['worst']) ? $resDetail['worst'] : "";?>"
                           id="worst_<?= $dd['id']?>" 
                           placeholder="Worst">
                    <input style="width: 40px;" name="color_worst[]" type="hidden" value="<?=($resDetail['color_worst']) ? $resDetail['color_worst'] : '';?>" class="color-picker" data-id="<?= $dd['id']; ?>" 
                    id="color_worst_<?= $dd['id']; ?>" >
                </td>
            </tr>
    <?php
            else:
    ?>
            <tr>
                <td class="text-center" rowspan="<?= $detailCount + 1; ?>"><?= $no++; ?></td>
                <td colspan="6"><?= $ID['judul']; ?></td>
            </tr>
            <?php foreach ($detailData as $dd): 
                 $resDetail = $this->db
                 ->where('id_indikator_detail', $dd['id'])
                 ->where('urut', $dd['urut'])
                 ->where('semester', $semester)
                 ->where('periode', $periode)
                 ->order_by('urut')
                 ->get('bangga_stress_test')
                 ->row_array();    
                //  doi::dump($resDetail);
            ?>
                
                <tr>
                    <td><?= $dd['urut'] . ". " . $dd['parameter']; ?></td>
                    <td class="text-center"><?= $dd['rkap']; ?></td>
                    <td class="text-center"><?= $dd['satuan']; ?></td>
                    <td>
                        <input name="urut[]" style="width: 100px;" type="hidden" value="<?= $dd['urut']; ?>" class="form-control form-control-sm">
                        <input name="id[]" style="width: 100px;" value="<?= $dd['id']; ?>" type="hidden" class="form-control form-control-sm">
                        <input style="width: 100px; background-color:<?=$resDetail['color_best'];?>; <?= ($resDetail['color_best']) ? 'color:white' : '';?>" type="text" class="form-control form-control-xs best" 
                               name="best[]" value="<?= ($resDetail['best']) ? $resDetail['best'] : "";?>"
                               id="best_<?= $dd['id']?>" data-id="<?= $dd['id']; ?>"
                               placeholder="Best">
                               <input style="width: 40px;" name="color_best[]" value="<?=($resDetail['color_best']) ? $resDetail['color_best'] : '';?>" type="hidden" class="color-picker" data-id="<?= $dd['id']; ?>" 
           id="color_best_<?= $dd['id']; ?>" >

                    </td>
                    <td>
                        <input style="width: 100px;background-color:<?=$resDetail['color_base'];?>; <?= ($resDetail['color_base']) ? 'color:white' : '';?>" type="text" class="form-control form-control-xs base" data-id="<?= $dd['id']; ?>"
                               name="base[]" value="<?= ($resDetail['base']) ? $resDetail['base'] : "";?>"
                               id="base_<?= $dd['id']?>" 
                               placeholder="Base">
                               <input style="width: 40px;" name="color_base[]" type="hidden" value="<?=($resDetail['color_base']) ? $resDetail['color_base'] : '';?>" class="color-picker" data-id="<?= $dd['id']; ?>" 
                               id="color_base_<?= $dd['id']; ?>" >
                    </td>
                    <td>
                        <input style="width: 100px;background-color:<?=$resDetail['color_worst'];?>; <?= ($resDetail['color_worst']) ? 'color:white' : '';?>" type="text" class="form-control form-control-xs worst" data-id="<?= $dd['id']; ?>"
                               name="worst[]" value="<?= ($resDetail['worst']) ? $resDetail['worst'] : "";?>"
                               id="worst_<?= $dd['id']?>" 
                               placeholder="Worst">
                               <input style="width: 40px;" name="color_worst[]" type="hidden" value="<?=($resDetail['color_worst']) ? $resDetail['color_worst'] : '';?>" class="color-picker" data-id="<?= $dd['id']; ?>" 
           id="color_worst_<?= $dd['id']; ?>" >
                    </td>
                </tr>
            <?php endforeach; ?>
    <?php
            endif;
        endforeach;
    }else{
    ?>
    <tr>
        <td colspan="7" class="text-center"><b>Data Tidak Ditemukan</b></td>
    </tr>
    <!-- <tr>Data tidak ditemukan</tr> -->
    <?php }?>
</tbody>
<tfoot>
    <tr>
        <th colspan="7" class="text-right" style="padding: 10px;"><button id="simpan" class="btn btn-save" type="button">Simpan</button></th>
    </tr>
</tfoot>


    </table>
</div>

<style>
     .btn-save {
                background-color: #fff;
                color: #367FA9;
                font-weight: bold;
                border: none;
                border-radius: 5px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
                cursor: pointer;
                transition: background-color 0.3s, box-shadow 0.3s;
            }

            .btn-save:hover {
                background-color: #28597A;
                color: white;
                box-shadow: 0 6px 8px rgba(0, 0, 0, 0.3);
            }

            .btn-save:active {
                background-color: #204562;
                box-shadow: 0 3px 5px rgba(0, 0, 0, 0.4);
            }
</style>

<script>
// Validasi input dan kirim data melalui AJAX
$('.best').on('change', function () {
    let value = this.value.replace(/[^0-9.,-]/g, ''); // Memungkinkan tanda koma dan titik
    if (value.indexOf('-') > 0) value = value.replace('-', '');
    if ((value.match(/[.,]/g) || []).length > 1) value = value.replace(/[.,]+$/, '');
    
    // Ganti titik dengan koma agar konsisten
    this.value = value.replace(',', '.');

    let id = $(this).data('id');
    let data = { id: id, best: value };

    // Kirim data melalui AJAX
    let url = modul_name + "/get_warna";
    cari_ajax_combo("post", "", data, "", url, "result_best");
});

// Validasi change dan kirim data melalui AJAX
$('.base').on('change', function () {
    let value = this.value.replace(/[^0-9.,-]/g, ''); // Memungkinkan tanda koma dan titik
    if (value.indexOf('-') > 0) value = value.replace('-', '');
    if ((value.match(/[.,]/g) || []).length > 1) value = value.replace(/[.,]+$/, '');
    
    // Ganti titik dengan koma agar konsisten
    this.value = value.replace(',', '.');

    let id = $(this).data('id');
    let data = { id: id, base: value };

    // Kirim data melalui AJAX
    let url = modul_name + "/get_warna";
    cari_ajax_combo("post", "", data, "", url, "result_base");
});

// Validasi change dan kirim data melalui AJAX
$('.worst').on('change', function () {
    let value = this.value.replace(/[^0-9.,-]/g, ''); // Memungkinkan tanda koma dan titik
    if (value.indexOf('-') > 0) value = value.replace('-', '');
    if ((value.match(/[.,]/g) || []).length > 1) value = value.replace(/[.,]+$/, '');
    
    // Ganti titik dengan koma agar konsisten
    this.value = value.replace(',', '.');

    let id = $(this).data('id');
    let data = { id: id, worst: value };

    // Kirim data melalui AJAX
    let url = modul_name + "/get_warna";
    cari_ajax_combo("post", "", data, "", url, "result_worst");
});

// Fungsi untuk mengatur warna berdasarkan respons
function result_best(res) {
    if (!res || !res.id || !res.warna) {
        console.error("Respons tidak valid", res);
        return;
    }

    let text = "#ffffff";
    $('#best_' + res.id).css({
        'background-color': res.warna,
        'color': text
    });
     $('#color_best_' + res.id).val(res.warna);
}

// Fungsi untuk mengatur warna berdasarkan respons
function result_base(res) {
    if (!res || !res.id || !res.warna) {
        console.error("Respons tidak valid", res);
        return;
    }

    let text = "#ffffff";
   

    $('#base_' + res.id).css({
        'background-color': res.warna,
        'color': text
    });

    $('#color_base_' + res.id).val(res.warna);
}
// Fungsi untuk mengatur warna berdasarkan respons
function result_worst(res) {
    if (!res || !res.id || !res.warna) {
        console.error("Respons tidak valid", res);
        return;
    }

    let text = "#ffffff";

    $('#worst_' + res.id).css({
        'background-color': res.warna,
        'color': text
    });
    $('#color_worst_' + res.id).val(res.warna);
}

$("#simpan").click(function () {
    var ids = [];
    var bests = [];
    var bases = [];
    var worsts = [];
    var color_bests = [];
    var color_bases = [];
    var color_worsts = [];
    var uruts = [];


    $('input[name="id[]"]').each(function () {
        ids.push($(this).val());
    });
    $('input[name="urut[]"]').each(function () {
        uruts.push($(this).val());
    });
    $('input[name="best[]"]').each(function () {
        bests.push($(this).val());
    });

    $('input[name="base[]"]').each(function () {
        bases.push($(this).val());
    });

    $('input[name="worst[]"]').each(function () {
        worsts.push($(this).val());
    });

    $('input[name="color_best[]"]').each(function () {
        color_bests.push($(this).val());
    });

    $('input[name="color_base[]"]').each(function () {
        color_bases.push($(this).val());
    });

    $('input[name="color_worst[]"]').each(function () {
        color_worsts.push($(this).val());
    });


    // var owner = $('input[name="owner"]').val();
    var semester = $('input[name="semester"]').val();
    var periode = $('input[name="periode"]').val();

    var data = {
        'id': ids,
        'urut': uruts,
        'best': bests,
        'base': bases,
        'worst': worsts,
        'color_best': color_bests,
        'color_base': color_bases,
        'color_worst': color_worsts,
        'semester' : semester,
        'periode' : periode
    };

        // var parent = $(this).parent();
        var url = modul_name + "/simpan";

        cari_ajax_combo("post", "", data, "", url, "result");
});

function result(res){
    pesan_toastr('Proses Simpan Berhasil...', 'info', 'Prosess', 'toast-top-center', true);
}

</script>