<div class="x_panel">
    <div class="x_content">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" id="tab_input">
                <li id="tab-00" class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="false"> <i
                            class="fa fa-list"></i> RCSA</a></li>
                <li id="tab-01" class=""><a href="#tab_2" data-toggle="tab" aria-expanded="true"> <i
                            class="fa fa-list"></i> Isu Internal</a></li>
                <li id="tab-02" class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false"> <i class="fa fa-list"></i> Isu External</a></li>
                <!-- <li id="tab-03" class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false"> <i class="fa fa-list"></i> Kriteria Probabilitas</a></li>
                <li id="tab-04" class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false"> <i class="fa fa-list"></i> Kriteria Dampak</a></li> -->
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <table class="table table-borderless">
                    <tr><td width="20%">Risk Owner</td><td><?=$info['name'];?></td></tr>
                    <tr><td>Create User</td><td><?=$info['create_user'];?></td></tr>
                    <tr><td>Periode</td><td><?=$info['periode_name'];?></td></tr>
                    <tr><td>Anggaran RKAP</td><td><?=number_format($info['anggaran_rkap']);?></td></tr>
                    <tr><td>Pimpinan Unit Kerja</td><td><?=$info['owner_pic'];?></td></tr>
                    <tr><td>Anggota Unit Kerja</td><td><?=$info['anggota_pic'];?></td></tr>
                    <tr><td>Tugas Pokok & Fungsi</td><td><?=$info['tugas_pic'];?></td></tr>
                    <tr><td>Pekerjaan diluar Tupoksi</td><td><?=$info['tupoksi'];?></td></tr>
                    <!-- <tr><td>Status</td><td><?=$info['status'];?></td></tr> -->
                </table>
                <br/>SASARAN<br/>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Sasaran</th>
                            <th>Strategi</th>
                            <th>Kebijakan</th>
                            <!-- <th>Jumlah</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no=0;
                        foreach($sasaran as $row):?>
                    <tr>
                        <td style="text-align: center;"><?=++$no;?></td>
                        <td><?=$row['sasaran'];?></td>
                        <td><?=$row['strategi'];?></td>
                        <td><?=$row['kebijakan'];?></td>
                    </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="tab_2">
                <table class="table table-borderless">
                    <tr><td width="20%">Man</td><td><?=$info['man'];?></td></tr>
                    <tr><td>Method</td><td><?=$info['method'];?></td></tr>
                    <tr><td>Machine</td><td><?=$info['machine'];?></td></tr>
                    <tr><td>Money</td><td><?=$info['money'];?></td></tr>
                    <tr><td>Material</td><td><?=$info['material'];?></td></tr>
                    <tr><td>Market</td><td><?=$info['market'];?></td></tr>
                </table>
                <br/>Stakeholder Internal<br/>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Stakeholder Internal</th>
                            <th>Peran/Fungsi</th>
                            <th>Komunikasi Yag dipilih</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no=0;
                        foreach($internal as $row):?>
                        <tr><td style="text-align: center;"><?=++$no;?></td><td><?=$row['stakeholder'];?></td><td><?=$row['peran'];?></td><td><?=$row['komunikasi'];?></td></tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane" id="tab_3">
                <table class="table table-borderless">
                    <tr><td width="20%">Politics</td><td><?=$info['politics'];?></td></tr>
                    <tr><td>Economics</td><td><?=$info['economics'];?></td></tr>
                    <tr><td>Social</td><td><?=$info['social'];?></td></tr>
                    <tr><td>Technologi</td><td><?=$info['tecnology'];?></td></tr>
                    <tr><td>Environtment</td><td><?=$info['environment'];?></td></tr>
                    <tr><td>Legal</td><td><?=$info['legal'];?></td></tr>
                </table>
                <br/>Stakeholder External<br/>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Stakeholder External</th>
                            <th>Peran/Fungsi</th>
                            <th>Komunikasi Yag dipilih</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no=0;
                        foreach($external as $row):?>
                        <tr><td style="text-align: center;"><?=++$no;?></td><td><?=$row['stakeholder'];?></td><td><?=$row['peran'];?></td><td><?=$row['komunikasi'];?></td></tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>

           <div class="tab-pane hide" id="tab_4">
                <br/>Kriteria Probabilitas<br/>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Deskripsi</th>
                            <th>Sangat Besar</th>
                            <th>Besar</th>
                            <th>Sedang</th>
                            <th>Kecil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no=0;
                        foreach($probabilitas as $row):?>
                        <tr>
                            <td style="text-align: center;"><?=++$no;?></td>
                            <td style="text-align: center;"><?=$row['deskripsi'];?></td>
                            <td><?=$row['sangat_besar'];?></td>
                            <td><?=$row['besar'];?></td>
                            <td><?=$row['sedang'];?></td>
                            <td><?=$row['kecil'];?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane hide" id="tab_5">
                <br/>Kriteria Dampak<br/>
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Deskripsi</th>
                            <th>Sangat Besar</th>
                            <th>Besar</th>
                            <th>Sedang</th>
                            <th>Kecil</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no=0;
                        foreach($dampak as $row):?>
                        <tr>
                            <td style="text-align: center;"><?=++$no;?></td>
                            <td style="text-align: center;"><?=$row['deskripsi'];?></td>
                            <td><?=$row['sangat_besar'];?></td>
                            <td><?=$row['besar'];?></td>
                            <td><?=$row['sedang'];?></td>
                            <td><?=$row['kecil'];?></td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>