<?php
	$field=$detail_barang['field'];
	$info="";
	$sts_input="";
	$info_error="";
	if (validation_errors()){
		$info_error= validation_errors();
		$sts_input='danger';
	}elseif ($this->session->userdata('result_proses_error')){
		$info_error =  $this->session->userdata('result_proses_error');
		$this->session->set_userdata(array('result_proses_error'=>''));
		$sts_input='danger';
	}
	
	if ($this->session->userdata('result_proses')){
		$info = $this->session->userdata('result_proses');
		$this->session->set_userdata(array('result_proses'=>''));
		$sts_input='info';
	}
	
	$total_payment=floatval($field['tagihan'])-floatval($field['disk'])+floatval($field['ppn']);
?>
<script>
	$(function() {
		var err="<?php echo $info;?>";
		var sts="<?php echo $sts_input;?>";
		if (err.length>0)
			pesan_toastr(err,sts);
	});
</script>


<?php echo form_open_multipart(base_url("pembelian/simpan"),array('menthod'=>'POST','id'=>'simpan_data','class'=>'form-horizontal','role'=>'form'));?>
<div class="row">
	<div class="col-lg-12" id="scrollingDiv">
		<section class="panel" style="margin-bottom:10px;">
			<div class="panel-body" style="padding:5px;">
				<button class="delete btn btn-success btn-flat" data-content="Save" data-toggle="popover" name="l_save" value="Simpan" type="submit" data-original-title="" title="">
					<i class="fa fa-floppy-o"></i> &nbsp;Save
				</button>
				<?php if ($mode=="edit"){ ?>
					<a class="add btn btn-primary btn-flat" data-content="Add New Data" data-toggle="popover" href="<?php echo base_url('pembelian');?>" data-original-title="" title="">
						<i class="fa fa-plus"></i>&nbsp; Add
					</a>
				<?php } ?>
				<span class="tools pull-right">
					<h3 style="margin:0px;" id="display_ttl">Rp. <?php echo number_format($field['tagihan']);?>,-</h3>
				</span>
			</div>
		</section>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<header class="panel-heading">
			  <span id="title_pembelian">Transaksi Pembelian dari Supplier : <span class="text-primary"><?php echo $field['supplier_name'];?></span> | Tanggal : <span class="text-primary"><?php echo date('d-m-Y',strtotime($field['tanggal']));?></span></span>
				<span class="tools pull-right">
					<a class="fa fa-chevron-down" href="javascript:;"></a>
				</span>
			</header>
			<div class="panel-body padding-5">
				<div class="row">
					<div class="col-lg-6">
						<section class="panel">
							<div class="panel-body no-padding">
								<div class="form-group padding-bottom-5">
									<label for="inputEmail1" class="col-lg-3 control-label">Factur : </label>
									<?php echo form_input('faktur',$field['faktur']," class='col-lg-9 form-control' required style='width:30% !important;' id='faktur' ");?>
								</div>
								<div class="form-group padding-bottom-5">
									<label for="inputEmail1" class="col-lg-3 control-label">Supplier : </label>
									<?php echo form_input('supplier_name',$field['supplier_name']," class='col-lg-9 form-control' required style='width:60% !important;' id='supplier_name' ");?>
									<span class="input-group-addon" id="browse_supplier" style="cursor:pointer;width:0;border:2px solid #ccc;" title="Browse Supplier">....</span>
									<input type="hidden" name="tagihan" id="tagihan" value="<?php echo $field['tagihan'];?>">
									<input type="hidden" name="mode" id="mode" value="<?php echo $mode;?>">
									<input type="hidden" name="id_edit" id="id_edit" value="<?php echo $field['id'];?>">
									<input type="hidden" name="supplier_no" id="supplier_no" value="<?php echo $field['supplier_no'];?>">
								</div>
								<div class="form-group padding-bottom-5">
									<label for="inputEmail1" class="col-lg-3 control-label">Transaction Date : </label>
									<?php echo form_input('tgl', date('d-m-Y')," id='tgl' class='col-lg-9 form-control datepicker' style='width:130px;' ");?>
								</div>
							</div>
						</section>
					</div>
					<div class="col-lg-6">
						<section class="panel">
							<div class="panel-body no-padding">
								<div class="form-group padding-bottom-5">
									<label for="inputEmail1" class="col-lg-3 control-label">Payment Type : </label>
									<?php echo form_dropdown('type_bayar', array('1'=>'Cash','2'=>'Transfer','3'=>'Check','4'=>'Giro'), $field{'type_bayar'},"id='type' class='form-control' style='width:auto;'");?>
								</div>
								<div class="form-group padding-bottom-5">
									<label for="inputEmail1" class="col-lg-3 control-label">Description : </label>
									<?php echo $content= form_textarea('keterangan',$field['keterangan']," maxlength='255' size='100' class='form-control ' rows='2' cols='5' style='overflow: hidden; width: 510px; height: 104px;' ");?>
								</div>
							</div>
						</section>
					</div>
				</div>
			</div>
		</section>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
	  <section class="panel">
		  <div class="panel-body">
			 <div class="form-group">
					<label for="inputEmail1" class="col-lg-2 col-sm-4 control-label">Product Name : </label>
					<input type="text" id="barang_no" class="col-lg-10 form-control"  placeholder="nama barang" style="width:70% ! important;">
					<span class="input-group-addon" id="browse_barang" style="cursor:pointer;width:0;border:2px solid #ccc;" title="Browse Barang">....</span>
				</div>
			  <section id="unseen">
			  <div class="table-responsive">
				<table id="tbl_pembelian" class="table table-bordered table-striped table-condensed">
				  <thead>
				  <tr>
					  <th width="4%">Code</th>
					  <th>Product Name</th>
					  <th width="12%">Cost</th>
					  <th width="8%">Disc(%)</th>
					  <th width="12%">Price</th>
					  <th width="8%">Qty.</th>
					  <th width="12%">Total</th>
					  <th width="6%">Action</th>
				  </tr>
				  </thead>
				  <tbody>
				  <?php 
					if ($mode=="error" || $mode=="new"){
						foreach($field['id_edit_detail'] as $key=>$row){
							$id_edit = form_hidden('id_edit_detail',$field['id_edit_detail'][$key]);
							$id_barang = form_hidden('id_barang',$field['id_barang'][$key]);
							$kd_barang = form_hidden('kd_barang',$field['kd_barang'][$key]);
							$nm_brg = form_hidden('nm_brg',$field['nm_brg'][$key]);
							$disc = form_input('disc[]',$field['disc'][$key]," class='form-control text-center' onkeyup='cari_total()' style='width:100% !important'");
							$price = form_input('price[]',$field['price'][$key]," class='text-right form-control' style='width:100% !important;'");
							$qty = form_input('qty[]',$field['qty'][$key]," class='form-control text-center' style='width:100% !important;'");
							$total = form_input('total[]',$field['total']," class='form-control text-right' style='width:100% !important;'");
							?>
							<tr>
								<td width="4%"><?php echo $field['kd_barang'][$key];?></td>
								<td><?php echo $field['nm_brg'][$key];?></td>
								<td width="12%"><?php echo $field['cost'][$key].$id_edit.$id_barang.$kd_barang.$nm_brg.$satuan;?></td>
								<td width="8%"><?php echo $disc;?></td>
								<td width="12%"><?php echo $price;?></td>
								<td width="8%"><?php echo $qty;?></td>
								<td width="12%"><?php echo $total;?></td>
								<td width="6%"><span style="cursor:pointer;" onclick="remove_transaksi(this,0)"><i class="fa fa-cut text-primary" title="menghapus data" id="sip"></i></span</td>
							</tr>
							<?php
						}
					}elseif($mode=="edit"){
						foreach($detail_barang['detail'] as $key=>$row){
							$id_edit = form_hidden('id_edit_detail[]',$row['id']);
							$id_barang = form_hidden('id_barang[]',$row['barang_no']);
							$kd_barang = form_hidden('kd_barang[]',$row['sku']);
							$nm_brg = form_hidden('nm_brg[]',$row['nama_barang']);
							$satuan = form_hidden('satuan[]',$row['satuan']);
							$modal = form_input('cost[]',number_format($row['modal'])," class='form-control text-center' onkeyup='cari_total()' style='width:100% !important'");
							$disc = form_input('disc[]',$row['disc']," class='form-control text-center' onkeyup='cari_total()' style='width:100% !important'");
							$price = form_input('price[]',number_format($row['harga_jual'])," class='text-right form-control' readonly='' style='width:100% !important;'");
							$qty = form_input('qty[]',$row['qty']," onkeyup='cari_total()'  class='form-control text-center' style='width:100% !important;'");
							$ttl=(intval($row['qty']) * floatval($row['modal'])) - (intval($row['qty']) * floatval($row['modal']) * intval($row['disc'])/100);
							$total = form_input('total[]',number_format($ttl)," class='form-control text-right' style='width:100% !important;' readonly=''");
							?>
							<tr>
								<td width="4%"><?php echo $row['sku'];?></td>
								<td><?php echo $row['nama_barang'];?></td>
								<td width="12%"><?php echo $modal.$id_edit.$id_barang.$kd_barang.$nm_brg.$satuan;?></td>
								<td width="8%"><?php echo $disc;?></td>
								<td width="12%"><?php echo $price;?></td>
								<td width="8%"><?php echo $qty;?></td>
								<td width="12%"><?php echo $total;?></td>
								<td width="6%"><span style="cursor:pointer;" onclick="remove_transaksi(this,0)"><i class="fa fa-cut text-primary" title="menghapus data" id="sip"></i></span</td>
							</tr>
							<?php
						}
					}
				  ?>
					<tr>
						<td colspan="6" class="text-right margin-5 padding-5">Sub Total</td>
						<td class="margin-5 padding-5"><?php echo form_input('gsubtotal',$field['tagihan'],' id="gsubtotal" readonly="" class="form-control text-right" style="width:100% !important;"');?></td>
						<td class="margin-5 padding-5">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="6" class="text-right margin-5 padding-5">Discount</td>
						<td class="margin-5 padding-5"><?php echo form_input('gdisc',$field['disk'],' id="gdisc" class="form-control text-right" style="width:100% !important;"');?></td>
						<td class="margin-5 padding-5">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="6" class="text-right margin-5 padding-5">PPN</td>
						<td class="margin-5 padding-5"><?php echo form_input('gppn',$field['ppn'],' id="gppn" class="form-control text-right" style="width:100% !important;"');?></td>
						<td class="margin-5 padding-5">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="6" class="text-right margin-5 padding-5">Total Invoice</td>
						<td class="margin-5 padding-5"><?php echo form_input('gtotal',$total_payment,' id="gtotal" readonly="" class="form-control text-right" style="width:100% !important;"');?></td>
						<td class="margin-5 padding-5">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="6" class="text-right margin-5 padding-5">Payment</td>
						<td class="margin-5 padding-5"><?php echo form_input('gpayment',$field['payment'],' id="gpayment" class="form-control text-right" style="width:100% !important;"');?></td>
						<td class="margin-5 padding-5">&nbsp;</td>
					</tr>
				</tbody>
				 
			  </table>
			  </div>
			  </section>
		  </div>
	  </section>
  </div>
</div>
<?php echo form_close();?>

 <!-- Modal -->
 
 <div class="modal fade top-modal-without-space" id="myBrowse" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
		  <div class="modal-content-wrap">
			  <div class="modal-content">
				  <div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					  <h4 class="modal-title">BROWSE</h4>
				  </div>
				  <div class="modal-body">

					  Body goes here...

				  </div>
				  <div class="modal-footer">
					  <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
				  </div>
			  </div>
		  </div>
	  </div>
  </div>

<div class="modal fade" id="confirmSave" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true" style="display:none">
  <div class="modal-dialog modal-sm">
    <div class="modal-content modal-question">
      <div class="modal-header"><h4 class="modal-title"><?php echo lang('msg_save_header');?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <p class="question"><?php echo lang('msg_save_title');?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('msg_save_batal');?></button>
        <button type="button" class="btn btn-danger btn-grad" id="confirm"  data-dismiss="modal"><?php echo lang('msg_save_proses');?></button>
      </div>
    </div>
  </div>
</div>

<script>
	var asal_tmp=0;
	$(function () {
		$("#supplier_name").autocomplete({
			serviceUrl: "<?php echo base_url('pembelian/search_suggestions_supplier'); ?>",
			onSelect: function (suggestion) {
				$("#supplier_no").val(suggestion.id);
				var tgl= $("#tgl").val();
				$("#title_pembelian").html("Transaksi Pembelian dari Supplier : <span class='text-primary'>" + suggestion.value + "</span> | Tanggal : <span class='text-primary'>" + tgl + "</span>");
			},
			onSearchStart: function (query) {
				$("#supplier_no").val("");
				$("#title_pembelian").html("Pembelian");
				$(this).addClass('spinner');
			},
			onSearchError: function (query, jqXHR, textStatus, errorThrown) {
				$("#supplier_no").val("");
				$("#title_pembelian").html("Pembelian");
			} ,
			onInvalidateSelection: function () {
				$("#supplier_no").val("");
				$("#title_pembelian").html("Pembelian");
			},
			onSearchComplete: function (query, suggestions) {
			   $(this).removeClass('spinner');
		   }
		});
		
		$("#barang_no").autocomplete({
			serviceUrl: "<?php echo base_url('pembelian/search_suggestions_barang'); ?>",
			onSelect: function (suggestion) {
				asal_tmp=1;
				add_install(suggestion.id, suggestion.sku,suggestion.nama_barang,suggestion.satuan,suggestion.harga_beli,suggestion.harga_jual,1,0);
				$(this).val(''); 
				$(this).focus();
				return false;
			},
			onSearchStart: function (query) {
				$(this).addClass('spinner');
			},
			onSearchComplete: function (query, suggestions) {
			   $(this).removeClass('spinner');
		   }
		});
		
		$("#tgl").change(function(){
			var tgl= $(this).val();
			var sup= $("#supplier_name").val();
			
			$("#title_pembelian").html("Transaksi Pembelian dari Supplier : <span class='text-primary'>" + sup + "</span> | Tanggal : <span class='text-primary'>" + tgl + "</span>");
		});
		
		$("#browse_supplier").click(function(){
			$('body').addClass('loading');
			$.ajax({
			
				url:"<?php echo base_url('pembelian/get_supplier');?>",
				success:function(msg){
					$('body').removeClass('loading');
					$('#myBrowse').find('.modal-body').html(msg);
					$("#myBrowse").modal("show");
				},
				failed: function(msg){
					$('body').removeClass('loading');
					alert("gagal");
				},
			});
		})
		
		$("#browse_barang").click(function(){
			$('body').addClass('loading');
			$.ajax({
				url:"<?php echo base_url('pembelian/get_barang');?>",
				success:function(msg){
					$('body').removeClass('loading');
					$('#myBrowse').find('.modal-body').html(msg);
					$("#myBrowse").modal("show");
				},
				failed: function(msg){
					$('body').removeClass('loading');
					alert("gagal");
				},
			});
		})
	})
	
	function cari_total(){
		var ttl=0;
		var gttl=0;
		var nil=0;
		var names=document.getElementsByName('nm_brg[]');

		for(key=0; key < names.length; key++)  {
			cost = document.getElementsByName("cost[]")[key];
			disc = document.getElementsByName("disc[]")[key];
			jml = document.getElementsByName("qty[]")[key];
			ttl = parseFloat(cost.value.replace(/,/g,"")) * parseFloat(jml.value);
			disc = ttl * disc.value/100;
			ttl = ttl-disc;
			cost.value=accounting.formatMoney(parseFloat(cost.value.replace(/,/g,"")));
			jml_ttl = document.getElementsByName("total[]")[key].value=accounting.formatMoney(ttl);
			gttl += parseFloat(ttl);
		};
		
		$("#gsubtotal").val(accounting.formatMoney(gttl));
		
		var subttl=parseFloat($("#gsubtotal").val().replace(/,/g,""));
		var disk=parseFloat($("#gdisc").val().replace(/,/g,""));
		var ppn=parseFloat($("#gppn").val().replace(/,/g,""));
		
		var total = subttl - disk - ppn;
		$("#gtotal").val(accounting.formatMoney(total));
		$("#gdisc").val(accounting.formatMoney(disk));
		$("#gppn").val(accounting.formatMoney(ppn));
		
		$("#display_ttl").html("Rp. " + accounting.formatMoney(total));
		$("#tagihan").val(total);
	}
	
	$("#gdisc, #gppn").change(function(){
		var subttl=parseFloat($("#gsubtotal").val().replace(/,/g,""));
		var disk=parseFloat($("#gdisc").val().replace(/,/g,""));
		var ppn=parseFloat($("#gppn").val().replace(/,/g,""));
		
		var total = subttl - disk - ppn;
		$("#gtotal").val(accounting.formatMoney(total));
		$("#gdisc").val(accounting.formatMoney(disk));
		$("#gppn").val(accounting.formatMoney(ppn));
	})
	
	function add_install(id_barang, kd_brg, nm_brg, satuan, cost, price, qty, disc){
			
			var ada=false;
			$('input[name="kd_barang[]"]').each(function(){
				aValue=$(this).val();
				if (kd_brg==aValue) {
					pesan_toastr("Data - " + nm_brg + " - Sudah Terpilih!!!",'err','Warning','toast-top-center');
					// alert("Data - " + nm_brg + " - Sudah Ada!!!")
					ada=true;
					$("#barang_no").val("");
					$("#barang_no").focus();
					return false;
				}
			});	
			if (ada) return false;
			
			var edit = document.createElement("input");
			edit.setAttribute('type',"hidden");
			edit.setAttribute('name',"id_edit_detail[]");
			edit.setAttribute('value',0);
			
			var i_id_barang = document.createElement("input");
			i_id_barang.setAttribute('type',"hidden");
			i_id_barang.setAttribute('name',"id_barang[]");
			i_id_barang.setAttribute('value',id_barang);
			
			var i_kd_barang = document.createElement("input");
			i_kd_barang.setAttribute('type',"hidden");
			i_kd_barang.setAttribute('name',"kd_barang[]");
			i_kd_barang.setAttribute('value',kd_brg);
			
			var i_nm_brg = document.createElement("input");
			i_nm_brg.setAttribute('type',"hidden");
			i_nm_brg.setAttribute('name',"nm_brg[]");
			i_nm_brg.setAttribute('value',nm_brg + " (" + satuan + ") ");
			
			var i_cost = document.createElement("input");
			i_cost.setAttribute('type',"text");
			i_cost.setAttribute('name',"cost[]");
			i_cost.setAttribute('id',"cost");
			i_cost.setAttribute('align',"right");
			i_cost.setAttribute('onkeyup',"cari_total()");
			i_cost.setAttribute('class',"form-control text-right");
			i_cost.setAttribute('style',"width:100% !important");
			i_cost.setAttribute('value',accounting.formatMoney(cost));
			
			var i_price = document.createElement("input");
			i_price.setAttribute('type',"text");
			i_price.setAttribute('align',"right");
			i_price.setAttribute('readonly',"");
			i_price.setAttribute('name',"price[]");
			i_price.setAttribute('id',"price");
			i_price.setAttribute('style',"width:100% !important");
			i_price.setAttribute('class',"form-control text-right");
			i_price.setAttribute('value',accounting.formatMoney(price));
			
			var i_qty = document.createElement("input");
			i_qty.setAttribute('type',"text");
			i_qty.setAttribute('name',"qty[]");
			i_qty.setAttribute('id',"qty");
			i_qty.setAttribute('onkeyup',"cari_total()");
			i_qty.setAttribute('class',"form-control text-center");
			i_qty.setAttribute('style',"width:100% !important;");
			i_qty.setAttribute('value',qty);
			
			var i_disc = document.createElement("input");
			i_disc.setAttribute('type',"text");
			i_disc.setAttribute('align',"right");
			i_disc.setAttribute('name',"disc[]");
			i_disc.setAttribute('onkeyup',"cari_total()");
			i_disc.setAttribute('id',"disc");
			i_disc.setAttribute('class',"form-control text-center");
			i_disc.setAttribute('style',"width:100% !important;");
			i_disc.setAttribute('value',disc);
			
			var i_total = document.createElement("input");
			i_total.setAttribute('type',"text");
			i_total.setAttribute('align',"right");
			i_total.setAttribute('readonly',"");
			i_total.setAttribute('name',"total[]");
			i_total.setAttribute('style',"width:100% !important");
			i_total.setAttribute('class',"form-control text-right");
			i_total.setAttribute('value',accounting.formatMoney(cost));
			
			var theTable= document.getElementById("tbl_pembelian");
			var rl = theTable.tBodies[0].rows.length-5;
			
			var lastRow = theTable.tBodies[0].rows[rl];
			var tr = document.createElement("tr");
			
			if((rl-1)%2==0)
				tr.className="dn_block";
			else
				tr.className="dn_block_alt";
			
			var td1 =document.createElement("TD");
			td1.setAttribute("style","text-align:center;width:10%;");
			var td2 =document.createElement("TD");
			td2.setAttribute("align","left");
			var td3 =document.createElement("TD");
			td3.setAttribute("align","right");
			td3.setAttribute("style","width:12%;");
			td3.appendChild(edit);
			td3.appendChild(i_id_barang);
			td3.appendChild(i_kd_barang);
			td3.appendChild(i_nm_brg);
			td3.appendChild(i_cost);
			var td4 =document.createElement("TD");
			td4.setAttribute("align","right");
			td4.setAttribute("style","width:8%;");
			td4.appendChild(i_disc);
			var td5 =document.createElement("TD");
			td5.setAttribute("align","right");
			td5.setAttribute("style","width:12%;");
			td5.appendChild(i_price);
			var td6 =document.createElement("TD");
			td6.setAttribute("align","right");
			td6.setAttribute("style","width:8%;");
			td6.appendChild(i_qty);
			var td7 =document.createElement("TD");
			td7.setAttribute("align","center");
			td7.setAttribute("style","width:12%;");
			td7.appendChild(i_total);
			var td8 =document.createElement("TD");
			td8.setAttribute("style","text-align:center;width:10%;");
			td8.setAttribute("style","width:6%;");
			
			++rl;
			
			td1.innerHTML=kd_brg ;
			td2.innerHTML=nm_brg + " (" + satuan + ") ";
			
			td8.innerHTML='<span style="cursor:pointer;" onclick="remove_transaksi(this,0)"><i class="fa fa-cut text-primary" title="menghapus data" id="sip"></i></span>';
			
			tr.appendChild(td1);
			tr.appendChild(td2);
			tr.appendChild(td3);
			tr.appendChild(td4);
			tr.appendChild(td5);
			tr.appendChild(td6);
			tr.appendChild(td7);
			tr.appendChild(td8);
			
			theTable.tBodies[0].insertBefore(tr , lastRow);
			cari_total();
		};
		
	function remove_transaksi(t,iddel){
		if(confirm("Are you sure you want to permanently delete this transaction ?\nThis action cannot be undone")){
			var ri = t.parentNode.parentNode.rowIndex;			
			t.parentNode.parentNode.parentNode.deleteRow(ri-1);
			cari_total();
		}
		return false;
	}
	
	$("#barang_no").keydown(function(e){
		// alert(e.keyCode);
		if (e.keyCode == 13 && asal_tmp==0) {
			//$('body').addClass('loading');
			$(this).addClass('spinner');
			var sku=$(this).val();
			var form={'sku':sku};
			$.ajax({
				type: "POST",
				url:"<?php echo base_url('pembelian/get_barang_satuan');?>",
				data:form,
				dataType: 'json',
				success: function(suggestion){
					$("#barang_no").removeClass('spinner');
					add_install(suggestion.id, suggestion.sku,suggestion.nama_barang,suggestion.satuan,suggestion.harga_beli,suggestion.harga_jual,1,0);
					// $('body').removeClass('loading');
					$("#barang_no").val("");
					$("#barang_no").focus();
				},
				failed: function(msg){
					$("#barang_no").removeClass('spinner');
					// $('body').removeClass('loading');
					$("#barang_no").val("");
					$("#barang_no").focus();
					alert("gagal");
				},
			});
		}
	})
	
	$("#simpan_data").submit(function(){
		var faktur = $("#faktur").val();
		var supplier_no = $("#supplier_no").val();
		var tgl = $("#tgl").val();
		var names=document.getElementsByName('nm_brg[]');
		
		if (faktur=="" || supplier_no=="" || tgl==""){
			pesan_toastr("No. Faktur - Supplier Name, Tanggal Transaksi tidak boleh kosong",'err');
			return false;
		}else if(names.length<=0){
			pesan_toastr("Minimal harus ada 1 barang yang dientri",'err');
			return false;
		}
		
		var ket = "<?php echo lang('msg_save_confirm'); ?>";
		$('p.question').html(ket);
		$('#confirmSave').modal('show');
		$('#confirm').on('click', function(){
			pesan_toastr('Mohon Tunggu','info','Prosess','toast-top-center',false);
			dataString = $("#simpan_data").serialize();
			url= "<?php echo base_url('pembelian'); ?>",
			 $.ajax({
			   type: "POST",
			   url: "<?php echo base_url('pembelian/simpan'); ?>",
			   data: dataString,
	 
			   success: function(data){
					if (data=="1"){
						pesan_toastr("Success",'info');
						window.location.href=url;
					}else{
						pesan_toastr("Failed Save",'err');
					}
			   },
			   failed: function(data){
				   pesan_toastr("Failed Save",'err');
			   }
	 
			 });
		});
         return false;  //stop the actual form post !important!
      });
</script>