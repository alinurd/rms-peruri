
<div class="table-responsive">
    <table class="display table table-bordered" id="tbl_event">
        <thead>
            <tr>
                <th width="5%">No.</th>
                <th >Risk Identify</th>
                <th class="text-center" width="20%">Risk Analysis</th>
                <th width="15%">Risk Evaluasi</th>
                <th width="15%">Risk Treatment</th>
                <!-- <th class="text-center" width="10%">Risk Level (residual)</th> -->
                <th width="10%">Progress Treatment</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($field as $key=>$row):?>
                <tr style="background-color:#d5edef;"><td colspan="7"><strong><?=strtoupper($row['nama']);?></strong></td></tr>
                <?php 
                $no=0;
                foreach($row['detail'] as $ros):
                    $mitigasi='';
                    $realisasi='';
                    if ($ros['jml_mitigasi']>0){
                        $mitigasi = '<span class="badge bg-primary">1</span>';
                    }
                    if ($ros['jml_realisasi']>0){
                        $realisasi = '<span class="badge bg-primary">'.$ros['jml_realisasi'].'</span>';
                    }
                ?>
                    <tr>
                        <td><?=++$no;?></td>
                        <td class="peristiwa  pointer">
                            <?=$ros['event_name'];?>
                            <div class="row-options pull-right">
                                <span class="edit-peristiwa pointer" data-id="<?=$ros['id'];?>" data-rcsa="<?=$ros['rcsa_no'];?>"><em>Edit</em> </span> | 
                                <span class="delete-peristiwa text-danger pointer" data-id="<?=$ros['id'];?>" data-rcsa="<?=$ros['rcsa_no'];?>"><em>Delete</em> </span>
                            </div>
                        </td>
                        <td class="edit text-center  pointer">
                            <?php
                            if ($ros['inherent_level']>0):
                                echo "<span style='background-color:".$ros['warna'].";color:".$ros['warna_text'].";'>&nbsp;".$ros['inherent_analisis']."&nbsp;</span>";;
                            ?>
                                &nbsp;&nbsp;<span class="text-primary pointer edit-level level" data-id="<?=$ros['id'];?>" data-rcsa="<?=$ros['rcsa_no'];?>"><i class="fa fa-pencil"></i></span>
                            <?php else:?>
                                &nbsp;&nbsp;<span class="text-primary pointer edit-level level" data-id="<?=$ros['id'];?>" data-rcsa="<?=$ros['rcsa_no'];?>"><i class="fa fa-plus"></i></span>
                            <?php endif;?>
                        </td>
                        <td class="edit text-center"><?=$ros['risk_control'];?></td>
                        <td class="edit text-center pointer">
                            <?php
                            if ($ros['sts_next']):
                                echo $mitigasi;?>&nbsp;&nbsp;<span class="text-primary pointer show-mitigasi level" data-id="<?=$ros['id'];?>" data-rcsa="<?=$ros['rcsa_no'];?>"><i class="fa fa-pencil"></i></span>
                            <?php
                            else:?>
                                <i class="fa fa-times-circle text-danger"></i><br/><?=$ros['treatment'];
                            endif;?>
                            </td>
<!--                         <td class="text-center pointer">
                            <?php
                            if ($ros['risk_level']>0)
                                echo "<span style='background-color:".$ros['warna_residual'].";color:".$ros['warna_text_residual'].";'>&nbsp;".$ros['residual_analisis']."&nbsp;</span>";
                            ?>
                        </td> -->
                        <td class="edit text-center pointer">
                            <?php
                            if (intval($parent['sts_propose'])<4):?>
                                <i class="fa fa-times-circle text-danger"></i><br/>need approval
                            <?php
                            elseif ($ros['sts_next']):
                                echo $realisasi;?>&nbsp;&nbsp;<span class="text-primary pointer show-realisasi level" data-id="<?=$ros['id'];?>" data-rcsa="<?=$ros['rcsa_no'];?>"><i class="fa fa-pencil"></i></span>
                             <?php else:?>
                                <i class="fa fa-times-circle text-danger"></i><br/><?=$ros['treatment'];
                            endif;?>
                            </td>
                    </tr>
                <?php 
                endforeach;
            endforeach;?>
        </tbody>
    </table>
</div>

<script>
$(function(){
    $("table tr td.peristiwa").mouseover(function(){
        $(".row-options").css('left', '-9999em')
        $(this).find(".row-options").css('left','0em');
    })

    $("table tr td.edit").mouseover(function(){
        $(".edit-level, .show-mitigasi, .show-realisasi").css('margin-top','-20px');
        $(".edit-level, .show-mitigasi, .show-realisasi").css('top','-9999em');
        $(this).find(".edit-level, .show-mitigasi, .show-realisasi").css('margin-top','0px');
        $(this).find(".edit-level, .show-mitigasi, .show-realisasi").css('top','40%');
    })
})
</script>