<?php
	$units =$this->authentication->get_info_user('param_level');
	$groups =$this->authentication->get_info_user('group');
	$info_owner = $this->authentication->get_info_user('group_owner');
	// doi::dump($info_owner,false,true);
?>
<section id="main-content">
	<section class="wrapper site-min-height">
		<section class="panel">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<div class="col-sm-8 panel-heading">
							<h3 style="padding-left:10px;">Peta Risk Exposure</h3>
						</div>
						<div class="col-sm-4" style="text-align:right; float: right;">
							<ul class="breadcrumb">
								<li> <a href="#"> <i class="fa fa-home"></i> Home</a></li>
								<li><a href="#">Risk Exposure</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
            
			<div class="row">
				<div class="col-md-12">
					<?php  echo form_open_multipart(base_url('risk-exposure'),array('id'=>'dashboard-project'));?>
					<section class="panel">
						<header class="panel-heading">
							Filter
							<span class="tools pull-right">
								<a class="fa fa-chevron-down" href="javascript:;"></a>
							</span>
						</header>
						<div class="panel-body progress-panel box">
							<table class="table borderless">
								<tr>
									<td width="15%">Owner Name :</td>
									<td colspan="2">
										<?php echo form_dropdown('owner_no',$cbo_owner,$post['owner_no'],' id="owner_no" class=" form-control select3" style=" width:auto;"');?></td>
									<td width="10%" class="text-center" rowspan="3"> 
										<button class="btn btn-round btn-flat btn-primary" name="search" value="Simpan" type="submit" id="btn-search" data-original-title="" title="" style="min-height:60px;"><i class="fa fa-search"></i> <?php echo lang('msg_tbl_search');?></button>
									</td>
								</tr>
								<tr>
									<td>Risk Register Type : </td>
									<td><?php echo form_dropdown('type_no',$cbo_type, $post['type_no'],' id="type_no" class=" form-control" style=" width:auto;"');?></td>
								</tr>
								<tr>
									<td>Period : </td>
									<td><?php echo form_dropdown('period_no',$cbo_period, $post['period_no'],' id="period_no" class=" form-control" style=" width:auto;"');?></td>
								</tr>
							</table>
						</div>
					</section>
					<?php  echo form_close();?>
				</div>
			</div>
			<div class="row">
				<aside class="profile-info col-md-6">
					<section class="panel">
						<div class="panel-body bio-graph-info box">
							<div id="step_inherent">
								<?=$step;?>
							</div>
							<div class="" id="exposure_inherent">
								<?=draw_map_exposure($setting, 50, 'inherent', $urut);?>
							</div>
							<div id="overlay_inherent" class="overlay hide">
								<i class="fa fa-refresh fa-spin"></i>
							</div>
						</div>
					</section>
				</aside>
				<aside class="profile-info col-md-6">
					<section class="panel">
						<div class="panel-body bio-graph-info box">
							<div id="step_residual">
								<?=$step;?>
							</div>
							<div class="panel-body bio-graph-info" id="exposure_residual">
								<?=draw_map_exposure($setting, 50, 'residual', $urut);?>
							</div>
							<div id="overlay_residual" class="overlay hide">
								<i class="fa fa-refresh fa-spin"></i>
							</div>
						</div>
					</section>
				</aside>
			</div>
		</section>
	</section>
</section><!-- /.right-side -->

<script>
	$(document).ready(function() {
		$(document).on("click",".detail-exposure", function(e){
			alert("oke");
			var id=$(this).attr("value");
			if (id.length==0){
				return false;
			}
			var type=$(this).attr("typemap");
			var back=$(this).attr("data-back");
			var owner=$(this).attr("data-owner");
			var urut=$(this).attr("data-urut");
			var url = base_url + 'risk-exposure/get-detail/';
			var data={id:id,type:type, back:back, owner:owner, urut:urut};
			loading(true, 'overlay_'+type);
			$.ajax({
				url:url,
				type:"post",
				data:data,
				dataType:"json",
				success:function(result){
					$("#exposure_" + type).html(result.tabel);
					$("#step_" + type).html(result.step);
					loading(false, 'overlay_'+type);
				},
				error:function(a,b){
					loading(false, 'overlay_'+type);
					alert("error");
					
				},
			})
		})
		
		$(document).on("click","#view_next_risk", function(e){
			var id=$(this).attr("data-id");
			var type=$(this).attr("typemap");
			var parent=$(this).attr("data-parent");
			var urut=$(this).attr("data-urut");
			var period=$("#period_no").val();
			var type_no=$("#type_no").val();
			var url = base_url + 'risk-exposure/get-next-risk/';
			var data={id:id,type:type, parent:parent, urut:urut, period: period, type_no: type_no};
			loading(true, 'overlay_'+type);
			$.ajax({
				url:url,
				type:"post",
				data:data,
				dataType:"json",
				success:function(result){
					loading(false, 'overlay_'+type);
					$("#exposure_" + type).html(result.tabel);
					$("#step_" + type).html(result.step);
				},
				error:function(a,b){
					loading(false, 'overlay_'+type);
					alert("error");
				},
			})
		})
		
		$(document).on("click","#btn_back_list", function(e){
			var urut=$(this).attr("data-urut");
			var type=$(this).attr("typemap");
			var url = base_url + 'risk-exposure/get-back-detail/';
			var data={urut:urut,type:type};
			loading(true, 'overlay_'+type);
			$.ajax({
				url:url,
				type:"post",
				data:data,
				dataType:"json",
				success:function(result){
					$("#exposure_" + type).html(result.tabel);
					$("#step_" + type).html(result.step);
					loading(false, 'overlay_'+type);
				},
				error:function(a,b){
					loading(false, 'overlay_'+type);
					alert("error");
					
				},
			})
		})
		
		$(document).on("click","#btn_back_map", function(e){
			var urut=$(this).attr("data-urut");
			var type=$(this).attr("typemap");
			var period=$("#period_no").val();
			var type_no=$("#type_no").val();
			var url = base_url + 'risk-exposure/get-back-risk/';
			var data={urut:urut,type:type, period:period, type_no:type_no};
			loading(true, 'overlay_'+type);
			$.ajax({
				url:url,
				type:"post",
				data:data,
				dataType:"json",
				success:function(result){
					loading(false, 'overlay_'+type);
					$("#exposure_" + type).html(result.tabel);
					$("#step_" + type).html(result.step);
				},
				error:function(a,b){
					loading(false, 'overlay_'+type);
					alert("error");
				},
			})
		})
	})
	
	$(document).on("click",".li_step", function(e){
		var urut=$(this).attr("data-urut");
		var type=$(this).attr("typemap");
		var model=$(this).attr("data-type");
		var mode=$(this).attr("data-mode");
		var period=$("#period_no").val();
		var type_no=$("#type_no").val();
		if (model=="list"){
			var url = base_url + 'risk-exposure/get-back-detail/';
		}else{
			var url = base_url + 'risk-exposure/get-back-risk/';
		}
		var data={urut:urut,type:type, period:period, type_no:type_no};
		loading(true, 'overlay_'+type);
		$.ajax({
			url:url,
			type:"post",
			data:data,
			dataType:"json",
			success:function(result){
				$("#exposure_" + type).html(result.tabel);
				$("#step_" + type).html(result.step);
				loading(false, 'overlay_'+type);
			},
			error:function(a,b){
				loading(false, 'overlay_'+type);
				alert("error");
				
			},
		})
	})
	
	$(document).on("click",".li_step_detail", function(e){
		var nil=$(this).attr('data-id');
		var type=$(this).attr('typemap');
		var period=$("#period_no").val();
		var type_no=$("#type_no").val();
		var urut=$(this).attr("data-urut");
		var project_no=0;
		var rcsa_no=0;
		if (nil.length==0){
			return false;
		}
		var url=base_url + "risk-exposure/get-event-exposure";
		var data = {owner_no:nil, type_map:type, period_no:period, project_no:project_no, rcsa_no:rcsa_no, urut:urut,type_no:type_no};
		loading(true, 'overlay_'+type);
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			dataType: "json",
			success:function(result){
				$("#exposure_" + type).html(result.tabel);
				$("#step_" + type).html(result.step);
				loading(false, 'overlay_'+type);
			},
			failed: function(msg){
				loading(false, 'overlay_'+type);
				pesan_toastr('Error Load Data','err','Error','toast-top-center');
			},
			error: function(msg){
				loading(false, 'overlay_'+type);
				pesan_toastr('Error Load Data','err','Error','toast-top-center');
			},
		});
	});
	
	$(document).on("click",".view_risk", function(e){
		var nil=$(this).attr('data-id');
		var type=$(this).attr('typemap');
		var period=$("#period_no").val();
		var type_no=$("#type_no").val();
		var urut=$(this).attr("data-urut");
		var project_no=0;
		var rcsa_no=0;
		if (nil.length==0){
			return false;
		}
		var url=base_url + "risk-exposure/get-event-exposure";
		var data = {owner_no:nil, type_map:type, period_no:period, project_no:project_no, rcsa_no:rcsa_no, urut:urut, type_no:type_no};
		loading(true, 'overlay_'+type);
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			dataType: "json",
			success:function(result){
				$("#exposure_" + type).html(result.tabel);
				$("#step_" + type).html(result.step);
				loading(false, 'overlay_'+type);
			},
			failed: function(msg){
				loading(false, 'overlay_'+type);
				pesan_toastr('Error Load Data','err','Error','toast-top-center');
			},
			error: function(msg){
				loading(false, 'overlay_'+type);
				pesan_toastr('Error Load Data','err','Error','toast-top-center');
			},
		});
	});
</script>