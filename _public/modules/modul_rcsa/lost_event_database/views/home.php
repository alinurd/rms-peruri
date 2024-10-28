<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-sm-8 panel-heading">
                <h3 style="padding-left: 10px;">Lost Event Database</h3>
            </div>
            <div class="col-sm-4 text-right">
                <ul class="breadcrumb">
                    <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
                    <li><a href="#">Lost Event Database</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="x_panel">
    <div class="x_title">
        <form method="GET" action="<?= site_url(_MODULE_NAME_REAL_.'/index'); ?>">
            <div class="row">
                <!-- Dropdown untuk filter tahun (cboPeriod) -->
                <div class="col-md-2 col-sm-4 col-xs-6">
                    <label for="filter_periode">Tahun</label>
                    <select name="periode" id="filter_periode" class="form-control select2" style="width: 100%;">
                        <?php foreach ($cboPeriod as $key => $value): ?>
                            <option value="<?= ($key == 0) ? '0' : $value; ?>" <?= ($this->input->get('periode') == $value) ? 'selected' : ''; ?>><?= $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Dropdown untuk filter Risk Owner (cboOwner) -->
                <div class="col-md-6 col-sm-8 col-xs-6">
                    <label for="filter_owner">Risk Owner</label>
                    <select name="owner" id="filter_owner" class="form-control select2" style="width: 100%;">
                        <?php foreach ($cboOwner as $key => $value): ?>
                            <option value="<?= $key; ?>" <?= ($this->input->get('owner') == $key) ? 'selected' : ''; ?>><?= $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Dropdown untuk filter Triwulan -->
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <label for="filter_triwulan">Triwulan</label>
                    <select name="triwulan" id="filter_triwulan" class="form-control select2" style="width: 80%;">
                        <option value="1" <?= ($triwulan == 1) ? 'selected' : ''; ?>>Triwulan 1</option>
                        <option value="2" <?= ($triwulan == 2) ? 'selected' : ''; ?>>Triwulan 2</option>
                        <option value="3" <?= ($triwulan == 3) ? 'selected' : ''; ?>>Triwulan 3</option>
                        <option value="4" <?= ($triwulan == 4) ? 'selected' : ''; ?>>Triwulan 4</option>
                    </select>
                </div>

                <!-- Tombol Filter -->
                <div class="col-md-2 col-sm-2 col-xs-2 mt-3">
                    <button type="submit" class="btn btn-success text-white" style="margin-top: 25px;">
                        <span class="glyphicon glyphicon-search"></span>&nbsp;Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <ul class="nav navbar-right panel_toolbox">
        <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
    </ul>
    <div class="clearfix"></div>

    <div class="x_panel">
        <div class="x_content table-responsive" style="overflow-x: auto;">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th style="position: sticky; left: 0; background: white; z-index: 99;">No</th>
                        <th style="position: sticky; left: 30px; background: white; z-index: 99;">Risk Owner</th>
                        <th style="position: sticky; left: 95px; background: white; z-index: 99; width: 320px;">Peristiwa Risiko</th>
                        <th style="position: sticky; left: 95px; background: white; z-index: 99; width: 320px;">Proaktif</th>
                        <th>Tahun</th> 

                        <?php if ($triwulan == 1): ?>
                            <th>Januari</th>
                            <th>Februari</th>
                            <th>Maret</th>
                        <?php elseif ($triwulan == 2): ?>
                            <th>April</th>
                            <th>Mei</th>
                            <th>Juni</th>
                        <?php elseif ($triwulan == 3): ?>
                            <th>Juli</th>
                            <th>Agustus</th>
                            <th>September</th>
                        <?php elseif ($triwulan == 4): ?>
                            <th>Oktober</th>
                            <th>November</th>
                            <th>Desember</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($field as $q) {
                        $act = $this->db->where('rcsa_detail_no', $q['id'])->get(_TBL_VIEW_RCSA_MITIGASI)->row_array();
                    ?>
                        <tr>
                            <td style="position: sticky; left: 0; background: white;"><?= $no++ ?></td>
                            <td style="position: sticky; left: 30px; background: white;"><?= $q['name'] ?></td>
                            <td style="position: sticky; left: 95px; background: white;"><?= $act['event_name'] ?></td>
                            <td style="position: sticky; left: 95px; background: white;"><?= $act['proaktif'] ?></td>
                            <td><?= $q['tahun'] ?></td> 
                            <?php
                            switch ($triwulan) {
                                case 1:
                                    $start = 1; $end = 4; break;
                                case 2:
                                    $start = 4; $end = 7; break;
                                case 3:
                                    $start = 7; $end = 10; break;
                                case 4:
                                    $start = 10; $end = 13; break;
                            }

                            for ($i = $start; $i < $end; $i++): ?>
                                <td>
                                    <?php
                                    $data['id'] = $q['id'];
                                    $data['rcsa_no'] = $q['rcsa_no'];
                                    echo $this->data->getMonthlyMonitoringGlobal($data, $i);
                                    ?>
                                </td>
                            <?php endfor; ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <div class="clearfix"></div>
                <?= $pagination; ?>
                <p>Menampilkan <?= $start_data; ?> - <?= $end_data; ?> dari total <?= $total_data; ?> data</p>
                <i><?= $timeLoad ?> second</i>
            </div> 
        </div>
    </div>
</section>

<!-- Modal Fullscreen -->
<div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog fullscreen" role="document">
        <div class="modal-content fullscreen" style="height: 100%; overflow: hidden; background-color: #f8f9fa; border-radius: 10px;">
            <div class="modal-header" style="background-color: #367FA9; color: white;">
                <h4 class="modal-title" id="modalLabel">Lost Event Database</h4>
            </div>
            <div class="modal-body" style="height: calc(100vh - 120px); overflow-y: auto; padding: 20px; background-color: #f1f3f5;">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-4" style="background-color: white; padding: 10px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <h5 class="text-center" style="color: #343a40;">Kejadian Risiko</h5>
                            <table class="table table-bordered" style="background-color: white;">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="20%">Nama Kejadian (Event)</th>
                                        <th><input style="background-color: #367FA9; color: white; border: none;" type="text" class="form-control" id="nm_event" name="nm_event" readonly></th>
                                    </tr>
                                    <tr>
                                        <th width="20%">Identifikasi Kejadian</th>
                                        <td>
                                            <textarea class="form-control" id="identifikasi_kejadian" cols="30" rows="5" required></textarea>
                                            <div class="text-danger" id="error-identifikasi_kejadian"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="20%">Kategori Kejadian</th>
                                        <td>
                                            <input type="text" class="form-control" id="kategori" name="kategori" required>
                                            <div class="text-danger" id="error-kategori"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="20%">Sumber Penyebab</th>
                                        <td>
                                            <input type="text" class="form-control" id="sumber_penyebab" name="sumber_penyebab" required>
                                            <div class="text-danger" id="error-sumber_penyebab"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="20%">Penyebab Kejadian</th>
                                        <td>
                                            <textarea class="form-control" id="penyebab_kejadian" cols="30" rows="5" required></textarea>
                                            <div class="text-danger" id="error-penyebab_kejadian"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="20%">Penanganan Saat Kejadian</th>
                                        <td>
                                            <textarea class="form-control" id="penanganan" cols="30" rows="5" required></textarea>
                                            <div class="text-danger" id="error-penanganan"></div>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="mb-4" style="background-color: white; padding: 10px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <h5 class="text-center" style="color: #343a40;">Hubungan Kejadian Risiko Dengan Risk Event</h5>
                            <table class="table table-bordered" style="background-color: white;">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="20%">Kategori Risiko</th>
                                        <td colspan="3">
                                            <input type="text" class="form-control" id="kat_risiko" name="kat_risiko" required>
                                            <div class="text-danger" id="error-kat_risiko"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="20%">Hubungan Kejadian Risk Event</th>
                                        <td colspan="3">
                                            <input type="text" class="form-control" id="hub_kejadian_risk_event" name="hub_kejadian_risk_event" required>
                                            <div class="text-danger" id="error-hub_kejadian_risk_event"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="20%">Analisis Risiko</th>
                                        <td class="text-center" style="background-color: #e9ecef;">Skala Dampak</td>
                                        <td class="text-center" style="background-color: #e9ecef;">Skala Probabilitas</td>
                                        <td class="text-center" style="background-color: #e9ecef;">Level Risiko</td>
                                    </tr>
                                    <tr>
                                        <th width="20%">Inheren</th>
                                        <td>
                                            <?= form_dropdown('skal_dampak_in', $cboLike, '', 'class="form-control" id="skal_dampak_in"'); ?>
                                            <div class="text-danger" id="error-skal_dampak_in"></div>
                                        </td>
                                        <td>
                                            <?= form_dropdown('skal_prob_in', $cboImpact, '', 'class="form-control" id="skal_prob_in"'); ?>
                                            <div class="text-danger" id="error-skal_prob_in"></div>
                                        </td>
                                        <td>
                                            <span id="level_risiko_inher_label">
                                                <span style="background-color: <?= (count($analisiData['inherent_level_text']) > 0) ? $analisiData['inherent_level_text'][0]['color'] : '#fff'; ?>; color: <?= (count($analisiData['inherent_level_text']) > 0) ? $analisiData['inherent_level_text'][0]['color_text'] : '#000'; ?>; padding: 1px 3px;">
                                                    <?= strtoupper((count($analisiData['inherent_level_text']) > 0) ? $analisiData['inherent_level_text'][0]['level_mapping'] : ''); ?>
                                                </span>
                                            </span>
                                            <span id="spinner-inherent" class="spinner"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="20%">Target Residual</th>
                                        <td>
                                            <?= form_dropdown('Target_Res_dampak', $cboLike, '', 'class="form-control" id="Target_Res_dampak"'); ?>
                                            <div class="text-danger" id="error-Target_Res_dampak"></div>
                                        </td>
                                        <td>
                                            <?= form_dropdown('Target_Res_prob', $cboImpact, '', 'class="form-control" id="Target_Res_prob"'); ?>
                                            <div class="text-danger" id="error-Target_Res_prob"></div>
                                        </td>
                                        <td>
                                            <span id="level_risiko_res_label">
                                                <span style="background-color: <?= (count($analisiData['inherent_level_text']) > 0) ? $analisiData['inherent_level_text'][0]['color'] : '#fff'; ?>; color: <?= (count($analisiData['inherent_level_text']) > 0) ? $analisiData['inherent_level_text'][0]['color_text'] : '#000'; ?>; padding: 1px 3px;">
                                                    <?= strtoupper((count($analisiData['inherent_level_text']) > 0) ? $analisiData['inherent_level_text'][0]['level_mapping'] : ''); ?>
                                                </span>
                                            </span>
                                            <span id="spinner-inherent" class="spinner"></span>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <!-- Asuransi -->
                        <div class="mb-4" style="background-color: white; padding: 10px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <h5 class="text-center" style="color: #343a40;">Asuransi</h5>
                            <table class="table table-bordered" style="background-color: white;">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Status Asuransi</th>
                                        <th>Nilai Premi</th>
                                        <th>Nilai Klaim</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" id="status_asuransi" name="status_asuransi" required>
                                            <div class="text-danger" id="error-status_asuransi"></div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon">Rp.</span>
                                                <input type="text" class="form-control" id="nilai_premi" name="nilai_premi" required>
                                            </div>
                                            <div class="text-danger" id="error-nilai_premi"></div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon">Rp.</span>
                                                <input type="text" class="form-control" id="nilai_klaim" name="nilai_klaim" required>
                                            </div>
                                            <div class="text-danger" id="error-nilai_klaim"></div>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                    <!-- Rencana dan Realisasi Perlakuan Risiko -->
                    <div class="col-md-6">
                        <div class="mb-4" style="background-color: white; padding: 10px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <h5 class="text-center" style="color: #343a40;">Rencana dan Realisasi Perlakuan Risiko</h5>
                            <table class="table table-bordered" style="background-color: white;">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">Mitigasi Yang Direncanakan</th>
                                        <th width="20%" class="text-center">Realisasi Mitigasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control" id="mitigasi_rencana" name="mitigasi_rencana" required>
                                            <div class="text-danger" id="error-mitigasi_rencana"></div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="mitigasi_realisasi" name="mitigasi_realisasi" required>
                                            <div class="text-danger" id="error-mitigasi_realisasi"></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Perbaikan Mendatang -->
                        <div class="mb-4" style="background-color: white; padding: 10px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <h5 class="text-center" style="color: #343a40;">Perbaikan Mendatang</h5>
                            <table class="table table-bordered" style="background-color: white;">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">Rencana Perbaikan Mendatang</th>
                                        <th width="20%" class="text-center">Pihak Terkait</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <textarea class="form-control" id="rencana_perbaikan_mendatang" cols="30" rows="5" required></textarea>
                                            <div class="text-danger" id="error-rencana_perbaikan_mendatang"></div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" id="pihak_terkait" name="pihak_terkait" required>
                                            <div class="text-danger" id="error-pihak_terkait"></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Kerugian -->
                        <div class="mb-4" style="background-color: white; padding: 10px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                            <h5 class="text-center" style="color: #343a40;">Kerugian</h5>
                            <table class="table table-bordered" style="background-color: white;">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="20%">Penjelasan Kerugian</th>
                                        <td>
                                            <textarea class="form-control" id="penjelasan_kerugian" cols="30" rows="5" required></textarea>
                                            <div class="text-danger" id="error-penjelasan_kerugian"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="20%">Nilai Kerugian</th>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-addon">Rp.</span>
                                                <input type="text" class="form-control" id="nilai_kerugian" name="nilai_kerugian" required>
                                            </div>
                                            <div class="text-danger" id="error-nilai_kerugian"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="20%">Kejadian Berulang</th>
                                        <td>
                                            <input type="text" class="form-control" id="kejadian_berulang" name="kejadian_berulang" required>
                                            <div class="text-danger" id="error-kejadian_berulang"></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th width="20%">Frekuensi Kejadian</th>
                                        <td>
                                            <input type="text" class="form-control" id="frekuensi_kejadian" name="frekuensi_kejadian" required>
                                            <div class="text-danger" id="error-frekuensi_kejadian"></div>
                                        </td>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="#" id="btn-simpan" class="btn btn-primary">Simpan</a>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk menampilkan popup
    function showPopup() {
        document.getElementById('infoPopup').style.display = 'block';
    }

    // Fungsi untuk menyembunyikan popup
    function hidePopup() {
        document.getElementById('infoPopup').style.display = 'none';
    }
</script>

<style>
    /* Gaya untuk popup */
    .popup {
        display: none;
        position: absolute;
        padding: 10px;
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        z-index: 9999;
    }

    #realisasi {
        position: relative;
        z-index: 1;
    }
</style>
