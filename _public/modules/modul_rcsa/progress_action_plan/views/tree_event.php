<?php 
	// doi::dump($data_even_detail);
?>	

<div class="col-md-3">
	 <section class="panel">
		<div class="x_content no-padding">
			<div class="tree" style="overflow: scroll;height:500px;">
				<ul>
					<?php 
					if (isset($data_tree)){
					foreach($data_tree as $key=>$rows){
					?>
					<li> 
						<span title="Expand"><i class="fa fa-folder-open"></i> <?php echo $rows['corporate'];?></span>
						<ul style="padding-left:30px;">
							<?php 
							foreach($rows['detail'] as $key=>$row){
								// doi::dump($row);
							?>
								<li class="event" value="<?php echo $row['id'];?>" rcsa="<?php echo $row['id_detail'];?>">&nbsp;&nbsp;<span><?="<span class='bg-warning'>Proaktif </span>: ".$row['proaktif']."<br/><span class='bg-success'>Reaktif </span>: ".$row['reaktif'];?></span></li>
							<?php
							}
							?>
						</ul>
					</li>
					<?php } } ?>
				</ul>
			</div>
		</div>
	</section>
</div>
