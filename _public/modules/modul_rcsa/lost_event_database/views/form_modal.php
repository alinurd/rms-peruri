<?php
// doi::dump($label_res);
if(!$lost_event){
    $chekya = "checked";
}else{
    if ($lost_event['kejadian_berulang'] == 1) {
        $chekya = "checked";
    } else {
        $chektdk = "checked";
    }
}



?>
<style>
    .mandatory{
        color : red;
    }
</style>
<form method="POST" id='form-lost' enctype="multipart/form-data"  action="<?= base_url(_MODULE_NAME_REAL_ . '/simpan_lost_event');?>">
<!-- ================ KEJADIAN RISIKO ====================== -->
<div class="row">
    <div style="background-color: white; padding: 10px; border-radius: 10px;">
        <h5 class="text-center" style="color: #343a40;">Kejadian Risiko</h5>
        <table class="table table-bordered" style="background-color: white;">
            <input type="hidden" name="rcsa_no_e" id="rcsa_no_e" value="<?=$lost_event ? $lost_event['rcsa_no'] : $rcsa_no ?>">
            <input type="hidden" name="id_edit" id="id_edit" value="<?= ($type != 'add') ? $lost_event['id'] : '';?>">
            <input type="hidden" name="type" id="type" value="<?= $type;?>">
            <input type="hidden" name="event_no" id="event_no" >
            <thead class="thead-light">
            <tr>
                <th width="20%">Nama Kejadian (Event) <span class="mandatory">*</span></th>
                <?php if($type === "edit") : ?>
                    <td colspan="2">
                        <?= $data_event['event_name']?>
                    </td>
                <?php endif;?>

                <?php if($type === "add") : ?>
                    <td width="70%" id="td_peristiwa">
                        <?= form_dropdown(
                            'id_detail',
                            $cboper,
                            $lost_event ? $lost_event['rcsa_detail_id'] : '',
                            'class="eventcombo select2 form-control" style="width:100% !important;" id="id_detail"' . $disable
                        ); ?>
                        <div class="text-danger" id="error-id_detail"></div>
                    </td>
                    <td width="10%" id="td_peristiwa_new">
                        <button type="button" class="btn btn-info <?= $hide_edit ?>" id="peristiwa_baru">New</button>
                    </td>
                    <td id="td_peristiwabaru">
                        <?= form_input(
                            'peristiwabaru',
                            $detail ? $detail['peristiwabaru'] : '',
                            'class="form-control" placeholder="Input Peristiwa Baru" id="peristiwabaru"'
                        ); ?>
                    </td>
                    <td id="td_peristiwa_lib" width="10%">
                        <button type="button" class="btn btn-info" id="peristiwa_lib">Library</button>
                    </td>
                <?php endif;?>

                
            </tr>

                <tr>
                    <th width="20%">Identifikasi Kejadian <span class="mandatory">*</span></th>
                    <td colspan="2">
                        <textarea name="identifikasi_kejadian" class="form-control" id="identifikasi_kejadian" cols="30" rows="5"><?= $lost_event['identifikasi_kejadian'];?></textarea>
                        <div class="text-danger" id="error-identifikasi_kejadian"></div>
                    </td>
                </tr>
                <tr>
                    <th width="20%">Kategori Kejadian <span class="mandatory">*</span></th>
                    <td colspan="2">
                        <?= form_dropdown('kategori', $kategori_kejadian, ($lost_event) ? $lost_event['kategori'] : '', 'class="select2 form-control" style="width:100%;" id="kategori"' . $disable); ?>
                        <div class="text-danger" id="error-kategori"></div>
                    </td>
                </tr>
                <tr>
                    <th width="20%">Sumber Penyebab <span class="mandatory">*</span></th>
                    <td colspan="2">
                        <input type="text" class="form-control" id="sumber_penyebab" name="sumber_penyebab" value="<?= $lost_event['sumber_penyebab'];?>">
                        <div class="text-danger" id="error-sumber_penyebab"></div>
                    </td>
                </tr>
                <tr>
                    <th width="20%">Penyebab Kejadian <span class="mandatory">*</span></th>
                    <td colspan="2">
                        <textarea class="form-control" name="penyebab_kejadian" id="penyebab_kejadian" cols="30" rows="5"><?= $lost_event['penyebab_kejadian'];?></textarea>
                        <div class="text-danger" id="error-penyebab_kejadian"></div>
                    </td>
                </tr>
                <tr>
                    <th width="20%">Penanganan Saat Kejadian <span class="mandatory">*</span></th>
                    <td colspan="2">
                        <textarea class="form-control" name="penanganan" id="penanganan" cols="30" rows="5"><?= $lost_event['penanganan'];?></textarea>
                        <div class="text-danger" id="error-penanganan"></div>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>


<!-- ================ HUBUNGAN KEJADIAN RISIKO DENGAN RISK EVENT ====================== -->
<div class="row">
    <div style="background-color: white; padding: 10px; border-radius: 10px;">
        <h5 class="text-center" style="color: #343a40;">Hubungan Kejadian Risiko Dengan Risk Event</h5>
        <table class="table table-bordered" style="background-color: white;">
            <thead class="thead-light">
                <tr>
                    <th width="20%">Kategori Risiko <span class="mandatory">*</span></th>
                    <td colspan="3">
                    <?= form_dropdown('kat_risiko', $kat_risiko, ($lost_event) ? $lost_event['kat_risiko'] : '', 'class="select2 form-control" style="width:100%;" id="kat_risiko"' . $disable); ?>
                        <div class="text-danger" id="error-kat_risiko"></div>
                    </td>
                </tr>
                <tr>
                    <th width="20%">Hubungan Kejadian Risk Event <span class="mandatory">*</span></th>
                    <td colspan="3">
                        <input type="text" class="form-control" id="hub_kejadian_risk_event" name="hub_kejadian_risk_event" value="<?= $lost_event['hub_kejadian_risk_event'];?>">
                        <div class="text-danger" id="error-hub_kejadian_risk_event"></div>
                    </td>
                </tr>
                <tr>
                    <th width="20%">Analisis Risiko <span class="mandatory">*</span></th>
                    <td class="text-center" style="background-color: #e9ecef;">Skala Dampak</td>
                    <td class="text-center" style="background-color: #e9ecef;">Skala Probabilitas</td>
                    <td class="text-center" style="background-color: #e9ecef;">Level Risiko</td>
                </tr>
                <tr>
                    <th width="20%">Inheren <span class="mandatory">*</span></th>
                    <td>
                        <?= form_dropdown('skal_dampak_in', $cboImpact, (empty($lost_event['skal_dampak_in'])) ? '' : $lost_event['skal_dampak_in'], 'class="form-control" id="skal_dampak_in"'); ?>
                        <div class="text-danger" id="error-skal_dampak_in"></div>
                    </td>
                    <td>
                        <?= form_dropdown('skal_prob_in', $cboLike, (empty($lost_event['skal_prob_in'])) ? '' : $lost_event['skal_prob_in'], 'class="form-control" id="skal_prob_in"'); ?>
                        <div class="text-danger" id="error-skal_prob_in"></div>
                    </td>
                    <td align="center">
                        <span id="level_risiko_inher_label" class="text-center">
                            <?php
                                echo $label_in;
                            ?>
                        </span>
                        <span id="spinner-inherent" class="spinner"></span>
                    </td>
                </tr>
                <tr>
                    <th width="20%">Target Residual <span class="mandatory">*</span></th>
                    <td>
                        <?= form_dropdown('target_res_dampak', $cboImpact, (empty($lost_event['target_res_dampak'])) ? '' : $lost_event['target_res_dampak'], 'class="form-control" id="target_res_dampak"'); ?>
                        <div class="text-danger" id="error-Target_Res_dampak"></div>
                    </td>
                    <td>
                        <?= form_dropdown('target_res_prob', $cboLike, (empty($lost_event['target_res_prob'])) ? '' : $lost_event['target_res_prob'], 'class="form-control" id="target_res_prob"'); ?>
                        <div class="text-danger" id="error-Target_Res_prob"></div>
                    </td>
                    <td align="center">
                        <span id="level_risiko_res_label" class="text-center">
                        <?php
                                echo $label_res;
                            ?>
                        </span>
                        <span id="spinner-inherent" class="spinner"></span>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>



<!-- ================ RENCANA DAN REALISASI PERLAKUAN RISIKO ====================== -->
<div class="row">
    <div style="background-color: white; padding: 10px; border-radius: 10px;">
        <h5 class="text-center" style="color: #343a40;">Rencana dan Realisasi Perlakuan Risiko</h5>
        <table class="table table-bordered" style="background-color: white;">
            <thead class="thead-light">
                <tr>
                    <th class="text-center">Mitigasi Yang Direncanakan <span class="mandatory">*</span></th>
                </tr>
                <tr>
                    <td>
                        <textarea class="form-control" id="mitigasi_rencana" name="mitigasi_rencana"  style="height: 200px !important;"><?= $lost_event['mitigasi_rencana'] ;?></textarea>
                        <!-- <input type="text" class="form-control" id="mitigasi_rencana" name="mitigasi_rencana"readonly> -->
                        <div class="text-danger" id="error-mitigasi_rencana"></div>
                    </td>
                </tr>
                <tr>
                    <th class="text-center">Realisasi Mitigasi <span class="mandatory">*</span></th>
                </tr>
                <tr>
                    <td>
                        <input type="text" class="form-control" id="mitigasi_realisasi" name="mitigasi_realisasi" value="<?= $lost_event['mitigasi_realisasi'] ;?>" >
                        <div class="text-danger" id="error-mitigasi_realisasi"></div>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>


<!-- ================ ASURANSI ====================== -->
<div class="row">
    <div style="background-color: white; padding: 10px; border-radius: 10px;">
        <h5 class="text-center" style="color: #343a40;">Asuransi</h5>
        <table class="table table-bordered" style="background-color: white;">
            <thead class="thead-light">
                <tr>
                    <th class="text-center">Status Asuransi</th>
                    <th class="text-center">Nilai Premi</th>
                    <th class="text-center">Nilai Klaim</th>
                </tr>
                <tr>
                    <td>
                        <input type="text" class="form-control" id="status_asuransi" name="status_asuransi" value="<?= $lost_event['status_asuransi'];?>">
                        <div class="text-danger" id="error-status_asuransi"></div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">Rp.</span>
                            <input type="text" class="form-control rupiah" id="nilai_premi" name="nilai_premi" value="<?= ($lost_event['nilai_premi']) ? number_format($lost_event['nilai_premi'],0,',',',') : "";?>">
                        </div>
                        <div class="text-danger" id="error-nilai_premi"></div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">Rp.</span>
                            <input type="text" class="form-control rupiah" id="nilai_klaim" name="nilai_klaim" value="<?= ($lost_event['nilai_klaim']) ? number_format($lost_event['nilai_klaim'],0,',',',') : "";?>">
                        </div>
                        <div class="text-danger" id="error-nilai_klaim"></div>
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>


<div class="row">
     <!-- Perbaikan Mendatang -->
     <div style="background-color: white; padding: 10px; border-radius: 10px;">
        <h5 class="text-center" style="color: #343a40;">Perbaikan Mendatang </h5>
        <table class="table table-bordered" style="background-color: white;">
            <thead class="thead-light">
                <tr>
                    <th class="text-center">Rencana Perbaikan Mendatang <span class="mandatory">*</span></th>
                    <th width="20%" class="text-center">Pihak Terkait</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <textarea class="form-control" name="rencana_perbaikan_mendatang" id="rencana_perbaikan_mendatang" cols="30" rows="5"><?= $lost_event['rencana_perbaikan_mendatang'];?></textarea>
                        <div class="text-danger" id="error-rencana_perbaikan_mendatang"></div>
                    </td>
                    <td>
                        <input type="text" class="form-control" id="pihak_terkait" name="pihak_terkait" value="<?= $lost_event['pihak_terkait'];?>" >
                        <div class="text-danger" id="error-pihak_terkait"></div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- ================ KERUGIAN ====================== -->
<div class="row">
    <div style="background-color: white; padding: 10px; border-radius: 10px;">
        <h5 class="text-center" style="color: #343a40;">Kerugian</h5>
        <table class="table table-bordered" style="background-color: white;">
            <thead class="thead-light">
                <tr>
                    <th width="20%">Penjelasan Kerugian</th>
                    <td>
                        <textarea class="form-control" name="penjelasan_kerugian" id="penjelasan_kerugian" cols="30" rows="5"><?= $lost_event['penjelasan_kerugian'];?></textarea>
                        <div class="text-danger" id="error-penjelasan_kerugian"></div>
                    </td>
                </tr>
                <tr>
                    <th width="20%">Nilai Kerugian</th>
                    <td>
                        <div class="input-group">
                            <span class="input-group-addon">Rp.</span>
                            <input type="text" class="form-control rupiah" id="nilai_kerugian" name="nilai_kerugian" value="<?= ($lost_event['nilai_kerugian']) ? number_format($lost_event['nilai_kerugian'],0,',',',') : "";?>">
                        </div>
                        <div class="text-danger" id="error-nilai_kerugian"></div>
                    </td>
                </tr>
                <tr>
                    <th width="20%">Kejadian Berulang</th>
                    <td>
                        <input type="radio" name="kejadian_berulang" id="ya" value="1" <?= $disable ?> <?= $chekya ?>> <label for="ya">Ya</label> &nbsp; &nbsp; &nbsp;
                        <input type="radio" name="kejadian_berulang" value="0" id="tidak" <?= $disable ?> <?= $chektdk ?>> <label for="tidak">Tidak</label>
                        <div class="text-danger" id="error-kejadian_berulang"></div>
                    </td>
                </tr>
                <tr>
                    <th width="20%">Frekuensi Kejadian</th>
                    <td>
                    <?= form_dropdown('frekuensi_kejadian', $frekuensi_kejadian, ($lost_event) ? $lost_event['frekuensi_kejadian'] : '', 'class="select2 form-control" style="width:100%;" id="frekuensi_kejadian"' . $disable); ?>
                        <div class="text-danger" id="error-frekuensi_kejadian"></div>
                    </td>
                </tr>
                <tr>
                    <th width="20%">Upload File</th>
                    <td>
                        <input type="hidden" name="file_upload_lama" class="form-control" id="file_upload_lama" style="width:100%;" value="<?=$lost_event['file_path'];?>" />
                        <input type="file" name="file_upload" class="form-control" id="userfile" style="width:100%;"   />
                    </td>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="row text-center">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
    <button type="submit" id="btn-simpan" class="btn btn-primary"  >Simpan</button>
</div>
<!-- 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
<script>
    $(document).ready(function() {
        // Hide the "Input Peristiwa Baru" and "Library" elements by default
        $('#td_peristiwabaru').hide();
        $('#td_peristiwa_lib').hide();

        // Optional: Show elements when "New" button is clicked
        $('#peristiwa_baru').on('click', function() {
            $('#td_peristiwa').hide();
            $('#td_peristiwa_new').hide();
            $('#td_peristiwabaru').show();
            $('#td_peristiwa_lib').show();
            $('#id_detail').val('');
            
        });

        // Optional: Show "Library" when a certain event occurs
        $('#peristiwa_lib').on('click', function() {
            $('#td_peristiwa').show();
            $('#td_peristiwa_new').show();
            $('#td_peristiwabaru').hide();
            $('#td_peristiwa_lib').hide();
            $('#peristiwabaru').val('');

            
        });

        $("#form-lost").on("submit", function(event) {
        let isValid = true; // Menandakan apakah form valid


        // Array of required fields with error messages
        const requiredFields = [
            {
            id: "#identifikasi_kejadian",
            errorId: "#error-identifikasi_kejadian",
            message: "Identifikasi Kejadian wajib diisi.",
            },
            {
            id: "#kategori",
            errorId: "#error-kategori",
            message: "Pilih kategori kejadian.",
            },
            {
            id: "#sumber_penyebab",
            errorId: "#error-sumber_penyebab",
            message: "Sumber penyebab wajib diisi.",
            },
            {
            id: "#penyebab_kejadian",
            errorId: "#error-penyebab_kejadian",
            message: "Penyebab kejadian wajib diisi.",
            },
            {
            id: "#penanganan",
            errorId: "#error-penanganan",
            message: "Penanganan wajib diisi.",
            },
            {
            id: "#kat_risiko",
            errorId: "#error-kat_risiko",
            message: "Pilih kategori risiko.",
            },
            {
            id: "#hub_kejadian_risk_event",
            errorId: "#error-hub_kejadian_risk_event",
            message: "Hubungan kejadian wajib diisi.",
            },
            {
            id: "#skal_dampak_in",
            errorId: "#error-skal_dampak_in",
            message: "Pilih skala dampak inheren.",
            },
            {
            id: "#skal_prob_in",
            errorId: "#error-skal_prob_in",
            message: "Pilih skala probabilitas inheren.",
            },
            {
            id: "#target_res_dampak",
            errorId: "#error-Target_Res_dampak",
            message: "Pilih skala dampak target residual.",
            },
            {
            id: "#target_res_prob",
            errorId: "#error-Target_Res_prob",
            message: "Pilih skala probabilitas target residual.",
            },
            {
            id: "#mitigasi_rencana",
            errorId: "#error-mitigasi_rencana",
            message: "Mitigasi yang direncanakan wajib diisi.",
            },
            {
            id: "#mitigasi_realisasi",
            errorId: "#error-mitigasi_realisasi",
            message: "Mitigasi realisasi wajib diisi.",
            },
            {
            id: "#status_asuransi",
            errorId: "#error-status_asuransi",
            message: "Status asuransi wajib diisi.",
            },
            {
            id: "#nilai_premi",
            errorId: "#error-nilai_premi",
            message: "Nilai premi wajib diisi.",
            },
            {
            id: "#nilai_klaim",
            errorId: "#error-nilai_klaim",
            message: "Nilai klaim wajib diisi.",
            },
            {
            id: "#rencana_perbaikan_mendatang",
            errorId: "#error-rencana_perbaikan_mendatang",
            message: "Rencana perbaikan wajib diisi.",
            },
            {
            id: "#pihak_terkait",
            errorId: "#error-pihak_terkait",
            message: "Pihak terkait wajib diisi.",
            },
            {
            id: "#penjelasan_kerugian",
            errorId: "#error-penjelasan_kerugian",
            message: "Penjelasan kerugian wajib diisi.",
            },
            {
            id: "#nilai_kerugian",
            errorId: "#error-nilai_kerugian",
            message: "Nilai kerugian wajib diisi.",
            },
            {
            id: "#frekuensi_kejadian",
            errorId: "#error-frekuensi_kejadian",
            message: "Pilih frekuensi kejadian.",
            },
        ];

        // Validate required fields
        requiredFields.forEach((field) => {
            const input = $(field.id);
            const errorDiv = $(field.errorId);

            if (input.val().trim() === "") {
            errorDiv.text(field.message); // Show error message
            input.addClass("is-invalid"); // Add invalid class
            isValid = false; // Mark as invalid
            } else {
            errorDiv.text(""); // Clear error message
            input.removeClass("is-invalid"); // Remove invalid class
            }
        });

        // Stop submission if validation fails
        if (!isValid) {
            event.preventDefault();
        }


        });
    });
</script>