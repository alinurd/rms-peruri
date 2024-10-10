<?=form_open_multipart(base_url(_MODULE_NAME_REAL_.'/'._METHOD_.'/save'), array('id' => 'form_realisasi'), ['id_edit'=>$edit_no, 'rcsa_no'=>$rcsa_no, 'detail_rcsa_no'=>$rcsa_detail_no]);?>
<div class="col-md-12 col-sm-12 col-xs-12" id="input_realisasi">
	<section class="x_panel">
		<div class="x_footer">
			<ul class="nav navbar-right panel_toolbox">
<!-- 				<li><span class="btn btn-primary pointer" id="simpan_realisasi"> Simpan </span></li>
				<li><span class="btn btn-info pointer" id="close_input_realisasi"  > Cancel </span></li> -->
			</ul>
			<div class="clearfix"></div>
		</div>
		<?php 
		$a=date("m");
		$b=date("y");
		// $a="5";
		// $b="20";
		$hoho=array();
		$status=array();
		foreach ($cek as $key => $row) {
			$bb = $row['create_date'];
			$time=strtotime($bb);
			$month=date("m",$time);
			$year=date("y",$time);
			$hoho[]=array('bulan'=>$month,'tahun'=>$year);
			// $hoho[]=array('bulan'=>$month);
			// var_dump($hoho);
			// die();
			if ($year != $b) {
				$status[]=TRUE;
			}
			else{
				if ($month != $a) {
					$status[]=TRUE;
				 }else{
				$status[]=FALSE;
				}
			}
		}
		// var_dump($status);
		// var_dump($id);
		 ?>
        <hr>
		<div class="x_content">
			<div class="table-responsive">
                <?php
                foreach($realisasi as $key=>$row){ ?>
                <div class="col-md-3 col-sm-3 col-xs-3 mitigasi_<?=$key;?> <?=($row['show'])?'':'hide';?>"><?=$row['label']?></div>
                <div class="col-md-9 col-sm-9 col-xs-9 mitigasi_<?=$key;?> <?=($row['show'])?'':'hide';?>"><div class="form-group form-inline"><?=$row['isi']?></div></div>
                <?php } ?>
			</div>
		</div>
        <hr>
		<div class="x_footer">
			<ul class="nav navbar-right panel_toolbox">
<?php if ($id != 0) : ?>
	<li><span class="btn btn-primary pointer" id="simpan_realisasi"> Simpan </span></li>
<?php elseif(!in_array(FALSE, $status)) : ?>
	<li><span class="btn btn-primary pointer" id="simpan_realisasi"> Simpan </span></li>
<?php else: ?>
	<li><span class="btn btn-primary pointer" id="simpan_realisasi"> Simpan </span></li>
<?php endif; ?>
				<li><span class="btn btn-info pointer" id="close_input_realisasi" > Cancel </span></li>
			</ul>
			<div class="clearfix"></div>
		</div>
	</section>
</div>
<?=form_close();?>
