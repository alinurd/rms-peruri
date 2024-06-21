<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-sm-8 panel-heading">
                <h3 style="padding-left:10px;">News Detail</h3>
            </div>
            <div class="col-sm-4" style="text-align:right">
                <ul class="breadcrumb">
                    <li> <a href="#"> <i class="fa fa-home"></i> Home</a></li>
                    <li><a href="<?= base_url(_MODULE_NAME_REAL_ . '/news'); ?>">News</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- $xx= anchor_popup($pbaru, $isi, $atts); -->

<section id=" main-content">
    <section class="wrapper site-min-height">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row col-md-12" style="text-align: center; box-shadow: rgba(0, 0, 0, 0.18) 0px 2px 4px;">
                            <br> <span style="font-weight: bold; font-size: large; "><u><?= $title ?></u> </span>  <br><br>
                            <div class="col-md-6 col-sm-12 col-xs-6 " style="margin: 3px; left:25%;">
                                <img src="<?= base_url('themes/upload/news/' . $photo); ?>" width="100%" height="100%" title="">
                            </div>
                            <div class="col-md-9 col-sm-6 col-xs-12" style="text-align: left; font-size:15px; margin:10px; left:10%;">
                                <span><br>
                                    <?= $content ?>
                                </span><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div>&nbsp;&nbsp;</div>
            </div>
    </section>
</section>