<?php
$gender = $this->authentication->get_info_user('kelamin');
$photo = $this->authentication->get_Preference('list_photo');
$units = $this->authentication->get_info_user('param_level');
$groups = $this->authentication->get_info_user('group');
$info_owner = $this->authentication->get_info_user('group_owner');
// doi::dump($info_owner,false,true);
// doi::dump($info_owner,false,true);
// if (file_exists(staft_path_relative($this->authentication->get_info_user('photo'))) && !empty($this->authentication->get_info_user('photo'))) {
// 	$photo = staft_url($this->authentication->get_info_user('photo'));
// } else {
// 	$photo = img_url('male.png');
// 	if ($gender == "P")
// 		$photo = img_url('female.png');
// }
?>
  
	<section class="wrapper site-min-height">
		<div class="x_panel">
			<div class="row">
				<div class="col-md-12">
					<div class="x_content">
						<aside class="profile-info col-md-12">
 								<div class="x_content" style="overflow-x:auto;">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th>Kemungkinan</th>
												<?php
												foreach ($kriteria as $k) {
												?>
													<td width="15%" bgcolor="<?= $k['color'] ?>" class="text-center" style="color: #000;">
														<?= $k['name'] ?>
													</td>
												<?php
												}
												?>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($kemungkinan as $kem) {
											?>
												<tr>
													<td><?= $kem['data'] ?></td>
													<?php
													foreach ($kriteria as $kee => $k) {
													?>
														<td>
															<?php
															$kemu = $this->db->where('km_id', $kem['id'])->where('criteria_risiko', $kee)->order_by('criteria_risiko')->get(_TBL_AREA_KM)->row_array();
															?>
															<?php if ($kemu) : ?>
																<?= $kemu['area'] ?>
															<?php endif ?>
														</td>
													<?php
													}
													?>
												</tr>
											<?php
											} ?>
										</tbody>
									</table>
								</div>
							</section>
 			 
				</div>
			</div>
		</div>
		</div>
	</section>
</section>