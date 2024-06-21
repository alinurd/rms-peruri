<div class="col-md-3">
	 <section class="x_panel">
		<div class="x_content no-padding">
			<div class="tree" style="overflow: scroll;height:500px;">
				<ul>
					<li>
						<span><i class="fa fa-folder-open"></i> <?php echo lang('msg_field_list_event');?></span>
						<ul style="padding-left:30px;">
							<?php 
							foreach($data_tree as $key=>$row){
								if ($row['event_no']){
									$output=split_words($row['event_no'][0]['name'],30);
							?>
									<li class="event-project" value="<?php echo $row['id'];?>" rcsa="<?php echo $id_rcsa;?>">&nbsp;&nbsp;<span><?php echo $output;?></span></li>
							<?php
								}
							}
							?>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</section>
</div>

