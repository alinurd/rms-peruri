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
        <?php foreach ($data as $p): ?>
        <tr>
            <td><input type="text" class="form-control" name="urut[]" value="<?= $p['urut'] ?>" readonly></td>
            <td><input class="form-control" type="text" name="param[]" value="<?= $p['parameter'] ?>" id="param"></td>
            <td><input class="form-control" type="number" name="skala[]" value="<?= $p['skala'] ?>" id="skala"></td>
            <td><input class="form-control" type="number" name="penilaian[]" value="<?= $p['penilaian'] ?>" id="penilaian"></td>
            <td>
                <button type="button" class="btn btn-danger delete-row"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<center>
    <button id="addParam" class="btn btn-primary" type="button">
        <i class="fa fa-plus"></i>
    </button>
</center>

<script>
document.getElementById("addParam").addEventListener("click", function() {
    const tbody = document.querySelector("#tbl_sasaran_new tbody");
    const rowCount = tbody.rows.length;
    const urutan = String.fromCharCode(65 + rowCount); // Urutan abjad, misalnya A, B, C, dst.

    const newRow = document.createElement("tr");

    const urutCell = document.createElement("td");
    const urutInput = document.createElement("input");
    urutInput.className = "form-control";
    urutInput.type = "text";
    urutInput.name = "urut[]";
    urutInput.value = urutan;
    urutInput.readOnly = true;
    urutCell.appendChild(urutInput);
    newRow.appendChild(urutCell);

    const paramCell = document.createElement("td");
    const paramInput = document.createElement("input");
    paramInput.className = "form-control";
    paramInput.type = "text";
    paramInput.name = "param[]";
    paramCell.appendChild(paramInput);
    newRow.appendChild(paramCell);

    const skalaCell = document.createElement("td");
    const skalaInput = document.createElement("input");
    skalaInput.className = "form-control";
    skalaInput.type = "number";
    skalaInput.name = "skala[]";
    skalaCell.appendChild(skalaInput);
    newRow.appendChild(skalaCell);

    const penilaianCell = document.createElement("td");
    const penilaianInput = document.createElement("input");
    penilaianInput.className = "form-control";
    penilaianInput.type = "number";
    penilaianInput.name = "penilaian[]";
    penilaianCell.appendChild(penilaianInput);
    newRow.appendChild(penilaianCell);

    const aksiCell = document.createElement("td");
    const deleteButton = document.createElement("button");
    deleteButton.className = "btn btn-danger delete-row";
    deleteButton.innerHTML = '<i class="fa fa-trash"></i>';
    deleteButton.type = "button";
    aksiCell.appendChild(deleteButton);
    newRow.appendChild(aksiCell);

    tbody.appendChild(newRow);
    updateUrutAbjad();
 
    deleteButton.addEventListener("click", function() {
        newRow.remove();
        updateUrutAbjad();
    });
});

function updateUrutAbjad() {
    const tbody = document.querySelector("#tbl_sasaran_new tbody");
    const rows = tbody.querySelectorAll("tr");

    rows.forEach((row, index) => {
        const urutInput = row.querySelector('input[name="urut[]"]');
        urutInput.value = String.fromCharCode(65 + index);
    });
}
 
document.querySelectorAll(".delete-row").forEach(button => {
    button.addEventListener("click", function() {
        if (confirm("Apakah Anda yakin ingin menghapus data?")) {
            button.closest("tr").remove();
            updateUrutAbjad();
        }
    });
});

</script>
