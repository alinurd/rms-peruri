<?php echo form_open(base_url('rcsa-context/simpan-copy'), array('id' => 'form_input_library', 'role' => 'form"'), ['id_rcsa' => $id_rcsa]); ?>
<?= $id; ?>
<table class="table table-bordered  ">
    <tr style="background:#0B2161 !important; color: white">
        <td width="90%">
            <h4><b><u>Data Risk Context</u></b></h4>
            <table width="100%" style="color: white">
                <tr>
                    <td width="10%">judul</td>
                    <td><?= $judul; ?></td>
                </tr>
                <tr>
                    <td>owner</td>
                    <td><?= $cboowner; ?></td>
                </tr>

                <tr>
                    <td style="text-align:justify; ">Sasaran</td>
                    <td>
                        <table class="table table-bordered  ">
                            <?php $no = 1;
                            foreach ($sasaran as $row) :
                                $detail = $this->db->where('sasaran_no', $row['id'])->get("bangga_view_rcsa_detail")->result_array();

                            ?>
                                <tr style="background:#0B2161 !important; color: white">
                                    <td rowspan=""><?= $no++; ?></td>

                                    <td width="100%"><strong><?= $row['sasaran']; ?></strong>

                                        <?php
                                        if (count($detail) > 0) { ?>
                                            <br><i> Risk Identify :
                                            </i> <br>
                                        <?php

                                        }
                                        foreach ($detail as $d) : ?>
                                            - <?= $d['event_name']; ?> <br>
                                        <?php endforeach; ?>

                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>tahun</td>
                    <td><?= $tahun; ?></td>
                </tr>
            </table>
        </td>
        <td><button class="btn btn-sm btn-info copy pull-right" id="copy" style="right:10px; top:13px;">COPY DATA</button>
        </td>
    </tr>
</table>
<br>
<br>
<!-- <span style='font-size: 20px; font-weight: bold;'> Risk Contex Detail </span><br>
<i style='font-size:12px;'>Created By: <?= $rcsa['create_user'] ?></i>
<div class="double-scroll" style='height:550px;'>

    <table class="table table-bordered table-sm table-risk-register table-scroll" id="datatables_event">
        <thead>
            <tr>
                <th colspan="4">General Information</th>
                <th colspan="6">Isu Internal</th>
                <th colspan="6">Isu External</th>
            </tr>
            <tr>
                <th>Pimpinan Unit Kerja</th>
                <th>Anggota Unit Kerja</th>
                <th>Tugas Pokok & Fungsi</th>
                <th>Pekerjaan diluar Tupoksi</th>

                
                <th>Man</th>
                <th>Method</th>
                <th>Machine</th>
                <th>Money</th>
                <th>Material</th>
                <th>Market</th>

                 <th>Politics</th>
                <th>Economics</th>
                <th>Social</th>
                <th>Technologi</th>
                <th>Environtment</th>
                <th>Legal</th>
            </tr>
        </thead>
        <tbody id="risk-register">

            <?php
            if (count($rcsa) == 0)
                echo '<tr><td colspan=16 style="text-align:center">Tidak Ada Data</td></tr>'
            ?>
            <tr>
                <td><?= $rcsa['owner_pic'] ?></td>
                <td><?= $rcsa['anggota_pic'] ?></td>
                <td><?= $rcsa['tugas_pic'] ?></td>
                <td><?= $rcsa['tupoksi'] ?></td>

                 <td><?= $rcsa['man'] ?></td>
                <td><?= $rcsa['method'] ?></td>
                <td><?= $rcsa['machine'] ?></td>
                <td><?= $rcsa['money'] ?></td>
                <td><?= $rcsa['material'] ?></td>
                <td><?= $rcsa['market'] ?></td>

                 <td><?= $rcsa['politics'] ?></td>
                <td><?= $rcsa['economics'] ?></td>
                <td><?= $rcsa['social'] ?></td>
                <td><?= $rcsa['tecnology'] ?></td>
                <td><?= $rcsa['environment'] ?></td>
                <td><?= $rcsa['legal'] ?></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th>Pimpinan Unit Kerja</th>
                <th>Anggota Unit Kerja</th>
                <th>Tugas Pokok & Fungsi</th>
                <th>Pekerjaan diluar Tupoksi</th>

                 <th>Man</th>
                <th>Method</th>
                <th>Machine</th>
                <th>Money</th>
                <th>Material</th>
                <th>Market</th>

                 <th>Politics</th>
                <th>Economics</th>
                <th>Social</th>
                <th>Technologi</th>
                <th>Environtment</th>
                <th>Legal</th>
            </tr>
        </tfoot>
    </table>
</div> -->
<? echo form_close();
?>


<script type="text/javascript">
    var note = '<?php echo $note; ?>';
    $(document).ready(function() {
        $('.double-scroll').doubleScroll({
            resetOnWindowResize: true,
            scrollCss: {
                'overflow-x': 'auto',
                'overflow-y': 'auto'
            },
            contentCss: {
                'overflow-x': 'auto',
                'overflow-y': 'auto'
            },
        });
        $(window).resize();
    });
    $(document).on("click", "#copy", function() {
        var tahun = $("#ctahun").val()
        var judul = $("#cjudul").val()
        console.log(judul)
        if (!tahun) {
            alert("Data Tahun Tidak Boleh Kosong!");
            return false;

        } else {
            alert("Anda yakin ingin mengcoppy data risk-contex ?\nJudul Assesment: " + judul);

        }

        return true;
    })
    var arr_row = [];
    var total_row = <?php echo count($field); ?>;

    for (var i = 0; i < total_row; i++) {
        arr_row[i] = i;
    }
</script>

<style>
    .double-scroll {
        width: 100%;
    }

    thead th,
    tfoot th {
        font-size: 12px;
        padding: 5px !important;
        text-align: center;
    }

    .w250 {
        width: 250px;
    }

    .w150 {
        width: 150px;
    }

    .w100 {
        width: 100px;
    }

    .w80 {
        width: 80px;
    }

    .w50 {
        width: 50px;
    }

    td ol {
        padding-left: 10px;
        width: 300px;
    }

    td ol li {
        margin-left: 5px;

    }
</style>