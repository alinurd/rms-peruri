<?php 
	echo form_open_multipart($this->uri->uri_string,array('id'=>'form_input'));
?>
<section id="main-content">
	<section class="wrapper site-min-height">
		<section class="x_panel">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-sm-8 panel-heading">
							<h3 style="padding-left:10px;">DASHBOARD</h3>
						</div>
						<div class="col-sm-4" style="text-align:right; float: right;">
							<ul class="breadcrumb">
								<li> <a href="#"> <i class="fa fa-home"></i> Home</a></li>
								<li><a href="#">Dashboard</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
              <!--state overview end-->
			<div class="row">
				<div class="col-sm-12">
					<div class="x_panel">
						<div class="x_title"></div>
						<div class="x_content" id="scrollingDiv">
							<?=$action;?>
						</div>
						
						<div class="x_content">
							<div class="alert alert-info alert-dismissable">
								<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
								<h4>
								<i class="icon fa fa-info"></i>
								Info!
								</h4>
								Silahkan geser menu untuk menentukan posisi menu yang diinginkan!.
							</div>
							<menu id="nestable-menu" class="pull-right">
								<button type="button" data-action="expand-all">Expand All</button>
								<button type="button" data-action="collapse-all">Collapse All</button>
							</menu>
							<table class="table">
								<tr>
									<td>
									<textarea id="nestable-output" name="nestable-output" class="hide"><?=$source_tree;?></textarea>
									<div class="dd" id="nestable">
										<ol class="dd-list">
											<?php echo $tree;?>
										</ol>
									</div>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</section>
	</section>
</section>
<?php echo form_close();?>