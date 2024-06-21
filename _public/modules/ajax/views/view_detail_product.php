<?php
	$img=show_image($product->photo, 0, 500, 'product');
?>
<div class="table-responsive">
	<table class="table table-hover" id="datatablesx">
		<tr>
			<td width="20%"><?=$img;?></td>
			<td style="vertical-align:top;">
				<div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_info" data-toggle="tab"><?=lang('msg_field_barang_tab1');?></a></li>
                  <li><a href="#tab_beli" data-toggle="tab"><?=lang('msg_field_barang_tab2');?></a></li>
                  <li><a href="#tab_jual" data-toggle="tab"><?=lang('msg_field_barang_tab3');?></a></li>
                  <li><a href="#tab_retur" data-toggle="tab"><?=lang('msg_field_barang_tab4');?></a></li>
                  <li><a href="#tab_reject" data-toggle="tab"><?=lang('msg_field_barang_tab5');?></a></li>
                </ul>
                <div class="tab-content">
				<div class="tab-pane active" id="tab_info">
                    <table class="table table-hover">
						<tr><td width="15%" ><?=lang('msg_field_barang_kode');?></td><td width="4%" class="text-center">:</td><td><?=$product->kode;?></td></tr>
						<tr><td><?=lang('msg_field_barang_kategori');?></td><td width="4%" class="text-center">:</td><td><?=$product->kategori;?></td></tr>
						<tr><td><?=lang('msg_field_barang_nama_barang');?></td><td width="4%" class="text-center">:</td><td><?=$product->nama_barang;?></td></tr>
						<tr><td><?=lang('msg_field_barang_merk');?></td><td width="4%" class="text-center">:</td><td><?=$product->merk;?></td></tr>
						<tr><td><?=lang('msg_field_barang_unit');?></td><td width="4%" class="text-center">:</td><td><?=$product->unit;?></td></tr>
						<tr><td><?=lang('msg_field_barang_warna');?></td><td width="4%" class="text-center">:</td><td><?=$product->warna;?></td></tr>
						<tr><td><?=lang('msg_field_barang_size');?></td><td width="4%" class="text-center">:</td><td><?=$product->size;?></td></tr>
						<tr><td><?=lang('msg_field_barang_harga');?></td><td width="4%" class="text-center">:</td><td><?=number_format($product->harga_jual);?></td></tr>
						<tr><td><?=lang('msg_field_barang_harga_member');?></td><td width="4%" class="text-center">:</td><td><?=number_format($product->harga_jual_member);?></td></tr>
						<tr><td><?=lang('msg_field_barang_min_stock');?></td><td width="4%" class="text-center">:</td><td><?=$product->min_stock;?></td></tr>
						<tr><td><?=lang('msg_field_barang_keterangan');?></td><td width="4%" class="text-center">:</td><td><?=$product->keterangan;?></td></tr>
					</table>
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_beli">
                    <b>History Pembelian</b>
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_jual">
                    <b>History Penjualan</b>
                  </div><!-- /.tab-pane -->
                  <div class="tab-pane" id="tab_retur">
                    <b>History Retur</b>
                  </div><!-- /.tab-pane -->
				  <div class="tab-pane" id="tab_reject">
                    <b>Histori Reject</b>
                  </div><!-- /.tab-pane -->
                </div><!-- /.tab-content -->
              </div><!-- nav-tabs-custom -->
			</td>
		</tr>
	</table>
</div>

