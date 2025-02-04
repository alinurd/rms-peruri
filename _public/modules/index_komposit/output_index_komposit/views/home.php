
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-sm-8 panel-heading">
                <h3 style="padding-left:10px;"><?= lang("msg_title") ?></h3>
            </div>
            <div class="col-sm-4" style="text-align:right">
                <ul class="breadcrumb">
                    <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
                    <li><a href="#">Index Komposit</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<section class="x_panel">
    <div class="x_title">
        <h3>Output Peringkat Komposit Risiko</h3>
        <div class="clearfix"></div>
        <form method="GET" action="<?= site_url(_MODULE_NAME_REAL_.'/index'); ?>">
            <div class="row">
                <div class="col-md-2 col-sm-4 col-xs-6">
                    <label for="filter_periode">Tahun</label>
                    <select name="periode" id="filter_periode" class="form-control select2" style="width: 100%;">
                        <?php foreach ($cboPeriod as $key => $value): ?>
                            <option value="<?= ($key == 0) ? '0' : $value; ?>" <?= ($periode == $value) ? 'selected' : ''; ?>><?= $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- <div class="col-md-6 col-sm-8 col-xs-6">
                    <label for="filter_owner">Risk Owner</label>
                    <select name="owner" id="filter_owner" class="form-control select2" style="width: 100%;">
                        <?php foreach ($cboOwner as $key => $value): ?>
                            <option value="<?= $key; ?>" <?= ($owner == $key) ? 'selected' : ''; ?>><?= $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div> -->
                <div class="col-md-2 col-sm-2 col-xs-2">
                    <label for="filter_triwulan">Triwulan <?=$tw?></label>
                    <select name="triwulan" id="filter_triwulan" class="form-control select2" style="width: 80%;">
                        <option value="1" <?= ($tw == 1) ? 'selected' : ''; ?>>Triwulan 1</option>
                        <option value="2" <?= ($tw == 2) ? 'selected' : ''; ?>>Triwulan 2</option>
                        <option value="3" <?= ($tw == 3) ? 'selected' : ''; ?>>Triwulan 3</option>
                        <option value="4" <?= ($tw == 4) ? 'selected' : ''; ?>>Triwulan 4</option>
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
    <div class="x_content">
        <div class="row">
            <div class="col-md-6">
                <section class="x_panel">
                    <div class="x_title">
                        <strong>Kualitas Penerapan Management Risko (KPMR)</strong>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="clearfix"></div>
                            <div class="table-responsive">
                                <table class="display table table-bordered" id="tbl_event">
                                    <thead>
                                        <tr>
                                        <th class="text-center">No</th>
                                            <th class="text-center">Indikator</th>
                                            <th class="text-center">Bobot</th>
                                            <th class="text-center">Hasil Penilaian</th>
                                            <th class="text-center">Skor Penilaian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $kualitasKPMR = "Undefined";
                                        $nc = 1;
                                        $totalPenilaianCombo = 0;
                                        foreach ($kompositData as $k => $c) :
                                            if ($c['pid'] == 0) :
                                                $bobot = $c['bobot'];
                                                $totalNilai = 0;
                                                $totalPenilai = 0;
                                                foreach ($c['parent'] as $pk) {
                                                    $countDetailx = $c['detail'][$pk['id']];
                                                    $resParents = $this->db
                                                        ->where('id_komposit', $pk['id_combo'])
                                                        // ->where('owner', $owner)
                                                        ->where('tw', $tw)
                                                        ->where('periode', $periode)
                                                        ->order_by('urut')
                                                        ->get('bangga_indexkom_realisasi')
                                                        ->row_array();

                                                    $skala = [$pk['skala'] => $pk['penilaian']];
                                                    $hasilPenilaian = $skala[$resParents['realisasi']] ?? 0;

                                                    if ($bobot > 0) {
                                                        $nilai = ($bobot / 100) * $hasilPenilaian;
                                                    } else {
                                                        $nilai = $hasilPenilaian;
                                                    }

                                                    $totalPenilai += $hasilPenilaian;
                                                    $totalNilai += $nilai;

                                                    if (count($countDetailx) > 0) {
                                                        $totalDetailPenilai = 0;
                                                        $totalDetailNilai = 0;

                                                        foreach ($countDetailx as $dKey => $d) {
                                                            $resDetail = $this->db
                                                                ->where('id_komposit', $d['id_param'])
                                                                
                                                        // ->where('owner', $owner)
                                                        ->where('tw', $tw)
                                                        ->where('periode', $periode)
                                                                ->where('urut', $pk['urut'])
                                                                ->order_by('urut')
                                                                ->get('bangga_indexkom_realisasi')
                                                                ->row_array();
                                                            $skalaDetail = [$d['skala'] => $d['penilaian']];
                                                            $hasilPenilaianDetail = ($pk['bobot'] / 100) * $skalaDetail[$resDetail['realisasi']] ?? 0;
                                                            if ($bobot > 0) {
                                                                $nilaiDetail = ($bobot / 100) * $hasilPenilaianDetail;
                                                            } else {
                                                                $nilaiDetail = $hasilPenilaianDetail;
                                                            }

                                                            $totalDetailPenilai += $hasilPenilaianDetail;
                                                            $totalDetailNilai += $nilaiDetail;
                                                        }

                                                        $totalPenilai += $totalDetailPenilai;
                                                        $totalNilai += $totalDetailNilai;
                                                    }
                                                }
                                                $totalPenilaianCombo += $totalNilai;
                                        ?>
                                                <tr>
                                                    <td class="text-center"><?= $nc++ ?></td>
                                                    <td><?= $c['data'] ?></td>
                                                    <td class="text-center"><?= $bobot ?> %</td>
                                                    <td class="text-center"><?= $totalPenilai ?></td>
                                                    <td class="text-center"><?= $totalNilai ?></td>
                                                </tr>

                                        <?php
                                            endif;
                                        endforeach;
                                        foreach ($levelKPMR as $level) {
                                            if ($totalPenilaianCombo >= $level['min'] && $totalPenilaianCombo <= $level['max']) {
                                                $kualitasKPMR = $level['label'];
                                                break;
                                            }
                                        }
                                        ?>
                                        <tr style="background: #367FA9; color:#fff;">
                                            <th colspan="4" style="text-align: center;">Total Nilai</th>
                                            <th class="text-center"><?= $totalPenilaianCombo ?></th>
                                        </tr>
                                        <tr style="background: #367FA9; color:#fff;">
                                            <th colspan="4" style="text-align: center;">Kualitas Penerapan Manajemen Risiko (KPMR)</th>
                                            <th class="text-center"><?= $kualitasKPMR ?></th>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-md-6">
                <section class="x_panel">
                    <div class="x_title">
                        <strong>Pencapaian Kinerja</strong>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="clearfix"></div>
                            <div class="table-responsive">
                                <table class="display table table-bordered" id="tbl_event">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Indikator</th>
                                            <th class="text-center">Bobot</th>
                                            <th class="text-center">Hasil Penilaian</th>
                                            <th class="text-center">Skor Penilaian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $kualitasKinerja = "Undefined";
                                        $nc = 1;
                                        $totalPenilaianKinerja = 0;
                                        foreach ($kompositData as $k => $c) :
                                            if ($c['pid'] == 1) :
                                                $bobot = $c['bobot'];
                                                $totalNilai = 0;
                                                $totalPenilai = 0;
                                                foreach ($c['parent'] as $pk) {
                                                    $countDetailx = $c['detail'][$pk['id']];
                                                    $resParents = $this->db
                                                        ->where('id_komposit', $pk['id_combo'])
                                                        
                                                        // ->where('owner', $owner)
                                                        ->where('tw', $tw)
                                                        ->where('periode', $periode)
                                                        ->order_by('urut')
                                                        ->get('bangga_indexkom_realisasi')
                                                        ->row_array();

                                                    $skala = [$pk['skala'] => $pk['penilaian']];
                                                    $hasilPenilaian = $skala[$resParents['realisasi']] ?? 0;

                                                    if ($bobot > 0) {
                                                        $nilai = ($bobot / 100) * $hasilPenilaian;
                                                    } else {
                                                        $nilai = $hasilPenilaian;
                                                    }

                                                    $totalPenilai += $hasilPenilaian;
                                                    $totalNilai += $nilai;

                                                    if (count($countDetailx) > 0) {
                                                        $totalDetailPenilai = 0;
                                                        $totalDetailNilai = 0;

                                                        foreach ($countDetailx as $dKey => $d) {
                                                            $resDetail = $this->db
                                                                ->where('id_komposit', $d['id_param'])
                                                                ->where('urut', $pk['urut'])
                                                                
                                                        // ->where('owner', $owner)
                                                        ->where('tw', $tw)
                                                        ->where('periode', $periode)
                                                                ->order_by('urut')
                                                                ->get('bangga_indexkom_realisasi')
                                                                ->row_array();
                                                            $skalaDetail = [$d['skala'] => $d['penilaian']];
                                                            $hasilPenilaianDetail = ($pk['bobot'] / 100) * $skalaDetail[$resDetail['realisasi']] ?? 0;
                                                            if ($bobot > 0) {
                                                                $nilaiDetail = ($bobot / 100) * $hasilPenilaianDetail;
                                                            } else {
                                                                $nilaiDetail = $hasilPenilaianDetail;
                                                            }

                                                            $totalDetailPenilai += $hasilPenilaianDetail;
                                                            $totalDetailNilai += $nilaiDetail;
                                                        }

                                                        $totalPenilai += $totalDetailPenilai;
                                                        $totalNilai += $totalDetailNilai;
                                                    }
                                                }
                                                $totalPenilaianKinerja += $totalNilai;
                                        ?>
                                                <tr>
                                                    <td class="text-center"><?= $nc++ ?></td>
                                                    <td><?= $c['data'] ?></td>
                                                    <td class="text-center"><?= $bobot ?> %</td>
                                                    <td class="text-center"><?= $totalPenilai ?></td>
                                                    <td class="text-center"><?= $totalNilai ?></td>
                                                </tr>

                                        <?php
                                            endif;
                                        endforeach;
                                        foreach ($levelKinerja as $level) {
                                            if ($totalPenilaianKinerja >= $level['min'] && $totalPenilaianKinerja <= $level['max']) {
                                                $kualitasKinerja = $level['label'];
                                                break;
                                            }
                                        }
                                        ?>
                                        <tr style="background: #367FA9; color:#fff;">
                                            <th colspan="4" style="text-align: center;">Total Nilai</th>
                                            <th class="text-center"><?= $totalPenilaianKinerja ?></th>
                                        </tr>
                                        <tr style="background: #367FA9; color:#fff;">
                                            <th colspan="4" style="text-align: center;">Kualitas Penerapan Manajemen Risiko (KPMR)</th>
                                            <th class="text-center"><?= $kualitasKinerja ?></th>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- MAP Komposit -->
        <div class="row">
            <div class="col-md-12">
                <section class="x_panel">
                <div class="x_title">
                    <center><i>Matriks Peringkat Komposit Risiko</i></center>                
                    <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <center>
                            <div class="row">
                                 <?php
                                $indexKinerja=[];
                                $kmpr=[];
                                foreach ($levelKinerja as $k) {
                                    $nilaiArray = explode(',', $k['nilai']);
                                    $indexKinerja[] = array_merge([$k['label']], $nilaiArray);
                                }
                                
                                foreach($levelKPMR as $k){
                                    $kmpr[] = $k['label'];
                                }
                                $data=[
                                    'KINERJA'=>['label'=>'KINERJA', 'realisasiText'=>$kualitasKinerja, 'realisasiAngka'=>$totalPenilaianKinerja], 
                                    'KPMR'=>['label'=>'KPMR', 'realisasiText'=>$kualitasKPMR, 'realisasiAngka'=>$totalPenilaianKinerja], 
                                ];
                                echo $this->data->drawMapKomposit($indexKinerja, $kmpr, $data);
                                ?>

                            </div>
                        </center>
                    </div>
                </section>
            </div>
        </div>
        <!-- endMAP Komposit -->

        <div class="row">
            <div class="col-md-6">
                <section class="x_panel">
                    <div class="x_title">
                        <center><i>Konversi Skor Penilaian Terhadap KPMR</i></center>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="clearfix"></div>
                            <div class="table-responsive">
                                <table class="display table table-bordered" id="tbl_event">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">KPMR</th>
                                            <th class="text-center">Skor Penilaian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($levelKPMR as $k => $p):
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= $p['label'] ?></td>
                                                <td class="text-center">
                                                    <?php
                                                    $ln = $p['min'] . ' - ' . $p['max'];
                                                    if ($p['max'] == 1000) {
                                                        $ln = ' > ' . $p['min'];
                                                    } elseif ($p['min'] == 0) {
                                                        $ln = ' < ' . $p['max'];
                                                    } ?>
                                                    <?= $ln ?></td>

                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            <div class="col-md-6">
                <section class="x_panel">
                    <div class="x_title">
                        <center><i>Konversi Skor Penilaian Terhadap Pencapaian Kinerja</i></center>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="clearfix"></div>
                            <div class="table-responsive">
                                <table class="display table table-bordered" id="tbl_event">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Kinerja</th>
                                            <th class="text-center">Skor Penilaian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $ln = 'Undefined';
                                        foreach ($levelKinerja as $k => $p):
                                        ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td><?= $p['label'] ?></td>
                                                <td class="text-center">
                                                    <?php
                                                    $ln = $p['min'] . ' - ' . $p['max'];
                                                    if ($p['max'] == 1000) {
                                                        $ln = ' > ' . $p['min'];
                                                    } elseif ($p['min'] == 0) {
                                                        $ln = ' < ' . $p['max'];
                                                    } ?>
                                                    <?= $ln ?></td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>