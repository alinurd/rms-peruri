<table class="table table-bordered table-striped table-hover dataTable data table-small-font dt-responsive" width="100%" id="datatables_criteria" style="font-size: <?= htmlspecialchars($master['attrTable']['size']); ?>;">
    <thead>
        <tr>
            <th class="text-center">NO</th>
            <th class="text-center">Judul Assessment</th>
            <th class="text-center">Risk Owner</th>
            <th class="text-center">Periode</th>
            <th class="text-center">View Risk Criteria</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($data)): ?>
            <?php foreach ($data as $index => $row): ?>
                <tr>
                    <td class="text-center"><?= $index + 1; ?></td>
                    <td><?= $row['judul_assesment']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td class="text-center"><?= $row['periode_name']; ?></td>
                    <td class="text-center">
                        <a class="" href="<?= base_url('all_report/view/').$row['id'].'/'.$row['owner_no'].'/'.$row['periode_name'].'/risk_criteria';?>"><i class="fa fa-search pointer"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" class="text-center">Tidak ada data tersedia</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#datatables_criteria').DataTable({
            responsive: true
        });
    });
</script>


