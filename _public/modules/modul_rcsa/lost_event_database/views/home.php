<?php
if ($this->session->userdata('result_proses')){
    $info = $this->session->userdata('result_proses');
    $this->session->set_userdata(array('result_proses'=>''));
    $sts_input='info';
}

if ($this->session->userdata('result_proses_error')){
    $info =  $this->session->userdata('result_proses_error');
    $this->session->set_userdata(array('result_proses_error'=>''));
    $sts_input='danger';
}
?>
<script>
	$(function() {
		var err="<?php echo $info;?>";
		var sts="<?php echo $sts_input;?>";
		if (err.length>0)
			pesan_toastr(err,sts);
	});
</script>
<div class="row">
    <div class="col-md-12">
        <!-- ==========================================
             Header: Loss Event Database Title and Breadcrumb
             ========================================== -->
        <div class="row">
            <div class="col-sm-8 panel-heading">
                <h3 style="padding-left: 10px;"><?= lang("msg_title");?></h3>
            </div>
            <div class="col-sm-4 text-right">
                <ul class="breadcrumb">
                    <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
                    <li><a href="#"><?= lang("msg_title");?></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="x_panel">
    <!-- ==========================================
         Filter Section: Year, Risk Owner, and Assessment Title Filters
         ========================================== -->
    <div class="x_title">
        <form method="GET" action="<?= site_url(_MODULE_NAME_REAL_.'/index'); ?>">
        <div class="row">
    <!-- Filter by Year (cboPeriod) -->
    <div class="col-md-2 col-sm-4 col-xs-6">
        <label for="filter_periode"><?= lang("msg_filter_periode_label"); ?></label>
        <select name="periode" id="filter_periode" class="form-control select2" style="width: 100%;">
            <?php foreach ($cboPeriod as $key => $value): ?>
                <option value="<?= ($key == 0) ? '0' : $value; ?>" <?= ($this->input->get('periode') == $value) ? 'selected' : ''; ?>>
                    <?= $value; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Filter by Risk Owner (cboOwner) -->
    <div class="col-md-4 col-sm-8 col-xs-6">
        <label for="filter_owner"><?= lang("msg_filter_owner_label"); ?></label>
        <select name="owner" id="filter_owner" class="form-control select2" style="width: 100%;">
            <?php foreach ($cboOwner as $key => $value): ?>
                <option value="<?= $key; ?>" <?= ($this->input->get('owner') == $key) ? 'selected' : ''; ?>>
                    <?= $value; ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Filter by Assessment Title (judulAssesment) -->
    <div class="col-md-4 col-sm-8 col-xs-6">
        <label for="filter_judul_assesment"><?= lang("msg_filter_assesment_label"); ?></label>
        <select name="judul_assesment" id="filter_judul_assesment" class="form-control select2" style="width: 100%;">
            <option value="">- select -</option>
        </select>
    </div>

    <!-- Filter Button -->
    <div class="col-md-2 col-sm-2 col-xs-2 mt-3" style="padding-top: 25px;">
        <button type="submit" class="btn btn-success text-white" >
            <span class="glyphicon glyphicon-search text-white"></span>
        </button>
        <button type="button" class="btn btn-primary text-white openModal" data-type="add">
            <span class="glyphicon glyphicon-plus text-white"></span>
        </button>
    </div>

</div>

        </form>
    </div>

    <!-- ==========================================
         Toolbox for Panel Collapse
         ========================================== -->
    <ul class="nav navbar-right panel_toolbox">
        <li class="pull-right"><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
    </ul>
    <div class="clearfix"></div>

    <!-- ==========================================
         Table Section: Data Display with Filters
         ========================================== -->
    <div class="x_panel">
        <div class="x_content table-responsive" style="overflow-x: auto;">
            <div class="row align-items-center">
                <!-- Select Assessment Title -->
                <!-- <div class="col-md-4 col-sm-8 col-xs-6">
                    <label for="rcsa_no" class="d-block"><?= lang("msg_filter_assesment_label");?></label>
                    <select name="rcsa_no" id="rcsa_no" class="form-control select2" style="width: 100%;">
                        <?php foreach ($judulAssesment as $key => $value): ?>
                            <option value="<?= $key; ?>"><?= $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div> -->

                
            </div>

            <!-- Table Display for Loss Event Data -->
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Risk Owner</th>
                        <th>Judul Assesment</th>
                        <th>Peristiwa Risiko</th>
                        <th>Tahun</th>
                        <th width="10%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($field as $q): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $q['name'] ?></td>
                            <td><?= $q['judul_assesment'] ?></td>
                            <td><?= $q['event_name'] ?></td>
                            <td><?= $q['tahun'] ?></td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="propose pointer btn btn-primary openModal" data-type="edit" data-id="<?= $q['id_loss_event']; ?>">Edit</button>
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li class="delete pointer" data-id="<?= $q['id_loss_event'] ;?>" id="deleteLost"><a href="#">Delete</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- ==========================================
             Pagination and Data Summary Section
             ========================================== -->
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="clearfix"></div>
                <?= $pagination; ?>
                <p>Menampilkan <?= $start_data; ?> - <?= $end_data; ?> dari total <?= $total_data; ?> data</p>
                <i><?= $timeLoad ?> second</i>
            </div> 
        </div>
    </div>
</section>

<div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true" style="display:none">
  <div class="modal-dialog modal-sm">
    <div class="modal-content modal-question">
      <div class="modal-header"><h4 class="modal-title"><?php echo lang('msg_del_header');?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id_lost">
        <p class="question"><?php echo lang('msg_del_title');?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo lang('msg_del_batal');?></button>
        <button type="button" class="btn btn-danger btn-grad" id="confirm"><?php echo lang('msg_del_hapus');?></button>
      </div>
    </div>
  </div>
</div>



<!-- ==========================================
     Popup Display Script
     ========================================== -->
<script>
    // Show popup
    function showPopup() {
        document.getElementById('infoPopup').style.display = 'block';
    }

    // Hide popup
    function hidePopup() {
        document.getElementById('infoPopup').style.display = 'none';
    }
</script>

<!-- ==========================================
     Custom Styles for Popup and Related Elements
     ========================================== -->
<style>
    /* Styling for popup display */
    .popup {
        display: none;
        position: absolute;
        padding: 10px;
        background-color: #f9f9f9;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        z-index: 9999;
    }

    #realisasi {
        position: relative;
        z-index: 1;
    }
</style>
