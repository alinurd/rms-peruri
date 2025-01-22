
<table class="table table-striped table-bordered table-hover">
<thead>
    <tr>
        <th class="text-center" rowspan="2" width="4%">No</th>
        <th class="text-center" rowspan="2" width="8%">Risk Owner</th>
        <th class="text-center" rowspan="2" width="12%">Peristiwa Risiko</th>
        <th class="text-center" rowspan="2" width="8%">Indikator</th>
        <th class="text-center" rowspan="2" width="8%">Satuan</th>
        <th colspan="3" class="text-center" width="20%">Threshold</th>
        <th colspan="12" class="text-center" width="40%">Realisasi</th>
    </tr>
    <tr class="text-center">
        <td class="text-center" style="background-color: #7FFF00; color: #000;" width="6%">Aman</td>
        <td class="text-center" style="background-color: #FFFF00; color: #000;" width="6%">Hati-Hati</td>
        <td class="text-center" style="background-color: #FF0000; color: #000;" width="6%">Bahaya</td>
        <th class="text-center" rowspan="2" width="3%">Jan</th>
        <th class="text-center" rowspan="2" width="3%">Feb</th>
        <th class="text-center" rowspan="2" width="3%">Mar</th>
        <th class="text-center" rowspan="2" width="3%">Apr</th>
        <th class="text-center" rowspan="2" width="3%">Mei</th>
        <th class="text-center" rowspan="2" width="3%">Jun</th>
        <th class="text-center" rowspan="2" width="3%">Jul</th>
        <th class="text-center" rowspan="2" width="3%">Agu</th>
        <th class="text-center" rowspan="2" width="3%">Sep</th>
        <th class="text-center" rowspan="2" width="3%">Okt</th>
        <th class="text-center" rowspan="2" width="3%">Nov</th>
        <th class="text-center" rowspan="2" width="3%">Des</th>
    </tr>
</thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($data as $q) {
            if ($q['kri']) {
                $act            = $this->db->where('rcsa_detail_no', $q['id'])->get(_TBL_VIEW_RCSA_MITIGASI)->row_array();
                $combo          = $this->db->where('id', $q['kri'])->get('bangga_data_combo')->row_array();
                $combo_stuan    = $this->db->where('id', $q['satuan'])->get('bangga_data_combo')->row_array();

                $level_1        = range($q['min_rendah'], $q['max_rendah']);
                $level_2        = range($q['min_menengah'], $q['max_menengah']);
                $level_3        = range($q['min_tinggi'], $q['max_tinggi']);

                if (in_array($data, $level_1)) {
                    $bgres = 'style="background-color: #7FFF00; color: #000;"';
                } elseif (in_array($data, $level_2)) {
                    $bgres = 'style="background-color: #FFFF00; color: #000;"';
                } elseif (in_array($data, $level_3)) {
                    $bgres = 'style="background-color: #FF0000; color: #000;"';
                } else {
                    $bgres = '';
                }
        ?>
        <tr>
            <td class="text-center" style="background-color: #fff;"><?= $no++ ?></td>
            <td style="background-color: #fff;"><?= $q['name'] ?></td>
            <td style="background-color: #fff; "><?= $act['event_name'] ?></td>
            <td style="background-color: #fff;"><?= $combo['data'] ?></td>
            <td style="background-color: #fff; ">
                <center><?= $combo_stuan['data'] == "%" ? "persentase [%]" : $combo_stuan['data'] ?></center>
            </td>
            <td class="text-center" style="background-color: #7FFF00; color: #000;"><?= $q['min_rendah'] ?> - <?= $q['max_rendah'] ?></td>
            <td class="text-center" style="background-color: #FFFF00; color: #000;"><?= $q['min_menengah'] ?> - <?= $q['max_menengah'] ?></td>
            <td class="text-center" style="background-color: #FF0000; color: #000;"><?= $q['min_tinggi'] ?> - <?= $q['max_tinggi'] ?></td>
            <?php
            $start  = 1;
            $end    = 12;
            for ($i = $start; $i <= $end; $i++): 
                $data['id']         = $q['id'];
                $data['rcsa_no']    = $q['rcsa_no'];
                $res = $this->data->getMonthlyMonitoringGlobal_Early($data, $i);
            ?>
            <td <?= $res['bgres'] ?> id="kri-<?= $q['id'] ?><?= $i ?>">
                <center><?= $res['data'] ?></center>
            </td>
            <?php endfor; ?>
        </tr>
        <?php } else { ?>
        <tr>
            <td class="text-center" colspan="11">Tidak ada data Key Risk Indikator</td>
        </tr>
        <?php } ?>
        <?php } ?>
    </tbody>
</table>