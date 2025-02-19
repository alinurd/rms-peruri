<div class="table-responsive">
<table class="table table-bordered table-hover table-responsive">
    <thead>
        <tr>
            <th class="text-center">No</th>
            <th class="text-center">Risk Owner</th>
            <th class="text-center">Peristiwa</th>
            <th class="text-center">Treatment</th>
            <th class="text-center">Tahun</th>
            <th class="text-center">Tanggal Validasi</th>
            <th class="text-center">Bulan</th>
            <th class="text-center">Status</th>
            <th class="text-center">Keterangan</th>
        </tr>
    </thead>
    <tbody>
    <?php $no = 1; foreach ($field as $row) : ?>

    <?php 

        
        $data_treatment = $this->db->where('id_rcsa_action', $row['rcsa_action_no'])->where('bulan', $row['bulan'])
                                ->get(_TBL_RCSA_TREATMENT)
                                ->row_array();
        $status = '';
        $class_text = '';
        if ($row['progress_detail'] == $data_treatment['target_progress_detail'] && $row['target_progress_detail'] == $data_treatment['target_damp_loss']) {
            $status = 'Sesuai';
            $class_text = 'text-success';
        } else {
            $status = 'Tidak Sesuai';
            $class_text = 'text-danger';
        }

        // Nama bulan untuk ditampilkan
        $bulan_names = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $bulan = $row['bulan'];  // Misalnya, $row['bulan'] berisi angka bulan
    ?>
    <tr>
        <td class="text-center"><?= $no++; ?></td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['event_name'] ?></td>
        <td class="text-center"> <?= ($row['proaktif']) ? $row['proaktif'] : $row['reaktif']; ?></td>
        <td class="text-center"><?= $row['tahun'] ?></td>
        <td class="text-center"><?=  date("d-m-Y", strtotime($row['tanggal_validasi'])); ?></td>
        <td class="text-center"><?= isset($bulan_names[$bulan]) ? $bulan_names[$bulan] : 'Unknown' ?></td>
        <td class="text-center"><span class="<?= $class_text; ?>"><?= $status; ?></span></td>
        <td>
            <div class="form-group" style="display: flex; justify-content: center; align-items: center; gap: 20px;">
                <div>
                    <label for="progressInput">Progress (%)</label>
                    <div class="input-group">
                        <input style="width:100px !important;" type="number" readonly class="form-control" placeholder="Progress %" value="<?= $data_treatment['target_progress_detail'];?>" aria-describedby="basic-addon2" id="progressInput">
                        <span class="input-group-addon" id="basic-addon2">%</span>
                    </div>
                </div>

                <div>
                    <label for="dampLossInput">Damp Loss (Rp.)</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1">Rp.</span>
                        <input style="width:100px !important;" readonly type="text" 
                        value="<?= number_format($data_treatment['target_damp_loss'], 0, ',', ',');?>" class="form-control numeric rupiah" placeholder="Damp Loss" aria-describedby="basic-addon1" id="dampLossInput">
                    </div>
                </div>
            </div>
        </td>


       
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</div>
