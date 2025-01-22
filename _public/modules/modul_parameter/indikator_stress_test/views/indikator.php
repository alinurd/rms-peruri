
<?php
 $textColor = [
    '1' => 'Merah',
    '2' => 'Biru',
    '3' => 'Hijau'
];

$comboColor = [
    '1' => '#c62828',    // Cukup & Efektif
    '2' => '#0288d1',    // Sebagian
    '3' => '#689f38'  // Tidak Cukup & Tidak Efektif
];


?>


<!-- START CSS -->
<style>
   
    .bs-container dropdown bootstrap-select open {
        margin-top: -50px;
    }
        

    .bootstrap-select{
        height: 40px !important;
    }

    .bootstrap-select .popover {
        display: none !important;
    }
</style>
<!-- END STYLE CSS -->
<table class="table table-bordered" id="tbl_sasaran_new">
    <thead class="sticky-thead">
        <tr>
            <th class="text-center" width="5%">Urut</th>
            <th class="text-center">Indikator</th>
            <th class="text-center" width="10%">RKAP</th>
            <th class="text-center" width="10%">Satuan</th>
            <th class="text-center" width="10%">Kurang</th>
            <th class="text-center" width="10%">Sama</th>
            <th class="text-center" width="10%">Lebih</th>
            <th class="text-center" width="5%">Aksi</th>
        </tr>
        <tr>

        </tr>
    </thead>
    <tbody>
        
    <?php foreach($data as $p): ?>
            <tr class="detail-row">
                <td>
                <input type="hidden" class="form-control" name="detail_edit[]" value="<?= $p['id'] ?>" readonly>
                <input class="form-control text-center" type="text" name="urut[]" value="<?= $p['urut'] ?>" placeholder="Detail Indikator" readonly></td>
                <td><input class="form-control" type="text" name="param[]" value="<?= $p['parameter'] ?>" placeholder="Indikator"></td>
                <td>
                    <input class="form-control rkap" type="text" name="rkap[]" value="<?= $p['rkap'] ?>" placeholder="RKAP">
                </td>

                <td><input class="form-control" type="text" name="satuan[]" value="<?= $p['satuan'] ?>" placeholder="Satuan"></td>
                <td style="vertical-align: middle;">
                    <!-- Dropdown untuk memilih warna -->
                    <select name="kurang[]" class="selectpicker form-control select-color" 
                            data-style="btn btn-outline-primary" 
                            data-width="100%" 
                            data-size="7" 
                            data-container="body" 
                            required>
                        <?php foreach ($textColor as $key => $value): ?>
                            <option value="<?= $value; ?>" 
                                    data-color="<?= $comboColor[$key]; ?>" 
                                    data-content="<span class='badge' style='background-color: <?= $comboColor[$key]; ?>; color: #FFFFFF;'><?= $value; ?></span>" 
                                    <?= ($p['kurang'] == $value) ? 'selected' : ''; ?>>
                                <?= $value; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <!-- Input untuk menampilkan kode warna yang dipilih -->
                    <input class="form-control color-input" 
                        type="hidden" 
                        name="color_kurang[]" 
                        value="<?= $p['color_kurang'] ?>" 
                        readonly 
                        placeholder="Warna">
                </td>

                <td style="vertical-align: middle;">
                    <select name="sama[]" class="selectpicker form-control select-color" data-style="btn btn-outline-primary" data-width="100%" data-size="7" data-container="body" required>
                        <?php foreach ($textColor as $key => $value): ?>
                            <option value="<?= $value; ?>" data-color="<?= $comboColor[$key]; ?>"  data-content="<span class='badge' style='background-color: <?= $comboColor[$key]; ?>; color: #FFFFFF'><?= $value; ?></span>" <?= ($p['sama'] == $value) ? 'selected' : ''; ?>>
                                <?= $value; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Input untuk menampilkan kode warna yang dipilih -->
                    <input class="form-control color-input" 
                        type="hidden" 
                        name="color_sama[]" 
                        value="<?= $p['color_sama'] ?>" 
                        readonly 
                        placeholder="Warna">
                </td>
                <td style="vertical-align: middle;">
                    <select name="lebih[]" class="selectpicker form-control select-color" data-style="btn btn-outline-primary" data-width="100%" data-size="7" data-container="body" required>
                        <?php foreach ($textColor as $key => $value): ?>
                            <option value="<?= $value; ?>" data-color="<?= $comboColor[$key]; ?>"  data-content="<span class='badge' style='background-color: <?= $comboColor[$key]; ?>; color: #FFFFFF'><?= $value; ?></span>" <?= ($p['lebih'] == $value) ? 'selected' : ''; ?>>
                                <?= $value; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Input untuk menampilkan kode warna yang dipilih -->
                    <input class="form-control color-input" 
                        type="hidden" 
                        name="color_lebih[]" 
                        value="<?= $p['color_lebih'] ?>" 
                        readonly 
                        placeholder="Warna">
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-danger delete-row"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<center>
    <button id="addParam" class="btn btn-primary" type="button">
        <i class="fa fa-plus"></i> Tambah
    </button>
</center>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const tbody = document.querySelector("#tbl_sasaran_new tbody");

    // Fungsi memperbarui urutan abjad
    function updateUrutAbjad() {
        const rows = tbody.querySelectorAll(".detail-row");
        rows.forEach((row, index) => {
            row.querySelector('input[name="urut[]"]').value = String.fromCharCode(65 + index);
        });
    }

    // Fungsi untuk mengatur warna default pada halaman load
    function setDefaultColor() {
        document.querySelectorAll('.select-color').forEach(function(select) {
            const selectedColor = select.querySelector('option:checked').dataset.color;
            if (selectedColor) {
                select.closest('td').querySelector('.color-input').value = selectedColor;
            }
        });
    }

    // Tambah baris utama baru
    document.getElementById("addParam").addEventListener("click", function () {
        const newRow = document.createElement("tr");
        newRow.classList.add("detail-row");

        const abjad = String.fromCharCode(65 + tbody.querySelectorAll(".detail-row").length);
        newRow.innerHTML = `
            <td>
                <input type="text" class="form-control text-center" name="urut[]" value="${abjad}" readonly>
            </td>
            <td>
                <input class="form-control" type="text" name="param[]" placeholder="Indikator">
            </td>
            <td>
                <input class="form-control rkap" type="text" name="rkap[]" placeholder="RKAP">
            </td>
            <td>
                <input class="form-control" type="text" name="satuan[]" placeholder="Satuan">
            </td>
            ${['kurang', 'sama', 'lebih'].map(key => `
            <td>
                <select name="${key}[]" class="selectpicker form-control select-color" data-style="btn btn-outline-primary" required>
                    <?php foreach ($textColor as $id => $value): ?>
                    <option value="<?= $value; ?>" 
                            data-color="<?= $comboColor[$id]; ?>" 
                            data-content="<span class='badge' style='background-color: <?= $comboColor[$id]; ?>; color: #FFFFFF;'><?= $value; ?></span>">
                        <?= $value; ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                <input class="form-control color-input" type="hidden" name="color_${key}[]" readonly>
            </td>`).join('')}
            <td class="text-center">
                <button type="button" class="btn btn-danger delete-row"><i class="fa fa-trash"></i></button>
            </td>
        `;

        tbody.appendChild(newRow);
        updateUrutAbjad();
        $('.selectpicker').selectpicker('refresh');
        setDefaultColor(); // Set warna default untuk baris baru
    });

    // Hapus baris utama
    tbody.addEventListener("click", function (e) {
        if (e.target.closest(".delete-row")) {
            const row = e.target.closest("tr");
            row.remove();
            updateUrutAbjad();
        }
    }); 

    // Validasi change dan kirim data melalui AJAX
$('.worst').on('input', function () {
    let value = this.value.replace(/\./g, ''); // Menghapus titik, untuk menangani format ribuan
    value = value.replace(',', '.'); // Mengganti koma dengan titik desimal
    this.value = _formatNumber(value.replace('.', ',')); // Mengubah titik menjadi koma untuk format tampilan

    let id = $(this).data('id');
    let data = { id: id, worst: value };

    // Kirim data melalui AJAX
    let url = modul_name + "/get_warna";
    cari_ajax_combo("post", "", data, "", url, "result_worst");
});

    // jQuery untuk validasi input angka
    $(document).on('input', '.rkap', function() {
        let value   = this.value.replace(/\./g, ''); // Memungkinkan tanda koma dan titik
        value       = value.replace(',', '.');
        this.value  = _formatNumber(value.replace('.', ','));
    });

    $(document).on('blur', '.rkap', function() {
        if (this.value === '.' || this.value === ',') this.value = '';
    });


    // Event delegation untuk select dropdown
    $(document).on('change', '.select-color', function() {
        const selectedColor = $(this).find('option:selected').data('color');
        $(this).closest('td').find('.color-input').val(selectedColor);
    });

    // Set warna default saat halaman dimuat
    setDefaultColor();
});

</script>
