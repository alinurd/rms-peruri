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

<section id="main-content">
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
											<th>Kategori</th>
											<th>Dampak</th>
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
										<?php foreach ($dampak as $dam) {
											$subDampak = $this->db->where('kelompok', 'sub-kriteria-dampak')
												->where('pid', $dam['id'])->get(_TBL_DATA_COMBO)->result_array()
										?>
											<?php foreach ($subDampak as $key => $subd) {
											?>
												<tr>
													<?php if ($key + 1 == 1) : ?>
														<td rowspan="<?= count($subDampak) ?>"><?= $dam['data'] ?></td>
													<?php endif ?>
													<td><?= $subd['data'] ?></td>
													<?php
													foreach ($kriteria as $kee => $k) {
													?>
														<td>
															<?php
															$damp = $this->db->where('sub_dampak_id', $subd['id'])->where('criteria_risiko', $kee)->order_by('criteria_risiko')->get(_TBL_AREA)->row_array();
															?>
															<?php if ($damp) : ?>
																<?= $damp['area'] ?>
															<?php endif ?>
														</td>
													<?php
													}
													?>
												</tr>
											<?php
											} ?>
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