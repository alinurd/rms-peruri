<?php
$bulanName = [
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

foreach ($bulanName as $keyB => $bulanheader) {
?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="text-center" style="background: white; width: 50px;">No</th>
            <th class="text-center" style="background: white; width: 120px;">Risk Owner</th>
            <th class="text-center" style="background: white; width: 140px;">Peristiwa Risiko</th>
            <th class="text-center" style="background: white; width: 50px;">Tahun</th>
            <th class="text-center" style="background: white; width: 50px;">Inh</th>
            <th class="text-center" style="background: white; width: 50px;">Res</th>
            <th class="text-center" style="background: white; width: 50px;">PL</th>
            <th class="text-center">keterangan Pergerakan Level Bulan : <?=$bulanheader; ?></th>
        </tr>
    </thead>

    <tbody>
        <?php
        $data['owner_no']       = $data['owner_no'];
        $data['periode_no']     = $data['periode_no'];
        $data['bulan']          = $keyB;
        $field                  = $this->data->perubahan_level($data);
        // doi::dump($field);
        $no = 1;
        foreach ($field as $q) {
            $residual_level = $this->data->get_master_level(true, $q['inherent_level']);
            $getKode        = $this->data->level_action($residual_level['likelihood'], $residual_level['impact']);
            $reKod          = $getKode['like']['code'] . ' x ' . $getKode['impact']['code'];

            $inherent = '
            <a class="btn" data-toggle="popover" data-content="
            <center>
            ' . $reKod . ' <br>
            ' . $residual_level['level_mapping'] . '
            </center>
            " style="padding:4px; height:4px 8px;width:100%;background-color:' . $residual_level['color'] . ';color:' . $residual_level['color_text'] . ';"> &nbsp;</a>';

            $pl = ''; 
            $getMonitoring = $this->data->getMonthlyMonitoringGlobal_PL($q['id'], $keyB, $residual_level['level_mapping']);
        ?>

            <tr>
                <td style="position: sticky; left: 0; background: white;z-index: 99;"><?= $no++ ?></td>
                <td style="position: sticky; left: 50px; background: white;z-index: 98;"><?= $q['owner_name'] ?></td>
                <td style="position: sticky; left: 170px; background: white;z-index: 97;"><?= $q['event_name'] ?></td>
                <td style="position: sticky; left: 310px; background: white; z-index: 96; "><?= $q['tahun'] ?></td>
                <td style="position: sticky; left: 360px; background: white; z-index: 95; "><?= $inherent ?></td>
                <td style="position: sticky; left:400px; background: white; z-index: 95; "><?= $getMonitoring['lv'] ?></td>
                <td style="position: sticky; left:440px; background: white; z-index: 95; ">
                    <?= $getMonitoring['pl'] ?>

                </td>

                <td class="text-center">
                    <?= $getMonitoring['ket'] ?>

                </td>
            </tr>
        
        <?php
            }
        ?>
    </tbody>

</table>
<?php
   # code...
}

?>
