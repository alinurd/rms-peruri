<?php
$aksi = $mode_aksi;
$view = ($aksi == 'view') ? true : false;
$data = array();
$id = 0;
if (isset($dat_edit['fields'])) {
	$data = $dat_edit['fields'];
	if (isset($data['l_' . $master['primary']['id']]))
		$id = $data['l_' . $master['primary']['id']];
	else
		$id = 0;
}
$primary = form_hidden('l_' . $master['primary']['id'], $id);
$sts_simpan = form_hidden('sts_simpan', $dat_edit['sts']);

$info = "";
$sts_input = "";
$info_error = "";
if (validation_errors()) {
	$info_error = validation_errors();
	$sts_input = 'danger';
} elseif ($this->session->userdata('result_proses_error')) {
	$info_error =  $this->session->userdata('result_proses_error');
	$this->session->set_userdata(array('result_proses_error' => ''));
	$sts_input = 'danger';
}

if ($this->session->userdata('result_proses')) {
	$info = $this->session->userdata('result_proses');
	$this->session->set_userdata(array('result_proses' => ''));
	$sts_input = 'info';
}
?>
<script>
	$(function() {
		var err = "<?php echo $info; ?>";
		var sts = "<?php echo $sts_input; ?>";
		if (err.length > 0)
			pesan_toastr(err, sts);
	});
</script>

<?php
if (!empty($info_error)) {
?>
	<div id='sts_error' class="alert alert-<?php echo $sts_input; ?> alert-dismissable">
		<i class="fa fa-check"></i>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<b>Info !</b> <?php echo $info_error; ?>
	</div>
<?php }
echo form_open_multipart($this->uri->uri_string, array('id' => 'form_input', 'class' => 'form-horizontal'));
// echo form_hidden($this->security->get_csrf_token_name(),$this->security->get_csrf_hash());

?>
<div class="row">
	<div class="col-xs-12" id="scrollingDiv">
		<div class="x_panel">
			<div class="x_title">


			</div>
			<div class="x_content">
				<?php
				$sts = $this->authentication->get_Privilege("icon_tombol");
				foreach ($action as $key => $tbl) {
					$lbl = "";
					if ($sts) {
						$lbl = $tbl['label'];
					}
					if (is_array($tbl)) {
						$tombol = $tbl['tbl_open'] . $tbl['icon'] . $lbl . $tbl['tbl_close'];
					} else {
						$tombol = $tbl;
					}
					if ($key == 'save' && ($privilege['add'] == '1' || $privilege['edit'] == '1') && !$view && $privilege['tombol_save']) {
						if (($aksi == 'add' && $privilege['add'] == '1') || ($aksi == 'edit' && $privilege['edit'] == '1')) {
							echo $tombol . "&nbsp;&nbsp;";
						}
					} elseif ($key == 'savequit' && ($privilege['add'] == '1' || $privilege['edit'] == '1')  && !$view  && $privilege['tombol_save_quit']) {
						if (($aksi == 'add' && $privilege['add'] == '1') || ($aksi == 'edit' && $privilege['edit'] == '1')) {
							echo $tombol . "&nbsp;&nbsp;";
						}
					} elseif ($key == 'add_input' && $privilege['add'] == '1'  && $privilege['tombol_add']) {
						echo $tombol . "";
					} elseif ($key == 'quit' && $privilege['tombol_quit']) {
						echo $tombol . "&nbsp;&nbsp;";
					}
				}
				if (isset($optional_cmd)) {
					foreach ($optional_cmd as $key => $tombol) {
						$ada = false;
						if (array_key_exists('posisi', $tombol)) {
							if ($tombol['posisi'] == 'left') {
								$ada = true;
							}
						} else {
							$ada = true;
						}

						if ($ada) {
							echo $tombol['content'] . "&nbsp;&nbsp;";
						}
					}
				}
				?>
				<span class="pull-right">
					<?php
					if (isset($optional_cmd)) {
						foreach ($optional_cmd as $key => $tombol) {

							$ada = false;
							if (array_key_exists('posisi', $tombol)) {
								if ($tombol['posisi'] == 'right') {
									$ada = true;
								}
							}

							if ($ada) {
								echo $tombol['content'] . "&nbsp;&nbsp;";
							}
						}
					}
					?>
				</span>
				<br>
			</div>
		</div>
	</div>
</div>
<div class="x_panel">
	<div class="x_title">


	</div>
	<div class="x_content">
		<?php
		$hide_field = '';
		foreach ($master['fields'] as $row) {
			if (array_key_exists('label', $row)) {
				$label = $row['label'];
			} else {
				$label = 'l_' . $row['field'];
			}
			$isi = "";
			if (array_key_exists('default', $row['input'])) {
				$isi = $row['input']['default'];
			}
			if (array_key_exists($label, $data)) {
				$isi = $data[$label];
			}

			if (!$row['show'] && $row['input']['type'] !== 'free') {
				$hide_field .= form_hidden(array($label => $isi));
			}
		}
		echo lang('msg_' . $dat_edit['sts'] . '_data');
		echo $hide_field . $primary . $sts_simpan;
		?>
	</div>

	<?php
	if (isset($sub_header)) { ?>
		<div class="x_content">
			<?php echo $sub_header; ?>
		</div>
	<?php
	} ?>

	<div class="x_content">
		<?php
		if (count($master['tabs']) > 0) { ?>
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs" id="tab_input">
					<?php
					$i = 1;
					$nobtn = -1;
					foreach ($master['tabs'] as $key => $tab) {
						$active = "";
						if ($i == 1)
							$active = ' active ';

						$hide = '';
						if (array_key_exists('show', $tab)) {
							if (!$tab['show'])
								$hide = ' hide ';
						}

						$tab_icon = ' <i class="fa fa-book"></i> ';
						$next_arr[$key] = '#tab_' . $i;
						if (array_key_exists('icon', $tab))
							$tab_icon = ' <i class="fa fa-' . $tab['icon'] . '"></i> ';
					?>
						<li id="<?php echo $tab['id']; ?>" class="<?php echo $active . $hide; ?>"><a href="#tab_<?php echo $i; ?>" data-toggle="tab"> <?php echo $tab_icon; ?> <?php echo $tab['title']; ?></a></li>
					<?php
						$i++;
					} ?>
				</ul>
			</div>
			<div class="tab-content">
				<?php
				$i = 1;
				$i_left = 0;
				foreach ($master['tabs'] as $key => $tab) {
					$active = "";
					if ($i == 1) {
						$active = ' active ';
					}
				?>
					<div class="tab-pane <?php echo $active; ?>" id="tab_<?php echo $i; ?>">
						<?php
						if (array_key_exists('coloums', $master) && count($master['coloums']) > 0) {
						?>
							<table class="table table-condensed x" cellspacing="0" cellpadding="0" border="0" width="100%">
								<tr>
									<?php
									foreach ($master['coloums'] as $cols) {
									?>
										<td width="50%" style="vertical-align:top;">
											<table class="table table-condensed y" cellspacing="0" cellpadding="0" border="0" width="100%">
												<?php draw($master, $data, '', false, $cols); ?>
											</table>
										</td>
									<?php
									}
									?>
								</tr>
							</table>

							<?php
							if (array_key_exists('coloums_all', $master)) {
								$cols = $master['coloums_all'];
							?>
								<table class="table table-condensed z" cellspacing="0" cellpadding="0" border="0" width="100%">
									<?php draw($master, $data, '', false, $cols[$key]); ?>
								</table>
							<?php
							}
						} else { ?>
							<?php draw($master, $data, $tab); ?>
						<?php
						}
						$next = '';
						$back = '';
						$ho = '';
						$he = '';
						if (count($master['tabs']) > 1 && $key < (count($master['tabs']) - 1)) :
							$id = $next_arr[($key + 1)];
							$next = '<span class="btn btn-danger pull-right pointer action_tab" data-id="' . $id . '" style="display:block;position:relative;" id="tab_lanjut_' . $key . '"> Lanjut </span>';

						endif;
						if (count($master['tabs']) > 1 && $key > 0) :
							$id = $next_arr[($key - 1)];
							$back = '<span class="btn btn-primary pull-right pointer action_tab" data-id="' . $id . '"  style="display:block;position:relative;" id="tab_balik_' . $key . '"> Kembali </span>';
							// $ho = '<span class="btn btn-warning btn-flat pull-right pointer action_tab" data-id="'.$id.'"  style="display:block;position:relative;" id="tab_ho_'.$key.'"> Simpan Dan Keluar </span>';
							$ho = '<button type="submit" class="btn btn-warning btn-flat" name="l_save" value="Simpan_Quit" style="float: right;" data-toggle="popover" data-content="Simpan Dan Keluar" data-original-title="" title=""><i class="fa fa-floppy-o"></i> Simpan Dan Keluar</button>';
							$ha = '<button type="submit" class="delete btn btn-success btn-flat" value="Simpan" name="l_save" style="float: right; data-toggle="popover" data-content="Simpan Perubahan" data-original-title="" title=""><i class="fa fa-floppy-o"></i> Simpan</button>';
						endif;
						// $ho = '<button type="submit" class="btn btn-warning btn-flat" name="l_save" value="Simpan_Quit" data-toggle="popover" data-content="Simpan Dan Keluar" data-original-title="" title=""><i class="fa fa-floppy-o"></i> Simpan Dan Keluar</button>';
						// if ($key<(count($master['tabs'])-1)) :
						if ($this->modul_name == "rcsa" && $key == (count($master['tabs']) - 1)) :
							echo $next . '&nbsp;&nbsp;&nbsp;' . $back . '&nbsp;&nbsp;' . $ho . '&nbsp;&nbsp;' . $ha;
						else :
							echo $next . '&nbsp;&nbsp;&nbsp;' . $back;
						endif;




						// echo $next.'&nbsp;&nbsp;&nbsp;'.$back
						?>
					</div>
				<?php
					$i++;
				} ?>
			</div>

			<?php
		} else {
			if (array_key_exists('coloums', $master)) {
			?>
				<table class="table table-condensed w" cellspacing="0" cellpadding="0" border="0" width="100%">
					<tr>
						<?php
						foreach ($master['coloums'] as $cols) {
						?>
							<td width="50%" style="vertical-align:top;">
								<table class="table table-condensed h" cellspacing="0" cellpadding="0" border="0" width="100%">
									<?php draw($master, $data, '', false, $cols); ?>
								</table>
							</td>
						<?php
						}
						?>
					</tr>
				</table>

				<?php
				if (array_key_exists('coloums_all', $master)) {
					$cols = $master['coloums_all'];
				?>
					<table class="table table-condensed k" cellspacing="0" cellpadding="0" border="0" width="100%">
						<?php draw($master, $data, '', false, $cols); ?>
					</table>
		<?php
				}
			} else {
				draw($master, $data, '', false);
			}
		} ?>
		<hr>
	</div>

	<?php
	if (isset($sub_footer)) { ?>
		<div class="x_content">
			<?php echo $sub_footer; ?>
		</div>
	<?php
	}
	?>

	<div class="loading-img hide" id="loading"></div>


	<sup style="color:red;">*) <?php echo lang('msg_field_required'); ?></sup>
	<?php
	$cb = (isset($data['create_user'])) ? $data['create_user'] : '';
	$cd = (isset($data['create_date'])) ? $data['create_date'] : '';
	$ub = (isset($data['update_user'])) ? $data['update_user'] : '';
	$ud = (isset($data['update_date'])) ? $data['update_date'] : '';
	?>
	<span class="pull-right"><em><sup><i class="fa fa-user"></i> <?php echo lang('msg_create_by') . '<span class="label label-info">' . $cb . '</span> , <i class="fa fa-calendar"></i> ' . lang('msg_create_stamp') . '<span class="label label-info">' . $cd . '</span> | <i class="fa fa-user"></i> ' . lang('msg_update_by') . '<span class="label label-warning">' . $ub . '</span> <i class="fa fa-calendar"></i> ' . lang('msg_update_stamp') . '<span class="label label-warning">' . $ud . '<span>'; ?></sup></em></span>
</div>
<?php echo form_close();

function draw($master, $data, $tab = '', $next_row = false, $cols = '')
{
	$CI = &get_instance();
	$aksi = strtolower($CI->uri->segment(2));
	$view = ($aksi == 'view') ? true : false;

	// die("Statusnya : ".$aksi);
	$CI = &get_instance();
	$nodate = 0;
	$i_left = 0;
	$nopass = 0;
	$field_first = TRUE;
	foreach ($master['fields'] as $key => $row) {
		$width = "20%";
		$width_multi = "510px";
		$autofocus = '';
		if ($field_first)
			$autofocus = ' autofocus ';
		$sts_tab = (is_array($tab)) ? true : false;
		$sts_cols = (is_array($cols)) ? true : false;
		$sts_in_array = true;
		if ($sts_tab) {
			$sts_in_array = (in_array($row['field'], $tab['field'])) ? true : false;
		}

		if ($next_row)
			$sts_in_array = (array_key_exists('next_row', $row)) ? true : false;

		if ($sts_cols) {
			$sts_in_array = (in_array($row['field'], $cols)) ? true : false;
			$width = "30%";
			$width_multi = "310px";
		}

		if ($sts_in_array) {
			if (array_key_exists('show', $row)) {
				if ($row['show']) {
					$isi = "";
					$required = "";
					$help = "";
					$span_help = "";
					$help_text = '';
					$style = "";
					$onClick = "";
					$onChange = "";
					$class_upper = "";
					$mode = 'a';
					$error = "";
					$placeholder = '';
					$disabled = '';
					$align = 'text-left';
					$typeahead = '';
					$readOnly = '';
					$span_start = '';
					$span_end = '';
					$span_left_addon = '';
					$span_right_addon = '';
					$span_right = '';
					$span_left = '';
					$btn_add = '';
					$group = "";
					$open_span_help = '<span class="tooltip-content">';
					$close_span_help = '</span>';
					$help_title = '<span class="tooltip-title" style="width:100%;display:block;margin:0;color:yellow;margin-bottom:12px;"><i class="fa fa-info"></i> Info</span>';
					$type = $row['input']['input'];
					$content = '';
					$btn_label_accordion = '';
					$inline = '';
					$size = '';

					if (array_key_exists('required', $row)) {
						if ($row['required'])
							$required = '<sup><span class="required"> *) </span></sup>';
					}

					$msg_title = $row['title'];

					$attr_title_prefix = '<label for="lbl_language" id="' . $row['field'] . '">';
					$attr_title_suffix = '</label>';

					if (array_key_exists('input', $row)) {
						if (!empty($data) && $row['input']['type'] !== 'free' && $row['input']['input'] !== 'pass') {
							if (array_key_exists('label', $row)) {
								if (array_key_exists($row['label'], $data)) {
									$isi = $data[$row['label']];
								}
							} else {
								$isi = $data['l_' . $row['field']];
							}
						} else {
						}
					} elseif (!empty($data)) {
						if (array_key_exists('label', $row)) {
							$isi = $data[$row['label']];
						} else {
							$isi = $data['l_' . $row['field']];
						}
					}

					$msg_help = lang('msg_help_' . $row['field']);
					if ($CI->authentication->get_Preference('help_tool') == '1') {
						if (array_key_exists('help', $row)) {
							if ($row['help'] && !empty($msg_help)) {
								// $help= "<span class='glyphicon glyphicon-info-sign pointer text-primary' data-container='body' data-toggle = 'tooltip' data-placement='right' data-html='true' data-original-title='".$msg_help."'  style='cursor:help;top:2px;margin-left:15px;'></span>";
								if ($CI->authentication->get_Preference('help_popup') == '1') {
									$help = "<span class='glyphicon glyphicon-info-sign pointer text-primary info-help' data-toggle = 'popover' data-placement='top' data-html='true' data-content='" . $msg_help . "'  style='cursor:help;top:2px;margin-left:15px;'></span>";
								} else {
									$help_text = '<span id="helpBlock" class="showHelpBlock help-block">' . $msg_help . '</span>';
								}
							}
						}
					}

					if (array_key_exists('align', $row['input'])) {
						$align = 'text-' . $row['input']['align'];
					} else {
						switch ($type) {
							case 'int':
							case 'integer':
							case 'intdot':
							case 'integerdot':
							case 'float':
								$align = 'text-right';
								break;
							default:
								$align = 'text-left';
								break;
						}
					}

					if (array_key_exists('label', $row)) {
						$label = $row['label'];
					} else {
						$label = 'l_' . $row['field'];
					}

					if (array_key_exists('bind', $master)) {
						foreach ($master['bind'] as $bd) {
							if ($bd['nmtbl'] == $row['nmtbl'] && $bd['field'] == $row['field']) {
								if (array_key_exists('style', $bd)) {
									$style = $bd['style'];
								}
								if (array_key_exists('onClick', $bd)) {
									$onClick = 'onClick="' . $bd['onClick'] . '"';
								}
								if (array_key_exists('onChange', $bd)) {
									$onChange = 'onChange="' . $bd['onChange'] . '"';
								}
								if (array_key_exists('value', $bd) && $aksi == 'add') {
									$isi = $bd['value'];
								}
								if (array_key_exists('span_left_addon', $bd)) {
									$span_left_addon = '<span id="span_' . $label . '" class="input-group-addon">' . $bd['span_left_addon'] . ' ' . $help . '</span>';
									$help = '';
								}
								if (array_key_exists('span_right_addon', $bd)) {
									$span_right_addon = '<span  id="span_' . $label . '" class="input-group-addon">' . $bd['span_right_addon'] . '</span>';
								}
								if (array_key_exists('span_help', $bd)) {
									$span_help = '<span class="help-block">' . $bd['span_help'] . '</span>';
								}
								if (array_key_exists('span_left', $bd)) {
									$span_left = $bd['span_left'];
								}
								if (array_key_exists('span_right', $bd)) {
									$span_right = $bd['span_right'];
								}
								if (array_key_exists('align', $bd)) {
									$align = 'text-' . $bd['align'];
								}
								if (array_key_exists('readonly', $bd)) {
									$readOnly = 'readonly=""';
								}
								if (array_key_exists('disabled', $bd)) {
									$disabled = 'disabled="disabled"';
								}
								if (array_key_exists('group', $bd)) {
									$group = "input-group";
								}
								if (array_key_exists('upper', $bd)) {
									$class_upper = "text-upper";
								}
								if (array_key_exists('inline', $bd)) {
									$inline = "form-inline";
								}
								if (array_key_exists('btn_add', $bd)) {
									$btn_add = '<span class="btn btn-flat btn-small btn-default btn-add" data-target="' . $bd['target'] . '" data-combo="' . $label . '" data-label="' . $msg_title . '" data-fld="' . $bd['fld'] . '">' . lang('msg_tombol_add_list') . ' ' . $msg_title . '</span>';
								}
								break;
							}
						}
					}


					if (array_key_exists('accordion', $master)) {
						foreach ($master['accordion'] as $bd) {
							if ($bd['nmtbl'] == $row['nmtbl'] && $bd['field'] == $row['field']) {
								$class = "bg-green pointer";
								if (array_key_exists('class', $bd))
									$class = $bd['class'];

								$icon = '';
								if (array_key_exists('icon', $bd))
									$icon = $bd['icon'];

								$left_margin = 0;
								if (array_key_exists('level', $bd)) {
									$left_margin = intval($bd['level']) * 15;
								}

								$lbl_accordion = strtoupper($bd['label']);
								$btn_label_accordion = '<div class="' . $class . '" style="width:auto; padding:10px;margin-bottom:15px;margin-left:' . $left_margin . 'px;">' . $icon . ' <strong>' . $lbl_accordion . '</strong></div>';

								if (array_key_exists('sub-title', $bd)) {
									$left_margin = 15;
									if ($bd['level'] == 1)
										$left_margin = 30;

									$class = "bg-default pointer";
									$lbl_accordion = $bd['sub-title'];
									$btn_label_accordion .= '<div class="' . $class . '" style="width:auto; padding:10px;margin-bottom:15px;margin-left:' . $left_margin . 'px;">' . $icon . ' <strong>' . $lbl_accordion . '</strong></div>';
								}

								break;
							}
						}
					}

					if (empty($msg_title))
						$msg_title = $row['title'];

					if ($CI->session->flashdata('msg_log_error')) {
						$error = "has-error";
					}

					if (form_error('l_' . $row['field'], '<div class="error">', '</div>')) {
						$error = "has-error";
					}

					if (array_key_exists('placeholder', $row['input']))
						$placeholder = 'placeholder="' . $row['input']['placeholder'] . '"';

					if (array_key_exists('disabled', $row['input']) || $view)
						$disabled = 'disabled="disabled"';

					if ($row['input']['input'] == 'text_auto') {
						$typeahead = 'typeahead';
					}

					if (array_key_exists('span', $row['input'])) {
						if (array_key_exists('start', $row['input']['span'])) {
							$span_start = ' <span class="input-group-addon"><i class="' . $row['input']['span']['start'] . '"></i></span>';
						}
						if (array_key_exists('end', $row['input']['span'])) {
							$span_end = ' <span class="input-group-addon"><i class="' . $row['input']['span']['end'] . '"></i></span>';
						}
					}

					if (array_key_exists('manual_input', $master)) {
						foreach ($master['manual_input'] as $bd) {
							if ($bd['nmtbl'] == $row['nmtbl'] && $bd['field'] == $row['field']) {
								$manual_input = $bd['value'];
								$type = "manual_input";
								break;
							}
						}
					}

					if (array_key_exists('input', $row)) {
						if (array_key_exists("mode", $row['input'])) {
							$mode = $row['input']['mode'];
						}
						if ($aksi == 'add') {
							if (array_key_exists('default', $row['input'])) {
								$isi = $row['input']['default'];
							}
						}
					}

					if (array_key_exists('combo', $row['input']))
						$combo = $row['input']['combo'];
					else
						$combo = array();

					switch ($type) {
						case "manual_input":
							$content = $manual_input;
							if ($row['size'] == 100) {
								$size = '100%';
							}
							break;
						case 'string':
						case 'text':
							$content = $span_start;
							if ($row['size'] == 100) {
								$size = '100%';
							}

							$content .= form_input($label, $isi, " size=$row[size] class='form-control $error $align $typeahead $class_upper' $onChange $disabled $readOnly $placeholder id=$label $autofocus style='width:$size !important;' ");
							if (!empty($disabled)) {
								$content .= form_hidden($label, $isi);
							}
							$content .= $span_end;
							break;
						case 'text_tags':
							$content = $span_start;
							$content .= form_input($label, $isi, " size=$row[size] class='form-control $error $align' $disabled data-role='tagsinput' $placeholder id=$label $autofocus ");
							if (!empty($disabled)) {
								$content .= form_hidden($label, $isi);
							}
							$content .= $span_end;
							break;
						case 'multitext':
						case 'multitext:sms':
							$jmlhuruf = intval($row['size']) - intval(strlen($isi));
							++$i_left;
							$left = 'id_sisa_' . $i_left;
							$size = "100%";
							if (intval($row['size']) > 0) {
								$content = form_textarea($label, $isi, " id='$label' maxlength='$row[size]' size=$row[size] $disabled class='form-control $error $align ckeditor' rows='2' cols='5' style='overflow: hidden; width: $size !important; height: 104px;'  onblur='_maxLength(this , \"$left\")' onkeyup='_maxLength(this , \"$left\")' data-role='tagsinput' $autofocus ");
								$content .= '<br/><span class="text-warning">' . lang('msg_chr_left') . ' </span><span style="display:inline-block;height:20px;"><input id="' . $left . '" type="hidden" align="right" class="form-control" style="text-align:right;width:60px;" disabled="" name="f1_11_char_left" value="' . $jmlhuruf . '" size="5"><span id="span_' . $left . '"  align="right" class="badge" name="f1_11_char_left">' . $jmlhuruf . '</span></span>';
							} else {
								$content = form_textarea($label, $isi, " id='$label' maxlength='10000' size=$row[size] $disabled class='form-control $error $align' rows='2' cols='5' style='overflow: hidden; width: $size !important; height: 104px;' ");
							}
							if (!empty($disabled))
								$content .= form_hidden($label, $isi);

							break;
						case 'html':
							$content = $span_start;
							$content .= "<textarea name='$label'  id='$label' class='form-control' rows='10' $autofocus $disabled style='width:100%;'>$isi</textarea>";
							if (!empty($disabled))
								$content .= form_hidden($label, $isi);
							$content .= $span_end;
							break;
						case 'pass':
							$id_pass = 'password' . ++$nopass;
							$result_pass = "result" . $nopass;
							$content = form_password($label, '', " size=$row[size] $disabled class='form-control $error $align' autocomplete='off' id='$id_pass' $autofocus ");
							if (!empty($disabled))
								$content .= form_hidden($label, '');
							$content .= " &nbsp;<span id='$result_pass'></span>";
							break;
						case 'int':
						case 'integer':
							$content = form_input($label, $isi, " class='form-control angka $error $align'  $disabled size=$row[size] $onChange id=$label $readOnly $autofocus ");
							if (!empty($disabled))
								$content .= form_hidden($label, $isi);
							break;
							case 'number':
   								$addon="hide";
								if($row['input']['type']=="%"){
									$addon="";
								}
								$content = "<input type='number' name='$label' value='$isi' class='form-control numericdot $error $align' $disabled size='$row[size]' $onChange id='$label' $readOnly $autofocus>
								  <span class='input-group-addon ".$addon."' id='bobot'>".$row['input']['type']."</span>
";
								if (!empty($disabled)) {
									$content .= "<input type='hidden' name='$label' value='$isi'>";
								}
								break;
							
						case 'float':
							$isi = number_format(floatval($isi));
							if (empty($isi))
								$isi = 0;
							$content = form_input($label, $isi, " class='form-control rupiah $error $align'  $disabled size=$row[size] $onChange id=$label $readOnly $autofocus ");
							if (!empty($disabled))
								$content .= form_hidden($label, $isi);
							break;
						case 'intdot':
						case 'integerdot':
							$content = form_input($label, $isi, " class='form-control numericdot $error $align'  $disabled size=$row[size] $onChange id=$label $readOnly $autofocus ");
							if (!empty($disabled))
								$content .= form_hidden($label, $isi);
							break;
						case 'updown':
							if (empty($isi))
								$isi = 0;
							$content = form_input(array('type' => 'number', 'name' => $label), $isi, " $disabled class='form-control numeric $error $align' $readOnly size=$row[size] style='width:$row[size]px !important;' id=$label $autofocus ");
							if (!empty($disabled))
								$content .= form_hidden($label, $isi);
							break;
						case 'color':
							$content = form_input(array('type' => 'text', 'name' => $label), $isi, " $disabled class='$error colorpicker-default form-control' size=$row[size] style='height:30px;width:80px;background-color:$isi;' id=$label $autofocus ");
							if (!empty($disabled))
								$content .= form_hidden($label, $isi);
							break;
						case 'boolean':
							$content =  form_dropdown($label, array('-1' => '-', '0' => lang('msg_cbo_no'), '1' => lang('msg_cbo_yes')), $isi, "id=$label $disabled style='height:30px;width:100px' class='form-control' $autofocus ");
							if (!empty($disabled))
								$content .= form_hidden($label, $isi);
							break;
						case 'boolean:string':
							$content =  form_dropdown($label, array('' => '-', 'N' => lang('msg_cbo_no'), 'Y' => lang('msg_cbo_yes')), $isi, "id=$label $disabled style='height:30px;width:100px' class='form-control' $autofocus ");
							if (!empty($disabled))
								$content .= form_hidden($label, $isi);
							break;
						case 'combo':
							// $size=$row['size'].'px';
							$size = 'auto';
							if ($row['size'] == 100) {
								$size = '100%';
							} elseif ($row['size'] == 0) {
								$size = 'auto';
							}
							$content = '<div id="loadingmessage" class="waitting" style="display: none;"></div>';
							$content .= form_dropdown($label, $combo, $isi, "id=$label $disabled class='$error form-control' style='$style width:$size  !important;' $onChange $autofocus $readOnly ");
							if (!empty($disabled))
								$content .= form_hidden($label, $isi);
							break;

						case 'combo:search':
							$multi = '';
							// $size = $row['size'] . 'px'[]
							$size = $row['size'] * 5;
							$size .= 'px';
							if (array_key_exists('multiselect', $row)) {
								$size = '100%';
								$multi = ' multiple="multiple" ';
								$label = $label . '[]';
								if (!is_array($isi))
									$isi = explode(',', $isi);
							} elseif ($row['size'] == 100) {
								$size = '100%';
							}

							$content = form_dropdown($label, $combo, $isi, "id=$label $disabled class='$error form-control select2' style='$style width:$size;' $onChange $autofocus $multi ");
							if (!empty($disabled))
								$content .= form_hidden($label, $isi);
							break;
						case 'tags':
							$content = form_input($label, $isi, " id=$label size=$row[size] class='form-control $error $align tokenfield' $disabled $autofocus ");
							if (!empty($disabled))
								$content .= form_hidden($label, $isi);
							break;
							if (!empty($disabled))
								$content .= form_hidden($label, $isi);
							break;

						case 'date':
							++$nodate;
							$tgl = date('d-m-Y');
							if (!empty($isi)) {
								if ($isi == '01-01-1970')
									$isi = date('d-m-Y');
								else
									$isi = date('d-m-Y', strtotime($isi));
							}
							$content = form_input($label, $isi, " id=$label size=$row[size] class='form-control $error datepicker' $disabled style='width:130px;'  $readOnly $autofocus ");
							if (!empty($disabled))
								$content .= form_hidden($label, $isi);
							break;

						case 'datetime':
							++$nodate;
							$tgl = date('d-m-Y');
							if (!empty($isi))
								$tgl = date('d-m-Y', strtotime($isi));

							$content = form_input($label, $isi, " id=$label size=$row[size] class='form-control $error datetimepicker' $disabled style='width:130px;'  $readOnly $autofocus ");
							if (!empty($disabled))
								$content .= form_hidden($label, $isi);
							break;
						case 'upload':
							$content = '';
							$o = '<img id="img_' . $label . '" style="width:40%; margin-top:10px;"  src="" alt="image"/>';
							$oo = "";
							if (!empty($isi)) {
								$kel = 'img';
								if (array_key_exists('path', $row)) {
									$kel = $row['path'];
								}
								$nm = $kel . '_url';
								$ext = explode(".", $isi);
								$ext = $ext[count($ext) - 1];
								if ($ext == "jpg" || $ext == "png" || $ext == "jpeg" || $ext == "gif" || $ext == "bmp") {
									$pbaru = base_url()  . 'themes/file/' . $kel . '/' . $isi;
									$pd =  'themes##file##' . $kel . '##' . $isi;
									if ($kel == "news") {
										$pbaru = base_url()  . 'themes/upload/' . $kel . '/' . $isi;
										$pd =  'themes####upload####' . $kel . '####' . $isi;
									}

									// doi::dump($pbaru);
									// doi::dump($isi);
									$o = '<img id="img_' . $label . '" style="width:40%; margin-top:10px;"  src="' . $pbaru . '" alt="image"/>';
								}
								$nmFunc = $kel . '_path_relative';
								// die($nmFunc);
								// $result = get_file_info($pbaru);
								$size = 0;
								if ($result) {
									if ($result['size'] > 2000)
										$size = number_format($result['size'] / 1024) . ' kb';
									else
										$size = $result['size'] . ' byte';
								}
								$atts = array(
									// 'title'       => 'This is the link title', // Add your desired title here									
									'width'       => 700,
									'height'      => 700,
									'scrollbars'  => 'yes',
									'status'      => 'yes',
									'resizable'   => 'yes',
									'screenx'     => 50,
									'screeny'     => 40,
									'window_name' => '_blank'
								);

								
								// Menghasilkan path lokal dengan menggabungkan base path dan file
								$basePath = base_url() . 'themes/file/' . $kel . '/' . $isi;
							

								$response = @file_get_contents($basePath);

								// Jika file berhasil diakses
								if ($response !== false) {
									$pbaru = $basePath;
								} else {
									$pbaru = "";  // File tidak ditemukan
								}


								$xx = anchor_popup($pbaru, $isi, $atts);

								$oo = '<br/><span class="well"><a href="' . $pbaru . '" data-target="' . $kel . '" data-file="' . $isi . '" class="preview_file_temp pointer text-primary">' . $xx . '</a></span> 

								



								<br/><span style="padding-left:19px;"> </span><br/>&nbsp;<br/>';
								//ori
								// $oo='<br/><span class="well"><span data-url="'.base_url('ajax/download_preview/').'" data-target="'.$kel.'" data-file="'.$isi.'" class="preview_file pointer text-primary">'.$isi.'</span></span><br/><span style="padding-left:19px;">Size : '.$size.'</span><br/>&nbsp;<br/>';

																
//  <div class="btn tmbl-download" data-patch="localhost/peruri/themes/upload/news/" data-name="' . $isi . '" style="padding-left:10px; font-size:30px;">
//   <i class="fa fa-download "></i>
// </div>
// <a   href="' . base_url()  . 'regulasi_news/downloadfile/'. $isi.'/' . $pd . '">  <i class="fa fa-download "></i>
// </a>
							}
							$content = $o . $oo;
							$content .= form_upload($label, '', 'onchange="showMyImage(this,\'img_' . $label . '\')"');
							break;
						case 'radio':
							$content = "";
							foreach ($combo as $key => $cbo) {
								$check = false;
								if ($isi == $key) {
									$check = true;
								}
								$content .= form_radio($label, $key, $check, 'id="' . $label . '_' . $key . '" ');
								$content .= form_label($cbo . ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $label . '_' . $key, ['class' => 'pointer']);
							}
							break;
						case 'check':
							$br = '';
							if (array_key_exists('vertical', $row))
								if ($row['vertical'])
									$br = '<br/>';

							$content = "";
							$isi = explode(",", $isi);
							foreach ($combo as $key => $cbo) {
								$check = false;
								if (in_array($key, $isi)) {
									$check = true;
								}
								$content .= form_checkbox($label . '[]', $key, $check, 'id="' . $label . '_' . $key . '" ');
								$content .= form_label($cbo . ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $label . '_' . $key, ['class' => 'pointer']) . $br;
							}
							break;
						case 'free':
							if (array_key_exists('value', $row['input'])) {
								$content = $row['input']['value'];
							} else {
								$content = form_input($label, $isi, " size=$row[size] class='form-control $error $align $typeahead $class_upper' $onChange $disabled $readOnly $placeholder id=$label $autofocus ");
							}
							break;
					}
?>
					<?php
					if ($mode == 'a') {
						if (!empty($btn_label_accordion))
							echo $btn_label_accordion;
					?>
						<div class="form-group clearfix <?php echo $error; ?>">
							<label class="col-sm-2 control-label text-left" id="<?= $label . '_label'; ?>" style="text-align:left !important;">
								<?php echo $required . ' ' . $msg_title; ?><span class="pull-right">:<?= $help; ?></span>
							</label>
							<div class="col-sm-10 <?= $inline; ?>">
								<div id="<?= $label . '_parent'; ?>" class="<?= (($type == 'combo:search' || $type == 'html' ||  $type == 'tags' || $size == "100%") && (empty($span_right_addon) && empty($span_left_addon))) ? 'no-input-group' : 'input-group'; ?>">
									<?php echo $span_right . $span_right_addon . $content; ?>
									<?php echo $span_left_addon . $span_left . $btn_add; ?>
								</div>
								<?= form_error('l_' . $row['field'], '<div class="help-block">', '</div>'); ?>
								<?= $help_text; ?>
							</div>
						</div>
					<?php
					} else {
					?>
						<table class="table borderless no-border">
							<tr>
								<td colspan="3" style="text-align:left;">
									<div style="width:100%;">
										<label class="<?php echo $error; ?>">
											<strong><?php echo $required . ' ' . $msg_title; ?></strong>
										</label>
									</div>
								</td>
							</tr>
							<tr>
								<td colspan="3">
									<div style="width:100%;" id="<?= $label . '_detail'; ?>">
										<?php echo $content; ?>
										&nbsp;&nbsp; <?php echo $help; ?>
									</div>
									<?= $help_text; ?>
								</td>
							</tr>
						</table>
<?php
					}
				}
			}
		}
	}
}


?>
<script>
	$("form").submit(function() {
		pesan_toastr('Mohon Tunggu', 'info', 'Prosess', 'toast-top-center');
		looding("light", $(".right_col"));
		$("button, a").each(function(key, value) {
			$(this).addClass('disabled');
		})
		return true;
	});
</script>

<!-- Your existing HTML and CSS code -->
<script>
	document.addEventListener("DOMContentLoaded", function() {
		// Find the "tmbl-download" button element
		const downloadButton = document.querySelector(".tmbl-download");

		// Add a click event listener to the button
		downloadButton.addEventListener("click", function() {
			// Get the data attributes from the button
			const filePath = downloadButton.getAttribute("data-patch");
			const fileName = downloadButton.getAttribute("data-name");
		
			// // Create a dynamic link element
			const downloadLink = document.createElement("a");
			// downloadLink.href = filePath;
			// downloadLink.download = fileName;

			// // Append the link to the body
			// document.body.appendChild(downloadLink);

			// // Trigger the download
			downloadLink.click();
	if (file_exists(fileName)) {
				// Mengatur header HTTP
				header('Content-Type: application/octet-stream');
				header("Content-Disposition: attachment; filename=\"".fileName.
					"\"");
				header('Content-Length: '.filesize(filePath));
				// Membaca file dan mengirimkan isinya ke output
				readfile(filePath);
			}
			// // Clean up by removing the link element
			// document.body.removeChild(downloadLink);
		});
	});
</script>