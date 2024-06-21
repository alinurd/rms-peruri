<?php 
	echo form_open_multipart($this->uri->uri_string,array('id'=>'form_input'));
?>
<section id="main-content">
	<section class="wrapper site-min-height">
		<div class="x_panel">
              <!--state overview end-->
			<div class="row">
				<aside class="col-md-12">
					<!--user info table start-->
					<div class="x_panel">
						<div class="box-warning" id="scrollingDiv">
							<div class="x_content">
								<div class="box-header" style="z-index:1000;">
								<?=$action;?>
								</div>		
							</div>
						</div>
						
						<div class="x_content">
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
				</aside>
			</div>
		</div>
	</section>
</section>
<?php echo form_close();?>


<script>
	$(function(){
		$(".edit_modul").click(function(){
			var id = $(this).attr('data-id');
			$("#mdl_"+id).toggle();
		})
		
		$(".title_modul").keyup(function(){
			$(this).closest(".dd3-content").find(".judul").html($(this).val());
		})
		$(".icon_modul").change(function(){
			$(this).closest(".dd3-content").find("i").removeClass().addClass($(this).val());
		})
	})
</script>