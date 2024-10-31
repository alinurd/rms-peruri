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

<style>
    .modal {
        z-index: 2050;
    }
</style>

<!-- Modal Fullscreen -->
<!-- <div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog fullscreen" role="document">
        <div class="modal-content fullscreen" style="height: 100%; background-color: #f8f9fa; border-radius: 10px;">
            <div class="modal-header" style="background-color: #367FA9; color: white;">
                <h4 class="modal-title" id="modalLabel">Lost Event Database</h4>
            </div>
            <div class="modal-body" style="height: calc(100vh - 120px); overflow-y: auto; padding: 20px; background-color: #f1f3f5;">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                
            </div>
        </div>
    </div>
</div> -->

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
