$(function(){
	$("#lbl_option").click(function(){
        $("#option").toggle();
    })


    $("#proses").click(function(){
		
        var tahun = $("#periode_no option:selected").text();
        $("#tahun").val(tahun);
        // var bulan2 = $("#bulan option:selected").text();
        // $("#bulan2").val(bulan2);
        var owner_no = $("#owner_no option:selected").text();
        var owner_name = owner_no.trim();
        $("#owner_name").val(owner_name);
        
		var data=$("#form_grafik").serialize();
        var parent = $(this).parent();
		var target_combo = $("#content_detail");
		var url = modul_name+"/get-grafik";

		cari_ajax_combo("post", parent, data, target_combo, url);
	});
	
// 	$("#owner_no,#periode_no").change(function(){
// 		var owner = $("#owner_no").val();
//         var period = $("#periode_no").val();
//         var data={'owner':owner, 'period':period};
//         var target_combo = $("#risk_context");
// 		var url = modul_name+"/get-riskcontext";
		
// 		cari_ajax_combo("post", parent, data, target_combo, url);
// 	})
});

// $(document).ready(function(){
//     $("#owner_no").trigger('change');
// })

$("#downloadPdf").on('click', function() {
    var skillsSelect = document.getElementById("owner_no");
    var owner1 = skillsSelect.options[skillsSelect.selectedIndex].text;
    var owner = owner1.trim()
    $("#golum").show();
        html2canvas(document.querySelector("#content_detail")).then(canvas => {
    var doc = new jsPDF('l', 'mm', "a4");
    var canvas_img = canvas.toDataURL("image/png");
    doc.addImage(canvas_img, 'png', 10,10,280,200,"","FAST"); 
    doc.save("Risk-Categories-"+owner+".pdf")
    $("#golum").hide();
	})
    });

function graph(datas, target){ 
			
	var ctx = document.getElementById(target);
	var mybarChart = new Chart(ctx, {
	type: "radar",
	data: datas.data,

	options: {
        backgroundColor:'#ffffff',
		title: {
            display: option.title,
            text: datas.judul,
			fontSize:14
        },
        legend: {
            display: option.legend,
            labels: {
                fontColor: 'rgb(255, 99, 132)',
                position: 'left'
            },
            position: option.position,
        },
        tooltips: {
            enabled: true
        }
	}
	});
}