<section class="x_panel">
    <div class="x_title">
        <h3>Output Index Komposit</h3>

        <div class="clearfix"></div>
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
                                            <th>No</th>
                                            <th>Indikator</th>
                                            <th>Bobot</th>
                                            <th>Hasil Penilaian</th>
                                            <th>Skor Penilaian</th>
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
                                            <th>No</th>
                                            <th>Indikator</th>
                                            <th>Bobot</th>
                                            <th>Hasil Penilaian</th>
                                            <th>Skor Penilaian</th>
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
                    <center><i>Map Output Index Komposit</i></center>                
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
                        <center><i>Conversi Skor Penilaian Terhadap KPMR</i></center>
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
                        <center><i>Conversi Skor Penilaian Terhadap Pencapaian Kinerja</i></center>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="clearfix"></div>
                            <div class="table-responsive">
                                <table class="display table table-bordered" id="tbl_event">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Kinerja</th>
                                            <th>Skor Penilaian</th>
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