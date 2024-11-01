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
        <form method="GET" action="<?= site_url(_MODULE_NAME_REAL_ . '/index'); ?>">
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
                    <th class="text-center" rowspan="2" style="position: sticky; left: 0; z-index: 94;" width="5%">No</th>
                    <th class="text-center" rowspan="2" style="position: sticky; left: 30px; z-index: 95;" width="10%">Risk Owner</th>
                    <th class="text-center" rowspan="2" style="position: sticky; left: 120px; z-index: 96;" width="15%">Peristiwa Risiko</th>
                    <th class="text-center" rowspan="2" style="position: sticky; left: 250px; z-index: 97;" width="10%">Indikator</th>
                    <th class="text-center" rowspan="2" style="position: sticky; left: 360px; z-index: 98;" width="10%">Satuan</th>
                    <th colspan="3" class="text-center" style="position: sticky; left: 475px; z-index: 99;" width="28%">Threshold</th>
                    <?php if ($triwulan == 1): ?>
                        <th class="text-center" rowspan="2" width="5%">Januari</th>
                        <th class="text-center" rowspan="2" width="5%">Februari</th>
                        <th class="text-center" rowspan="2" width="5%">Maret</th>
                    <?php elseif ($triwulan == 2): ?>
                        <th class="text-center" rowspan="2" width="5%">April</th>
                        <th class="text-center" rowspan="2" width="5%">Mei</th>
                        <th class="text-center" rowspan="2" width="5%">Juni</th>
                    <?php elseif ($triwulan == 3): ?>
                        <th class="text-center" rowspan="2" width="5%">Juli</th>
                        <th class="text-center" rowspan="2" width="5%">Agustus</th>
                        <th class="text-center" rowspan="2" width="5%">September</th>
                    <?php elseif ($triwulan == 4): ?>
                        <th class="text-center" rowspan="2" width="5%">Oktober</th>
                        <th class="text-center" rowspan="2" width="5%">November</th>
                        <th class="text-center" rowspan="2" width="5%">Desember</th>
                    <?php endif; ?>
                </tr>
                <tr class="text-center">
                    <td class="text-center" style="background-color: #7FFF00; color: #000; position: sticky; left: 475px; z-index: 99;" width="9%">Aman</td>
                    <td class="text-center" style="background-color: #FFFF00; color: #000; position: sticky; left: 530px; z-index: 99;" width="9%">Hati-Hati</td>
                    <td class="text-center" style="background-color: #FF0000; color: #000; position: sticky; left: 490px; z-index: 99;" width="9%">Bahaya</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($field as $q) {
                    if ($q['kri']) {
                        $act = $this->db->where('rcsa_detail_no', $q['id'])->get(_TBL_VIEW_RCSA_MITIGASI)->row_array();
                        $combo = $this->db->where('id', $q['kri'])->get('bangga_data_combo')->row_array();
                        $combo_stuan = $this->db->where('id', $q['satuan'])->get('bangga_data_combo')->row_array();

                        $level_1 = range($q['min_rendah'], $q['max_rendah']);
                        $level_2 = range($q['min_menengah'], $q['max_menengah']);
                        $level_3 = range($q['min_tinggi'], $q['max_tinggi']);

                        if (in_array($data, $level_1)) {
                            $bgres = 'style="background-color: #7FFF00; color: #000;"';
                        } elseif (in_array($data, $level_2)) {
                            $bgres = 'style="background-color: #FFFF00; color: #000;"';
                        } elseif (in_array($data, $level_3)) {
                            $bgres = 'style="background-color: #FF0000; color: #000;"';
                        } else {
                            $bgres = '';
                        }
                ?>
                <tr>
                    <td class="text-center" style="background-color: #fff; position: sticky; left: 0; z-index: 94;"><?= $no++ ?></td>
                    <td style="background-color: #fff; position: sticky; left: 30px; z-index: 95;"><?= $q['name'] ?></td>
                    <td style="background-color: #fff; position: sticky; left: 120px; z-index: 96;"><?= $act['event_name'] ?></td>
                    <td style="background-color: #fff; position: sticky; left: 250px; z-index: 97;"><?= $combo['data'] ?></td>
                    <td style="background-color: #fff; position: sticky; left: 360px; z-index: 98;">
                        <center><?= $combo_stuan['data'] == "%" ? "persentase [%]" : $combo_stuan['data'] ?></center>
                    </td>
                    <td class="text-center" style="background-color: #7FFF00; color: #000; position: sticky; left: 475px; z-index: 99;"><?= $q['min_rendah'] ?> - <?= $q['max_rendah'] ?></td>
                    <td class="text-center" style="background-color: #FFFF00; color: #000; position: sticky; left: 530px; z-index: 99;"><?= $q['min_menengah'] ?> - <?= $q['max_menengah'] ?></td>
                    <td class="text-center" style="background-color: #FF0000; color: #000; position: sticky; left: 490px; z-index: 99;"><?= $q['min_tinggi'] ?> - <?= $q['max_tinggi'] ?></td>
                    <?php
                    $start = ($triwulan - 1) * 3 + 1;
                    $end = $start + 3;
                    for ($i = $start; $i < $end; $i++): 
                        $data['id'] = $q['id'];
                        $data['rcsa_no'] = $q['rcsa_no'];
                        $res = $this->data->getMonthlyMonitoringGlobal($data, $i);
                    ?>
                    <td <?= $res['bgres'] ?> id="kri-<?= $q['id'] ?><?= $i ?>">
                        <center><?= $res['data'] ?></center>
                    </td>
                    <?php endfor; ?>
                </tr>
                <?php } else { ?>
                <tr>
                    <td class="text-center" colspan="11">Tidak ada data Key Risk Indikator</td>
                </tr>
                <?php } ?>
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


<script>
    // Fungsi untuk menampilkan popup
    function showPopup() {
        var popup = document.getElementById('infoPopup');
        popup.style.display = 'block';
    }

    // Fungsi untuk menyembunyikan popup
    function hidePopup() {
        var popup = document.getElementById('infoPopup');
        popup.style.display = 'none';
    }
</script>

<style>
    /* Gaya untuk popup */
    .popup {
        display: none;
        position: absolute;
        /* Gunakan absolute agar popup tumpang tindih dengan elemen lain */
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
        /* Atur nilai z-index elemen realisasi agar lebih rendah daripada popup */
    }
</style>