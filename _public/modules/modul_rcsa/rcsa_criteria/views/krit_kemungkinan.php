<?php
$gender     = $this->authentication->get_info_user('kelamin');
$photo      = $this->authentication->get_Preference('list_photo');
$units      = $this->authentication->get_info_user('param_level');
$groups     = $this->authentication->get_info_user('group');
$info_owner = $this->authentication->get_info_user('group_owner');
// var_dump($id);
?>

<section class="wrapper site-min-height">
    <div class="x_panel">
        <div class="row">
            <div class="col-md-12">
                <div class="x_content">
                    <aside class="profile-info col-md-12">
                        <div class="x_content" style="overflow-x:auto;">
                        <input type="hidden" name="krit_kemungkinan" value="krit_kemungkinan">
                                <table class="table table-bordered" id="kemungkinanTable">
                                    <thead>
                                    <tr>
                                        <th rowspan="2" class="text-center align-middle">Kemungkinan</th>
                                        <th colspan="5" class="text-center">Risiko</th>
                                        <th rowspan="2" class="text-center align-middle">Aksi</th>
                                    </tr>
                                    <tr>
                                        <?php foreach ($kriteria as $key => $k): ?>
                                            <td width="15%" bgcolor="<?= $k['color'] ?>" class="text-center" style="color: #000;">
                                                <?= $k['name'] ?>
                                                
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                    </thead>
                                    <tbody id="kemungkinanBody">
                                        <?php foreach ($kemungkinan as $kem): ?>
                                            <tr>
                                                <td>
                                                <?= form_textarea('kemungkinan[]', $kem['data'], "maxlength='10000' class='form-control auto-resize' rows='2' style='overflow:hidden;'"); ?>
                                                </td>
                                                <?php foreach ($kriteria as $kee => $k): ?>
                                                    <td>
                                                        <?php 
                                                        $kemu = $this->db->where('km_id', $kem['id'])
                                                                         ->where('criteria_risiko', $kee)
                                                                         ->order_by('criteria_risiko')
                                                                         ->get(_TBL_AREA_KM)
                                                                         ->row_array();
                                                        ?>
                                                        <!-- Input hidden untuk menyimpan data kriteria -->
                                                        <input type="hidden" name="kriteria[<?= $kee ?>][name]" value="<?= $kee ?>">
                                                        <?= form_textarea('area['.$kee.'][]', isset($kemu['area']) ?  html_entity_decode($kemu['area']) : '', "maxlength='10000' class='form-control auto-resize' rows='2' style='overflow:hidden;'"); ?>

                                                    </td>
                                                <?php endforeach; ?>
                                                <td><button type="button" class="btn btn-danger removeRowBtn"><i class="fa fa-trash"></i></button></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
								<center>
									<button type="button" class="btn btn-primary" id="addRowBtn"><i class="fa fa-plus"></i> Kemungkinan</button>
								</center>
                        </div>
                    </aside>
                </div> <!-- x_content -->
            </div> <!-- col-md-12 -->
        </div> <!-- row -->
    </div> <!-- x_panel -->
</section>

<script>
   // Fungsi untuk mengubah ukuran textarea sesuai konten
    function autoResizeTextarea(textarea) {
        textarea.style.height = 'auto'; // Reset tinggi
        textarea.style.height = (textarea.scrollHeight) + 'px'; // Sesuaikan tinggi dengan konten
    }

    // Inisialisasi semua textarea saat halaman dimuat
    $(document).ready(function () {
        $('.auto-resize').each(function () {
            autoResizeTextarea(this);
        });
    });

    // Event listener untuk resize otomatis saat pengguna mengetik
    $(document).on('input', '.auto-resize', function () {
        autoResizeTextarea(this);
    });

    // Menggunakan jQuery untuk menambahkan row baru
    $('#addRowBtn').click(function () {
        var tbody = $('#kemungkinanBody');
        var newRow = $('<tr></tr>');

        // Tambah cell untuk textarea kemungkinan
        var newCellKemungkinan = $('<td></td>').html("<textarea name='kemungkinan[]' maxlength='10000' class='form-control auto-resize' rows='2' style='overflow:hidden;'></textarea>");
        newRow.append(newCellKemungkinan);

        // Tambah cell untuk setiap kriteria dan buat textarea
        <?php foreach ($kriteria as $kee => $k): ?>
        var newCell = $('<td></td>').html("<textarea name='area[<?= $kee ?>][]' maxlength='10000' class='form-control auto-resize' rows='2' style='overflow:hidden;'></textarea>");
        newRow.append(newCell);
        <?php endforeach; ?>

        // Tambah cell untuk tombol remove
        var newCellAction = $('<td></td>').html('<button type="button" class="btn btn-danger removeRowBtn"><i class="fa fa-trash"></i></button>');
        newRow.append(newCellAction);

        // Tambah row ke tabel
        tbody.append(newRow);

        // Inisialisasi auto-resize untuk textarea baru
        newRow.find('.auto-resize').each(function () {
            autoResizeTextarea(this);
        });

        // Tambah event listener untuk tombol remove
        newCellAction.find('.removeRowBtn').click(function () {
            newRow.remove();
        });
    });

</script>
