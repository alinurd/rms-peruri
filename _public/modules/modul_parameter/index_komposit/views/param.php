
<table class="table table-bordered" id="tbl_sasaran_new">
    <thead class="sticky-thead">
        <tr>
            <th  width="3%">Urut</th>
            <th >Parameter</th>
            <th  width="10%" >Skala</th>
            <th  width="10%" >Hasil Penilaian</th>
            <th  width="5%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td  >A</td>
            <td >
                <input class="form-control" type="text" name="param" id="param">
            </td>
            <td   >
                <input class="form-control" type="number" name="skala" id="skala">
            </td>
            <td   >
            <input class="form-control" type="number" name="penilaian" id="penilaian">
            </td>
            <td  >Aksi</td>
        </tr>
    </tbody>
</table>

<center>
    <button id="addParam" class="btn btn-primary" type="button">
        <i class="fa fa-plus"></i> Tambah
    </button>
</center>


<script>
document.getElementById("addParam").addEventListener("click", function() {
     const tbody = document.querySelector("#tbl_sasaran_new tbody");
    
     const rowCount = tbody.rows.length;
    const urutan = String.fromCharCode(65 + rowCount);
    
    const newRow = document.createElement("tr");

     const urutCell = document.createElement("td");
    urutCell.textContent = urutan;
    newRow.appendChild(urutCell);

    
    const paramCell = document.createElement("td");
    const paramInput = document.createElement("input");
    paramInput.className = "form-control";
    paramInput.type = "text";
    paramInput.name = "param";
    paramInput.id = "param";
    paramCell.appendChild(paramInput);
    newRow.appendChild(paramCell);

    
    const skalaCell = document.createElement("td");
    const skalaInput = document.createElement("input");
    skalaInput.className = "form-control";
    skalaInput.type = "number";
    skalaInput.name = "skala";
    skalaInput.id = "skala";
    skalaCell.appendChild(skalaInput);
    newRow.appendChild(skalaCell);

    
    const penilaianCell = document.createElement("td");
    const penilaianInput = document.createElement("input");
    penilaianInput.className = "form-control";
    penilaianInput.type = "number";
    penilaianInput.name = "penilaian";
    penilaianInput.id = "penilaian";
    penilaianCell.appendChild(penilaianInput);
    newRow.appendChild(penilaianCell);

    const aksiCell = document.createElement("td");
    const deleteButton = document.createElement("button");
    deleteButton.className = "btn btn-danger";
    deleteButton.textContent = "Hapus";
    deleteButton.type = "button";

    deleteButton.addEventListener("click", function() {
        newRow.remove();
        updateUrutAbjad(); 
    });

    aksiCell.appendChild(deleteButton);
    newRow.appendChild(aksiCell);
    tbody.appendChild(newRow);
});

 function updateUrutAbjad() {
    const tbody = document.querySelector("#tbl_sasaran_new tbody");
    const rows = tbody.querySelectorAll("tr");

    rows.forEach((row, index) => {
        const urutCell = row.cells[0];
        urutCell.textContent = String.fromCharCode(65 + index);
    });
}
</script>

