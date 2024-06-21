<style>
  .tree-container {
    position: absolute;
    left: 0px;
    width: 100%;
    margin-top: 100px;
  }

  .svgContainer {
    display: block;
      margin: auto;
  }

  .node {
    cursor: pointer;
  }

  .node-rect {
  }

  .node-rect-closed {
    stroke-width: 2px;
    stroke: rgb(0,0,0);
  }

  .link {
    fill: none;
    stroke: lightsteelblue;
    stroke-width: 2px;
  }

  .linkselected {
    fill: none;
    stroke: tomato;
    stroke-width: 2px;
  }

  .arrow {
    fill: lightsteelblue;
    stroke-width: 1px;
  }

  .arrowselected {
    fill: tomato;
    stroke-width: 2px;
  }

  .link text {
    font: 7px sans-serif;
    fill: #CC0000;
  }

  .wordwrap {
    white-space: pre-wrap; /* CSS3 */
    white-space: -moz-pre-wrap; /* Firefox */
    white-space: -pre-wrap; /* Opera <7 */
    white-space: -o-pre-wrap; /* Opera 7 */
    word-wrap: break-word; /* IE */
  }

  .node-text {
    font: 7px sans-serif;
    color: white;
  }

  .tooltip-text-container {
      height: 100%;
    width: 100%;
  }

  .tooltip-text {
    visibility: hidden;
    font: 7px sans-serif;
    color: white;
    display: block;
    padding: 5px;
  }

  .tooltip-box {
    background: rgba(0, 0, 0, 0.7);
    visibility: hidden;
    position: absolute;
    border-style: solid;
      border-width: 1px;
      border-color: black;
      border-top-right-radius: 0.5em;
  }

  p {
    display: inline;
  }

  .textcolored {
    color: orange;
  }

  a.exchangeName {
    color: orange;
  }
  
  b{
    font-size: 9px;;
  }
</style>


  <!-- Tab panes -->
  <?php foreach($master as $k => $v):?>
    <div style="margin-top:100px; text-align:center" >
    
      <h4><?= $v['name']?></h4>
      <div id="target-<?= $v['id']?>" ></div>

    </div>
  <?php endforeach ?>

</div>

<script>
  
  <?php foreach($master as $k => $v):?>
        <?php $dt = []?>
        <?php 
        
          $dt['name'] = "<b>".$v['name']."</b>";
          $dt['type'] = "type1";
          $dt['link']['direction'] = "ASYN";
        ?>
        <?php foreach($v['children'] as $ke => $ve):?>
    
          
            <?php 

              
              $dt['children'][]=[
                'name' => "<b>".$ve['name']."</b>",
                'type' => "type1",
                'link' => ['direction' => "ASYN"],
                'children' => [
                  [
                    "name" => $ve['children'],
                    'link' => ['direction' => "ASYN"]
                  ]
                ]
              ]

            ?>
            
        <?php endforeach ?>
    
    var data_<?= $v['id']?> = <?=json_encode($dt)?>;

    treeBoxes('', data_<?= $v['id']?>,"target-<?= $v['id']?>");
    <?php endforeach ?>
  
//     var datah = {
// 	"tree" : {
// 		"nodeName" : "NODE NAME 1",
// 		"name" : "NODE NAME 1",
// 		"type" : "type3",
// 		"code" : "N1",
// 		"label" : "Node name 1",
// 		"version" : "v1.0",
// 		"link" : {
// 				"name" : "Link NODE NAME 1",
// 				"nodeName" : "NODE NAME 1",
// 				"direction" : "ASYN"
// 			},
// 		"children" : [{
// 				"nodeName" : "NODE NAME 2.1",
// 				"name" : "NODE NAME 2.1",
// 				"type" : "type1",
// 				"code" : "N2.1",
// 				"label" : "Node name 2.1",
// 				"version" : "v1.0",
// 				"link" : {
// 						"name" : "Link node 1 to 2.1",
// 						"nodeName" : "NODE NAME 2.1",
// 						"direction" : "SYNC"
// 					},
// 				"children" : [{
// 						"nodeName" : "NODE NAME 3.1",
// 						"name" : "NODE NAME 3.1",
// 						"type" : "type2",
// 						"code" : "N3.1",
// 						"label" : "Node name 3.1",
// 						"version" : "v1.0",
// 						"link" : {
// 								"name" : "Link node 2.1 to 3.1",
// 								"nodeName" : "NODE NAME 3.1",
// 								"direction" : "SYNC"
// 							},
// 						"children" : []
// 					}, {
// 						"nodeName" : "NODE NAME 3.2",
// 						"name" : "NODE NAME 3.2",
// 						"type" : "type2",
// 						"code" : "N3.2",
// 						"label" : "Node name 3.2",
// 						"version" : "v1.0",
// 						"link" : {
// 								"name" : "Link node 2.1 to 3.2",
// 								"nodeName" : "NODE NAME 3.1",
// 								"direction" : "SYNC"
// 							},
// 						"children" : []
// 					}
// 				]
// 			}, {
// 				"nodeName" : "NODE NAME 2.2",
// 				"name" : "NODE NAME 2.2",
// 				"type" : "type1",
// 				"code" : "N2.2",
// 				"label" : "Node name 2.2",
// 				"version" : "v1.0",
// 				"link" : {
// 						"name" : "Link node 1 to 2.2",
// 						"nodeName" : "NODE NAME 2.2",
// 						"direction" : "ASYN"
// 					},
// 				"children" : []
// 			}, {
// 				"nodeName" : "NODE NAME 2.3",
// 				"name" : "NODE NAME 2.3",
// 				"type" : "type1",
// 				"code" : "N2.3",
// 				"label" : "Node name 2.3",
// 				"version" : "v1.0",
// 				"link" : {
// 						"name" : "Link node 1 to 2.3",
// 						"nodeName" : "NODE NAME 2.3",
// 						"direction" : "ASYN"
// 					},
// 				"children" : [{
// 						"nodeName" : "NODE NAME 3.3",
// 						"name" : "NODE NAME 3.3",
// 						"type" : "type1",
// 						"code" : "N3.3",
// 						"label" : "Node name 3.3",
// 						"version" : "v1.0",
// 						"link" : {
// 								"name" : "Link node 2.3 to 3.3",
// 								"nodeName" : "NODE NAME 3.3",
// 								"direction" : "ASYN"
// 							},
// 						"children" : [{
// 								"nodeName" : "NODE NAME 4.1",
// 								"name" : "NODE NAME 4.1",
// 								"type" : "type4",
// 								"code" : "N4.1",
// 								"label" : "Node name 4.1",
// 								"version" : "v1.0",
// 								"link" : {
// 										"name" : "Link node 3.3 to 4.1",
// 										"nodeName" : "NODE NAME 4.1",
// 										"direction" : "SYNC"
// 									},
// 								"children" : []
// 							}
// 						]
// 					}, {
// 						"nodeName" : "NODE NAME 3.4",
// 						"name" : "NODE NAME 3.4",
// 						"type" : "type1",
// 						"code" : "N3.4",
// 						"label" : "Node name 3.4",
// 						"version" : "v1.0",
// 						"link" : {
// 								"name" : "Link node 2.3 to 3.4",
// 								"nodeName" : "NODE NAME 3.4",
// 								"direction" : "ASYN"
// 							},
// 						"children" : [{
// 								"nodeName" : "NODE NAME 4.2",
// 								"name" : "NODE NAME 4.2",
// 								"type" : "type4",
// 								"code" : "N4.2",
// 								"label" : "Node name 4.2",
// 								"version" : "v1.0",
// 								"link" : {
// 										"name" : "Link node 3.4 to 4.2",
// 										"nodeName" : "NODE NAME 4.1",
// 										"direction" : "ASYN"
// 									},
// 								"children" : []
// 							}
// 						]
// 					}
// 				]
// 			}
// 		]
// 	}
// }

// treeBoxes('', datah.tree, 'tree-container');
// treeBoxes('', datah.tree, 'tree2');
</script>

