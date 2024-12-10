<?php
$revisi = "hide";
if ($parent['sts_propose'] == 5) {
    $revisi = "";
}
?>
<style>
    .custom-checkbox {
        width: 20px;  /* Atur lebar checkbox */
        height: 20px; /* Atur tinggi checkbox */
        cursor: pointer; /* Mengubah kursor saat hover */
    }
</style>
<a href="<?= base_url(_MODULE_NAME_REAL_ . '/tambah-peristiwa/add/' . $parent['owner_no'] . '/' . $parent['id']) ?>" class="btn btn-primary <?=$revisi?>" id="add_peristiwa" data-id="0" target="_blank" data-rcsa="<?= $parent['id']; ?>"> <?= lang('msg_tombol_add'); ?> </a>

<span class="<?=$revisi?>" style="background-color:#ff0000;color:#fff;"> <strong><?= strtoupper('Revisi Risk Contetx'); ?></strong> </span>
<br>
<div class="table-responsive">
    <table class="display table table-bordered" id="tbl_event">
        <thead>
            <tr>
                <th class="text-center" width="5%">No.</th>
                <th class="text-center" width="5%">Key Risk</th>
                <th class="text-center" width="5%">Risk Priority</th>
                <th class="text-center">Risk Identify</th>
                <th class="text-center" width="20%">Risk Analysis Inherent </th>
                <th class="text-center" width="15%">Risk Evaluasi</th>
                <th class="text-center" width="20%">Risk Analysis Residual </th>
                <th class="text-center" width="15%">Risk Treatment</th>
                <!-- <th width="10%">Progress Treatment</th> -->
                <th class="text-center" width="10%">Created</th>
                <th class="text-center" width="10%">Progress Pengisian</th>
            </tr>
        </thead>
        <tbody>

            <?php
            // doi::dump();
            foreach ($field as $key => $row) : ?>

                <tr style="background-color:#d5edef;">
                    <td colspan="10"><strong><?= strtoupper($row['nama']); ?></strong></td>
                </tr>
                <?php
                $no = 0; 
                foreach ($row['detail'] as $ros) :
                    $sts_heatmap = $this->db->where('id',$ros['id'])->get('bangga_rcsa_detail')->row_array();
                    // doi::dump($sts_heatmap);
                    // doi::dump($ros);
                    $act = $this->db->where('rcsa_detail_no', $ros['id'])->get('bangga_rcsa_action')->row_array();
                    $actkri = $this->db->where('rcsa_detail', $ros['id'])->get('bangga_kri')->row_array();

                    // $inherent_level     = $this->data->cek_level_new($ros['analisis_like_inherent'], $ros['analisis_impact_inherent']);
                    // $residual_level     = $this->data->cek_level_new($ros['analisis_like_residual'], $ros['analisis_impact_residual']);
                    // doi::dump($cek_score);
                    // doi::dump($cek_score1);
                    $inherent_level = $this->data->get_master_level(true, $ros['inherent_level']);

                    $residual_level = $this->data->get_master_level(true, $ros['residual_level']);
                    // var_dump($a);
                    if (!$inherent_level) {
                        $inherent_level = ['color' => '', 'warna_txt' => '', 'level_mapping' => '-'];
                    }
                    $a = $inherent_level['tingkat'];

                    if (!$residual_level) {
                        $residual_level = ['color' => '', 'warna_txt' => '', 'level_mapping' => '-'];
                    }




                    $mitigasi = '';
                    $realisasi = '';
                    if ($ros['jml_mitigasi'] > 0) {
                        $mitigasi = '<span class="badge bg-primary">1</span>';
                    }
                    if ($ros['jml_realisasi'] > 0) {
                        $realisasi = '<span class="badge bg-primary">' . $ros['jml_realisasi'] . '</span>';
                    }
                ?>
                    <tr>
                        <td><?= ++$no; ?></td>
                        <td class="text-center" style="vertical-align: middle;">
                            <?php
                            $iskri = 'hide';
                            // #0088ff;
                            if (!empty($act)) {
                                if ($act['iskri'] == 1) {
                                    $iskri = '';
                                    $cl = " #6c757d";
                                    $tl = "data kri tidak ada";
                                    if (!empty($actkri['kri_no'])) {
                                        $cl = " #0088ff";
                                        $tl = "data kri  lengkap";
                                    }
                                }
                            } else {
                                $iskri = 'hide';
                            } ?>
                            
                            
                            <center>
                                <span class="<?= $iskri ?>" style="font-weight: bold; font-size: 25px; color: <?= $cl ?>;" title="<?= $tl ?>">
                                    <i class="fa fa-key <?= $iskri ?>"></i>
                                </span><br>

                                                        </center>
                            

                        </td>
                        <td class="text-center" style="vertical-align: middle;">
                            <?php $sts_heatmap_value = isset($sts_heatmap['sts_heatmap']) ? $sts_heatmap['sts_heatmap'] : 0;?>
                                <center>
                                <input class="form-control custom-checkbox" 
                                type="checkbox" 
                                id="sts_heatmap_<?php echo htmlspecialchars($ros['id'], ENT_QUOTES, 'UTF-8'); ?>" 
                                name="sts_heatmap" 
                                value="<?php echo htmlspecialchars($ros['id'], ENT_QUOTES, 'UTF-8'); ?>" 
                                <?php echo ($sts_heatmap['sts_heatmap'] == 1) ? 'checked' : ''; ?>>
                                </center>
                        </td>
                        <td class="peristiwa  pointer"> 
                            <?= $ros['event_name']; ?>
                            <!-- <div class="row-options pull-right">
                                <a href="<?= base_url(_MODULE_NAME_REAL_ . '/tambah-peristiwa/edit/' . $ros['id']  . '/' . $ros['rcsa_no']) ?>" class="  <?= $hide_edit; ?>" id="edit-peristiwa" data-id="0" data-rcsa="<?= $parent['id']; ?>"> Edit </a>

                                <span class="edit-peristiwa pointer" data-id="<?= $ros['id']; ?>" data-rcsa="<?= $ros['rcsa_no']; ?>"><em>Edit</em> </span> |  
                                <span class="delete-peristiwa text-danger pointer" data-id="<?= $ros['id']; ?>" data-rcsa="<?= $ros['rcsa_no']; ?>"><em>Delete</em> </span>
                            </div> -->
                        </td>
                        <td class="edit text-center  pointer">
                            <?php
                            $like = $this->db
                                ->where('id', $residual_level['likelihood'])
                                ->get('bangga_level')->row_array();

                            $impact = $this->db
                                ->where('id', $residual_level['impact'])
                                ->get('bangga_level')->row_array();
                            $likeinherent = $this->db
                                ->where('id', $inherent_level['likelihood'])
                                ->get('bangga_level')->row_array();

                            $impactinherent = $this->db
                                ->where('id', $inherent_level['impact'])
                                ->get('bangga_level')->row_array();
                                // doi::dump($inherent_level);

                            if ($ros['inherent_level'] > 0) : ?>

                                <span id="inherent_level_label">
                                    <span style="background-color:<?= $inherent_level['color']; ?>;color:<?= $inherent_level['color_text']; ?>;">&nbsp;<?= $impactinherent['code']; ?> x <?= $likeinherent['code']; ?>&nbsp;<?= $inherent_level['level_mapping']; ?>&nbsp;</span>
                                </span>

                                <!--echo "<span style='background-color:" . $ros[' warna'] . ";color:" . $ros['warna_text'] . ";'>&nbsp;" . $ros['inherent_analisis'] . "&nbsp;</span>" ;; ?>
                                    &nbsp;&nbsp; -->
                            <?php else : ?>
                                &nbsp;&nbsp;
                                <i class="fa fa-times-circle text-danger"></i><br />

                            <?php endif; ?>
                        </td>
                        <td class="edit text-center">

                            <?php
                            if (empty($ros['risk_control'])) : ?>
                                <i class="fa fa-times-circle text-danger"></i><br />tidak ada data

                            <?php else : ?>
                            <?= $ros['risk_control'];
                            endif; ?>
                            <br>

                        </td>
                        <td class="edit text-center  pointer">
                            <?php
                            if ($ros['residual_level'] > 0) : ?>
                                <span id="residual_level_label">
                                    <span style="background-color:<?= $residual_level['color']; ?>;color:<?= $residual_level['color_text']; ?>;">&nbsp; <?= $impact['code']; ?> X <?= $like['code']; ?> &nbsp;<?= $residual_level['level_mapping']; ?>&nbsp;</span>
                                </span>

                                <!-- echo "<span style='background-color:" . $ros[' warna_residual'] . ";color:" . $ros['warna_text_residual'] . ";'>&nbsp;" . $ros['residual_analisis'] . "&nbsp;</span>" ;; ?> -->

                            <?php else : ?>
                                &nbsp;&nbsp;
                                <i class="fa fa-times-circle text-danger"></i><br />

                            <?php endif; ?>
                        </td>

                        <!-- <td class="edit text-center pointer">
                            <?php
                            if ($ros['sts_next']) :
                                echo $mitigasi; ?>&nbsp;&nbsp;
                              <span class="text-primary pointer show-mitigasi level" data-id="<?= $ros['id']; ?>" data-rcsa="<?= $ros['rcsa_no']; ?>"><i class="fa fa-pencil"></i></span>  
                    <?php
                            else : ?>
                        <i class="fa fa-times-circle text-danger"></i><br />
                        Risk Treatment Belum Diisi
                    <?= $ros['treatment'];
                            endif; ?>
                    </td> -->

                        <td class="edit text-center pointer">
                            <?php
                            if (intval($parent['sts_propose']) < 4) : ?>
                                <i class="fa fa-times-circle text-danger"></i><br />need approval
                                <?php
                            elseif ($ros['sts_next']) :
                                echo $realisasi; ?>&nbsp;&nbsp;
                                <span class="text-primary pointer show-realisasi level" data-id="<?= $ros['id']; ?>" data-rcsa="<?= $ros['rcsa_no']; ?>"><i class="fa fa-pencil"></i></span>
                            <?php else : ?>
                                <i class="fa fa-times-circle text-danger"></i><br /><?= $ros['treatment'];
                                                                                endif; ?>
                        </td>
                        <td class="  text-center  ">
                            <?= $ros['create_user']; ?>

                        </td>
                        <!-- <td> -->
                        <?php
                        if ($ros['pi'] == 1) {
                            $bg = 'danger';
                            $nilai = '25';
                            $inf = 'risk identity';
                        } elseif ($ros['pi'] == 2) {
                            $bg = 'warning';
                            $nilai = '30';
                            $inf = 'risk analisys';
                        } elseif ($ros['pi'] == 3) {
                            $bg = 'primary';
                            $nilai = '55';
                            $inf = 'risk evaluasi';
                        } elseif ($ros['pi'] == 4) {
                            $bg = 'info';
                            $nilai = '75';
                            $inf = 'risk treatment';
                        } elseif ($ros['pi'] == 5) {
                            $bg = 'success';
                            $nilai = '100';
                            $inf = 'progres treatment';
                        } elseif ($ros['pi'] == 6) {
                            $bg = 'primary';
                            $nilai = '90';
                            $inf = 'Key Risk';
                            if ($actkri['kri_no']) {
                                $bg = 'primary';
                                $nilai = '100';
                                $inf = 'progres treatment';
                            }
                        } ?>

                        <td class="">
                            <div class="progress">
                                <div class="progress-bar bg-<?= $bg ?>" role="progressbar" style="width: <?= $nilai ?>%" aria-valuenow="<?= $nilai ?>" aria-valuemin="0" aria-valuemax="100"><?= $nilai ?>%</div>
                            </div>
                            <div class=" text-center">
                                <a href="<?= base_url(_MODULE_NAME_REAL_ . '/tambah-peristiwa/edit/' . $ros['id']  . '/' . $ros['rcsa_no']) ?>" class="  <?= $hide_edit; ?>" id="edit-peristiwa" data-id="0" data-rcsa="<?= $parent['id']; ?>">
                                    <span class=" btn btn-primary"> <?= $inf ?></span>
                                </a>
                                <span class=" btn btn-danger ">
                                    <span class="delete-peristiwa  text-light pointer" data-id="<?= $ros['id']; ?>" data-rcsa="<?= $ros['rcsa_no']; ?>"> Delete</span>
                                </span>
                            </div>
                            <!-- </td> -->




                        </td>
                    </tr>
            <?php
                endforeach;
            endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $(function() {
        $("table tr td.peristiwa").mouseover(function() {
            $(".row-options").css('left', '-9999em')
            $(this).find(".row-options").css('left', '0em');
        })

        $("table tr td.edit").mouseover(function() {
            $(".edit-level, .show-mitigasi, .show-realisasi").css('margin-top', '-20px');
            $(".edit-level, .show-mitigasi, .show-realisasi").css('top', '-9999em');
            $(this).find(".edit-level, .show-mitigasi, .show-realisasi").css('margin-top', '0px');
            $(this).find(".edit-level, .show-mitigasi, .show-realisasi").css('top', '40%');
        })
        $("input[name='sts_heatmap']").change(function() {
            var isChecked = $(this).is(':checked') ? 1 : 0; // 1 untuk checked, 0 untuk unchecked
            var id = $(this).val(); // Ambil nilai checkbox (ID)
            // console.log(id);

            // Mengirim data ke server
            $.ajax({
                url: "<?= base_url(_MODULE_NAME_REAL_ . '/update_sts_heatmap') ?>",
                type: 'POST',
                data: { id: id, status: isChecked }, // Mengirim ID dan status
                success: function(response) {
                    alert(response); // Menampilkan pesan dari server
                },
                error: function(xhr, status, error) {
                    console.error(error); // Menangani error
                }
            });
        });
    })

    // $(document).ready(function() {
    //     // Ketika checkbox diklik
        
    // });
</script>