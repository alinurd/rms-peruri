<style>
     #scrollUp, #scrollDown {
            position: fixed;
            right: 20px;
            padding: 10px 15px;
            font-size: 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: none; /* Sembunyikan secara default */
            z-index: 1000; /* Pastikan tombol di atas elemen lain */
            transition: background-color 0.3s ease; /* Efek transisi */
            width: 50px;
            height: 50px;
        }

        #scrollUp {
            bottom: 80px; /* Posisi tombol up */
        }

        #scrollDown {
            bottom: 20px; /* Posisi tombol down */
        }

        /* Efek saat tombol ditekan */
        #scrollUp:active, #scrollDown:active {
            background-color: #0056b3; /* Warna lebih gelap saat ditekan */
            transform: scale(0.95); /* Sedikit mengecil saat ditekan */
        }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-sm-8 panel-heading">
                <h3 style="padding-left:10px;">All Report</h3>
            </div>
            <div class="col-sm-4" style="text-align:right">
                <ul class="breadcrumb">
                    <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
                    <li><a href="#">All Report</a></li>
                </ul>
            </div>
        </div>
        <section class="x_panel">
			<!-- <form id="form_grafik" method="post"> -->
                <?=form_open_multipart(base_url(), array('id' => 'form_grafik', 'class'=>'form-horizontal'));?>
                <div class="panel-body bio-graph-info" style="overflow-x: auto;">
                    <div class="col-md-3 col-sm-3 col-xs-3">Risk Owner</div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <div class="form-group form-inline">
                            <?=form_dropdown('owner_no', $korporasi, '', ' class="form-control select2" id="owner_no" style="width:100%;"');?>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3">Periode</div>
                    <div class="col-md-9 col-sm-9 col-xs-9">
                        <div class="form-group form-inline">
                            <?=form_dropdown('periode_no', $periode, _TAHUN_NO_, ' class="form-control select2" id="periode_no" style="width:100%;"');?>
                        </div>
                    </div>


                    <div class="col-md-3 col-sm-3 col-xs-3">&nbsp;</div>
                        <hr>
                        <input type="hidden" id="tahun" name="tahun">
                        <input type="hidden" id="bulan2" name="bulan2">
                        <input type="hidden" id="owner_name" name="owner_name">
                        <span class="btn btn-warning btn-flat pull-right"><a href="#" style="color:#ffffff;" id="downloadPdf"><i class="fa fa-file-pdf-o"></i>PDF </a>
                        </span>
                        <span class="btn btn-success btn-flat pull-right"><a href="#" style="color:#ffffff;" id="downloadExcel"><i class="fa fa-file-excel-o"></i>Progress Treatment </a></span>
                        <span class="btn btn-info btn-flat pull-right"><a href="#" style="color:#ffffff;" id="downloadExcelRegister"><i class="fa fa-file-excel-o"></i>Risk Register </a>
                        </span>
                        <span class="btn btn-primary pull-right" style="width:100px;" id="proses"> Proses </span>
                    </div>
                    <hr>
                    <p class="text-left text-danger"><span>*</span> Sebelum melakukan ekspor, harap lakukan proses terlebih dahulu. Tombol PDF untuk semua laporan kecuali progress treatment; gunakan Risk Register untuk ekspor data excel risk register dan Progress Treatment untuk ekspor data excel progress treatment.</p>
                </div>
                <?php echo form_close(); ?>
            <!-- </form> -->
		</section>

        <section class="x_panel">
            <!-- Accordion Section -->
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
                <h3 style="padding-left:10px;">Reporting Tabel</h3>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                               Risk Context
                                <i class="fa fa-minus pull-right"></i>  <!-- Icon Min di kanan -->
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body" id="risk_context">
                            
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwo">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Risk Criteria
                                <i class="fa fa-minus pull-right"></i>  <!-- Icon Min di kanan -->
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                        <div class="panel-body" id="risk_criteria">
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThree">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Risk Appetite
                                <i class="fa fa-minus pull-right"></i>  <!-- Icon Min di kanan -->
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                        <div class="panel-body" id="risk_appetite">
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingFour">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                               Risk Register
                                <i class="fa fa-minus pull-right"></i>  <!-- Icon Min di kanan -->
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                        <div class="panel-body" id="risk_register" style="overflow-x: auto;">
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingFive">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Efektifitas Control
                                <i class="fa fa-minus pull-right"></i>  <!-- Icon Min di kanan -->
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive">
                        <div class="panel-body" id="efektifitas_control">

                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingSix">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                Progress Treatment
                                <i class="fa fa-minus pull-right"></i>  <!-- Icon Min di kanan -->
                            </a>
                        </h4>
                    </div>
                    <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix">
                        <div class="panel-body" id="progress_treatment" style="overflow-x: auto;">
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingSeven">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                               Lost Event Database
                                <i class="fa fa-minus pull-right"></i>  
                            </a>
                        </h4>
                    </div>
                    <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven">
                        <div class="panel-body" id="loss_event_database">
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingEight">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                                Early Warning
                                <i class="fa fa-minus pull-right"></i>  <!-- Icon Min di kanan -->
                            </a>
                        </h4>
                    </div>
                    <div id="collapseEight" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEight">
                        <div class="panel-body" id="early_warning"  style="overflow-x: auto;">
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingNine">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                                Ihtisar Perubahan Level
                                <i class="fa fa-minus pull-right"></i>  <!-- Icon Min di kanan -->
                            </a>
                        </h4>
                    </div>
                    <div id="collapseNine" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingNine">
                        <div class="panel-body" id="perubahan_level">
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Accordion Section -->
        </section>
        <section class="x_panel">
            <!-- Accordion Section -->
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="false">
                <h3 style="padding-left:10px;">Reporting Grafik</h3>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTen">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                               Heatmap
                                <i class="fa fa-minus pull-right"></i>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTen">
                        <div class="panel-body">
                            <div class="col-md-3 col-sm-3 col-xs-3">Bulan</div>
                                <div class="col-md-9 col-sm-9 col-xs-9">
                                    <div class="form-group form-inline">
                                        <?php
                                            $current_month = date('n'); 
                                            echo form_dropdown(
                                                'bulan', 
                                                [
                                                    '1' => 'Januari',
                                                    '2' => 'Februari',
                                                    '3' => 'Maret',
                                                    '4' => 'April',
                                                    '5' => 'Mei',
                                                    '6' => 'Juni',
                                                    '7' => 'Juli',
                                                    '8' => 'Agustus',
                                                    '9' => 'September',
                                                    '10' => 'Oktober',
                                                    '11' => 'November',
                                                    '12' => 'Desember'
                                                ], 
                                                $current_month,
                                                'class="form-control select2" id="bulan" style="width:100%;"'
                                            );
                                            ?>

                                        </div>
                            </div>
                            <div class="heatmap" id="heatmap">

                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingEleven">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                                Risk Distribution
                                <i class="fa fa-minus pull-right"></i>  <!-- Icon Min di kanan -->
                            </a>
                        </h4>
                    </div>
                    <div id="collapseEleven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingEleven">
                        <div class="panel-body" id="risk_distribution">
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingTwelve">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">
                                Risk Categories
                                <i class="fa fa-minus pull-right"></i>  <!-- Icon Min di kanan -->
                            </a>
                        </h4>
                    </div>
                    <div id="collapseTwelve" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwelve">
                        <div class="panel-body" id="risk_categories">
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingThirteen">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThirteen" aria-expanded="false" aria-controls="collapseThirteen">
                               Takstonomi Risiko T1,T2,T3
                                <i class="fa fa-minus pull-right"></i>  <!-- Icon Min di kanan -->
                            </a>
                        </h4>
                    </div>
                    <div id="collapseThirteen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThirteen">
                        <div class="panel-body" id="risk_tasktonomi" style="overflow-x: auto;">
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingFourteen">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFourteen" aria-expanded="false" aria-controls="collapseFourteen">
                                Efektifitas Control
                                <i class="fa fa-minus pull-right"></i>  <!-- Icon Min di kanan -->
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFourteen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFourteen">
                        <div class="panel-body" id="grapik_efektifitas_control">

                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingFiveteen">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFiveteen" aria-expanded="false" aria-controls="collapseFiveteen">
                                Progress Treatment
                                <i class="fa fa-minus pull-right"></i>  <!-- Icon Min di kanan -->
                            </a>
                        </h4>
                    </div>
                    <div id="collapseFiveteen" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFiveteen">
                        <div class="panel-body" id="grapik_progress_treatment" style="overflow-x: auto;">
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Accordion Section -->
        </section>
        <!-- Tombol Scroll Up dan Down -->
    </div>
    <button id="scrollUp" class="btn btn-sm btn-primary"><i class="fa fa-chevron-up"></i></button>
    <button id="scrollDown" class="btn btn-sm btn-primary"><i class="fa fa-chevron-down"></i></button>
</div>


<script>
    $(document).ready(function() {
        $('#accordion').on('shown.bs.collapse', function(e) {
            $(e.target).prev().find('i').removeClass('fa-minus').addClass('fa-plus');
        });

        $('#accordion').on('hidden.bs.collapse', function(e) {
            $(e.target).prev().find('i').removeClass('fa-plus').addClass('fa-minus');
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#datatables').DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
    const scrollDistance = 100; // Jarak scroll per interval
    let scrollInterval;

    // Fungsi scroll
    function scrollUp() {
        $('html, body').animate({ scrollTop: $('html, body').scrollTop() - scrollDistance }, 10);
    }
    function scrollDown() {
        $('html, body').animate({ scrollTop: $('html, body').scrollTop() + scrollDistance }, 10);
    }

    // Tampilkan atau sembunyikan tombol berdasarkan posisi scroll
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('#scrollUp').fadeIn();
        } else {
            $('#scrollUp').fadeOut();
        }

        // Selalu tampilkan tombol scroll down jika tidak di bagian bawah halaman
        if ($(this).scrollTop() + $(this).height() < $(document).height() - 100) {
            $('#scrollDown').fadeIn();
        } else {
            $('#scrollDown').fadeOut();
        }
    });

    // Mulai scroll saat tombol ditekan
    $('#scrollUp').on('mousedown touchstart', function(e) {
        e.preventDefault();
        clearInterval(scrollInterval); // Hentikan scroll yang sedang berjalan
        scrollInterval = setInterval(scrollUp, 20);
    });
    $('#scrollDown').on('mousedown touchstart', function(e) {
        e.preventDefault();
        clearInterval(scrollInterval); // Hentikan scroll yang sedang berjalan
        scrollInterval = setInterval(scrollDown, 20);
    });

    // Berhenti scroll saat tombol dilepas
    $('#scrollUp, #scrollDown').on('mouseup touchend', function() {
        clearInterval(scrollInterval);
    });
});
</script>
