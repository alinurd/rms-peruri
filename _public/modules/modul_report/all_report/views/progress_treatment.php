
  <table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="no-col" rowspan="2" style="background: white; min-width: 50px;">No</th>
            <th class="risk-owner-col text-center" rowspan="2" style=" background: white; min-width: 150px;">Risk Owner</th>
            <th class="text-center peristiwa-risiko-col" rowspan="2" style=" background: white; min-width: 200px;">Peristiwa Risiko</th>
            <th class="text-center treatment-col" rowspan="2" style=" background: white; min-width: 200px;">Treatment</th>
            <th class="text-center tahun-col" rowspan="2" style="min-width: 100px;">Tahun</th>
            <th class="text-center month-col" colspan="2">Januari</th>
            <th class="text-center month-col" colspan="2">Februari</th>
            <th class="text-center month-col" colspan="2">Maret</th>
            <th class="text-center month-col" colspan="2">April</th>
            <th class="text-center month-col" colspan="2">Mei</th>
            <th class="text-center month-col" colspan="2">Juni</th>
            <th class="text-center month-col" colspan="2">Juli</th>
            <th class="text-center month-col" colspan="2">Agustus</th>
            <th class="text-center month-col" colspan="2">September</th>
            <th class="text-center month-col" colspan="2">Oktober</th>
            <th class="text-center month-col" colspan="2">November</th>
            <th class="text-center month-col" colspan="2">Desember</th>
        </tr>
        <tr>
            <th class="text-center target-col">Target</th>
            <th class="text-center realisasi-col">Realisasi</th>
            <th class="text-center target-col">Target</th>
            <th class="text-center realisasi-col">Realisasi</th>
            <th class="text-center target-col">Target</th>
            <th class="text-center realisasi-col">Realisasi</th>
            <th class="text-center target-col">Target</th>
            <th class="text-center realisasi-col">Realisasi</th>
            <th class="text-center target-col">Target</th>
            <th class="text-center realisasi-col">Realisasi</th>
            <th class="text-center target-col">Target</th>
            <th class="text-center realisasi-col">Realisasi</th>
            <th class="text-center target-col">Target</th>
            <th class="text-center realisasi-col">Realisasi</th>
            <th class="text-center target-col">Target</th>
            <th class="text-center realisasi-col">Realisasi</th>
            <th class="text-center target-col">Target</th>
            <th class="text-center realisasi-col">Realisasi</th>
            <th class="text-center target-col">Target</th>
            <th class="text-center realisasi-col">Realisasi</th>
            <th class="text-center target-col">Target</th>
            <th class="text-center realisasi-col">Realisasi</th>
            <th class="text-center target-col">Target</th>
            <th class="text-center realisasi-col">Realisasi</th>
        </tr>

        <?php
        $no = 1;
        foreach ($data as $d) {
        ?>
            <tr>
                <td style="background: white; min-width: 50px;"><?= $no++ ?></td>
                <td style=" background: white; min-width: 150px; z-index: 1000;"><?= $d['name'] ?></td>
                <td style="background: white; min-width: 200px; z-index: 1000;"><?= $d['event_name'] ?></td>
                <td style="background: white; min-width: 200px; z-index: 1000;"><?= ($d['proaktif']) ? $d['proaktif'] : $d['reaktif']; ?></td>
                <td style="min-width: 100px;"><?= $d['periode_name'] ?></td>
                <?php
                for ($i = 1; $i <= 12; $i++):
                    $data['id']         = $d['id'];
                    $data['id_action']  = $d['id_action'];
                    $data['rcsa_no']    = $d['rcsa_no'];
                    echo $this->data->getMonthlyMonitoringGlobal($data, $i);
                endfor;
                ?>
            </tr>
    <?php } ?>
    </thead>
</table>
