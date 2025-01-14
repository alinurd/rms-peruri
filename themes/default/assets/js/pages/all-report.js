$(function () {
  $("#lbl_option").click(function () {
    $("#option").toggle();
  });

  $("#proses").click(function () {
    var tahun = $("#periode_no option:selected").text();
    $("#tahun").val(tahun);
    var owner_no = $("#owner_no option:selected").text();
    var owner_name = owner_no.trim();
    $("#owner_name").val(owner_name);

    var data = $("#form_grafik").serialize();
    var parent = $(this).parent();
    var url = modul_name + "/get-grafik";
    cari_ajax_combo("post", parent, data, "", url, "result_show");
  });

  $("#downloadPdf").on("click", function () {
    var parent = $(this).parent();
    var owner_no = $("#owner_no").val();
    var periode_no = $("#periode_no").val();

    // Validasi input
    if (!owner_no || !periode_no) {
      alert("Periode dan Owner harus diisi!");
      return;
    }

    var imageElements = [
      "#heatmap",
      "#risk_distribution",
      "#risk_categories",
      "#grapik_efektifitas_control",
      "#grapik_progress_treatment",
    ];

    // Memeriksa apakah semua elemen gambar memiliki konten
    for (var i = 0; i < imageElements.length; i++) {
      var element = document.querySelector(imageElements[i]);
      if (!element || !element.innerHTML.trim()) {
        alert("Silahkan Proses Terlebih Dahulu.");
        return;
      }
    }

    looding("light", parent); // Menampilkan loading

    // Mengambil gambar dari elemen yang ditentukan
    Promise.all(
      imageElements.map(function (selector) {
        return html2canvas(document.querySelector(selector), { scale: 2 });
      })
    ).then((canvases) => {
      // Mengonversi canvas menjadi data URL
      var data = {
        periode_no: periode_no,
        owner_no: owner_no,
        heatmap: canvases[0].toDataURL("image/png"),
        risk_distribution: canvases[1].toDataURL("image/png"),
        risk_categories: canvases[2].toDataURL("image/png"),
        risk_efektifitas_control: canvases[3].toDataURL("image/png"),
        risk_progress_treatment: canvases[4].toDataURL("image/png"),
      };

      // Mengirim data ke server untuk menghasilkan PDF
      var url = modul_name + "/downloadPdf";
      fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/pdf",
        },
        body: JSON.stringify(data),
      })
        .then((response) => {
          if (response.ok) {
            return response.blob();
          } else {
            throw new Error("Gagal menghasilkan PDF");
          }
        })
        .then((blob) => {
          var blobUrl = URL.createObjectURL(blob);
          window.open(blobUrl, "_blank"); // Membuka PDF di tab baru
          stopLooding(parent); // Menghentikan loading
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("Gagal menghasilkan atau menampilkan PDF.");
          stopLooding(parent); // Menghentikan loading jika terjadi error
        });
    });
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
  $("#risk_distribution").html(hasil.risk_distribution);
  $("#risk_categories").html(hasil.risk_categories);
  $("#risk_tasktonomi").html(hasil.risk_tasktonomi);
  $("#grapik_efektifitas_control").html(hasil.grapik_efektifitas_control);
  $("#grapik_progress_treatment").html(hasil.grapik_progress_treatment);
  $("#heatmap").html(hasil.heatmap);
  $("#collapseOne").collapse("show");
  $("#collapseTwo").collapse("show");
  $("#collapseThree").collapse("show");
  $("#collapseFour").collapse("show");
  $("#collapseFive").collapse("show");
  $("#collapseSix").collapse("show");
  $("#collapseSeven").collapse("show");
  $("#collapseEight").collapse("show");
  $("#collapseNine").collapse("show");
  $("#collapseTen").collapse("show");
  $("#collapseEleven").collapse("show");
  $("#collapseTwelve").collapse("show");
  $("#collapseThirteen").collapse("show");
  $("#collapseFourteen").collapse("show");
  $("#collapseFiveteen").collapse("show");
}
function result_cetak(hasil) {
  console.log(hasil);
}

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

function graph_categories(datas, target) {
  var ctx = document.getElementById(target);
  var mybarChart = new Chart(ctx, {
    type: "radar",
    data: datas.data,

    options: {
      backgroundColor: "#ffffff",
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
    },
  });
}
