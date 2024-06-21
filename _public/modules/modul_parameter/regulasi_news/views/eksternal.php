<div class="row">
    <div class="col-md-12">
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

<section id="main-content">
    <section class="wrapper site-min-height">
        <div class="panel panel-default">
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
                                    <img src="<?= base_url('themes/file/regulasi/' . $datax['poto']); ?>" width="100" height="100" title="">
                                </div>
                                <div class="col-md-9 col-sm-6 col-xs-12" style="margin-top: 10px;">
                                    <span style="font-weight: bold; font-size: large;"> <?= $title ?></span> <br>
                                    <i>Dipublikasi pada <?= $dt ?></i>
                                </div>
                                <div>
                                    <!-- <a href="<?php echo base_url('downloadcontroller/downloadfile'); ?>">Klik di sini untuk mengunduh file</a> -->
                                    <!-- <a href="<?= base_url(_MODULE_NAME_REAL_ . '/' . _METHOD_ . '/' . $parent['id']); ?>" class="btn btn-default" id="btnBack"> Kembali ke List </a> -->

                                    <a style=" margin-top: 20px;box-shadow: rgba(0, 0, 0, 0.18) 0px 2px 4px;" class="btn btn-default text-center" href="<?php echo base_url(_MODULE_NAME_REAL_ . '/downloadfile/' . $datax['id']); ?>">
                                        <span style="display: inline-block; text-align: center;">
                                            <i class="glyphicon glyphicon-download-alt"></i>
                                        </span>
                                    </a>

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
