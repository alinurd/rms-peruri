<style>

    .redirect-link {
        background-color:#d06aff;
        border-radius: 10px; 
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        /* padding: 5px;  */
        margin: 20px 0; 
        overflow: hidden; 
    }

    .running-text {
        white-space: nowrap; 
        display: inline-block; 
        animation: scroll 25s linear infinite; 
        color: white;
        padding: 0px !important;
    }

    @keyframes scroll {
        0% {
            transform: translateX(100%); /* Mulai dari luar kanan */
        }
        100% {
            transform: translateX(-100%); /* Bergerak ke luar kiri */
        }
    }

    .running-text p {
        margin: 0; /* Menghapus margin default pada paragraf */
        font-size: 18px; /* Ukuran font yang lebih besar */
        color: #333; /* Warna teks */
    }
</style>

<div class="row">
    <div class="col-md-12" style="padding: 0px !important;">
        <div class="row">
            <div class="col-sm-8 panel-heading">
                <h3 style="padding-left:10px;"><?= $title ?></h3>
            </div>
            <div class="col-sm-4" style="text-align:right">
                <ul class="breadcrumb">
                    <li> <a href="#"> <i class="fa fa-home"></i> Home</a></li>
                    <li><a href="#">Dashboard</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- $xx= anchor_popup($pbaru, $isi, $atts); -->

<section id="main-content">
    <section class="wrapper site-min-height">
    <div class="row redirect-link">
        <div class="col-md-12">
            <div class="running-text">
                <p style="color: white !important;">Anda sedang menggunakan versi terbaru EYERISK PERURI. Jika Anda ingin kembali ke <a href="https://rcsa.peruri.co.id" style="color: yellow !important;">RCSA PERURI</a>, silakan klik di sini.</p>
            </div>
        </div>
    </div>
        <div class="panel panel-default">
            <style></style>
        
            <!-- looping nya disini -->
            <?php foreach ($data as $datax) { // Ubah $data menjadi $datax 
            ?>
                <?php
                $title = $datax['title'];
                $dsc = $datax['keterangan'];
                $id = $datax['id'];
                $dt = $datax['create_date'];
                // doi::dump($datax);
                if (!$dsc) {
                    $dsc = "tidak ada keterangan";
                }
                ?>

                <div class="panel-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row col-md-12" style="box-shadow: rgba(0, 0, 0, 0.18) 0px 2px 4px;">
                                <div class="col-md-2 col-sm-4 col-xs-6 " style="margin: 3px;">
                                    <img src="<?= base_url('themes/upload/news/' . $datax['photo']); ?>" width="100" height="100" title="">
                                </div>
                                <div class="col-md-9 col-sm-6 col-xs-12" style="margin-top: 10px;">
                                    <span style="font-weight: bold; font-size: large;"> <?= $title ?></span> <br>
                                    <i>Dipublikasi pada <?= $dt ?></i>
                                </div>
                                <div>
                                    <!-- <a href="<?php echo base_url('downloadcontroller/downloadfile'); ?>">Klik di sini untuk mengunduh file</a> -->
                                    <!-- <a href="<?= base_url(_MODULE_NAME_REAL_ . '/' . _METHOD_ . '/' . $parent['id']); ?>" class="btn btn-default" id="btnBack"> Kembali ke List </a> -->

                                    <a style=" margin-top: 20px;box-shadow: rgba(0, 0, 0, 0.18) 0px 2px 4px;" class="btn btn-default text-center" href="<?php echo base_url(_MODULE_NAME_REAL_ . '/detail/' . $datax['id']); ?>">
                                        <span style="display: inline-block; text-align: center;">
                                            <i class="fa fa-search" aria-hidden="true"></i> </span>
                                    </a>
                                    <!-- <a style=" margin-top: 20px;box-shadow: rgba(0, 0, 0, 0.18) 0px 2px 4px;" class="btn btn-default text-center" href="<?php echo base_url(_MODULE_NAME_REAL_ . '/downloadfile/' . $datax['id']); ?>">
                                        <span style="display: inline-block; text-align: center;">
                                            <i class="fa fa-search" aria-hidden="true"></i> </span>
                                    </a> -->

                                </div>
                            </div>
                        </div>
                    </div>
                    <div>&nbsp;&nbsp;</div>
                </div>
            <?php } ?>
            <!-- end -->

            <div class="text-center " style=" margin-bottom: 13px;margin-top: 13px;">
                <?php
                $totalPages = ceil($total_rows / $per_page);

                // Display "Back" button if not on the first page
                if ($currentPage >= 1) {
                    $prevPage = $currentPage - 1;
                    echo "<a class='btn btn-primary' href='" . base_url(_MODULE_NAME_REAL_ . '/' . _METHOD_ . '/' . $prevPage) . "'>&laquo; Back</a> ";
                }

                // Display pagination links
                $showEllipsis = false;
                for ($i = 1; $i <= $totalPages; $i++) {
                    if ($totalPages <= 5 || $i == 1 || $i == $totalPages || ($i >= $currentPage - 1 && $i <= $currentPage + 1)) {
                        if ($i == $currentPage) {
                            echo "<strong><a class='btn btn-dark' class='active' href='" . base_url(_MODULE_NAME_REAL_ . '/' . _METHOD_ . '/' . $i) . "'>$i</a></strong> ";
                        } else {
                            echo "<a class='btn btn-secondary' href='" . base_url(_MODULE_NAME_REAL_ . '/' . _METHOD_ . '/' . $i) . "'>$i</a> ";
                        }
                    } elseif (!$showEllipsis) {
                        echo "        <label class='text-dark'>-</label>
";
                        $showEllipsis = true;
                    }
                }
                if ($currentPage < $totalPages) {
                    $nextPage = $currentPage + 1;
                    echo "<a class='btn btn-primary' href='" . base_url(_MODULE_NAME_REAL_ . '/' . _METHOD_ . '/' . $nextPage) . "'>Next &raquo;</a> ";
                }
                ?>
            </div>
            <i>&nbsp;&nbsp;Data records: <?= $total_rows ?> | Menampilkan <b><?= $per_page ?></b> data perhalaman</i><br>
        </div>




    </section>

</section>

<script>
    var dsc = "<?= $dsc ?>";
    var isFullDescriptionShown = false;

    function toggleDescription(event, id) {
        event.preventDefault();
        var dscText = document.getElementById("dscText-" + id);
        var toggleBtn = document.getElementById("toggleBtn-" + id);

        if (dscText && toggleBtn) {
            if (dscText.classList.contains("hide")) {
                dscText.classList.remove("hide");
                toggleBtn.innerHTML = "Hide Detail";
            } else {
                dscText.classList.add("hide");
                toggleBtn.innerHTML = "More";
            }
        }
    }

    window.onload = function() {
        var toggleButtons = document.querySelectorAll("[data-toggle-description]");

        for (var i = 0; i < toggleButtons.length; i++) {
            var toggleBtn = toggleButtons[i];
            var id = toggleBtn.getAttribute("data-toggle-description");
            var dscText = document.getElementById("dscText-" + id);

            if (dscText) {
                var trimmedDsc = dscText.innerHTML.substr(0, 30) + '...';
                dscText.innerHTML = trimmedDsc;
                dscText.classList.add("hide");

                toggleBtn.addEventListener("click", function(event) {
                    toggleDescription(event, id);
                });
            }
        }
    };
</script>