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
        <form method="GET" action="<?= site_url($this->modul_name.'/index'); ?>">
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
                                    <th class="text-center" style="position: sticky; left: 50px; background: white; z-index: 99; width: 120px;">Risk Owner</th>
                                    <th class="text-center" style="position: sticky; left: 170px; background: white; z-index: 99; width: 140px;">Peristiwa Risiko</th>
                                    <th class="text-center" style="position: sticky; left: 310px; background: white; z-index: 99; width: 50px;">Tahun</th>
                                    <th class="text-center" style="position: sticky; left: 360px; background: white; z-index: 99; width: 50px;">Inh</th>
                                    <th class="text-center" style="position: sticky; left: 400px; background: white; z-index: 99; width: 50px;">Res</th>
                                    <th class="text-center" style="position: sticky; left: 340px; background: white; z-index: 99; width: 50px;">PL</th>
                                    <th class="text-center">keterangan Pergerakan Level Bulan :<?=$triwulan?></th>
                                      
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($field as $q) {
                                     $residual_level = $this->data->get_master_level(true, $q['inherent_level']);
                                    $getKode        = $this->data->level_action($residual_level['likelihood'], $residual_level['impact']);
                                    $reKod    = $getKode['like']['code'] . ' x ' . $getKode['impact']['code'];
                                    
                                    $inherent = '
                                    <a class="btn" data-toggle="popover" data-content="
                                    <center>
                                    ' . $reKod . ' <br>
                                    ' . $residual_level['level_mapping'] . '
                                    </center>
                                    " style="padding:4px; height:4px 8px;width:100%;background-color:' . $residual_level['color'] . ';color:' . $residual_level['color_text'] . ';"> &nbsp;</a>';
                                  
                                    $pl='';
                                    $bln=1;
                                    $getMonitoring=$this->data->getMonthlyMonitoringGlobal($q['id'], $bln, $residual_level['level_mapping']);
                                ?>
                                    <tr>
                                        <td style="position: sticky; left: 0; background: white;z-index: 99;"><?= $no++ ?></td>
                                        <td style="position: sticky; left: 50px; background: white;z-index: 98;"><?= $q['name'] ?></td>
                                        <td style="position: sticky; left: 170px; background: white;z-index: 97;"><?= $q['event_name'] ?></td>
                                        <td style="position: sticky; left: 310px; background: white; z-index: 96; "><?= $q['tahun'] ?></td>
                                        <td style="position: sticky; left: 360px; background: white; z-index: 95; "><?= $inherent ?></td>
                                        <td style="position: sticky; left:400px; background: white; z-index: 95; "><?= $getMonitoring['lv'] ?></td>
                                        <td style="position: sticky; left:440px; background: white; z-index: 95; ">
                                       <?= $getMonitoring['pl']?>
                    
                                        </td>
                                   
                                            <td class="text-center">
                                            <?= $getMonitoring['ket']?>

                                            </td> 
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

<style>

button {
  background-color: transparent;
  border: none;
  box-shadow: none;
  padding: 2;
}


</style>