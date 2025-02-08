<?php
$gender     = $this->authentication->get_info_user('kelamin');
$photo      = $this->authentication->get_Preference('list_photo');
$units      = $this->authentication->get_info_user('param_level');
$groups     = $this->authentication->get_info_user('group');
$info_owner = $this->authentication->get_info_user('group_owner');
?>

<!-- Dashboard Section -->
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-sm-8 panel-heading">
                <h3 style="padding-left:10px;">DASHBOARD</h3>
            </div>
            <div class="col-sm-4" style="text-align:right">
                <ul class="breadcrumb">
                    <li> <a href="#"> <i class="fa fa-home"></i> Home</a></li>
                    <li><a href="#">Dashboard</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Section -->
<section id="main-content">
    <section class="wrapper site-min-height">
        <div class="x_panel">
            <div class="row">
                <div class="col-md-12">
                    <div class="x_content">

                        <!-- Filter Form Section -->
                        <div class="row">
                            <div class="col-md-12">
                                <?php echo form_open_multipart(base_url('dashboard-operational'), array('id' => 'dashboard-operational')); ?>
                                <section class="x_panel">
                                    <header class="x_title">
                                        Filter
                                    </header>
                                    <div class="x_content">
                                        <table class="table borderless" style="width: 100% !important;">
                                            <tr class="">
                                                <td width="20%">Risk Owner :</td>
                                                <td width="80%" colspan="2">
                                                    <?php echo form_dropdown('owner_no', $cbo_owner, $post['owner_no'], ' id="owner_no" class=" form-control select2" style=" width:100%;"'); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Periode : </td>
                                                <td><?php echo form_dropdown('period_no', $cbo_period, 14, ' id="period_no" class=" form-control" style=" width:100%;"'); ?></td>
                                            </tr>
                                            <tr>
                                                <td>Bulan : </td>
                                                <td><?php echo form_dropdown('bulan', $cbo_bulan, 1, ' id="bulan" class=" form-control select2" style=" width:100%;"'); ?></td>
                                            </tr>
                                            <!-- <tr>
                                                <td>Sampai Bulan : </td>
                                                <td><?php echo form_dropdown('bulanx', $cbo_bulan, 12, ' id="bulanx" class=" form-control select2 " style=" width:100%;"'); ?></td>
                                            </tr> -->
                                        </table>
                                    </div>
                                </section>
                                <?php echo form_close(); ?>
                            </div>
                        </div>

                        <!-- Inherent & Residual Section -->
                        <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <section class="x_panel">
                                    <div class="x_title">
                                        <strong>Inherent & Residual</strong>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li class="pull-right"><a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content" style="overflow-x: auto;">
                                        <div class="profile-info col-md-4">
                                            <!-- <strong>Inherent </strong> -->
                                            <div class="x_content text-center" style="max-width: 100%;" id="mapping_inherent">
                                                <?= $mapping1['inherent']; ?>
                                            </div>
                                        </div>
                                        
                                        <div class="profile-info col-md-4">
                                            <div class="x_content text-center"  style="max-width: 100%;" id="mapping_residual">
                                                <?= $mapping1['residual']; ?>
                                            </div>
                                        </div>

                                        <div class="profile-info col-md-4">
                                            <div class="x_content text-center"  style="max-width: 100%;" id="mapping_residual1">
                                                <?= $mapping2['residual1']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>

                        <!-- Residual-1 and Residual-2 Section -->
                        <!-- <div class="row">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <section class="x_panel">
                                    <div class="x_title">
                                        <strong>Residual</strong>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li class="pull-right"><a class="collapse-link pull-right"><i class="fa fa-chevron-up"></i></a></li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content" style="overflow-x: auto;">
                                        <div class="profile-info col-md-6">

                                            <strong>Residual-1 </strong>
                                            </strong>
                                            <div class="x_content text-center" id="mapping_residual1">
                                                <?= $mapping2['residual1']; ?>
                                            </div>
                                        </div>
                                        <div class="profile-info col-md-6">
                                            <strong>Residual-2</strong>
                                            <div class="x_content text-center" id="mapping_residual2">
                                                <?= $mapping3['residual2']; ?>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div> -->
                    </div>

                    <!-- Overlay Spinner for loading -->
                    <div class="overlay hide" id="overlay_content">
                        <i class="fa fa-refresh fa-spin">asasas</i>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</section><!-- /.right-side -->


<!-- Notification Section -->
<div class=" text-center alert alert-warning alert-dismissible fade in <?= (empty($notif)) ? 'hide' : ''; ?>" role="alert" style="color:#000000;"><?= $notif; ?></div>


<!-- Profile Section (Hidden) -->
<div class="row hide">
    <!-- Profile Sidebar Section -->
    <aside class="profile-nav col-md-4 col-sm-4 col-xs-12">
        <!-- Profile Panel -->
        <section class="panel">
            <div class="panel-body">
                <a href="#" class="task-thumb">
                    <?php
                    $o = show_image($photo, 60);
                    echo $o;
                    ?>
                </a>
                <div class="task-thumb-details">
                    <h1><a href="#"><?php echo $this->authentication->get_info_user('nama_lengkap'); ?></a></h1>
                    <p><?php echo $this->authentication->get_info_user('email_user'); ?></p>
                </div>
            </div>
        </section>

        <!-- Navigation Links for Profile, Change Password, and Last Login -->
        <section class="panel">
            <ul class="nav nav-pills nav-stacked">
                <li><a href="<?php echo base_url('profile'); ?>"> 
                    <i class="fa fa-user"></i> 
                    <?php echo lang('msg_field_profile'); ?>
                </a></li>
                <li><a href="<?php echo base_url('change-password'); ?>"> 
                    <i class="fa fa-calendar"></i> 
                    <?php echo lang('msg_field_change_password'); ?>
                </a></li>
                <li><a href="#"> 
                    <i class="fa fa-calendar"></i> 
                    <?php echo lang('msg_field_last_login'); ?> 
                    <span class="label label-info pull-right r-activity">
                        <?php echo $this->authentication->get_info_user('last_visit_date'); ?>
                    </span>
                </a></li>
            </ul>
        </section>

        <!-- Navigation Links for Unit, Privileges, and Groups -->
        <section class="panel">
            <ul class="nav nav-pills nav-stacked">
                <li><a href="#"> 
                    <i class="fa fa-user"></i> 
                    <?php echo lang('msg_field_unit') . get_help('msg_help_unit'); ?> 
                    <?php echo ($info_owner['owner']) ? $info_owner['owner']['name'] : 'Operator Risk'; ?> 
                </a></li>
                <li><a href="#"> 
                    <i class="fa fa-calendar"></i> 
                    <?php echo lang('msg_field_unit') . get_help('msg_help_unit'); ?> 
                    <span class="label label-info pull-right r-activity">
                        <?php echo $info_owner['privilege_owner']['privilege_name']; ?>
                    </span>
                </a></li>
                <li><a href="#"> 
                    <i class="fa fa-calendar"></i> 
                    <?php echo lang('msg_field_group') . get_help('msg_help_group'); ?> 
                    <span class="label label-info pull-right r-activity">
                        <?php
                        if ($info_owner['group']) {
                            foreach ($info_owner['group'] as $gr) {
                                echo $gr . '<br/>';
                            }
                        }
                        ?>
                    </span>
                </a></li>
            </ul>

            <!-- Personal Task Table (Hidden by default) -->
            <table class="table table-hover personal-task hide">
                <tbody>
                    <tr>
                        <td width="2%">1</td>
                        <td>
                            <?php echo lang('msg_field_task_propose') . get_help('msg_help_task_propose'); ?>
                        </td>
                        <td>
                            <span class="badge bg-info" id="propose"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>
                            <?php echo lang('msg_field_task_action') . get_help('msg_help_task_action'); ?>
                        </td>
                        <td>
                            <span class="badge bg-warning" id="action"></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </aside>

    <!-- Risk Map / Peta Risiko Section -->
    <aside class="profile-nav col-md-8 col-sm-8 col-xs-12">
        <section class="panel" style="height: 407px">
            <div class="panel-body">
                <h3 style="color: #005398"><?php echo lang('msg_title_risk_map'); ?></h3>
                <div class="col-lg-6 col-md-7 col-sm-6 col-xs-8 pull-right">
                    <div class="x_content bio-graph-info text-center">
                        <?= draw_map($setting, 100, 'residual'); ?>
                    </div>
                </div>
            </div>
        </section>
    </aside>
</div>


<!-- <?php if (!empty($haha)) : ?>
<?php if ($haha['position_no'] == 12) : ?>
    <div class="row hide">     
<?php endif; ?>
<?php endif; ?> -->
<div class="row">
    <aside class="profile-info col-md-12 col-sm-12 col-xs-12">
        <section class="panel">
            <div class="panel-body bio-graph-info" style="overflow-x: auto;">
                <h1><strong><?php echo lang('msg_field_need_review'); ?></strong></h1>
                <table class="display table table-bordered table-striped dataTable table-hover" id="datatables_dashboard_propose">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <!-- <th><?php echo lang('msg_field_module'); ?></th> -->
                            <th>Judul Assessment</th>
                            <th>Risk Owner</th>
                            <!--                            <th>Jml Sasaran</th>
                            <th>Jml Peristiwa</th>
                            <th>Periode</th>
                            <th>Risk Register</th> -->
                            <!-- <th><?php echo lang('msg_field_task_description'); ?></th> -->
                            <th class="text-center">Proposed Date Risk Agent</th>
                            <th class="text-center">Proposed Date Kadep</th>
                            <th class="text-center">Proposed Date Kadiv</th>
                            <th class="text-center">Approved Date Admin</th>
                            <!-- <th>Approved Date</th> -->
                            <!-- <th><?php echo lang('msg_field_progress'); ?></th> -->
                            <!-- <th><?php echo lang('msg_field_status'); ?></th> -->
                            <?php if (!empty($haha)) : ?>
                                <?php if ($haha['position_no'] == 12) : ?>

                                <?php else : ?>
                                    <th class="text-center"><?php echo lang('msg_field_action'); ?></th>
                                <?php endif; ?>
                            <?php else : ?>
                                <th class="text-center"><?php echo lang('msg_field_action'); ?></th>
                            <?php endif; ?>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $jmlapp = 0;
                        foreach ($task['propose'] as $row) {
                            $url = $task['tipe'];
                            $id = $row->id;
                            if (empty($task['tipe'])) {
                                if ($row->sts_propose == 1) {
                                    $url = 'propose-div/propose/' . $id;
                                } elseif ($row->sts_propose == 2) {
                                    $url = 'approve-div/approval/' . $id;
                                } elseif ($row->sts_propose == 3) {
                                    $url = 'approve-admin/approval/' . $id;
                                }
                            } ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo $row->judul_assesment; ?></td>
                                <td><?php echo $row->name; ?></td>
                                <?php setlocale(LC_ALL, 'id_ID.UTF8', 'id_ID.UTF-8', 'id_ID.8859-1', 'id_ID', 'IND.UTF8', 'IND.UTF-8', 'IND.8859-1', 'IND', 'Indonesian.UTF8', 'Indonesian.UTF-8', 'Indonesian.8859-1', 'Indonesian', 'Indonesia', 'id', 'ID', 'en_US.UTF8', 'en_US.UTF-8', 'en_US.8859-1', 'en_US', 'American', 'ENG', 'English'); ?>
                                <?php
                                $aa = strftime("%d %B %Y", strtotime($row->date_propose));
                                $bb = strftime("%d %B %Y", strtotime($row->date_propose_kadep));
                                $cc = strftime("%d %B %Y", strtotime($row->date_approve_kadiv));
                                $dd = strftime("%d %B %Y", strtotime($row->date_approve_admin));
                                $ee = '<span style="background-color: blue;color:white">Belum di-Approve</span>';
                                $ff = '<span style="background-color: red;color:white">Revisi dari Kadiv</span>';
                                $gg = '<span style="background-color: red;color:white">Revisi dari Kadep</span>'; ?>
                                <?php if ($aa == "01 Januari 1970") : ?>
                                    <td style="text-align: center;"><?= $ee; ?></td>
                                <?php elseif ($row->sts_propose == 0 && $aa != "01 Januari 1970") : ?>
                                    <td style="text-align: center;"><?= $gg; ?></td>
                                <?php else : ?>
                                    <td style="text-align: center;"><?= $aa; ?></td>
                                <?php endif; ?>

                                <?php if ($bb != "01 Januari 1970" && $row->sts_propose == 2) : ?>
                                    <td style="text-align: center;"><?= $bb; ?></td>
                                <?php elseif ($row->sts_propose == 1 && $bb != "01 Januari 1970" && $row->note_approve_kadep != "") : ?>
                                    <td style="text-align: center;"><?= $ff; ?></td>
                                <?php elseif ($row->sts_propose == 3 && $bb != "01 Januari 1970") : ?>
                                    <td style="text-align: center;"><?= $bb; ?></td>
                                <?php else : ?>
                                    <td style="text-align: center;"><?= $ee; ?></td>

                                <?php endif; ?>

                                <?php if ($cc != "01 Januari 1970" && $row->sts_propose == 3) : ?>
                                    <td style="text-align: center;"><?= $cc; ?></td>
                                <?php else : ?>

                                    <td style="text-align: center;"><?= $ee; ?></td>
                                <?php endif; ?>

                                <?php if ($dd == "01 Januari 1970") : ?>
                                    <td style="text-align: center;"><?= $ee; ?></td>

                                <?php else : ?>
                                    <td style="text-align: center;"><?= $dd; ?></td>
                                <?php endif; ?>
                                <?php if (!empty($haha)) : ?>
                                    <?php if ($haha['position_no'] == 12) : ?>
                                    <?php else : ?>
                                        <td class="text-center"><a href="<?php echo base_url($url); ?>"><?php echo lang('msg_field_approve'); ?></a></td>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <td class="text-center"><a href="<?php echo base_url($url); ?>"><?php echo lang('msg_field_approve'); ?></a></td>
                                <?php endif; ?>
                            </tr>
                        <?php
                            $jmlapp++;
                        }
                        ?>
                    </tbody>
                </table>
                <?php  //doi::dump($this->authentication->get_info_user('param_level'));
                // doi::dump($this->authentication->get_info_user('group'));
                ?>
            </div>
        </section>
    </aside>
</div>

<script type="text/javascript">
    $(function() {
        loadTable('', 0, 'datatables_dashboard_propose');
        loadTable('', 0, 'datatables_dashboard');
    })
</script>
<script>
    $(function() {
        var currentDate = new Date();
        $("#datetimepickerx").datetimepicker({
            dateFormat: "yy-mm-dd", // Format tanggal (tahun-bulan-hari)
            timeFormat: "HH:mm:ss", // Format jam (24-jam:menit:detik)
            defaultDate: currentDate, // Nilai awal tanggal dan jam
            // Opsi tambahan sesuai kebutuhan
        });
    });

    var type_dash = '<?= $type_dash; ?>';
</script>