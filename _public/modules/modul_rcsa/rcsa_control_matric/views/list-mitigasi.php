<?php
	$hide_edit='';
	$sts_risk=0;
	if (isset($parent['sts_propose']))
		$sts_risk=intval($parent['sts_propose']);
	if ($sts_risk>=1){
		$hide_edit=' hide ';
	}
?>
List Mitigasi:<br/>
<ul class="nav navbar-right panel_toolbox">
    <li><span class="btn btn-primary pointer  <?=$hide_edit;?>" id="add_mitigasi" data-id="0" data-parent="<?=$detail['id'];?>" data-rcsa="<?=$parent['id'];?>"> <i class="fa fa-plus"></i> Tambah </span></li>
    <li><span class="btn btn-warning pointer" id="close_mitigasi" data-id="0" data-parent="<?=$detail['id'];?>" data-rcsa="<?=$parent['id'];?>"> <i class="fa fa-close"></i>  Close </span></li>
</ul>
<div class="clearfix"></div>

<table class="display table table-bordered table-striped table-hover" id="tbl_mitigasi">
    <thead>
        <tr>
            <th width="5%">No.</th>
            <th>Proaktif</th>
            <th>Reaktif</th>
            <th width="10%">Biaya</th>
            <th width="10%">Target Waktu</th>
            <th width="5%">Progres</th>
            <th width="10%">Status</th>
            <th width="5%">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no=0;
        if($mitigasi){
        foreach($mitigasi as $key=>$row){?>
            <tr>
                <td><?=++$no;?></td>
                <td><?=$row['proaktif'];?></td>
                <td><?=$row['reaktif'];?></td>
                <td class="text-right"><?=number_format($row['amount']);?></td>
                <td><?=date('d-m-Y', strtotime($row['target_waktu']));?></td>
                <td class="text-center"><?=$row['progress'];?></td>
                <td class="text-center"><?=$row['status_no'];?></td>
                <td class="text-center">
                    <span class="pointer edit_mitigasi <?=$hide_edit;?>" data-id="<?=$row['id'];?>" data-parent="<?=$detail['id'];?>" data-rcsa="<?=$parent['id'];?>"> 
                        <i class="fa fa-pencil"></i>
                    </span>
                    <span class="pointer del_mitigasi <?=$hide_edit;?>" data-id="<?=$row['id'];?>"> 
                    | <i class="fa fa-trash pointer text-danger" data-id="<?=$row['id'];?>"></i>
                    </span>
                </td>
            </tr>
        <?php }} ?>
    </tbody>
</table>