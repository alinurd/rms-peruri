<style>
    .note {color:gray;font-size: 0.8em;}

    .label-0{ font-size: 2em; }
    .label-1{ font-size: 1.5em; fill: #111; }
    .label-2{ font-size: 1em; fill: #444; }
    .label-3{ font-size: .9em; fill: #888; }
    .label-4{ font-size: .8em; fill: #aaa; }
    .label-5{ font-size: .8em; fill: #aaa; }
    .label-6{ font-size: .8em; fill: #aaa; }

    .link-0{ stroke: #000; stroke-width: 2px}
    .link-1{ stroke: #333; stroke-width: 1px}
    .link-2,
    .link-3,
    .link-4,
    .link-5,
    .link-6{ stroke: #666; stroke-width: .5px; }

    .link-positive { stroke: blue; }
    .link-negative { stroke: red; }

    .positive { fill: green; stroke: green; }
    .negative { fill: red; stroke: red; }
</style>

<div>
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <?php foreach($master as $k => $v):?>
    <li role="presentation" <?=($k==0)?'class="active"':'' ?> ><a href="#tab_<?= $v['id']?>" aria-controls="tab_<?= $v['id']?>" role="tab" data-toggle="tab" data-id="data_<?= $v['id']?>"><?= $v['name']?></a></li>
    <?php endforeach ?>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
  <?php foreach($master as $k => $v):?>
    <div role="tabpanel" class="tab-pane fade <?=($k==0)?'in active':'' ?>" id="tab_<?= $v['id']?>">
        <div id="target_<?= $v['id']?>" style="border: dotted 1px #000; min-height: 800px;overflow-x: scroll;max-width: 1500px;"></div>

    </div>
  <?php endforeach ?>
  </div>

</div>


<script>
    
    <?php foreach($master as $k => $v):?>
        <?php $dt = []?>
        <?php $dt['name'] = $v['name'];?>
        <?php foreach($v['children'] as $ke => $ve):?>
            <?php $dt['children'][]['name'] = $ve['name'];?>
        <?php endforeach ?>
    var data_<?= $v['id']?> = <?=json_encode($dt)?>;
    ishikawa_create(data_<?= $v['id']?>, "target_<?= $v['id']?>");
    <?php endforeach ?>

</script>

