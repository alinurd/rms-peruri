$(function () {
  $("#lbl_option").click(function () {
    $("#option").toggle();
  });

  $("#proses").click(function () {
    var tahun = $("#periode_no option:selected").text();
    $("#tahun").val(tahun);
    // var bulan2 = $("#bulan option:selected").text();
    // $("#bulan2").val(bulan2);
    var owner_no = $("#owner_no option:selected").text();
    var owner_name = owner_no.trim();
    $("#owner_name").val(owner_name);

    var data = $("#form_grafik").serialize();
    var parent = $(this).parent();
    var url = modul_name + "/get-grafik";
    // var target_combo = result_show();
    cari_ajax_combo("post", parent, data, "", url, "result_show");
  });
});

function result_show(hasil) {
  $("#risk_context").html(hasil.combo);
  $("#risk_criteria").html(hasil.risk_criteria);
  $("#risk_appetite").html(hasil.risk_appetite);
  $("#risk_register").html(hasil.risk_register);
  $("#efektifitas_control").html(hasil.efektifitas_control);
  $("#progress_treatment").html(hasil.progress_treatment);
  $("#loss_event_database").html(hasil.loss_event_database);
  $("#early_warning").html(hasil.early_warning);
  $("#perubahan_level").html(hasil.perubahan_level);
  $("#collapseOne").collapse("show");
  $("#collapseTwo").collapse("show");
  $("#collapseThree").collapse("show");
  $("#collapseFour").collapse("show");
  $("#collapseFive").collapse("show");
  $("#collapseSix").collapse("show");
  $("#collapseSeven").collapse("show");
  $("#collapseEight").collapse("show");
  $("#collapseNine").collapse("show");
}

$("#downloadPdf").on("click", function () {
  var skillsSelect = document.getElementById("owner_no");
  var owner1 = skillsSelect.options[skillsSelect.selectedIndex].text;
  var owner = owner1.trim();
  $("#golum").show();
  html2canvas(document.querySelector("#content_detail")).then((canvas) => {
    var doc = new jsPDF("l", "mm", "a4");
    var canvas_img = canvas.toDataURL("image/png");
    doc.addImage(canvas_img, "png", 10, 10, 280, 180, "", "FAST");
    doc.save("Risk-Distribution-" + owner + ".pdf");
    $("#golum").hide();
  });
});
function graph(datas, target) {
  var ctx = document.getElementById(target);
  var mybarChart = new Chart(ctx, {
    type: option.type,
    data: datas.data,

    options: {
      title: {
        display: option.title,
        text: datas.judul,
        fontSize: 14,
      },
      legend: {
        display: option.legend,
        labels: {
          fontColor: "rgb(255, 99, 132)",
          position: "left",
        },
        position: option.position,
      },
      tooltips: {
        enabled: true,
      },
      plugins: {
        datalabels: {
          formatter: (value, ctx) => {
            let sum = 0;
            let dataArr = ctx.chart.data.datasets[0].data;
            dataArr.map((data) => {
              sum += parseFloat(data);
            });
            let percentage = ((value * 100) / sum).toFixed(2) + "%";
            return percentage;
          },
          color: "#fff",
        },
      },
    },
  });
}
