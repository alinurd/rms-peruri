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
    var tables = document.getElementsByClassName("table_grafik");
    for (var i = 0; i < tables.length; i++) {
      tables[i].style.display = "none"; // Menyembunyikan setiap tabel
    }
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

  $("#downloadExcel").on("click", function () {
    var owner_no = $("#owner_no").val();
    var periode_no = $("#periode_no").val();
    if (owner_no > 0 && periode_no) {
      var url =
        modul_name +
        "/exportExcel?owner_no=" +
        owner_no +
        "&periode_no=" +
        periode_no;
      window.location.href = url;
    } else {
      alert("Harap masukkan data yang diperlukan!");
    }
  });

  $("#downloadExcelRegister").on("click", function () {
    var owner_no = $("#owner_no").val();
    var periode_no = $("#periode_no").val();
    if (owner_no > 0 && periode_no) {
      var url =
        modul_name +
        "/exportExcelRegister?owner_no=" +
        owner_no +
        "&periode_no=" +
        periode_no;
      window.location.href = url;
    } else {
      alert("Harap masukkan data yang diperlukan!");
    }
  });

  $("#bulan").change(function () {
    var bulan = $(this).val();
    var owner_no = $("#owner_no").val();
    var periode_no = $("#periode_no").val();

    var parent = $(this).parent();
    var data = { owner_no: owner_no, periode_no: periode_no, bulan: bulan };
    // var target_combo = $("#mapping");
    var url = modul_name + "/get_map_residual";

    cari_ajax_combo("post", parent, data, "", url, "result_map");
  });

  $(document).on("click", ".sub_detail", function () {
    var parent = $(this).parent().parent();
    var id = $(this).data("id");
    var kel = $(this).data("kel");
    var data = { id: id };
    var target_combo = $("#sub_detail");
    var url = modul_name + "/get-subdetail";
    if (kel == "Target") {
      var bulan = $(this).data("bulan");
      var data = { id: id, bulan: bulan };
      var target_combo = $("#sub_detail_target");
      var url = modul_name + "/get-subdetailTarget";
    }

    cari_ajax_combo("post", parent, data, target_combo, url);
  });
});
function hoho(e) {
  var parent = $(e).parent();
  var nilai = $(e).data("nilai");

  if (nilai > 0) {
    var id = $(e).data("id");
    var kel = $(e).data("kel");
    var like = $(e).data("like");
    var impact = $(e).data("impact");
    var owner = $("#owner_no").val();
    var tahun = $("#period_no").val();
    var bulan = $("#bulan").val();
    // var bulanx = $("#bulanx").val();
    // console.log(kel + '2')
    var data = {
      id: id,
      owner: owner,
      tahun: tahun,
      // bulanx: bulanx,
      bulan: bulan,
      kel: kel,
      like: like,
      impact: impact,
    };
    // console.log(data)
    var target_combo = $("#detail_map");
    var url = modul_name + "/get-detail-map";

    if (kel == "residual1" || kel == "residual2") {
      var target_combo = $("#detail_map2");
      var url = modul_name + "/get-detail-map2";
      // console.log('masuk ke =>residual2')
    }
    if (kel == "residual") {
      var target_combo = $("#detail_map");
      var url = modul_name + "/get-detail-map-res";
      // get_detail_map_res
    }

    if (kel == "Target") {
      var target_combo = $("#detail_map");
      var url = modul_name + "/get-detail-map-target";
      // get_detail_map_res
    }
    console.log(kel);

    cari_ajax_combo("post", parent, data, target_combo, url, "show_detail");
  }
}

function result_map(hasil) {
  $("#mapping_residual").html(hasil.residual);
}

function show_detail(hasil) {
  $("#modal_general").find(".modal-body").html(hasil.combo);
  $("#modal_general").find(".modal-title").html("CORPORATE RISK");
  $("#modal_general").modal("show");
}

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

  if (hasil.combo.trim() === "") {
    if ($("#collapseOne").length) {
      $("#collapseOne").collapse("hide");
    }
  } else {
    if ($("#collapseOne").length) {
      $("#collapseOne").collapse("show");
    }
  }
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

function result_map(hasil) {
  // $("#mapping_inherent").html(hasil.inherent);
  $("#mapping_residual").html(hasil.residual);
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
