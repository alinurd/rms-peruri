<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-sm-8 panel-heading">
                <h3 style="padding-left:10px;"><?= lang("msg_title")?></h3>
            </div>
            <div class="col-sm-4" style="text-align:right">
                <ul class="breadcrumb">
                    <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
                    <li><a href="#">Level Risiko</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="x_panel">
    <div class="x_title">
        <form method="GET" action="<?= site_url('level_risiko/index'); ?>">
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

        <ul class="nav navbar-right panel_toolbox">
            <li class="pull-right">
                <a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a>
            </li>
        </ul>
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12" id="input_level">
                <div class="x_panel">
                    <div class="x_content table-responsive" style="overflow-x: auto;">
                        <table class="table table-striped table-bordered table-hover" style="table-layout: fixed;">
                            <thead>
                                <tr>
                                    <th class="text-center" style="position: sticky; left: 0; background: white; z-index: 99; width: 50px;">No</th>
                                    <th class="text-center" style="position: sticky; left: 50px; background: white; z-index: 99; width: 150px;">Risk Owner</th>
                                    <th class="text-center" style="position: sticky; left: 200px; background: white; z-index: 99; width: 200px;">Peristiwa Risiko</th>
                                    <th class="text-center" style="width: 100px;">Tahun</th>
                                    <th class="text-center" style="width: 200px;">Level Risiko Inheren</th>
                                    <th class="text-center" style="width: 200px;">Level Risiko Target</th>
                                    <?php if ($triwulan == 1): ?>
                                        <th class="text-center" style="width: 350px;">Januari</th>
                                        <th class="text-center" style="width: 350px;">Februari</th>
                                        <th class="text-center" style="width: 350px;">Maret</th>
                                    <?php elseif ($triwulan == 2): ?>
                                        <th class="text-center" style="width: 350px;">April</th>
                                        <th class="text-center" style="width: 350px;">Mei</th>
                                        <th class="text-center" style="width: 350px;">Juni</th>
                                    <?php elseif ($triwulan == 3): ?>
                                        <th class="text-center" style="width: 350px;">Juli</th>
                                        <th class="text-center" style="width: 350px;">Agustus</th>
                                        <th class="text-center" style="width: 350px;">September</th>
                                    <?php elseif ($triwulan == 4): ?>
                                        <th class="text-center" style="width: 350px;">Oktober</th>
                                        <th class="text-center" style="width: 350px;">November</th>
                                        <th class="text-center" style="width: 350px;">Desember</th>
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
                                        <td style="position: sticky; left: 0; background: white;z-index: 99;"><?= $no++ ?></td>
                                        <td style="position: sticky; left: 50px; background: white;z-index: 99;"><?= $q['name'] ?></td>
                                        <td style="position: sticky; left: 200px; background: white;z-index: 99;"><?= $q['event_name'] ?></td>
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
                                            <td class="text-center">
                                                <?php
                                                // var_dump($field);
                                                $data['id']         = $q['id'];
                                                $data['rcsa_no']    = $q['rcsa_no'];
                                                $data['cb_like']    = $cb_like;
                                                $data['cb_impact']  = $cb_impact;
                                                // var_dump($data['id'] );
                                                echo $this->data->getMonthlyMonitoringGlobal($data, $i);
                                                ?>
                                            </td>
                                        <?php endfor; ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <div class="clearfix"></div>
                <?= $pagination; ?>
                <p>Menampilkan <?= $start_data; ?> - <?= $end_data; ?> dari total <?= $total_data; ?> data</p>
                <i><?= $timeLoad ?> second</i>
            </div>
        </div
    </div>
</section>

<script>



</script>