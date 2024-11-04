<script type="text/javascript">
$(function() {
	$("form#form_delete").submit(function(e){
		var ff = this;
		var jml=$('input[name="check_item[]"]:checked').length;
		var checked = $('input[name="check_item[]"]:checked').length > 0;
		var ket = "<?php echo lang('msg_del_confirm'); ?>";
		$(".delete").addClass('disabled');
		if(checked) {
			e.preventDefault();
			$('p.question').html(ket.replace("#jml#",jml));
			$('#confirm_all').modal('show');
			$(".delete").removeClass('disabled');
			$('#confirm_del_all').on('click', function(){
				looding('light',$("#confirm_all").find(".modal-dialog"));
				ff.submit();
			});
		} else {
			pesan_toastr("pilih dahulu data yang akan di hapus yaaaassss","err","Admin","toast-top-center");
			$(".delete").removeClass('disabled');
			return false;
		}
	});
	loadTable("<?php echo base_url($url_data_table); ?>",Globals.nil_combo);
});

function cetak_lap(tipe)
{
	var url='<?php echo base_url($this->_Snippets_['modul']); ?>/cetak?tipe='+tipe;
	window.open(url);
}
</script>
<?php
	$qs="";
	if ($this->_Snippets_['jml_search']>0)
	{$qs=" [".$this->_Snippets_['jml_search']."]";}

	$judul=lang("msg_title");
	$judul= (!empty($judul)) ? $judul:ucwords(_MODULE_NAME_);
?>

<?php
	$info="";
	$sts_input="";
	if ($this->session->userdata('result_proses')){
		$info = $this->session->userdata('result_proses');
		$this->session->set_userdata(array('result_proses'=>''));
		$sts_input="success";
	}elseif ($this->session->userdata('result_proses_error')){
		$info =  $this->session->userdata('result_proses_error');
		$this->session->set_userdata(array('result_proses_error'=>''));
		$sts_input="err";
	}
?>	
<script>
	$(function() {
		var err="<?php echo $info;?>";
		var sts="<?php echo $sts_input;?>";
		if (err.length>0)
			pesan_toastr(err,sts);
	});
</script>
<?php echo form_open(base_url($this->_Snippets_['modul']."/delete"),array('id'=>'form_delete'));?>

<div class="row">
	<div class="col-xs-12" id="scrollingDiv">
		<div class="x_panel">
			<div class="x_title">
			
		
			</div>
			 <div class="x_content">
		<?php 
			$sts = $this->authentication->get_Privilege("icon_tombol");
			$txt_searc="";
			$txt_clear="";
			if ($sts){
				$txt_searc = lang("msg_tombol_search");
				$txt_clear = lang("msg_tombol_clear_search");
			}
			
			if (isset($master['setSearchprivilege'])) {
				if ($master['setSearchprivilege'] ) { ?>
					<?php if (intval($this->_Snippets_['jml_search'])>0){ ?>
						<a class="add btn btn-warning pull-right" href="<?php echo base_url($this->_Snippets_['modul']);?>?cs=1" data-content=" Clear Search "> <?=lang("msg_tombol_clear_search");?></a>
					<?php } ?>
					<button type="button" class="btn btn-success btn-flat pull-right" data-content="Cari Data" data-toggle="modal" data-target="#mySearch" style="margin-right:5px;"><strong> <i class="fa fa-search"></i> <?=$txt_searc;?></strong></button> 
				<?php
				} 
			}
		
		foreach($action as $key=>$tombol)
		{
			if ($key=='add' && $privilege['add']=='1')
				echo $tombol;
			elseif ($key=='del' && $privilege['delete']=='1')
				echo $tombol;
			elseif ($key=='print' && $privilege['cetak']=='1')
				echo $tombol;
			elseif ($key=='res')
				if ($this->uri->segment(1) == 'rcsa') {
					echo $tombol;
				}
			elseif ($key=='other'){
				if (is_array($tombol)){
					if (array_key_exists('right', $tombol)){
						foreach($tombol['right'] as $tbl){
							echo '&nbsp;&nbsp;' . $tbl;
						}
					}
					
					if (array_key_exists('left', $tombol)){
						foreach($tombol['left'] as $tbl){
							echo '&nbsp;&nbsp;' . $tbl;
						}
					}
				}else{
					echo '&nbsp;&nbsp;' . $tombol;
				}
			}
		}
		?>
		</div>
		</div>
	</div>
</div>
	<div id="alert_top"></div>
	
<div class="x_panel">
	<div class="x_title">
			
	</div>
	<div class="x_content">
		
		<?php if (isset($master['alert'])){ 
		$hide = "";
		if (empty($master['alert']['title']))
			$hide = "hide";
		?>
		<div class="alert <?=$master['alert']['type'];?> alert-dismissible color-palette">
			<button class="close" type="button" data-dismiss="alert" aria-hidden="true">×</button>
			<h4 class="<?=$hide;?>"><i class="icon fa fa-warning"></i><?=$master['alert']['title'];?></h4>
			<?=$master['alert']['content'];?>
		</div>
		<?php }
		if (count($master['ket_search'])>0) { ?>
		<div class="row" style="margin-bottom:20px;">
			<div class="col-xs-12">
				<?=lang("msg_filter_by");?> :<br/>
				<?php
				foreach ($master['ket_search'] as $row){
					?>
					<span class="label label-success"><?=$row['text'];?></span> :
					<span class="label label-warning"><?=$row['value'];?></span>&nbsp;&nbsp;&nbsp;
					<?php
				}
				?>
				<a href="<?php echo base_url($this->_Snippets_['modul']);?>?cs=1" data-content="Clear Search"> 
				<span class="glyphicon glyphicon-remove-circle pointer" style="top:5px;color:red;font-size:16px;" data-content=" Clear Search "></span></a>
			</div>
		</div>
		<?php } ?>
		<div class="table-responsive adv-table">
			<table class="table table-bordered table-striped table-hover dataTable data table-small-font dt-responsive" width="100%" id="datatables" style="font-size:<?=$master['attrTable']['size'];?>;">
				<thead>
					<tr>
						<th style="width:1% !important;" class="no" colspan="0">
							<input type="checkbox" id="check_all_master" class="apa" target='check_item[]' style="padding:0;height:0px;"></th>
						<?php
							foreach($master['title'] as $key=>$data)
							{
								$show=true;
								if (array_key_exists(5,$data))
									$show = $data[5];
								
								if ($show){
									$title=$data[2];
									$align='left';
									if (array_key_exists('4', $data)){
										if (!empty($data[4]))
											$align=$data[4];
									}else{
										foreach($this->tmp_data['fields'] as $key2=>$fld)
										{
											if ($fld['field']==$data[1] && $fld['nmtbl']==$data[0]){
												if (array_key_exists('input',$fld)){
													$type=$fld['input']['input'];
													switch ($type){
														case 'int':
														case 'integer':
														case 'intdot':
														case 'integerdot':
														case 'float':
															$align='right';
															break;
														default:
															$align='left';
															break;
													}
												}
												break;
											}
										}
									}
								
							?>
								<th align="<?php echo $align;?>" style="width:<?php echo (array_key_exists('3',$data)) ? $data[3]:'0';?>% !important;text-align:<?php echo $align;?>" ><?php echo $title;?></th>
							<?php
								}
							}
						if (isset($master['setActionprivilege'])) {
							if ($master['setActionprivilege'] ) {
						?>
						<th style="width:<?=$master['action_width']['size'];?>% !important;" class="no text-<?=$master['action_width']['align'];?>" colspan="0" id="ck"><?php echo lang('msg_aksi');?></th>
						<?php
						}
						}
						?>
					</tr>
				</thead>
				
				<tfoot>
					<tr>
						<th style="width:1% !important;" class="no" colspan="0">
							<input type="checkbox" id="check_all_master" target='check_item[]' style="padding:0;height:0px;"></th>
						<?php
							foreach($master['title'] as $key=>$data)
							{
								$show=true;
								if (array_key_exists(5,$data))
									$show = $data[5];
								
								if ($show){
									$title=$data[2];
									$align='left';
									if (array_key_exists('4', $data)){
										if (!empty($data[4]))
											$align=$data[4];
									}else{
										foreach($this->tmp_data['fields'] as $key2=>$fld)
										{
											if ($fld['field']==$data[1] && $fld['nmtbl']==$data[0]){
												if (array_key_exists('input',$fld)){
													$type=$fld['input']['input'];
													switch ($type){
														case 'int':
														case 'integer':
														case 'intdot':
														case 'integerdot':
														case 'float':
															$align='right';
															break;
														default:
															$align='left';
															break;
													}
												}
												break;
											}
										}
									}
								
							?>
								<th align="<?php echo (array_key_exists('4',$data)) ? $data[4]:'left';?>" style="width:<?php echo (array_key_exists('3',$data)) ? $data[3]:'0';?>% !important;text-align:<?php echo $align;?>" ><?php echo $title;?></th>
							<?php
								}
							}
						if (isset($master['setActionprivilege'])) {
							if ($master['setActionprivilege'] ) {
						?>
						<th style="width:10% !important;" class="no" colspan="0" id="ck"><?php echo lang('msg_aksi');?></th>
						<?php
						}
						}
						?>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<div class="overlay hide" id="overlay">
		<i class="fa fa-refresh fa-spin"></i>
	</div>
</div>
<?php echo form_close();?>

<!-- Modal -->

<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true" style="display:none">
  <div class="modal-dialog modal-sm">
    <div class="modal-content modal-question">
      <div class="modal-header"><h4 class="modal-title"><?php echo lang('msg_del_header');?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <p class="question"><?php echo lang('msg_del_title');?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('msg_del_cancel');?></button>
        <button type="button" class="btn btn-danger btn-grad" id="confirm"><?php echo lang('msg_del_delete');?></button>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-default" id="mySearch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
  <?php echo form_open($this->uri->uri_string,array('id'=>'form_input_search','role'=>'form"'));?>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Search <?=$judul;?></h4>
      </div>
      <div class="modal-body">
		<?php echo $search;?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="proses_searc" ><i class="fa fa-search"></i> Search</button>
		<a class="add btn btn-warning btn-sm btn-grad" href="<?php echo base_url($this->_Snippets_['modul']);?>?cs=1" title="Clear Search"><i class="fa fa-trash"></i> Clear Search</a>
      </div>
	  <div class="overlay hide" id="overlay_search">
		<i class="fa fa-refresh fa-spin"></i>
	</div>
    </div>
	<?php echo form_close();?>	
  </div>
</div>

<div class="modal fade" id="confirm_all" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true" style="display:none">
  <div class="modal-dialog modal-sm">
    <div class="modal-content modal-question">
      <div class="modal-header"><h4 class="modal-title"><?php echo lang('msg_del_header');?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <p class="question"><?php echo lang('msg_del_title');?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('msg_del_cancel');?></button>
        <button type="button" class="btn btn-danger btn-grad" id="confirm_del_all"><?php echo lang('msg_del_delete');?></button>
      </div>
    </div>
  </div>
</div>


<script>
	
	$(function() {

		$('body').on('shown.bs.modal', '.modal', function() {
  $(this).find('select').each(function() {
    var dropdownParent = $(document.body);
    if ($(this).parents('.modal.in:first').length !== 0)
      dropdownParent = $(this).parents('.modal.in:first');
	
    $(this).select2({
      dropdownParent: dropdownParent
    });
	$(this).css('width', '100%');
  });

});
	 

    // Fungsi submit form
    $("form#form_input_search").submit(function(event){
        // event.preventDefault(); // Mencegah submit form default
        looding("light", $("#mySearch").find(".modal-content"));
        // Anda bisa melakukan tindakan submit form disini jika diperlukan
        // $(this).off('submit').submit();
    });

    // Penyesuaian margin
    $("#datatables_filter").css('margin-right', '5px');

	// $("#resetBtn").click(function () {
	// 	// Array untuk menyimpan nilai checkbox yang dipilih
	// 	let selectedValues = [];

	// 	// Loop setiap checkbox yang dipilih dan ambil nilainya
	// 	$('input[name="check_item[]"]:checked').each(function () {
	// 	selectedValues.push($(this).val());
	// 	});

	// 	console.log(selectedValues);

	// 	// Tampilkan nilai checkbox yang dipilih di dalam modal
	// 	// $(".modal-body").html(selectedValues.join("<br>"));
	// 	// $("#modalUpdate").modal('show');
	// 	$("#modal_general").find(".modal-body").html(selectedValues.join("<br>"));
	// 	$("#modal_general").find(".modal-title").html("Reset Drafting Register");
	// 	$("#modal_general").modal("show");
	// });
	//  // / Event listener untuk elemen <li> dengan kelas "reset pointer"
	//  $("li.reset.pointer").click(function () {

	// 	// $("#modal_general").find(".modal-body").html(selectedValues.join("<br>"));
	// 	$("#modal_general").find(".modal-title").html("Reset Drafting Register");
	// 	$("#modal_general").modal("show");
	// });
});


</script>
