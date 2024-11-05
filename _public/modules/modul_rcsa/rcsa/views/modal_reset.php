<!-- 
<?php // if (isset($log)) : ?>
    <style>
        .modal { z-index: 2050; }
        .double-scroll { width: 100%; }
        thead th, tfoot th { padding: 5px !important; text-align: center; }
        .w250 { width: 250px; }
        .w150 { width: 150px; }
        .w100 { width: 100px; }
        .w80 { width: 80px; }
        .w50 { width: 50px; }
        td ol { padding-left: 10px; width: 300px; }
        td ol li { margin-left: 5px; }
    </style>

    <div class="row">
        <div class="col-md-12">
            <h4>Log Aktivitas</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th width="25%" class="text-left">Status</th>
                        <th class="text-left">Keterangan</th>
                        <th width="10%">Tanggal</th>
                        <th width="15%">Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php // foreach ($log as $index => $row) : ?>
                        <tr>
                            <td class="text-center"><?php // $index + 1; ?></td>
                            <td><?php // htmlspecialchars($row['keterangan']); ?></td>
                            <td><?php // htmlspecialchars($row['note']); ?></td>
                            <td><?php // htmlspecialchars($row['create_date']); ?></td>
                            <td><?php // htmlspecialchars($row['create_user']); ?></td>
                        </tr>
                    <?php // endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php // endif; ?> -->

<div class="row">
    <?php
    $jml_id_rcsa = count($id_rcsa);
    ?>
    <?php 
        for ($i=0; $i < $jml_id_rcsa; $i++) { ?>

            <input type="hidden" name="id_rcsa[]" id="id_rcsa[]" value="<?=$id_rcsa[$i];?>">
    <?php
        }
    ?>
    <div class="col-md-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-left">Catatan :</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <textarea class="form-control" name="note" id="note" cols="30" rows="10" style="width: 100%;"></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" id="btn-reset" class="btn btn-primary">Reset</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    

</script>
