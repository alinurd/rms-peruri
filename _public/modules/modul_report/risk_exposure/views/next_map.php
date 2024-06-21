<?=draw_map_exposure($setting,50, $type, 0, $urut);?>
<br/>&nbsp;<br/>&nbsp;
<?php
if (intval($urut)>0){ ?>
<button type="button" class="btn btn-flat btn-primary" id="btn_back_list" typemap="<?=$type;?>"  data-urut="<?=$urut;?>"><< Kembali</button>
<?php } ?>