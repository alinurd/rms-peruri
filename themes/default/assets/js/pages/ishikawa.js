$(function(){
	$("#lbl_option").click(function(){
        $("#option").toggle();
    })

    $("#proses").click(function(){
		var parent = $(this).parent();
		var data=$("#form_grafik").serialize();
		var target_combo = $("#content_detail");
		var url = modul_name+"/get-grafik";

		cari_ajax_combo("post", parent, data, target_combo, url);
	});
	
	$("#owner_no,#periode_no").change(function(){
		var owner = $("#owner_no").val();
        var period = $("#periode_no").val();
        var data={'owner':owner, 'period':period};
        var target_combo = $("#risk_context");
		var url = modul_name+"/get-riskcontext";
		
		cari_ajax_combo("post", parent, data, target_combo, url);
	})
});

$(document).ready(function(){
    $("#owner_no").trigger('change');
})


function ishikawa_create(srcdata, target){
    // create the configurable selection modifier
    var fishbone = d3.fishbone();
      
    // load the data
    // d3.json(srcdata, function(data){
      // the most reliable way to get the screen size
    //   var size = (function(){
    //       return {width: this.clientWidth, height: this.clientHeight};
    //     }).bind(window.document.documentElement),

        var size = (function () {
            var g = window.document.documentElement;
            return {
                width: $(".tab-content .tab-pane").first().width() - 100,
                height: $(".tab-content .tab-pane").first().height() - 65
            };
        });
        
      
      svg = d3.select("#"+target)
        .append("svg")
        // firefox needs a real size
        .attr(size())
        // .attr("width", $('#target').width())
        // .attr("height", $('#target').height())
        // // set the data so the reusable chart can find it
        .datum(srcdata)
        // set up the default arrowhead
        // .call(fishbone.defaultArrow)
        // call the selection modifier
        .call(fishbone);
        
      // this is the actual `force`: just start it
      fishbone.force().size([size().width - 100, size().height]).start();
      
      // handle resizing the window
      d3.select("#"+target).on("resize", function(){
        
        fishbone.force()
          .size([size().width - 100, size().height])
          .start();
        svg.attr(size())
      });
      
    // });
}