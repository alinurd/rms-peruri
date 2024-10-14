<?php
$hide_edit = '';
$sts_risk = intval($parent['sts_propose']);
if ($sts_risk >= 1) {
	$hide_edit = ' hide ';
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-sm-6 panel-heading">
                <h3 style="padding-left:10px;"><?= lang('msg_title'); ?></h3>
            </div>
            <div class="col-sm-6" style="text-align:right">
                <ul class="breadcrumb">
                    <li> <a href="<?= base_url(); ?>"> <i class="fa fa-home"></i> Home</a></li>
                    <li><a href="<?= base_url(_MODULE_NAME_REAL_); ?>"><?= _MODULE_NAME_; ?></a></li>
                    <li><a><?= lang('msg_title'); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <section class="x_panel">
            <div class="x_title">
                <strong>Assesment : <?= strtoupper($parent['name']); ?></strong>
                <ul class="nav navbar-right panel_toolbox">
                    <li class="pull-right"><a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content" style="overflow-x: auto;">
                <table class="table">
                    <tr><td width="20%"><em>Risk Owner</em></td><td><?= $parent['name']; ?></td></tr>
                    <tr><td><em>Risk Agent</em></td><td><?= $parent['officer_name']; ?></td></tr>
                    <tr><td><em>Periode</em></td><td><?= $parent['periode_name']; ?></td></tr>
                    <tr><td><em>Anggaran RKAP</em></td><td><?= number_format($parent['anggaran_rkap']); ?></td></tr>
                </table>
            </div>
        </section>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <span id="add_peristiwa" class="btn btn-primary <?= $hide_edit; ?> pointer" data-id="0" data-rcsa="<?=$parent['id'];?>" data-rcsa="<?=$parent['id'];?>" data-rcsa="<?=$parent['id'];?>"> <?= lang('msg_tombol_add'); ?> </span>&nbsp;&nbsp;
        <button class="btn btn-success pull-right" data-id="<?= $parent['id']; ?>" data-owner="<?=$parent['owner_no'];?>" id="cmdRisk_Register"> <?= lang('msg_field_risk_register'); ?> </button>
        <a href="<?= base_url(_MODULE_NAME_REAL_); ?>" class="btn btn-default"> Kembali ke List </a>

        <h3><?= lang('msg_sub_title'); ?></h3>
        <h5 class="text-warning"><strong><?= $parent['name']; ?></strong></h5>
    </div>
    <aside class="col-md-12 col-sm-12 col-xs-12">
        <section class="x_panel">
            <div class="x_content" id="list_peristiwa">
                <?=$list;?>
            </div>
        </section>
    </aside>
</div>

<div class="modal modal-default" id="peristiwa_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Title</h4>
      </div>
      <div class="modal-body">
		
      </div>
	  <div class="overlay hide" id="overlay_search">
		<i class="fa fa-refresh fa-spin"></i>
	</div>
    </div>
  </div>
</div>