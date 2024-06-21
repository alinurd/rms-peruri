<section class="content-header">
  <h1>
	Error Page
  </h1>
  <ol class="breadcrumb">
	<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active"><a href="#"><?php echo $this->uri->uri_string;?></a></li>
  </ol>
</section>

 <section class="content">
	 <div class="box box-primary">
		
		<div class="box-body">
			<center>
			<h1>
				Oops!</h1>
			<h2>Error 404 Module</h2>
			<div class="error-details">
				<h3><strong><?php echo "Modul ".$this->uri->uri_string." Not Found";?></strong> </h3>
			</div>
			<div class="error-actions">
				<br/>
			   <a href="<?php echo base_url();?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span> Take Me Home </a>
				<a href="<?php echo base_url('contact');?>" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Contact Support </a>
				<a href="<?php echo $this->uri->uri_string;?>" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-home"></span> Refresh</a>
			</div>
			</center>
		</div>
	</div>
</section>