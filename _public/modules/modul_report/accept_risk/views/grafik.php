<style>
    html, body, p { margin: 0; padding: 0; font-family: sans-serif;}

    .ellipsis {
        overflow: hidden;
        height: 200px;
        line-height: 25px;
        margin: 20px;
        border: 5px solid #AAA; }

    .ellipsis:before {
        content:"";
        float: left;
        width: 5px; height: 200px; }

    .ellipsis > *:first-child {
        float: right;
        width: 100%;
        margin-left: -5px; }        

    .ellipsis:after {
        content: "\02026";  

        box-sizing: content-box;
        -webkit-box-sizing: content-box;
        -moz-box-sizing: content-box;

        float: right; position: relative;
        top: -25px; left: 100%; 
        width: 3em; margin-left: -3em;
        padding-right: 5px;

        text-align: right;

        background: -webkit-gradient(linear, left top, right top,
            from(rgba(255, 255, 255, 0)), to(white), color-stop(50%, white));
        background: -moz-linear-gradient(to right, rgba(255, 255, 255, 0), white 50%, white);           
        background: -o-linear-gradient(to right, rgba(255, 255, 255, 0), white 50%, white);
        background: -ms-linear-gradient(to right, rgba(255, 255, 255, 0), white 50%, white);
        background: linear-gradient(to right, rgba(255, 255, 255, 0), white 50%, white); }
        #tree {
    width: 100%;
    height: 100%;
}
</style> 
    <div id="tree"></div>
    <br/>&nbsp;<hr>

<script src="themes/default/assets/js/pages/orgchart.js"></script>
<script>
    
    owner = <?=json_encode($owner)?>;
    bln = <?=json_encode($bln)?>;
    judul = <?=json_encode($judul)?>;
    post = <?=json_encode($post)?>;
    naruto = <?=json_encode($naruto)?>;
    sasaran = <?=json_encode($sasaran)?>;
 
    // console.log(naruto);
OrgChart.templates.myTemplate = Object.assign({}, OrgChart.templates.olivia);
OrgChart.templates.myTemplate.field_0 = '<text width="230" text-overflow="ellipsis"  style="font-size: 16px;" fill="#757575" x="125" y="50" text-anchor="middle">{val}</text>';

OrgChart.templates.myTemplate.field_1 = '<foreignObject x="0" y="0" width="230" height="100"><p xmlns="http://www.w3.org/1999/xhtml">{val}</p></foreignObject>';
OrgChart.templates.myTemplate.field_2 = '<text width="230" text-overflow="ellipsis"  style="font-size: 16px;" fill="#757575" x="225" y="15" text-anchor="middle">{val}</text>';

       function pdf(nodeId) {
            // chart.exportPDF({filename: "accountable-unit-data.pdf", expandChildren: true, nodeId: nodeId});
            chart.exportPDF({filename: "risk-ishikawa.pdf", expandChildren: false, nodeId: nodeId});
        }

var chart = new OrgChart(document.getElementById("tree"), {

                            mouseScrool: OrgChart.action.none,

            //scaleInitial:OrgChart.match.width,
            layout: OrgChart.mixed,
            // enableSearch: false,
            // template: "base",
            // layout: OrgChart.mixed,
            // showYScroll: OrgChart.scroll.visible, 
            // mouseScrool: OrgChart.action.yScroll,
            // scaleInitial: OrgChart.match.width,
            // layout: OrgChart.normal,
            template: "myTemplate",
            // collapse: {
            //     level: 2
            // },
        nodeBinding: {
            field_0: "name",
            
            field_1: "description",
            field_2: "title",
        },
        menu: {
                export_pdf: {
                    text: "Export PDF",
                    icon: OrgChart.icon.pdf(24, 24, "#7A7A7A"),
                    onClick: pdf
                }
            },
    });


        // chart.add({ id: post.owner_no, name: owner, description: "", title:bln });
        // chart.add({ id: post.judul_assesment, pid: post.owner_no, name: judul, title: ""});

        chart.add({ id: post.sasaran, name: "", description: sasaran, title:"" });
     
    $.each(naruto, function(key, val) {
        chart.add({ id: val.id, pid: post.sasaran, name:"", description: val.event_name, title:"" });
        chart.add({ id: (val.id+key),pid: val.id, name:"Penyebab", description: "", title:"" });
        chart.add({ id: (val.id+key+key),pid: val.id, name:"Dampak", description: "", title:"" });
        $.each(val.hoho, function(key1, val1) {
        chart.add({ id: (val1.id+key), pid: val.id+key, name: "" , description: val1.description, title:""  });
        })
         $.each(val.huhu, function(key2, val2) {
        chart.add({ id: (val2.id+key), pid: val.id+key+key, name: "" , description: val2.description, title:""  });
        })
    });

    chart.draw(OrgChart.action.init);
    
</script>