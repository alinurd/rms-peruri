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
            <td rowspan="1"><input type="text" class="form-control" name="urut[]" value="<?= $p['urut'] ?>" readonly></td>
            <td><input class="form-control" type="text" name="param[]" value="<?= $p['parameter'] ?>" placeholder="Parameter"></td>
            <td><input class="form-control" type="number" name="skala[]"  value="<?= $p['skala'] ?>"placeholder="Skala"></td>
            <td><input class="form-control" type="number" name="penilaian[]"  value="<?= $p['penilaian'] ?>"placeholder="Hasil Penilaian"></td>
            <td>
                <button type="button" class="btn btn-info add-Detail"><i class="fa fa-plus"></i></button>
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
// Fungsi memperbarui urutan dan rowspan kolom utama
function updateUrutAbjad() {
    const tbody = document.querySelector("#tbl_sasaran_new tbody");
    const rows = tbody.querySelectorAll(".main-row");

    rows.forEach((row, index) => {
        const urutInput = row.querySelector('input[name="urut[]"]');
        urutInput.value = String.fromCharCode(65 + index);
        updateRowspan(row);
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
    urutCell.rowSpan = detailCount + 1;
}

// Fungsi untuk memperbarui urutan nomor detail
function updateDetailUrut(mainRow) {
    let detailRows = [];
    let nextRow = mainRow.nextElementSibling;

    while (nextRow && nextRow.classList.contains("detail-row")) {
        detailRows.push(nextRow);
        nextRow = nextRow.nextElementSibling;
    }

    detailRows.forEach((row, index) => {
        row.querySelector(".detail-urut input").value = index + 1;
    });
}

// Event listener untuk menambah detail baru
document.querySelectorAll(".add-Detail").forEach(button => {
    button.addEventListener("click", function() {
        const mainRow = button.closest("tr");
        const lastDetailRow = findLastDetailRow(mainRow) || mainRow; // Dapatkan baris detail terakhir

        const newRow = document.createElement("tr");
        newRow.classList.add("detail-row");

         newRow.innerHTML = `
            <td class="detail-urut">
                <input type="text" class="form-control" name="detail_urut[]" readonly style="width: 5%; display: inline-block; margin-right: 5px;">
                <input type="text" class="form-control" name="detail_param[]" placeholder="Detail Parameter" style="width: 90%; display: inline-block;">
            </td>
            <td><input class="form-control" type="number" name="detail_skala[]" placeholder="Skala"></td>
            <td><input class="form-control" type="number" name="detail_penilaian[]" placeholder="Hasil Penilaian"></td>
            <td><button type="button" class="btn btn-warning delete-detail-row"><i class="fa fa-trash"></i></button></td>
        `;

        lastDetailRow.insertAdjacentElement('afterend', newRow); 
        updateDetailUrut(mainRow);
        updateRowspan(mainRow);

         newRow.querySelector(".delete-detail-row").addEventListener("click", function() {
            newRow.remove();
            updateDetailUrut(mainRow);
            updateRowspan(mainRow);
        });
    });
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

 document.getElementById("addParam").addEventListener("click", function() {
    const tbody = document.querySelector("#tbl_sasaran_new tbody");
    const rowCount = tbody.querySelectorAll(".main-row").length;
    const urutan = String.fromCharCode(65 + rowCount); 

    const newRow = document.createElement("tr");
    newRow.classList.add("main-row");

     newRow.innerHTML = `
        <td rowspan="1"><input type="text" class="form-control" name="urut[]" value="${urutan}" readonly></td>
        <td><input class="form-control" type="text" name="param[]"></td>
        <td><input class="form-control" type="number" name="skala[]"></td>
        <td><input class="form-control" type="number" name="penilaian[]"></td>
        <td>
            <button type="button" class="btn btn-info add-Detail"><i class="fa fa-plus"></i></button>
            <button type="button" class="btn btn-danger delete-row"><i class="fa fa-trash"></i></button>
        </td>
    `;

    tbody.appendChild(newRow);

     newRow.querySelector(".add-Detail").addEventListener("click", function() {
        const lastDetailRow = findLastDetailRow(newRow) || newRow; 

        const detailRow = document.createElement("tr");
        detailRow.classList.add("detail-row");

        detailRow.innerHTML = `
            <td class="detail-urut">
                <input type="text" class="form-control" name="detail_urut[${urutan}[]" readonly style="width: 5%; display: inline-block; margin-right: 5px;">
                <input type="text" class="form-control" name="detail_param[${urutan}[]" placeholder="Detail Parameter" style="width: 90%; display: inline-block;">
            </td>
            <td><input class="form-control" type="number" name="detail_skala[${urutan}[]" placeholder="Skala"></td>
            <td><input class="form-control" type="number" name="detail_penilaian[${urutan}[]" placeholder="Hasil Penilaian"></td>
            <td><button type="button" class="btn btn-warning delete-detail-row"><i class="fa fa-trash"></i></button></td>
        `;

        lastDetailRow.insertAdjacentElement('afterend', detailRow); 
        updateDetailUrut(newRow);
        updateRowspan(newRow);

         detailRow.querySelector(".delete-detail-row").addEventListener("click", function() {
            detailRow.remove();
            updateDetailUrut(newRow);
            updateRowspan(newRow);
        });
    });

    updateUrutAbjad();
});
</script>
