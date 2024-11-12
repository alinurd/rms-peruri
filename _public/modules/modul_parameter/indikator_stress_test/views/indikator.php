
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
            <th width="7%">Urut</th>
            <th>Indikator</th>
            <th width="10%">RKAP</th>
            <th width="10%">Satuan</th>
            <th width="10%">Kurang</th>
            <th width="10%">Sama</th>
            <th width="10%">Lebih</th>
            <th width="5%">Aksi</th>
        </tr>
        <tr>

        </tr>
    </thead>
    <tbody>
    <?php foreach($data as $p):
            $details = $this->db
                ->where('id_parent', $p['id'])
                ->get('bangga_indikator_stress_test_detail')
                ->result_array(); ?>
        <?php foreach ($details as $detail): ?>
            <tr class="detail-row">
                <td>
                <input type="hidden" class="form-control" name="detail_edit[<?= $p['urut'] ?>][]" value="<?= $detail['id'] ?>" readonly>
                <input class="form-control" type="text" name="param[<?= $p['urut'] ?>][]" value="<?= $detail['parameter'] ?>" placeholder="Detail Parameter"></td>
                <td><input class="form-control" type="number" name="skala[<?= $p['urut'] ?>][]" value="<?= $detail['skala'] ?>" placeholder="Detail Skala"></td>
                <td><input class="form-control" type="number" name="detail_penilaian[<?= $p['urut'] ?>][]" value="<?= $detail['penilaian'] ?>" placeholder="Detail Penilaian"></td>
                <td>
                    <button type="button" class="btn btn-warning delete-detail-row"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endforeach; ?>
    </tbody>
</table>

<center>
    <button id="addParam" class="btn btn-primary" type="button">
        <i class="fa fa-plus"></i> Tambah
    </button>
</center>

<script>
    
    // Fungsi untuk memperbarui urutan dan rowspan kolom utama
function updateUrutAbjad() {
    const tbody = document.querySelector("#tbl_sasaran_new tbody");
    const rows = tbody.querySelectorAll(".main-row");

    rows.forEach((row, index) => {
        const urutInput = row.querySelector('input[name="urut[]"]');
        urutInput.value = String.fromCharCode(65 + index); // Mengatur urutan ke huruf A, B, C, ...
        updateRowspan(row); // Memperbarui rowspan
    });
}

// Fungsi memperbarui rowspan kolom utama
function updateRowspan(mainRow) {
    const urutCell = mainRow.querySelector("td");
    let detailCount = 0;
    let nextRow = mainRow.nextElementSibling;

    while (nextRow && nextRow.classList.contains("detail-row")) {
        detailCount++;
        nextRow = nextRow.nextElementSibling;
    }
    urutCell.rowSpan = detailCount + 1; // Mengatur rowspan
}

// Event listener untuk tombol delete pada baris utama dan detail
function addDeleteEventListeners() {
    document.querySelectorAll(".delete-row").forEach(button => {
        button.addEventListener("click", function() {
            const mainRow = button.closest("tr");

            // Menghapus semua baris detail yang terkait dengan baris utama
            let nextRow = mainRow.nextElementSibling;
            while (nextRow && nextRow.classList.contains("detail-row")) {
                nextRow.remove();
                nextRow = mainRow.nextElementSibling;
            }
            
            mainRow.remove(); // Hapus baris utama
            updateUrutAbjad(); // Memperbarui urutan setelah menghapus
        });
    });

    document.querySelectorAll(".delete-detail-row").forEach(button => {
        button.addEventListener("click", function() {
            const detailRow = button.closest("tr");
            const mainRow = detailRow.previousElementSibling.classList.contains("main-row")
                ? detailRow.previousElementSibling
                : detailRow.previousElementSibling.previousElementSibling;
            detailRow.remove(); // Hapus baris detail
            updateRowspan(mainRow); // Memperbarui rowspan setelah menghapus
        });
    });
}

// Event listener untuk menambah detail baru
function findLastDetailRow(mainRow) {
    let nextRow = mainRow.nextElementSibling;

    while (nextRow && nextRow.classList.contains("detail-row")) {
        if (!nextRow.nextElementSibling || !nextRow.nextElementSibling.classList.contains("detail-row")) {
            return nextRow;
        }
        nextRow = nextRow.nextElementSibling;
    }
    return null;
}

 
 document.getElementById("addParam").addEventListener("click", function() {
    const tbody = document.querySelector("#tbl_sasaran_new tbody");
    const rowCount = tbody.querySelectorAll(".main-row").length;
    const urutan = String.fromCharCode(65 + rowCount); 

    const newRow = document.createElement("tr");
    newRow.classList.add("main-row");

    newRow.innerHTML = `
        <td rowspan="1"><input type="text" class="form-control" name="urut[]" value="${urutan}" readonly></td>
        <td><input class="form-control" type="text" name="param[]" placeholder="Indikator"></td>
        <td><input class="form-control" type="number" name="rkap[]" placeholder="RKAP"></td>
        <td><input class="form-control" type="text" name="satuan[]" placeholder="Satuan"></td>
        <td style="vertical-align: middle;">
            <select name="kurang[]" class="selectpicker form-control" data-style="btn btn-outline-primary" data-width="100%" data-size="7" data-container="body" required>
                <?php foreach ($textColor as $key => $value): ?>
                    <option value="<?= $value; ?>" data-content="<span class='badge' style='background-color: <?= $comboColor[$key]; ?>; color: #FFFFFF'><?= $value; ?></span>">
                        <?= $value; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </td>
        <td style="vertical-align: middle;">
            <select name="sama[]" class="selectpicker form-control" data-style="btn btn-outline-primary" data-width="100%" data-size="7" data-container="body" required>
                <?php foreach ($textColor as $key => $value): ?>
                    <option value="<?= $value; ?>" data-content="<span class='badge' style='background-color: <?= $comboColor[$key]; ?>; color: #FFFFFF'><?= $value; ?></span>">
                        <?= $value; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </td>
        <td style="vertical-align: middle;">
            <select name="lebih[]" class="selectpicker form-control" data-style="btn btn-outline-primary" data-width="100%" data-size="7" data-container="body" required>
                <?php foreach ($textColor as $key => $value): ?>
                    <option value="<?= $value; ?>" data-content="<span class='badge' style='background-color: <?= $comboColor[$key]; ?>; color: #FFFFFF'><?= $value; ?></span>">
                        <?= $value; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </td>
        <td>
            <button type="button" class="btn btn-danger delete-row"><i class="fa fa-trash"></i></button>
        </td>
    `;

    tbody.appendChild(newRow);

    // Tambahkan event listener delete untuk baris utama yang baru dibuat
    newRow.querySelector(".delete-row").addEventListener("click", function() {
        let nextRow = newRow.nextElementSibling;
        while (nextRow && nextRow.classList.contains("detail-row")) {
            nextRow.remove();
            nextRow = newRow.nextElementSibling;
        }
        newRow.remove();
        updateUrutAbjad(); // Memperbarui urutan setelah menghapus
    });


    updateUrutAbjad(); // Memperbarui urutan abjad
    addDeleteEventListeners(); // Tambah event listener untuk semua delete
    $('.selectpicker').selectpicker();
});

//add param detail defult
document.querySelectorAll(".add-Detailxxxx").forEach(button => {
    button.addEventListener("click", function() {
        var urutan = $(this).data("urutan");
        console.log(urutan) 
        const mainRow = button.closest("tr");
        const newRow = document.createElement("tr");
        newRow.classList.add("detail-row");
        const tbody = document.querySelector("#tbl_sasaran_new tbody");
        const rowCount = tbody.querySelectorAll("main-row").length;
         newRow.innerHTML = `
            <td><input type="text" class="form-control" name="detail_param[${urutan}][]" placeholder="${urutan} Parameter"></td>
            <td><input class="form-control" type="number" name="detail_skala[${urutan}][]" placeholder="Skala"></td>
            <td><input class="form-control" type="number" name="detail_penilaian[${urutan}][]" placeholder="Hasil Penilaian"></td>
            <td><button type="button" class="btn btn-warning delete-detail-row"><i class="fa fa-trash"></i></button></td>
        `;

        // Menambahkan baris detail baru di bawah semua baris detail yang ada
            let nextRow = mainRow.nextElementSibling;
            while (nextRow && nextRow.classList.contains("detail-row")) {
                nextRow = nextRow.nextElementSibling;
            }
            if (nextRow) {
                // Jika ada baris setelah detail, masukkan di atas baris itu
                nextRow.insertAdjacentElement('beforebegin', newRow);
            } else {
                // Jika tidak ada baris detail, masukkan di bawah baris utama
                mainRow.insertAdjacentElement('afterend', newRow);
            }
            updateRowspan(mainRow); // Memperbarui rowspan

        });
});

addDeleteEventListeners();

</script>