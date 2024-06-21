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
            <ul class="nav nav-tabs">
                <li role="regulasi" class="active"><a href="#regulasi">Regulasi</a></li>
                <li role="news"><a href="#news">News</a></li>
            </ul>
            <div id="reg"> regulasi</div>
            <div id=" news"> newsi</div>

            <!-- loopping nya disini -->
            <?php

            foreach ($data['regulasi'] as $datax) {
                $title = $datax['title'];
                $dsc = $datax['keterangan'];
                $id = $datax['id'];
                $dt = $datax['create_date'];
                if (!$dsc) {
                    $dsc = "tidak ada keterangan";
                }

            ?>

                <div class=" panel-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="row col-md-12" style="box-shadow: rgba(0, 0, 0, 0.18) 0px 2px 4px;">
                                <div class="col-md-2 col-sm-4 col-xs-6 " style="margin: 3px;">
                                    <img src="<?= base_url('themes/upload/news/x.jpg'); ?>" width="100" height="100" title="">
                                </div>
                                <div class="col-md-9 col-sm-6 col-xs-12" style="margin-top: 10px;">
                                    <span style="font-weight: bold; font-size: large;"> <?= $title ?></span> <br>
                                    <i>Dipublikasi pada <?= $dt ?></i>
                                </div>
                                <div>
                                    <a style=" margin-top: 20px;box-shadow: rgba(0, 0, 0, 0.18) 0px 2px 4px;" class="btn btn-default text-center" href="#">
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