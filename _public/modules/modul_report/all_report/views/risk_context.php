<table class="table table-bordered table-striped table-hover dataTable data table-small-font dt-responsive" width="100%" id="datatables" style="font-size: <?= htmlspecialchars($master['attrTable']['size']); ?>;">
    <thead>
        <tr>
            <th class="text-center">NO</th>
            <th class="text-center">Judul Assessment</th>
            <th class="text-center">Risk Owner</th>
            <th class="text-center">Jumlah Sasaran</th>
            <th class="text-center">Jumlah Peristiwa</th>
            <th class="text-center">Periode</th>
            <th class="text-center">Download</th>
            <th class="text-center">View Risk Context</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($data)): ?>
            <?php foreach ($data as $index => $row): ?>
                <tr>
                    <td class="text-center"><?= $index + 1; ?></td>
                    <td><?= $row['judul_assesment']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td class="text-center"><?= $row['jumlah_sasaran']; ?></td>
                    <td class="text-center"><?= $row['jumlah_peristiwa']; ?></td>
                    <td class="text-center"><?= $row['periode_name']; ?></td>
                    <td class="text-center">
                        <?php if($row['nm_file']) { ;?>
                            <a class="" href="<?= base_url('all_report/downloadFile/').$row['nm_file'];?>"><i class="fa fa-download" aria-hidden="true"></i></a>
                        <?php }else { ;?>
                        <span>File Tidak Ada</span>
                        <?php };?>
                    </td>
                    <td class="text-center">
                        <!-- <a class="" href="http://localhost/rms-peruri-main/report-risk-context/view/339/1825/2024"><i class="fa fa-search pointer"></i></a> -->
                        <a class="" href="<?= base_url('all_report/view/').$row['id'].'/'.$row['owner_no'].'/'.$row['periode_name'].'/risk_context';?>"><i class="fa fa-search pointer"></i></a>
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
