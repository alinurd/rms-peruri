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
                                            <th >Indikator</th>
                                            <th>Bobot</th>
                                            <th>Hasil Penilaian</th>
                                            <th>Skor Penilaian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $nc = 1;
                                        $totalPenilaianCombo = 0;

                                        foreach ($kompositData as $c) :
                                            if ($c['pid'] == 0) : 
                                                $bobot = 0; 
                                                $totalBobot = 0; 
                                                $nilai = 0; 
                                                $totalNilai = 0; 
                                                $penilaian = 0; 
                                                $skalaValue = [];
                                                
                                                foreach ($c['parent'] as $pk) { 
                                                    $resParents = $this->db
                                                        ->where('id_komposit', $pk['id_combo'])
                                                        ->order_by('urut')
                                                        ->get('bangga_indexkom_realisasi')
                                                        ->row_array();
                                                    
                                                    $skala = [$pk['skala'] => $pk['penilaian']];
                                                 
                                                    $bobot = $pk['bobot'];
                                                 
                                                    if ($bobot > 0) {
                                                        $nilai = ($bobot / 100) * $skala[$resParents['realisasi']];
                                                    } else {
                                                        $nilai = $skala[$resParents['realisasi']];  
                                                    } 
                                                    $totalNilai += $nilai;
                                                    $totalBobot += $bobot; 
                                                    $countDetail = $c['detail'][$pk['id']];
                                                     
                                                 }
                                        ?>
                                                <tr>
                                                    <td rowspan=""><?= $nc++ ?></td>
                                                    <td  ><?= $c['data'] ?></td>
                                                    <td ><?= $totalBobot ?> %</td>
                                                    <td >
                                                        <?=$totalNilai?>
                                                    </td>
                                                    <td >
                                                    <?=$totalBobot*$totalNilai?>
                                                    </td>
                                                </tr>
                                                 
                                                   
                                         <?php endif;
                                        endforeach; ?>

                                        <!-- Baris Total Nilai -->
                                        <tr style="background: #367FA9; color:#fff;">
                                            <th colspan="4" style="text-align: center;">Total Nilai</th>
                                            <th><?= $totalPenilaianCombo ?></th> <!-- Tampilkan nilai total penilaian di sini -->
                                        </tr>

                                        <!-- Baris Kualitas Penerapan Manajemen Risiko -->
                                        <tr style="background: #367FA9; color:#fff;">
                                            <th colspan="4" style="text-align: center;">Kualitas Penerapan Manajemen Risiko (KPMR)</th>
                                            <th>Fair</th>
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
                                        <tr>
                                            <td>No</td>
                                            <td>Indikator</td>
                                            <td>Bobot</td>
                                            <td>Hasil Penilaian</td>
                                            <td>Skor Penilaian</td>
                                        </tr>
                                        <tr style="background: #367FA9; color:#fff;">
                                            <th colspan="4" style="text-align: center;">Total Nilai</th>
                                            <th>83</th>
                                        </tr>
                                        <tr style="background: #367FA9; color:#fff;">
                                            <th colspan="4" style="text-align: center;">Kinerja</th>
                                            <th>Fair</th>
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
                    <div class="x_content">
                        <div class="row">
                            <div class="clearfix"></div>
                            <center>
                                <strong>MAP</strong>
                            </center>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- endMAP Komposit -->

        <div class="row">
            <div class="col-md-6">
                <section class="x_panel">
                    <div class="x_title">
                        <i>Conversi Skor Penilaian Terhadap KPMR</i>
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
                                            <th>KPMR</th>
                                            <th>Skor Penilaian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>No</td>
                                            <td>Indikator</td>
                                            <td>Skor Penilaian</td>
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
                        <i>Conversi Skor Penilaian Terhadap Pencapaian Kinerja</i>
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
                                        <tr>
                                            <td>No</td>
                                            <td>Indikator</td>
                                            <td>Skor Penilaian</td>
                                        </tr>
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