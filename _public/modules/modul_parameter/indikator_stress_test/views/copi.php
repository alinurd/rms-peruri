<?php echo form_open(base_url('indikator-stress-test/simpan-copy'), array('id' => 'form_input_indikator', 'role' => 'form"'), ['id_indikator' => $id]); ?>
<?= $id; ?>
<table class="table table-bordered ">
    <tr style="background:#0B2161 !important; color: white">
        <td width="90%">
            <h4><b><u>Data Indikator Stress Test</u></b></h4>
            <table width="100%" style="color: white">
                <tr>
                    <td width="10%">Judul</td>
                    <td><?= $judul; ?></td>
                </tr>

                <tr>
                    <td>Tahun</td>
                    <td><?= $tahun; ?></td>
                </tr>
                <tr>
                    <td>Semester</td>
                    <td><?= $semester; ?></td>
                </tr>
            </table>
            <br>
            <b>Detail Indikator Stress Test</b>
            <table class="table table-bordered" id="tbl_sasaran_new" style="color: black;">
                <thead class="sticky-thead">
                    <tr>
                        <th class="text-center" width="5%">Urut</th>
                        <th class="text-center">Indikator</th>
                        <th class="text-center" width="10%">RKAP</th>
                        <th class="text-center" width="10%">Satuan</th>
                        <th class="text-center" width="10%">Kurang</th>
                        <th class="text-center" width="10%">Sama</th>
                        <th class="text-center" width="10%">Lebih</th>
                    </tr>
                </thead>
                <tbody>
                    
                <?php foreach($detail_indikator as $p): ?>
                        <tr class="detail-row">
                            <td class="text-center"><?= $p['urut'] ?></td>
                            <td><?= $p['parameter'] ?></td>
                            <td class="text-center">
                            <?= $p['rkap'] ?>
                            </td>

                            <td class="text-center"><?= $p['satuan'] ?></td>
                            <td style="background-color: <?=$p['color_kurang'];?>; color:white;" class="text-center"><?= $p['kurang'] ?></td>
                            <td style="background-color: <?=$p['color_sama'];?>; color:white;" class="text-center"><?= $p['sama'] ?></td>
                            <td style="background-color: <?=$p['color_lebih'];?>; color:white;" class="text-center"><?= $p['lebih'] ?></td>                
                            
                        </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <table style="width: 100%;">
                <tr>
                    <td style="vertical-align: bottom; text-align: right;"><button class="btn btn-sm btn-info copy pull-right" id="copy" style="right:10px; top:13px;">COPY DATA</button>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- END STYLE CSS -->

<br>
<br>

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
        var semester = $("#csemester").val()
        var judul = $("#cjudul").val()
        console.log(judul)


        if (!semester) {
            alert("Data Semester Tidak Boleh Kosong!");
            return false;

        } 
        if (!tahun) {
            alert("Data Tahun Tidak Boleh Kosong!");
            return false;

        } else {
            alert("Anda yakin ingin mengcoppy data indikator stress test ?\nJudul Indikator Stress Test: " + judul);

        }

        return true;
    })

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