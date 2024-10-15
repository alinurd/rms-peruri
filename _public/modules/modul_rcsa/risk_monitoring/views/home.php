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
                <div class="col-md-8 col-sm-8 col-xs-6">
                    <label for="filter_owner">Risk Owner</label>
                    <select name="owner" id="filter_owner" class="form-control select2" style="width: 100%;">
                        <?php foreach ($cboOwner as $key => $value): ?>
                            <option value="<?= $key; ?>" <?= ($this->input->get('owner') == $key) ? 'selected' : ''; ?>><?= $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Tombol submit -->
                <div class="col-md-2 col-sm-12 col-xs-12 mt-3">
                    <button type="submit" class="btn btn-success text-white" style="margin-top: 25px;">
                        <span class="glyphicon glyphicon-search"></span>&nbsp;Cari
                    </button>
                </div>
            </div>
        </form>
        <ul class="nav navbar-right panel_toolbox">
            <li class="pull-right"><a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></li>
        </ul>
        <div class="clearfix"></div>
        <div class="row">
    <div class="col"><input type="radio" name="triwulan" id="tw1" onclick="filterTriwulan(1)"> Triwulan 1</div>
    <div class="col"><input type="radio" name="triwulan" id="tw2" onclick="filterTriwulan(2)"> Triwulan 2</div>
    <div class="col"><input type="radio" name="triwulan" id="tw3" onclick="filterTriwulan(3)"> Triwulan 3</div>
    <div class="col"><input type="radio" name="triwulan" id="tw4" onclick="filterTriwulan(4)"> Triwulan 4</div> 
</div>
    </div>

    <div class="x_content table-responsive" style="overflow-x: auto;">
        <table class="table table-striped table-bordered table-hover">
            <thead>
            <tr>
            <th style="position: sticky; left: 0; background: white; z-index: 99;">No</th>
            <th style="position: sticky; left: 30px; background: white; z-index: 115px;">Risk Owner</th>
            <th style="position: sticky; left: 95px; background: white; z-index: 99; width: 320px;">Peristiwa Risiko</th>
            <th>Tahun</th>
            <th>Level Risiko Inheren</th>
            <th>Level Risiko Target</th>
            <!-- triwulan 1 -->
            <th class="tw1">Januari</th>
            <th class="tw1">Februari</th>
            <th class="tw1">Maret</th>
            <!-- triwulan 2 -->
            <th class="tw2">April</th>
            <th class="tw2">Mei</th>
            <th class="tw2">Juni</th>
            <!-- triwulan 3 -->
            <th class="tw3">Juli</th>
            <th class="tw3">Agustus</th>
            <th class="tw3">September</th>
            <!-- triwulan 4 -->
            <th class="tw4">Oktober</th>
            <th class="tw4">November</th>
            <th class="tw4">Desember</th>
        </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($field as $q) {
                    $residual_level = $this->data->get_master_level(true, $q['inherent_level']);
                    $like = $this->db
                        ->where('id', $residual_level['likelihood'])
                        ->get('bangga_level')->row_array();
                    $impact = $this->db
                        ->where(
                            'id',
                            $residual_level['impact']
                        )
                        ->get('bangga_level')->row_array();
                    $likeimpac = $like['code'] . 'x' . $impact['code'];
                    if (!$residual_level) {
                        $residual_level = ['color' => '', 'color_text' => '', 'level_mapping' => '-'];
                        $likeimpac = '';
                    }
                    $inherent = '<span class="btn" style="padding:4px 8px;width:100%;background-color:' . $residual_level['color'] . ';color:' . $residual_level['color_text'] . ';">' . $residual_level['level_mapping'] . ' <br>[ ' . $likeimpac . ' ]</span><div title="Nilai rata-rata realisasi" style="padding-top:8px" > </div>';

                    $residual_level1 = $this->data->get_master_level(true, $q['residual_level']);
                    $likelll = $this->db
                        ->where('id', $residual_level1['likelihood'])
                        ->get('bangga_level')->row_array();
                    $impactttt = $this->db
                        ->where('id', $residual_level1['impact'])
                        ->get('bangga_level')->row_array();
                    $likelllimpac = $likelll['code'] . 'x' . $impactttt['code'];
                    if (!$residual_level1) {
                        $residual_level1 = ['color' => '', 'color_text' => '', 'level_mapping' => '-'];
                        $likelllimpac = '';
                    }
                    $target = '<span class="btn" style="padding:4px 8px;width:100%;background-color:' . $residual_level1['color'] . ';color:' . $residual_level1['color_text'] . ';">' . $residual_level1['level_mapping'] . ' <br>[ ' . $likelllimpac . ' ]</span><div title="Nilai rata-rata realisasi" style="padding-top:8px" > </div>';

                ?>
                     <tr>
            <td style="position: sticky; left: 0; background: white;"><?= $no++ ?></td>
            <td style="position: sticky; left: 30px; background: white;"><?= $q['name'] ?></td>
            <td style="position: sticky; left: 95px; background: white;"><?= $q['event_name'] ?></td>
            <td><?= $q['tahun'] ?></td>
            <td><?= $inherent ?></td>
            <td><?= $target ?></td>
            <?php for($i = 1; $i < 13; $i++): ?>
            <td class="tw<?= ceil($i/3) ?>">
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
            </div>

        </div>
</section>

<script>
    function filterTriwulan(triwulan) {
        // Sembunyikan semua kolom
        document.querySelectorAll('th[class^="tw"], td[class^="tw"]').forEach(function(el) {
            el.style.display = 'none';
        });

        // Tampilkan kolom sesuai triwulan
        document.querySelectorAll('.tw' + triwulan).forEach(function(el) {
            el.style.display = '';
        });
    }

    // Default ke Triwulan 1 saat halaman pertama kali dimuat
    document.getElementById('tw1').checked = true;
    filterTriwulan(1);
</script>