<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-sm-8 panel-heading">
                <h3 style="padding-left:10px;">Risk Monitoring</h3>
            </div>
            <div class="col-sm-4" style="text-align:right">
                <ul class="breadcrumb">
                    <li> <a href="#"> <i class="fa fa-home"></i> Home</a></li>
                    <li><a href="#">Risk-Monitoring</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<section class="x_panel">
    <div class="x_title">
        <form method="GET" action="<?= site_url('risk_monitoring/index'); ?>">
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
                        <span class="text-white glyphicon glyphicon-search"></span>&nbsp;Filter
                    </button>
                </div>
            </div>

    </div>
    </form>
    <ul class="nav navbar-right panel_toolbox">
        <li class="pull-right"><a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></li>
    </ul>
    <div class="clearfix"></div>



    <div class="x_panel">
        <div class="x_content table-responsive" style="overflow-x: auto;">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Risk Owner</th>
                        <th>Peristiwa Risiko</th>
                        <th>Tahun</th>
                        <th>Level Risiko Inheren</th>
                        <th>Level Risiko Target</th>
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
                        $residual_level = $this->data->get_master_level(true, $q['inherent_level']);
                        $inherent = '<span class="btn" style="padding:4px 8px;width:100%;background-color:' . $residual_level['color'] . ';color:' . $residual_level['color_text'] . ';">' . $residual_level['level_mapping'] . '</span>';

                        $residual_level1 = $this->data->get_master_level(true, $q['residual_level']);
                        $target = '<span class="btn" style="padding:4px 8px;width:100%;background-color:' . $residual_level1['color'] . ';color:' . $residual_level1['color_text'] . ';">' . $residual_level1['level_mapping'] . '</span>';
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $q['name'] ?></td>
                            <td><?= $q['event_name'] ?></td>
                            <td><?= $q['tahun'] ?></td>
                            <td><?= $inherent ?></td>
                            <td><?= $target ?></td>
                            <?php
                            switch ($triwulan) {
                                case 1:
                                    $start = 1;
                                    $end = 4;
                                    break;
                                case 2:
                                    $start = 4;
                                    $end = 7;
                                    break;
                                case 3:
                                    $start = 7;
                                    $end = 10;
                                    break;
                                case 4:
                                    $start = 10;
                                    $end = 13;
                                    break;
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