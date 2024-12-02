<style>
    /* Refined column widths for balanced proportions */
    .table th.no-col { width: 25px; }
    .table th.risk-owner-col { width: 100px; }
    .table th.peristiwa-risiko-col, .table th.treatment-col { width: 140px; }
    .table th.tahun-col { width: 60px; }
    .table th.month-col { width: 80px; }
    .table th.target-col, .table th.realisasi-col { width: 70px; }

    /* Popup styles */
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


<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-sm-8 panel-heading">
                <h3 style="padding-left:10px;">Progress Treatment</h3>
            </div>
            <div class="col-sm-4 text-right">
                <ul class="breadcrumb">
                    <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
                    <li><a href="#">Progress-Treatment</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="x_panel">
    <div class="x_title">
        <form method="GET" action="<?= site_url(_MODULE_NAME_REAL_.'/index'); ?>">
        <div class="row">
                <div class="col-md-2 col-sm-4 col-xs-6">
                    <label for="filter_periode">Tahun</label>
                    <select name="periode" id="filter_periode" class="form-control select2" style="width: 100%;">
                        <?php foreach ($cboPeriod as $key => $value): ?>
                            <option value="<?= ($key == 0) ? '0' : $value; ?>" <?= ($this->input->get('periode') == $value) ? 'selected' : ''; ?>><?= $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 col-sm-8 col-xs-6">
                    <label for="filter_owner">Risk Owner</label>
                    <select name="owner" id="filter_owner" class="form-control select2" style="width: 100%;">
                        <?php foreach ($cboOwner as $key => $value): ?>
                            <option value="<?= $key; ?>" <?= ($this->input->get('owner') == $key) ? 'selected' : ''; ?>><?= $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2 col-sm-2 col-xs-2">
                    <label for="filter_triwulan">Triwulan</label>
                    <select name="triwulan" id="filter_triwulan" class="form-control select2" style="width: 80%;">
                        <option value="1" <?= ($triwulan == 1) ? 'selected' : ''; ?>>Triwulan 1</option>
                        <option value="2" <?= ($triwulan == 2) ? 'selected' : ''; ?>>Triwulan 2</option>
                        <option value="3" <?= ($triwulan == 3) ? 'selected' : ''; ?>>Triwulan 3</option>
                        <option value="4" <?= ($triwulan == 4) ? 'selected' : ''; ?>>Triwulan 4</option>
                    </select>
                </div>

                <div class="col-md-2 col-sm-2 col-xs-2 mt-3">
                    <button type="submit" class="btn btn-success text-white" style="margin-top: 25px;">
                        <span class="glyphicon glyphicon-search"></span>&nbsp;Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
    <ul class="nav navbar-right panel_toolbox">
        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
    </ul>
    <div class="clearfix"></div>

    <div class="x_content table-responsive" style="overflow-x: auto;">
        <div style="overflow-x: auto;">
        <form id="level" method="POST">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="no-col" rowspan="2" style="position: sticky; left: 0; background: white; min-width: 50px; z-index: 100;">No</th>
                        <th class="risk-owner-col text-center" rowspan="2" style="position: sticky; left: 50px; background: white; min-width: 150px; z-index: 100;">Risk Owner</th>
                        <th class="text-center peristiwa-risiko-col" rowspan="2" style="position: sticky; left: 200px; background: white; min-width: 200px; z-index: 100;">Peristiwa Risiko</th>
                        <th class="text-center treatment-col" rowspan="2" style="position: sticky; left: 400px; background: white; min-width: 200px; z-index: 100;">Treatment</th>
                        <th class="text-center tahun-col" rowspan="2" style="min-width: 100px;">Tahun</th>
                        <?php if ($triwulan == 1): ?>
                            <th class="text-center month-col" colspan="2">Januari</th>
                            <th class="text-center month-col" colspan="2">Februari</th>
                            <th class="text-center month-col" colspan="2">Maret</th>
                        <?php elseif ($triwulan == 2): ?>
                            <th class="text-center month-col" colspan="2">April</th>
                            <th class="text-center month-col" colspan="2">Mei</th>
                            <th class="text-center month-col" colspan="2">Juni</th>
                        <?php elseif ($triwulan == 3): ?>
                            <th class="text-center month-col" colspan="2">Juli</th>
                            <th class="text-center month-col" colspan="2">Agustus</th>
                            <th class="text-center month-col" colspan="2">September</th>
                        <?php elseif ($triwulan == 4): ?>
                            <th class="text-center month-col" colspan="2">Oktober</th>
                            <th class="text-center month-col" colspan="2">November</th>
                            <th class="text-center month-col" colspan="2">Desember</th>
                        <?php endif; ?>
                    </tr>
                    <tr>
                        <th class="text-center target-col">Target</th>
                        <th class="text-center realisasi-col">Realisasi</th>
                        <th class="text-center target-col">Target</th>
                        <th class="text-center realisasi-col">Realisasi</th>
                        <th class="text-center target-col">Target</th>
                        <th class="text-center realisasi-col">Realisasi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($field as $q) {
                        // doi::dump($q);
                        // $act = $this->db->where('rcsa_detail_no', $q['id'])->get(_TBL_VIEW_RCSA_MITIGASI)->row_array();
                    ?>
                        <tr>
                            <td style="position: sticky; left: 0; background: white; min-width: 50px;"><?= $no++ ?></td>
                            <td style="position: sticky; left: 50px; background: white; min-width: 150px; z-index: 1000;"><?= $q['name'] ?></td>
                            <td style="position: sticky; left: 200px; background: white; min-width: 200px; z-index: 1000;"><?= $q['event_name'] ?></td>
                            <td style="position: sticky; left: 400px; background: white; min-width: 200px; z-index: 1000;"><?= ($q['proaktif']) ? $q['proaktif'] : $q['reaktif']; ?></td>
                            <td style="min-width: 100px;"><?= $q['tahun'] ?></td>
                            <?php
                            $start = ($triwulan - 1) * 3 + 1;
                            $end = $start + 3;
                            for ($i = $start; $i < $end; $i++):
                                $data['id'] = $q['id'];
                                $data['id_action'] = $q['id_action'];
                                $data['rcsa_no'] = $q['rcsa_no'];
                                echo $this->data->getMonthlyMonitoringGlobal($data, $i);
                            endfor;
                            ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            </form>
            <!-- Submit Buttons Positioned Outside of Table -->
            <div class="add-button-wrapper" style="position: sticky; left: 82%; background: white; width: 15%; z-index: 1000; display: flex; justify-content: space-between; padding: 10px;">
                <button type="button" class="btn btn-success btn-sm" id="simpan_validasi">
                    Validasi
                </button>
                <button type="button" class="btn btn-primary btn-sm" id="log_validasi">
                    Log Validasi
                </button>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12 text-center">
            <?= $pagination; ?>
            <p>Menampilkan <?= $start_data; ?> - <?= $end_data; ?> dari total <?= $total_data; ?> data</p>
            <i><?= $timeLoad ?> second</i>
        </div>
    </div>
</section>

<script>
    function showPopup() {
        document.getElementById('infoPopup').style.display = 'block';
    }
    function hidePopup() {
        document.getElementById('infoPopup').style.display = 'none';
    }
</script>
