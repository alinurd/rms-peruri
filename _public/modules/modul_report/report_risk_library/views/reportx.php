<a href="<?php echo base_url('report-risk-library/cetak-report/'.$id_parent);?>" data-toggle="modal" class="btn btn-danger btn-flat btn-large">
    <strong><i class="fa fa-file-pdf-o"></i> Print to PDF </strong>
</a> 

<?php
// Kumpulkan id untuk keperluan pre-fetch
$event_ids = [];
$t1_ids = [];
$t2_ids = [];
$t3_ids = [];
foreach ($library_data as $q) {
    $event_ids[] = $q['id'];
    if (!empty($q['t1'])) $t1_ids[] = $q['t1'];
    if (!empty($q['t2'])) $t2_ids[] = $q['t2'];
    if (!empty($q['t3'])) $t3_ids[] = $q['t3'];
}

$event_ids = array_unique($event_ids);
$t1_ids    = array_unique($t1_ids);
$t2_ids    = array_unique($t2_ids);
$t3_ids    = array_unique($t3_ids);

// Pre-fetch RCSA detail
$rcsa_rows = $this->db
    ->select('event_no, name as ownerName, sasaran')
    ->where_in('event_no', $event_ids)
    ->get("bangga_view_rcsa_detail")
    ->result_array();
 
$rcsa_group = [];
foreach ($rcsa_rows as $row) {
    $rcsa_group[$row['event_no']][] = $row;
}

// Pre-fetch Data Combo untuk t2 & t3 (misalnya untuk T3 dan T4 kolom)
$combo_ids = array_unique(array_merge($t2_ids, $t3_ids));

$combo_rows = $this->db
    ->select('id, data')
    ->where_in('id', $combo_ids)
    ->get(_TBL_DATA_COMBO)
    ->result_array(); 
$combo_data = [];
foreach ($combo_rows as $row) {
    $combo_data[$row['id']] = $row['data'];
}

// Pre-fetch data untuk t1 yang diambil dari library
$t1_rows = $this->db
    ->select('id, description')
    ->where_in('id', $t1_ids)
    ->get(_TBL_LIBRARY)
    ->result_array(); 
$t1_data = [];
foreach ($t1_rows as $row) {
    $t1_data[$row['id']] = $row['description'];
}
?>
<table border="1">
    <thead>
        <tr>
            <th>NO</th>
            <th>Kode</th>
            <th>Peristiwa</th>
            <th>T4</th>
            <th>T3</th>
            <th>T2</th>
            <th>Risk Cause</th>
            <th>Risk Impact</th>
            <th>Owner</th>
            <th>Sasaran</th>
        </tr>
    </thead>
    <tbody>
        <?php $row_no = 1; ?>
        <?php foreach ($library_data as $q): ?>
            <tr>
                <td><?= $row_no; ?></td>
                <td><?= $q['code']; ?></td>
                <td><?= $q['peristiwa']; ?></td>
                <td>
                      <?= isset($combo_data[$q['t3']]) ? $combo_data[$q['t3']] : '-'; ?>
                </td>
                <td>
                    <?= isset($combo_data[$q['t2']]) ? $combo_data[$q['t2']] : '-'; ?>
                </td>
                <td> 
                    <?= isset($t1_data[$q['t1']]) ? $t1_data[$q['t1']] : '-'; ?>
                </td>
               
                <td>
                    <?php
                    $cause_no = 1;
                    if (!empty($q['child_no'])) {
                        foreach ($q['child_no'] as $child) {
                            if ($child['type'] == 2) {
                                echo $cause_no++ . ". " . ($child['description'] ?: 'unknow') . "<br>";
                            }
                        }
                    } else {
                        echo "-";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $impact_no = 1;
                    if (!empty($q['child_no'])) {
                        foreach ($q['child_no'] as $child) {
                            if ($child['type'] == 3) {
                                echo $impact_no++ . ". " . ($child['description'] ?: 'unknow') . "<br>";
                            }
                        }
                    } else {
                        echo "-";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $owner_no = 1;
                    if (!empty($rcsa_group[$q['id']])) {
                        foreach ($rcsa_group[$q['id']] as $rcsa) {
                            echo $owner_no++ . ". " . ($rcsa['ownerName'] ?: 'unknow') . "<br>";
                        }
                    } else {
                        echo "-";
                    }
                    ?>
                </td>
                <td>
                    <?php
                    $sasaran_no = 1;
                    if (!empty($rcsa_group[$q['id']])) {
                        foreach ($rcsa_group[$q['id']] as $rcsa) {
                            echo $sasaran_no++ . ". " . ($rcsa['sasaran'] ?: 'unknow') . "<br>";
                        }
                    } else {
                        echo "-";
                    }
                    ?>
                </td>
            </tr>
            <?php $row_no++; ?>
        <?php endforeach; ?>
    </tbody>
</table>
