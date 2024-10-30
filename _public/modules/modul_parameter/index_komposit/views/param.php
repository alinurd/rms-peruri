
<table class="table table-bordered" id="tbl_sasaran_new">
    <thead class="sticky-thead">
        <tr>
            <th width="7%">Urut</th>
            <th>Parameter</th>
            <th width="10%">Skala</th>
            <th width="10%">Hasil Penilaian</th>
            <th width="5%">Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($data as $p):
            $details = $this->db
                ->where('id_param', $p['id'])
                ->get('bangga_index_komposit_detail')
                ->result_array(); ?>

        <tr class="main-row">
            <td rowspan="<?=count($details) + 1?>">
                <input type="text" class="form-control" name="idParam" value="<?= $p['id'] ?>" readonly>
                <input type="text" class="form-control" name="edit[]" value="<?= $p['id'] ?>" readonly>
                <input type="text" class="form-control" name="urut[]" value="<?= $p['urut'] ?>" readonly>
            </td>
            <td><input class="form-control" type="text" name="param[]" value="<?= $p['parameter'] ?>" placeholder="Parameter"></td>
            <td><input class="form-control" type="number" name="skala[]" value="<?= $p['skala'] ?>" placeholder="Skala"></td>
            <td><input class="form-control" type="number" name="penilaian[]" value="<?= $p['penilaian'] ?>" placeholder="Hasil Penilaian"></td>
            <td>
                <button type="button" class="btn btn-info add-Detail"><i class="fa fa-plus"></i></button>
                <button type="button" class="btn btn-danger delete-row"><i class="fa fa-trash"></i></button>
            </td>
        </tr>

        <?php foreach ($details as $detail): ?>
            <tr class="detail-row">
                <td>
                <input type="text" class="form-control" name="detail_edit[<?= $p['urut'] ?>][]" value="<?= $detail['id'] ?>" readonly>
                <input class="form-control" type="text" name="detail_param[<?= $p['urut'] ?>][]" value="<?= $detail['parameter'] ?>" placeholder="Detail Parameter"></td>
                <td><input class="form-control" type="number" name="detail_skala[<?= $p['urut'] ?>][]" value="<?= $detail['skala'] ?>" placeholder="Detail Skala"></td>
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
 // Event listener untuk menambah detail baru
 

 
document.getElementById("addParam").addEventListener("click", function() {
    const tbody = document.querySelector("#tbl_sasaran_new tbody");
    const rowCount = tbody.querySelectorAll(".main-row").length;
    const urutan = String.fromCharCode(65 + rowCount); 

    const newRow = document.createElement("tr");
    newRow.classList.add("main-row");

    newRow.innerHTML = `
        <td rowspan="1"><input type="text" class="form-control" name="urut[]" value="${urutan}" readonly></td>
        <td><input class="form-control" type="text" name="param[]" placeholder="Parameter"></td>
        <td><input class="form-control" type="number" name="skala[]" placeholder="Skala"></td>
        <td><input class="form-control" type="number" name="penilaian[]" placeholder="Hasil Penilaian"></td>
        <td>
            <button type="button" class="btn btn-info add-Detail"><i class="fa fa-plus"></i></button>
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

    newRow.querySelector(".add-Detail").addEventListener("click", function() {
        const lastDetailRow = findLastDetailRow(newRow) || newRow; // Dapatkan baris detail terakhir
        const tbody = document.querySelector("#tbl_sasaran_new tbody");
    const rowCount = tbody.querySelectorAll(".main-row").length;
    const urutan = String.fromCharCode(65 + rowCount-1); 

        const detailRow = document.createElement("tr");
        detailRow.classList.add("detail-row");

        detailRow.innerHTML = `
            <td><input type="text" class="form-control" name="detail_param[${urutan}][]" placeholder="${urutan} Parameter"></td>
            <td><input class="form-control" type="number" name="detail_skala[${urutan}][]" placeholder="Skala"></td>
            <td><input class="form-control" type="number" name="detail_penilaian[${urutan}][]" placeholder="Hasil Penilaian"></td>
            <td><button type="button" class="btn btn-warning delete-detail-row"><i class="fa fa-trash"></i></button></td>
        `;

        lastDetailRow.insertAdjacentElement('afterend', detailRow);
        updateRowspan(newRow); // Memperbarui rowspan

        // Event listener delete untuk baris detail baru
        detailRow.querySelector(".delete-detail-row").addEventListener("click", function() {
            detailRow.remove();
            updateRowspan(newRow); // Memperbarui rowspan setelah menghapus
        });
    });

    updateUrutAbjad(); // Memperbarui urutan abjad
    addDeleteEventListeners(); // Tambah event listener untuk semua delete
});

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

// Menambahkan event listener delete ketika halaman dimuat
addDeleteEventListeners();


</script>