var asal_event;
$(function () {
  $("#tema, #kategori, #sub_kategori").change(function () {
    var parent = $(this).parent();
    var id = $(this).attr("id");
    var nilai = $(this).val();
    var type = 0;
    var target_combo = "";
    if (id === "tema") {
      type = 1;
      target_combo = $("#kategori");
    } else if (id === "kategori") {
      type = 2;
      target_combo = $("#sub_kategori");
    } else if (id === "sub_kategori") {
      type = 3;
      target_combo = $("#event_no");
    }

    var data = { type: type, id: nilai };
    var url = "ajax/takstonomi";
    cari_ajax_combo("post", parent, data, target_combo, url);
  });

  $(document).on("ready", function () {
    //update level analisis Inherent
    var likelihood = $("#likeAnalisisInheren").val();
    var mode = $("#likeAnalisisInheren").data("mode");
    var month = $("#likeAnalisisInheren").data("month");
    var impact = $("#impactAnalisisInheren").val();

    var data = {
      likelihood: likelihood,
      impact: impact,
      mode: mode,
      month: month,
    };
    var parent = $(this).parent();
    var url = modul_name + "/cek-level";
    cari_ajax_combo("post", parent, data, "", url, "LevelAnalisisInheren");

    //update level analisis Residual
    var likelihood = $("#likeAnalisisResidual").val();
    var mode = $("#likeAnalisisResidual").data("mode");
    var month = $("#likeAnalisisResidual").data("month");
    var impact = $("#impactAnalisisResidual").val();
    var data = {
      likelihood: likelihood,
      impact: impact,
      mode: mode,
      month: month,
    };
    var parent = $(this).parent();
    var url = modul_name + "/cek-level";
    cari_ajax_combo("post", parent, data, "", url, "LevelAnalisisInheren");

    //update level Target
    for (var i = 1; i <= 12; i++) {
      var mode = 3;
      var month = i;
      var likelihood = $("#likeTargetResidual" + month).val();
      var impact = $("#impactTargetResidual" + month).val();

      if (mode !== undefined && month !== undefined && impact !== undefined) {
        var data = {
          likelihood: likelihood,
          impact: impact,
          mode: mode,
          month: month,
        };
        var parent = $(this).parent();
        var url = modul_name + "/cek-level";

        cari_ajax_combo("post", parent, data, "", url, "LevelAnalisisInheren");
      } else {
        console.error(
          "Error: Nilai mode, month, atau impact tidak terdefinisi dengan benar."
        );
      }
    }

    var event_no = $("#event_no").val();

    // all data
    $("#add_cause_newsx").hide();
      $("#risk_cousenox").hide();
      $("#add_impactx").hide();
      $("#add_impact").hide();
      $("#add_cause_news").show();
      $("#add_impact_news").show();
    // data mapping
    // if (event_no > 0) {
    //   $("#add_cause_newsx").hide();
    //   $("#risk_cousenox").hide();
    //   $("#add_impactx").hide();
    //   $("#add_impact").hide();
    //   $("#add_cause_news").show();
    //   $("#add_impact_news").show();
    // } else {
    //   $("#add_impactx").show();
    //   $("#risk_cousenox").show();
    //   $("#add_cause_newsx").show();
    //   $("#add_cause_news").hide();
    //   $("#add_impact_news").hide();
    // }

    var parent = $(this).parent();
    var kategori = $("#kategori").val();
    var data = {
      id: kategori,
    };
    var target_combo = $(".eventcombo");
    var url = "ajax/get_ajax_kelevent";
    cari_ajax_combo("post", parent, data, target_combo, url);

    $(".couse_text").hide();
    $(".impect_text").hide();
    var nilai = $(this).val();
    var kelompok = "subkel-library";
    var kel_targt = "subkel-library";
    var data = {
      id: nilai,
      kelompok: kel_targt,
    };
    var target_combo = $("#sub_kategori");
    var url = "ajax/get_ajax_combo";
    cari_ajax_combo("post", parent, data, target_combo, url);
  });
  $("#event_no").change(function () {
    $("#add_cause_news").show();
    $("#add_impact_news").show();
    $("#add_cause_newsx").hide();
    $("#add_impactx").hide();
  });
  $(document).on("click", "#add_cause_newsx, #add_impactx", function () {
    alert(" Pilih Detail Peristiwa Risiko (T5) Terlebih dahulu");
  });

  $(document).on("click", "#kriok", function () {
    $(".input_kri").toggleClass("hide");
    $(".list_kri").toggleClass("show");
    var $button = $(this);
    if ($button.text() === "Key Risk Indikator") {
      $button.text("Input Key Risk Indikator");
    } else {
      $button.text("Key Risk Indikator");
    }
  });

  $("#kategori").change(function () {
    var selectedId = $(this).val();
  });

  $("#add_sasaran").click(function () {
    var row = $("#tbl_sasaran > tbody");
    // row.append('<tr><td class="text-center">'+edit+'</td><td>'+sasaran+'</td><td>'+strategi+'</td><td>'+kebijakan+'</td><td class="text-center"><span class="text-primary" nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"<i class="fa fa-cut"></span></td></tr>');
    row.append(
      '<tr><td class="text-center">' +
        edit +
        "</td><td>" +
        sasaran +
        '</td><td class="text-center"><span class="text-primary" nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut"></span></td></tr>'
    );
  });

  $("#add_internal").click(function () {
    var row = $("#tbl_internal > tbody");
    row.append(
      '<tr><td class="text-center">' +
        edit_in +
        "</td><td>" +
        stakeholder_in +
        "</td><td>" +
        peran_in +
        "</td><td>" +
        komunikasi_in +
        "</td><td>" +
        potensi_in +
        '</td><td class="text-center"><span class="text-primary" nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut"></span></td></tr>'
    );
  });
  $("#add_external").click(function () {
    var row = $("#tbl_external > tbody");
    row.append(
      '<tr><td class="text-center">' +
        edit_ex +
        "</td><td>" +
        stakeholder_ex +
        "</td><td>" +
        peran_ex +
        "</td><td>" +
        komunikasi_ex +
        "</td><td>" +
        potensi_ex +
        '</td><td class="text-center"><span class="text-primary" nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut"></span></td></tr>'
    );
  });
  $("#add_probabilitas").click(function () {
    var row = $("#tbl_probabilitas > tbody");
    row.append(
      '<tr><td class="text-center">' +
        edit_p +
        "</td><td>" +
        deskripsi_p +
        "</td><td>" +
        sangat_kecil_p +
        "</td><td>" +
        kecil_p +
        "</td><td>" +
        sedang_p +
        "</td><td>" +
        besar_p +
        "</td><td>" +
        sangat_besar_p +
        '</td><td class="text-center"><span class="text-primary" nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut"></span></td></tr>'
    );
  });
  $("#add_dampak").click(function () {
    var row = $("#tbl_dampak > tbody");
    row.append(
      '<tr><td class="text-center">' +
        edit_d +
        "</td><td>" +
        deskripsi_d +
        "</td><td>" +
        sangat_kecil_d +
        "</td><td>" +
        kecil_d +
        "</td><td>" +
        sedang_d +
        "</td><td>" +
        besar_d +
        "</td><td>" +
        sangat_besar_d +
        '</td><td class="text-center"><span class="text-primary" nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut"></span></td></tr>'
    );
  });

  $(document).on("click", "li.reset", function () {
    var data_url = $(this).attr("url");
    var id = data_url.match(/\/(\d+)$/)[1];
    var url = modul_name + "/reset";
    var data = {
      id: id,
    };
    var parent = $(this).parent();
    cari_ajax_combo("post", parent, data, "", url, "result_show_modal_reset");
  });

  $(document).on("click", "#resetBtn", function () {
    // Array to store selected checkbox values
    let selectedValues = [];

    // Collect values from checked checkboxes
    $('input[name="check_item[]"]:checked').each(function () {
      selectedValues.push($(this).val());
    });

    // Check if any checkboxes were selected
    if (selectedValues.length === 0) {
      alert("Silakan pilih setidaknya satu data untuk direset."); // Alert if no checkbox is selected
      return; // Exit the function
    }

    var url = modul_name + "/reset"; // Define the URL for the AJAX request
    var data = {
      id: selectedValues, // Send selected values as an array
    };

    var parent = $(this).parent(); // Get the parent element of the button

    // Call the AJAX function to send data
    cari_ajax_combo("post", parent, data, "", url, "result_show_modal_reset");
  });

  $(document).on("click", "#btn-reset", function () {
    var idRCSAValues = [];

    // Menggunakan selektor atribut [name="id_rcsa[]"] untuk memilih elemen input
    $('input[name="id_rcsa[]"]').each(function () {
      idRCSAValues.push($(this).val());
    });

    var note = $("#note").val();

    var url = modul_name + "/proses_reset"; // Define the URL for the AJAX request
    var data = {
      id: idRCSAValues,
      note: note,
    };

    var parent = $(this).parent(); // Get the parent element of the button

    // Call the AJAX function to send data
    cari_ajax_combo("post", parent, data, "", url, "result_proses_reset");
  });

  $(document).on("click", "#cmdRisk_Register, .showRegister", function () {
    var id = $(this).data("id");
    var owner = $(this).data("owner");
    var data = { id: id, owner_no: owner };
    var parent = $(this).parent();
    var target_combo = "";
    var url = modul_name + "/get-register";

    cari_ajax_combo("post", parent, data, "", url, "show_register");
  });
  $(document).on("click", "#cmdRisk_Revisi, .showRevisi", function () {
    var id = $(this).data("id");
    var owner = $(this).data("owner");
    var data = { id: id, owner_no: owner };
    var parent = $(this).parent();
    var target_combo = "";
    var url = modul_name + "/get-rivis";

    cari_ajax_combo("post", parent, data, "", url, "show_revisi");
  });

  $(document).on("click", "#add_peristiwa, .edit-peristiwa", function () {
    var id = $(this).data("rcsa");
    var edit_no = $(this).data("id");
    var parent = 1;

    var data = { id: id, edit: edit_no };
    var target_combo = "";
    // var url = modul_name + "/add-peristiwa";
    var url = modul_name + "/tambah-peristiwa";

    cari_ajax_combo("post", parent, data, "", url, "show_peristiwa");
  });

  $(document).on("click", ".edit-level", function () {
    var id = $(this).data("rcsa");
    var edit_no = $(this).data("id");
    var data = { id: id, edit: edit_no };
    var parent = $(this).parent();
    var target_combo = "";
    var url = modul_name + "/edit-level";

    cari_ajax_combo("post", parent, data, "", url, "show_peristiwa");
  });

  $(document).on("click", ".show-mitigasi", function () {
    var id = $(this).data("rcsa");
    var edit_no = $(this).data("id");
    var data = { id: id, edit: edit_no };
    var parent = $(this).parent();
    var target_combo = "";
    var url = modul_name + "/input-mitigasi";

    cari_ajax_combo("post", parent, data, "", url, "show_peristiwa");
  });

  $(document).on("click", ".show-realisasi", function () {
    var id = $(this).data("rcsa");
    var edit_no = $(this).data("id");
    var data = { id: id, edit: edit_no };
    var parent = $(this).parent();
    var target_combo = "";
    var url = modul_name + "/list-realisasi";

    cari_ajax_combo("post", parent, data, "", url, "show_peristiwa");
  });

  $(document).on("click", ".delete-peristiwa", function () {
    if (confirm("Yakin akan menghapus data ini ?")) {
      var id = $(this).data("rcsa");
      var edit_no = $(this).data("id");
      var data = { rcsa_no: id, edit: edit_no };
      var parent = $(this).parent();
      var target_combo = "";
      var url = modul_name + "/delete-peristiwa";
      cari_ajax_combo("post", parent, data, "", url, "result_save_peristiwa");
    }
  });

  $(document).on("click", ".del_realisasi", function () {
    if (confirm("Yakin akan menghapus data ini ?")) {
      var id = $(this).data("rcsa");
      var edit_no = $(this).data("id");
      var data = { rcsa_no: id, edit: edit_no };
      var parent = $(this).parent();
      var target_combo = "";
      var url = modul_name + "/delete-realisasi";
      asal_event = $(this).closest("tr");

      cari_ajax_combo("post", parent, data, "", url, "result_delete_realisasi");
    }
  });

  $(document).on("click", "#couse_delete", function () {
    if (confirm("Yakin akan menghapus data ini ?")) {
      var edit_no = $(this).data("edit");
      var couseno = $(this).data("couseno");
      var data = { couseno: couseno, edit: edit_no };
      var parent = $(this).parent();
      var target_combo = "";
      var url = modul_name + "/delete-couse";
      asal_event = $(this).closest("tr");
      cari_ajax_singgle_del("post", data, url);
      //pesan_toastr('Mohon Tunggu', 'info', 'Prosess', 'toast-top-center', true);
      // alert('Simpan Key Risk Indikator ?')
      //location.reload(true);
    }
  });
  $(document).on("click", "#impct_delete", function () {
    if (confirm("Yakin akan menghapus data ini ?")) {
      var edit_no = $(this).data("edit");
      var impactno = $(this).data("impactno");
      var data = { impactno: impactno, edit: edit_no };
      var parent = $(this).parent();
      var target_combo = "";
      var url = modul_name + "/delete-impact";
      asal_event = $(this).closest("tr");
      cari_ajax_singgle_del("post", data, url);
      cari_ajax_singgle_del("post", data, url);
      //pesan_toastr('Mohon Tunggu', 'info', 'Prosess', 'toast-top-center', true);
    }
  });
  $(document).on("click", ".del_mitigasi", function () {
    if (confirm("Yakin akan menghapus data ini ?")) {
      var id = $(this).data("rcsa");
      var edit_no = $(this).data("id");
      var data = { rcsa_no: id, edit: edit_no };
      var parent = $(this).parent();
      var target_combo = "";
      var url = modul_name + "/delete-mitigasi";
      asal_event = $(this).closest("tr");
      cari_ajax_combo("post", parent, data, "", url, "result_delete_mitigasi");
    }
  });
  $(document).on("click", ".add-kri", function () {
    var row = $(this).closest("tbody");
    row.append(
      '<tr><td style="padding-left:0px;">' +
        riskEvent +
        riskEvent_no +
        '</td><td class="text-center"><i class="fa fa-search browse-kri text-primary pointer"></i> | <i class="fa fa-trash text-warning pointer" title="menghapus data" id="sip"></i></td></tr>'
    );
  });

  $(document).on("click", ".add-event", function () {
    var row = $(this).closest("tbody");
    row.append(
      '<tr><td style="padding-left:0px;">' +
        riskEvent +
        riskEvent_no +
        '</td><td class="text-center"><i class="fa fa-search browse-event text-primary pointer"></i> | <i class="fa fa-trash text-warning pointer" title="menghapus data" id="sip"></i></td></tr>'
    );
  });
  $(document).on("click", ".add-couse", function () {
    var row = $(this).closest("tbody");
    row.append(
      '<tr><td style="padding-left:0px;">' +
        riskCouse +
        riskCouse_no +
        '</td><td class="text-center"><i class="fa fa-search browse-couse text-primary pointer"></i> | <i class="fa fa-trash  text-warning pointer" title="menghapus data" id="sip"></i></td></tr>'
    );
  });
  $(document).on("click", ".add-impact", function () {
    var row = $(this).closest("tbody");
    row.append(
      '<tr><td style="padding-left:0px;">' +
        riskImpact +
        riskImpact_no +
        '</td><td class="text-center"><i class="fa fa-search browse-impact text-primary pointer"></i> | <i class="fa fa-trash text-warning pointer" title="menghapus data" id="sip"></i></td></tr>'
    );
  });

  $(document).on(
    "click",
    ".browse-couse, .browse-impact, .browse-event, .browse-kri",
    function () {
      // var event_no = $("#peristiwa").val();
      // var nilaidd = $('input[name="risk_event_no[]"]').val();
      // asal_event.find('input[name="risk_event_no[]"]').val(data[0]);

      if ($(this).hasClass("browse-event")) {
        event_no = $("#peristiwa").val();
      } else {
        var hiddenInputs = document.getElementsByName("risk_event_no[]");
        var nilai = hiddenInputs[0].value;
        var x = hiddenInputs;
      }

      if (event_no == "0") {
        alert("Event Wajib dipilih!");
        return false;
      }
      var kel = 0;
      if ($(this).hasClass("browse-couse")) {
        kel = 2;
      } else if ($(this).hasClass("browse-impact")) {
        kel = 3;
      } else if ($(this).hasClass("browse-event")) {
        kel = 1;
      } else if ($(this).hasClass("browse-kri")) {
        $("#peristiwa_modal").modal("show");
        kel = 4;
      }
      if (kel == 0) {
        alert("Salah Klik");
        return false;
      }
      var data = { id: nilai, kel: kel };
      var parent = $(this).closest("tr");
      asal_event = parent;
      var target_combo = "";
      var url = modul_name + "/get-library";
      if (kel == 1) {
        var url = modul_name + "/get-library-event";
      } else if (kel == 4) {
        var url = modul_name + "/get-kri";
      }

      cari_ajax_combo("post", parent, data, "", url, "show_event");
    }
  );

  $(document).on("click", ".close-library", function () {
    $("#input_peristiwa").removeClass("hide");
    $("#input_library").addClass("hide");
  });

  $(document).on("click", ".pilih-event", function () {
    var pilih = $(this).data("value");

    var data = pilih.split("#");
    if ($(this).hasClass("pilih-event")) {
      var arr = [];
      $('input[name="risk_event_no[]"]').each(function () {
        var value = $(this).val();
        if (value != 0) {
          arr.push(value);
        }
      });

      if (arr.indexOf(data[0]) == -1) {
        asal_event.find('textarea[name="risk_event[]"]').html(data[1]);
        asal_event.find('input[name="risk_event_no[]"]').val(data[0]);
        $(".close").trigger("click");
      } else {
        alert(
          "Data Penyebab Ini Telah Di Pilih, Silahkan Pilih Data Yang Lain!!"
        );
      }
    }
  });

  $(document).on("click", ".pilih-Couse, .pilih-Impact", function () {
    var pilih = $(this).data("value");
    var data = pilih.split("#");
    if ($(this).hasClass("pilih-Couse")) {
      var arr = [];
      $('input[name="risk_couse_no[]"]').each(function () {
        var value = $(this).val();
        if (value != 0) {
          arr.push(value);
        }
      });
      if (arr.indexOf(data[0]) == -1) {
        asal_event.find('textarea[name="risk_couse[]"]').html(data[1]);
        asal_event.find('input[name="risk_couse_no[]"]').val(data[0]);
        $(".close").trigger("click");
      } else {
        alert(
          "Data Penyebab Ini Telah Di Pilih, Silahkan Pilih Data Yang Lain!!"
        );
      }
    } else if ($(this).hasClass("pilih-Impact")) {
      var arr = [];
      $('input[name="risk_impact_no[]"]').each(function () {
        var value = $(this).val();
        if (value != 0) {
          arr.push(value);
        }
      });
      if (arr.indexOf(data[0]) == -1) {
        asal_event.find('textarea[name="risk_impact[]"]').html(data[1]);
        asal_event.find('input[name="risk_impact_no[]"]').val(data[0]);
        $(".close").trigger("click");
      } else {
        alert(
          "Data Dampak Ini Telah Di Pilih, Silahkan Pilih Data Yang Lain!!"
        );
      }
    }
  });

  $(document).on("click", "#simpan_peristiwa", function () {
  
    data = $("form#form_peristiwa").serialize();

    var parent = $(this).parent();
    var target_combo = "";
    var url = modul_name + "/simpan-peristiwa";
    //cari_ajax_singgle("post", data, url,);
    cari_ajax_combo("post", parent, data, "", url, "result_save_peristiwa");
  });

  $(document).on("click", "#simpan_level", function () {
    var id = $(this).data("id");
    var data = $("form#form_level").serialize();
    var parent = $(this).parent();
    var target_combo = "";
    var url = modul_name + "/simpan-level";

    cari_ajax_combo("post", parent, data, "", url, "result_save_peristiwa");
  });

  // $(document).on("click", "#simpan_mitigasi", function () {
  //   var id = $(this).data("id");

  //   var form = $("#form_mitigasi").get(0);
  //   var data = new FormData(form);
  //   // var data = $("form#form_mitigasi").serialize();
  //   var parent = $(this).parent();
  //   var target_combo = "";
  //   var url = modul_name + "/simpan-mitigasi";
  //   cari_ajax_combo_file("post", "#form_mitigasi", data, "", url, "sukses");
  //   // cari_ajax_combo_file("post", '#mitigasi_form', data, "", url, 'sukses');

  //   // cari_ajax_combo("post", parent, data, '', url, 'result_save_peristiwa');
  // });
  $(document).on("click", "#simpan_mitigasi", function () {
  	var id = $(this).data('id');
  	var data = $("form#form_mitigasi").serialize();
  	var parent = $(this).parent();
  	var target_combo = "";
  	var url = modul_name + "/simpan-mitigasi";

  	cari_ajax_combo("post", parent, data, '', url, 'result_save_peristiwa');
  })

  // $(document).on("change", "#residual_impact, #residual_likelihood", function () {
  // 	var likelihood = $("#residual_likelihood").val();
  // 	var impact = $("#residual_impact").val();
  // 	var data = { 'likelihood': likelihood, 'impact': impact };
  // 	var parent = $(this).parent();
  // 	var target_combo = "";
  // 	var url = modul_name + "/cek-level";

  // 	cari_ajax_combo("post", parent, data, '', url, 'result_level');
  // });
  $(document).on(
    "change",
    "#residual_impactx, #residual_likelihoodx",
    function () {
      var likelihood = $("#residual_likelihoodx").val();
      var impact = $("#residual_impactx").val();
      var data = { likelihood: likelihood, impact: impact };
      var parent = $(this).parent();
      var target_combo = "";
      var url = modul_name + "/cek-level";
      cari_ajax_combo("post", parent, data, "", url, "level_result_residual");
    }
  );

  $(document).on(
    "change",
    "#likeAnalisisInheren, #impactAnalisisInheren",
    function () {
      var likelihood = $("#likeAnalisisInheren").val();
      var mode = $("#likeAnalisisInheren").data("mode");
      var month = $("#likeAnalisisInheren").data("month");
      var impact = $("#impactAnalisisInheren").val();

      var data = {
        likelihood: likelihood,
        impact: impact,
        mode: mode,
        month: month,
      };
      var parent = $(this).parent();
      var url = modul_name + "/cek-level";

      cari_ajax_combo("post", parent, data, "", url, "LevelAnalisisInheren");
    }
  );

  $(document).on(
    "change",
    "#likeAnalisisResidual, #impactAnalisisResidual",
    function () {
      var likelihood = $("#likeAnalisisResidual").val();
      var mode = $("#likeAnalisisResidual").data("mode");
      var month = $("#likeAnalisisResidual").data("month");
      var impact = $("#impactAnalisisResidual").val();

      var data = {
        likelihood: likelihood,
        impact: impact,
        mode: mode,
        month: month,
      };
      var parent = $(this).parent();
      var url = modul_name + "/cek-level";

      cari_ajax_combo("post", parent, data, "", url, "LevelAnalisisInheren");
    }
  );
  // Penanganan untuk Target Risiko Residual (Bulan)
  $(document).on(
    "change",
    "[id^=likeTargetResidual], [id^=impactTargetResidual]",
    function () {
      var mode = $(this).data("mode");
      var month = $(this).data("month");

      var likelihood = $("#likeTargetResidual" + month).val();
      var impact = $("#impactTargetResidual" + month).val();

      if (mode !== undefined && month !== undefined && impact !== undefined) {
        var data = {
          likelihood: likelihood,
          impact: impact,
          mode: mode,
          month: month,
        };
        var parent = $(this).parent();
        var url = modul_name + "/cek-level";

        cari_ajax_combo("post", parent, data, "", url, "LevelAnalisisInheren");
      } else {
        console.error(
          "Error: Nilai mode, month, atau impact tidak terdefinisi dengan benar."
        );
      }
    }
  );

  $(document).on(
    "change",
    "#inherent_impact, #inherent_likelihood",
    function () {
      var likelihood = $("#inherent_likelihood").val();
      var impact = $("#inherent_impact").val();
      var data = { likelihood: likelihood, impact: impact };
      var parent = $(this).parent();
      var target_combo = "";
      var url = modul_name + "/cek-level";

      cari_ajax_combo("post", parent, data, "", url, "result_level");
    }
  );

  $(document).on("click", "#add_realisasi, .edit_realisasi", function () {
    var id = $(this).data("id");
    var rcsa_detail_no = $(this).data("parent");
    var rcsa_no = $(this).data("rcsa");
    var data = { id: id, rcsa_detail_no: rcsa_detail_no, rcsa_no: rcsa_no };
    var parent = $(this).parent();
    var target_combo = "";
    var url = modul_name + "/input-realisasi";

    cari_ajax_combo("post", parent, data, "", url, "show_realisasi");
  });

  $(document).on("click", "#add_mitigasi, .edit_mitigasi", function () {
    var id = $(this).data("id");
    var rcsa_detail_no = $(this).data("parent");
    var rcsa_no = $(this).data("rcsa");
    var data = { id: id, rcsa_detail_no: rcsa_detail_no, rcsa_no: rcsa_no };
    var parent = $(this).parent();
    var target_combo = "";
    var url = modul_name + "/input-mitigasi";

    cari_ajax_combo("post", parent, data, "", url, "show_mitigasi");
  });

  $(document).on("click", "#close_input_realisasi", function () {
    $("#list_realisasi").removeClass("hide");
    $("#input_realisasi").addClass("hide");
  });

  $(document).on("click", "#simpan_realisasi", function () {
    var id = $(this).data("id");
    var data = $("form#form_realisasi").serialize();
    var parent = $(this).parent();
    var target_combo = "";
    var url = modul_name + "/simpan-realisasi";

    cari_ajax_combo(
      "post",
      parent,
      data,
      target_combo,
      url,
      "result_realisasi"
    );
  });

  $(document).on("click", "#close_input_mitigasi", function () {
    $("#modal_general").modal("hide");
  });

  $(document).on("click", "#close_mitigasi", function () {
    var id = $(this).data("id");
    var rcsa_detail_no = $(this).data("parent");
    var rcsa_no = $(this).data("rcsa");
    var data = { id: id, rcsa_detail_no: rcsa_detail_no, rcsa_no: rcsa_no };
    var parent = $("#list_peristiwa").parent();
    var target_combo = $("#list_peristiwa");
    var url = modul_name + "/close-mitigasi";

    cari_ajax_combo("post", parent, data, target_combo, url);
    $("#modal_general").modal("hide");
  });

  $(document).on("click", "#close_realisasi", function () {
    var id = $(this).data("id");
    var rcsa_detail_no = $(this).data("parent");
    var rcsa_no = $(this).data("rcsa");
    var data = { id: id, rcsa_detail_no: rcsa_detail_no, rcsa_no: rcsa_no };
    var parent = $("#list_peristiwa").parent();
    var target_combo = $("#list_peristiwa");
    var url = modul_name + "/close-realisasi";

    cari_ajax_combo("post", parent, data, target_combo, url);
    $("#modal_general").modal("hide");
  });

  $(document).on("click", ".tab_lanjut", function () {
    var id = $(this).data("id");
    $("#" + id).tab("show");
  });
  // $(document).on("change","#inherent_level_label",function(){
  // 	// var parent = $(this).parent();
  // 	var ab = $("input[name='inherent_name']").val();
  // 	// var parent = document.getElementById("inherent_level_label").innerText;
  // 	var nilai = document.getElementsByName('inherent_name')[0].value;
  // 	var data={'id':nilai};
  // 	var target_combo = $("#treatment_no");
  // 	// var url = "ajax/get_rist_type";
  // 	// cari_ajax_combo("post", parent, data, target_combo, url);
  // })

  $(document).on("change", "input[name='status_loss']", function () {
    var nil = $("input[name='status_loss']:checked").val();
    if (nil == 0) {
      $(".mitigasi_1").removeClass("hide");
      $(".mitigasi_2").addClass("hide");
    } else if (nil == 1) {
      $(".mitigasi_1").addClass("hide");
      $(".mitigasi_2").removeClass("hide");
    }
  });

  $(document).on("click", "#add_library", function () {
    $("#konten_event").addClass("hide");
    $("#konten_add_library").removeClass("hide");
  });

  $(document).on("click", "#cancel_library", function () {
    $("#konten_event").removeClass("hide");
    $("#konten_add_library").addClass("hide");
    $("#input_peristiwa").addClass("show");
  });
  $(document).on("click", "#add_new_cause", function () {
    $(this).addClass("disabled");
    var theTable = document.getElementById("instlmt_cause");
    var rl = theTable.tBodies[0].rows.length;
    if (theTable.rows[rl].cells[1].childNodes[0].value == "0") {
      alert("Groups Tidak boleh Kosong!");
    } else {
      var lastRow = theTable.tBodies[0].rows[rl];
      var tr = document.createElement("tr");

      if ((rl - 1) % 2 == 0) tr.className = "dn_block";
      else tr.className = "dn_block_alt";

      var td1 = document.createElement("TD");
      td1.setAttribute("style", "text-align:center;width:10%;");
      var td2 = document.createElement("TD");
      td2.setAttribute("align", "left");
      var td3 = document.createElement("TD");
      td3.setAttribute("style", "text-align:center;width:10%;");

      ++rl;
      td1.innerHTML = rl + editCouse;
      td2.innerHTML = cbnCouse;
      td3.innerHTML =
        '<span nilai="0" style="cursor:pointer;" onclick="remove_install_cause(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';

      // tr.appendChild(td1);
      tr.appendChild(td2);
      tr.appendChild(td3);
      theTable.tBodies[0].insertBefore(tr, lastRow);
      $(".select2")
        .select2({
          allowClear: false,
          placeholder: " - Select - ",
          width: "100%",
        })
        .attr("id", "risk_couseno");
    }
    $("#add_new_cause").removeClass("disabled");
  });

  $(document).on("click", "#add_cause_news", function () {
    var theTable = document.getElementById("instlmt_cause");
    var rl = theTable.tBodies[0].rows.length;

    if (theTable.rows[rl].cells[1].childNodes[0].value == "0") {
      alert("Groups Tidak boleh Kosong!");
    } else {
      var lastRow = theTable.tBodies[0].rows[rl];
      var tr = document.createElement("tr");

      if ((rl - 1) % 2 == 0) tr.className = "dn_block";
      else tr.className = "dn_block_alt";

      var td1 = document.createElement("TD");
      td1.setAttribute("style", "text-align:center;width:10%;");
      var td2 = document.createElement("TD");
      td2.setAttribute("align", "left");
      var td3 = document.createElement("TD");
      td3.setAttribute("style", "text-align:center;width:10%;");

      ++rl;
      // nomornya
      // td1.innerHTML = rl + editCouse;
      // td2.innerHTML = cboCouse;

      td2.innerHTML =
        '<select name="risk_couse_no[]" class="select2 form-control" style="width:100%;" id="risk_couseno' +
        rl +
        '">';
      ("</select>");
      td3.innerHTML =
        '<span nilai="0" style="cursor:pointer;" onclick="remove_install_cause(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';

      // tr.appendChild(td1);
      tr.appendChild(td2);
      tr.appendChild(td3);
      theTable.tBodies[0].insertBefore(tr, lastRow);
      $(".select2").select2({
        allowClear: false,
        placeholder: " - Select - ",
        // id: 'risk_couseno' + rl,
        width: "100%",
      });
    }
    var parent = $(this).parent();
    var nilai = $("#event_no").val();
    var data = {
      id: nilai,
      type: 2,
    };
    var target_combo = $("#risk_couseno" + rl);
    var url = "ajax/get_ajax_libray_couse";
    cari_ajax_combo("post", parent, data, target_combo, url);
  });

  $(document).on("click", "#add_impact_news", function () {
    var theTable = document.getElementById("instlmt_impact");
    var rl = theTable.tBodies[0].rows.length;

    if (theTable.rows[rl].cells[1].childNodes[0].value == "0") {
      alert("Groups Tidak boleh Kosong!");
    } else {
      var lastRow = theTable.tBodies[0].rows[rl];
      var tr = document.createElement("tr");

      if ((rl - 1) % 2 == 0) tr.className = "dn_block";
      else tr.className = "dn_block_alt";

      var td1 = document.createElement("TD");
      td1.setAttribute("style", "text-align:center;width:10%;");
      var td2 = document.createElement("TD");
      td2.setAttribute("align", "left");
      var td3 = document.createElement("TD");
      td3.setAttribute("style", "text-align:center;width:10%;");

      ++rl;
      // nomornya
      // td1.innerHTML = rl + editCouse;
      // td2.innerHTML = cboCouse;

      td2.innerHTML =
        '<select name="risk_impact_no[]" class="select2 form-control" style="width:100%;" id="impactno' +
        rl +
        '">';
      ("</select>");
      td3.innerHTML =
        '<span nilai="0" style="cursor:pointer;" onclick="remove_install_cause(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';

      // tr.appendChild(td1);
      tr.appendChild(td2);
      tr.appendChild(td3);
      theTable.tBodies[0].insertBefore(tr, lastRow);
      $(".select2").select2({
        allowClear: false,
        placeholder: " - Select - ",
        // id: 'risk_couseno' + rl,
        width: "100%",
      });
    }

    var parent = $(this).parent();
    var nilai = $("#event_no").val();
    var data = {
      id: nilai,
      type: 3,
    };
    var target_combo = $("#impactno" + rl);
    var url = "ajax/get_ajax_libray_impact";
    cari_ajax_combo("post", parent, data, target_combo, url);
  });

  $(document).on("click", "#simpan_kri", function () {
    // $(this).addClass('disabled');

    var hiddenElement = document.getElementById("id_edit");
    var detail = hiddenElement.value;
    var hiddenElementrcsa_no = document.getElementById("rcsa_no");
    var rcsa_no = hiddenElementrcsa_no.value;

    var kri = $("#kri").val();
    var satuan = $("#satuan").val();
    var min_tinggi = $("#min_tinggi").val();
    var max_tinggi = $("#max_tinggi").val();
    var min_menengah = $("#min_menengah").val();
    var max_menengah = $("#max_menengah").val();
    var min_rendah = $("#min_rendah").val();
    var max_rendah = $("#max_rendah").val();
    var realisasi = $("#realisasi").val();
    var per_data = $("#per_data").val();

    var data = {
      rcsa_no: rcsa_no,
      id_edit: detail,
      kri: kri,
      satuan: satuan,
      min_tinggi: min_tinggi,
      max_tinggi: max_tinggi,
      min_rendah: min_rendah,
      max_menengah: max_menengah,
      min_menengah: min_menengah,
      max_rendah: max_rendah,
      per_data: per_data,
      realisasi: realisasi,
    };

    var parent = $(this).parent();
    var url = modul_name + "/simpan_kri";
    cari_ajax_singgle("post", data, url);

    // cari_ajax_combo("post", parent, data, '', url, "proses_simpan_library");
    // pesan_toastr('Mohon Tunggu', 'info', 'Prosess', 'toast-top-center', true);
    if (confirm("Simpan Key Risk Indikator & kembali ke list ?")) {
      var url = base_url + "rcsa/risk-event/" + detail + "/" + rcsa_no;

      window.location.href = url;
    } else {
      location.reload();
    }
  });

  $(document).on("click", "#simpan_library", function () {
    // $(this).addClass('disabled');
    var library = $("#add_event_name").val();
    var event_no = $('input[name="add_event_no"]').val();
    var kel = $('input[name="add_kel"]').val();

    //data  couse
    var couse = document.querySelectorAll('input[name="new_cause[]"]');
    var arrCous = [];
    for (var i = 0; i < couse.length; i++) {
      var nama = couse[i].value;
      arrCous.push(nama);
    }

    var impact = document.querySelectorAll('input[name="new_impact[]"]');
    var arrImpact = [];
    for (var i = 0; i < impact.length; i++) {
      var nama = impact[i].value;
      arrImpact.push(nama);
    }

    var selectElements = document.querySelectorAll(
      'select[name="new_cause_no[]"]'
    );
    var arrCous_no = [];
    selectElements.forEach(function (select) {
      var selectedOption = select.options[select.selectedIndex];
      var selectedValue = selectedOption.value;

      arrCous_no.push(selectedValue);
    });

    var selectElementsx = document.querySelectorAll(
      'select[name="new_impact_no[]"]'
    );
    var arrImpact_no = [];
    selectElementsx.forEach(function (select) {
      var selectedOption = select.options[select.selectedIndex];
      var selectedValue = selectedOption.value;

      arrImpact_no.push(selectedValue);
    });

    var arrCousx = arrCous.length > 0 ? arrCous : null;
    var arrImpactx = arrImpact.length > 0 ? arrImpact : null;
    var arrCous_nox = arrCous_no.length > 0 ? arrCous_no : null;
    var arrImpact_nox = arrImpact_no.length > 0 ? arrImpact_no : null;

    if (!library) {
      alert("Peristwa tidak boleh kosong!");
      return false;
    }
    var data = {
      library: library,
      kel: kel,
      event_no: event_no,
      // Data cause
      cause_name: arrCousx, // Menggunakan arrCous secara langsung
      cause_no: arrCous_nox,
      // Data impact
      impact_name: arrImpactx, // Menggunakan arrImpact secara langsung
      impact_no: arrImpact_nox,
    };

    var parent = $(this).parent();
    var url = modul_name + "/simpanLibrary";

    // alert("Tambahkan sebagai library peristiwa ? ");
    $(".close-library").trigger("click");

    cari_ajax_combo("post", parent, data, parent, url, "proses_simpan_library");
  });

  function calculateExposure() {
    var nilai_in_impact = $("#nilai_in_impact")
      .val()
      .replace(/[^0-9.-]+/g, ""); // Menghapus semua karakter kecuali angka dan tanda minus
    nilai_in_impact = parseFloat(nilai_in_impact) || 0; // Mengonversi ke float
    var nilai_in_likelihood = parseFloat($("#nilai_in_likelihood").val()) || 0;
    nilai_in_likelihood = nilai_in_likelihood / 100;
    var nilai_in_exposure = nilai_in_impact * nilai_in_likelihood;
    $("#nilai_in_exposure").val(
      nilai_in_exposure
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        .replace(".", ",")
    );
  }

  $("#nilai_in_impact, #nilai_in_likelihood").on("input", function () {
    calculateExposure();
  });

  function calculateResidualExposure() {
    var nilai_res_impact = $("#nilai_res_impact")
      .val()
      .replace(/[^0-9.-]+/g, "");
    nilai_in_impact = parseFloat(nilai_res_impact) || 0;
    var nilai_res_likelihood =
      parseFloat($("#nilai_res_likelihood").val()) || 0;
    nilai_res_likelihood = nilai_res_likelihood / 100;
    var nilai_res_exposure = nilai_res_impact * nilai_res_likelihood;
    $("#nilai_res_exposure").val(
      nilai_res_exposure
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        .replace(".", ",")
    );
  }

  // Event listener untuk input residual impact dan likelihood
  $("#nilai_res_impact, #nilai_res_likelihood").on("input", function () {
    calculateResidualExposure();
  });

  function calculateExposureMonth(month) {
    // Mengambil nilai impact dan menghapus karakter yang tidak diinginkan
    var nilai_impact = $("#nilai_impact" + month)
      .val()
      .replace(/[^0-9.-]+/g, ""); // Menghapus semua karakter kecuali angka dan tanda minus
    nilai_impact = parseFloat(nilai_impact) || 0; // Mengonversi ke float

    // Mengambil nilai likelihood dan mengonversi ke desimal
    var nilai_likelihood =
      parseFloat($("#nilai_likelihood" + month).val()) || 0;
    nilai_likelihood = nilai_likelihood / 100; // Mengonversi likelihood dari persen ke desimal

    // Menghitung exposure
    var nilai_exposure = nilai_impact * nilai_likelihood;

    // Menampilkan nilai exposure dengan format pemisah ribuan
    $("#nilai_exposure" + month).val(
      nilai_exposure
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ",") // Menambahkan koma sebagai pemisah ribuan
        .replace(".", ",") // Mengganti titik dengan koma untuk desimal
    );
  }

  // Menambahkan event listener untuk setiap bulan
  for (let index = 1; index <= 12; index++) {
    $("#nilai_impact" + index + ", #nilai_likelihood" + index).on(
      "input",
      function () {
        calculateExposureMonth(index);
      }
    );
  }

  $(document).on("click", "#simpan_analisis", function () {
      var id_detail                 = $("#id_detail").val();
      var analisis_like_inherent    = $("#likeAnalisisInheren").val();
      var analisis_impact_inherent  = $("#impactAnalisisInheren").val();
      var analisis_like_residual    = $("#likeAnalisisResidual").val();
      var analisis_impact_residual  = $("#impactAnalisisResidual").val();
      var inherent_level            = $("#inherent_level").val();
      var residual_level            = $("#residual_level").val();
      var nilai_in_impact           = $("#nilai_in_impact").val();
      var nilai_in_likelihood       = $("#nilai_in_likelihood").val();
      var nilai_in_exposure         = $("#nilai_in_exposure").val();
      var nilai_res_impact          = $("#nilai_res_impact").val();
      var nilai_res_likelihood      = $("#nilai_res_likelihood").val();
      var nilai_res_exposure        =   $("#nilai_res_exposure").val();
      var target_like               = [];
      var target_impact             = [];
      var month                     = [];
      var nilai_impact_array        = []; 
      var nilai_likelihood_array    = []; 
      var nilai_exposure_array      = [];

      // Loop untuk 12 bulan
      for (var i = 1; i <= 12; i++) {
          var like_value        = $("#likeTargetResidual" + i).val();
          var impact_value      = $("#impactTargetResidual" + i).val();
          var month_value       = $("#likeTargetResidual" + i).data("month");
          var nilai_impact      = $("#nilai_impact" + i).val();
          var nilai_likelihood  = $("#nilai_likelihood" + i).val();
          var nilai_exposure    = $("#nilai_exposure" + i).val();

          // Menyimpan bulan yang terisi
          if (like_value !== "" || impact_value !== "") {
              month.push(month_value);
          }

          // Menambahkan target_like jika terisi
          if (like_value !== "") {
              target_like.push(like_value);
          }

          // Menambahkan target_impact jika terisi
          if (impact_value !== "") {
              target_impact.push(impact_value);
          }

          // Menambahkan nilai jika terisi
          if (nilai_impact !== "") {
              nilai_impact_array.push(nilai_impact);
          }
          if (nilai_likelihood !== "") {
              nilai_likelihood_array.push(nilai_likelihood);
          }
          if (nilai_exposure !== "") {
              nilai_exposure_array.push(nilai_exposure);
          }
      }

      // Siapkan data yang akan dikirimkan
      var data = {
          id_detail: id_detail,
          analisis_like_inherent: analisis_like_inherent,
          analisis_impact_inherent: analisis_impact_inherent,
          analisis_like_residual: analisis_like_residual,
          analisis_impact_residual: analisis_impact_residual,
          nilai_in_impact: nilai_in_impact,
          nilai_in_likelihood: nilai_in_likelihood,
          nilai_in_exposure: nilai_in_exposure,
          nilai_res_impact: nilai_res_impact,
          nilai_res_likelihood: nilai_res_likelihood,
          nilai_res_exposure: nilai_res_exposure,
          inherent_level: inherent_level,
          residual_level: residual_level,
          target_impact: target_impact,
          target_like: target_like,
          nilai_impact: nilai_impact_array, // Menggunakan array yang benar
          nilai_likelihood: nilai_likelihood_array, // Menggunakan array yang benar
          nilai_exposure: nilai_exposure_array, // Menggunakan array yang benar
          month: month,
      };

      // Kirim data dengan ajax
      var parent = $(this).parent();
      var url = modul_name + "/simpan-analisis";

      cari_ajax_combo("post", parent, data, parent, url, "simpan_analisis");
  });
});

function simpan_analisis(hasil) {
  if (hasil.sts) {
    if (hasil.add) {
      pesan_toastr(
        "Berhasil disimpan...",
        "success",
        "Success",
        "toast-top-center",
        true
      );
      // Reload halaman dengan memastikan cache di-refresh
      location.reload(true);
    } else {
      pesan_toastr(
        "Berhasil disimpan...",
        "success",
        "Success",
        "toast-top-center",
        true
      );
      // Reload halaman tanpa memuat ulang cache
      location.reload(false);
    }
  } else {
    // Menampilkan pesan kesalahan yang diterima dari server
    var errorMessage = hasil.message || "Terjadi kesalahan!";
    pesan_toastr(
      errorMessage,
      "err",
      "Error",
      "toast-top-center",
      true
    );
  }
}

function LevelAnalisisInheren(hasil) {
  if (hasil.mode == 1) {
    $("#likeAnalisisInherenLabel").html(hasil.level_text);
    $("#inherent_level").val(hasil.level_no);
  } else if (hasil.mode == 2) {
    $("#likeAnalisisResidualLabel").html(hasil.level_text);
    $("#residual_level").val(hasil.level_no);
  } else {
    $("input[name='month']").val(hasil.month);
    $("#targetResidualLabel" + hasil.month).html(hasil.level_text);
  }
}

function proses_simpan_library(hasil) {
  // $("#cancel_library").trigger('click')
  $(".close-library").trigger("click");
  // $("#simpan_library").removeClass('disabled')
  // var data = { 'id': hasil.event_no, 'kel': hasil.kel };
  // var parent = $("#simpan_library").parent();
  // // asal_event = parent;
  // var target_combo = "";
  // var url = modul_name + "/get-library";

  // cari_ajax_combo("post", parent, data, '', url, 'show_event');
}

function show_register(hasil) {
  $("#modal_general").find(".modal-body").html(hasil.register);
  $("#modal_general").find(".modal-title").html("RISK REGISTER");
  $("#modal_general").modal("show");
}

function show_revisi(hasil) {
  $("#modal_general").find(".modal-body").html(hasil.register);
  $("#modal_general")
    .find(".modal-title")
    .html("Risk Context yang Harus di Perbaiki");
  $("#modal_general").modal("show");
}

function show_peristiwa(hasil) {
  $("#modal_general")
    .find(".modal-dialog")
    .removeClass("fullscreen")
    .addClass("semi-fullscreen");
  $("#modal_general").find(".modal-body").html(hasil.peristiwa);
  $("#modal_general").find(".modal-title").html("");
  $("#modal_general").modal("show");

  $(".datepicker").datetimepicker({
    timepicker: false,
    format: "d-m-Y",
    closeOnDateSelect: true,
    validateOnBlur: true,
    mask: false,
  });

  $(".select2").select2({
    allowClear: false,
    // width: 'style',
    // dropdownParent:	$('#modal_general')
    // dropdownParent: $('#modal_general .modal-content')
  });
  // 	$('select').select2({
  //     dropdownParent: $('#modal_general')
  // });

  // $(".hoho").select2({

  // 	// allowClear: false,
  // 	// width:'style',
  // 	dropdownParent:	$('#modal_general')
  // 	});

  $("#sasaran").select2({
    // dropdownParent: $('#modal_general .modal-content')
  });
  $("#peristiwa").select2({
    // dropdownParent: $('#modal_general')
  });
  $("#kategori").select2({
    // dropdownParent: $('#modal_general')
  });
  $.fn.modal.Constructor.prototype.enforceFocus = function () {
    var that = this;
    $(document).on("focusin.modal", function (e) {
      if ($(e.target).hasClass("select2-open")) {
        return true;
      }

      if (
        that.$element[0] !== e.target &&
        !that.$element.has(e.target).length
      ) {
        that.$element.focus();
      }
    });
  };
  // $('.select2').on('select2:open', function(e){
  // 	// $('.select2-container').parent().css('z-index', 99999);
  // 	$('.select2-container').css('z-index', 99999);
  // });
}

function show_event(hasil) {
  $("#input_library").removeClass("hide");
  $("#input_peristiwa").addClass("hide");
  $("#input_library").find(".x_panel").find(".x_content").html(hasil.library);
}

function result_save_peristiwa(hasil) {
  $("#list_peristiwa").html(hasil.combo);
    if(hasil.sasaran == 0){
      pesan_toastr(
        "Sasaran wajib dipilih!",
        "err",
        "Error",
        "toast-top-center",
        true
      );
      $('#sasaran').focus();
    }

    if(hasil.tema == 0){
      pesan_toastr(
        "Kategori Risiko (T2) wajib dipilih!",
        "err",
        "Error",
        "toast-top-center",
        true
      );
      $('#tema').focus();
    }

    if(hasil.kategori == 0){
      pesan_toastr(
        "Kelompok Risiko (T3) wajib dipilih!",
        "err",
        "Error",
        "toast-top-center",
        true
      );
      $('#kategori').focus();
    }

    if(hasil.sub_kategori == 0){
      pesan_toastr(
        "Sub-Kelompok Risiko (T4) wajib dipilih!",
        "err",
        "Error",
        "toast-top-center",
        true
      );
      $('#sub_kategori').focus();
    }

    if(hasil.subrisiko == 0){
      pesan_toastr(
        "Jenis Risiko wajib dipilih!",
        "err",
        "Error",
        "toast-top-center",
        true
      );
      $('#subrisiko').focus();
    }

    if(hasil.proses_bisnis == 0){
      pesan_toastr(
        "Proses Bisnis wajib diisi!",
        "err",
        "Error",
        "toast-top-center",
        true
      );
      $('#proses_bisnis').focus();
    }

    if(hasil.event_no == 0){
      pesan_toastr(
        "Detail Peristiwa Risiko (T5) wajib dipilih!",
        "err",
        "Error",
        "toast-top-center",
        true
      );
      $('#event_no').focus();
    }

    if(hasil.risk_couse_no == 0){
      pesan_toastr(
        "Penyebab wajib diisi!",
        "err",
        "Error",
        "toast-top-center",
        true
      );
      $('#risk_couse_no').focus();
    }

    if(hasil.risk_impact_no == 0){
      pesan_toastr(
        "Dampak wajib diisi!",
        "err",
        "Error",
        "toast-top-center",
        true
      );
      $('#risk_impact_no').focus();
    }
    if(hasil.risk_asumsi_perhitungan_dampak == 0){
      pesan_toastr(
        "Asumsi Perhitungan Dampak wajib diisi!",
        "err",
        "Error",
        "toast-top-center",
        true
      );
      $('#risk_asumsi_perhitungan_dampak').focus();
    }
    if(hasil.pic == 0){
      pesan_toastr(
        "PIC wajib diisi!",
        "err",
        "Error",
        "toast-top-center",
        true
      );
      $('#pic').focus();
    }

    if (hasil.sts == false) {
      var errorMessage = hasil.message;
      pesan_toastr(
        errorMessage,
        "err",
        "Error",
        "toast-top-center",
        true
      );

    }
    
    if (hasil.back) {
      $("#modal_general").modal("hide");
    }
}

function result_level(hasil) {
  $("#inherent_level_label").html(hasil.level_text);
  $("input[name='inherent_level']").val(hasil.level_no);
  $("input[name='inherent_name']").val(hasil.level_name);

  var bobo = '<option value="">' + hasil.level_resiko[""] + "</option>";
  Object.keys(hasil.level_resiko).forEach((key) => {
    if (key != "") {
      bobo +=
        '<option value="' + key + '">' + hasil.level_resiko[key] + "</option>";
    }
  });
  $("#treatment_no").html(bobo).change();
}

function level_result_residual(hasil) {
  $("#residual_level_label").html(hasil.level_text);
  $("input[name='residual_level']").val(hasil.level_no);
  $("input[name='residual_name']").val(hasil.level_name);

  var bobo = '<option value="">' + hasil.level_resiko[""] + "</option>";
  Object.keys(hasil.level_resiko).forEach((key) => {
    if (key != "") {
      bobo +=
        '<option value="' + key + '">' + hasil.level_resiko[key] + "</option>";
    }
  });
  $("#treatment_no").html(bobo).change();
}

function result_mitigasi(hasil) {
  $("#modal_general").modal("hide");
}

function show_mitigasi(hasil) {
  $("#input_mitigasi").removeClass("hide");
  $("#list_mitigasi").addClass("hide");
  $("#input_mitigasi").html(hasil.combo);
  $(".select2").select2();
  $(".datepicker").datetimepicker({
    timepicker: false,
    format: "d-m-Y",
    closeOnDateSelect: true,
    validateOnBlur: true,
    mask: false,
  });
}

function result_delete_realisasi(hasil) {
  if (hasil.sts == "1") {
    asal_event.remove();
  }
}

function result_delete_mitigasi(hasil) {
  if (hasil.sts == "1") {
    asal_event.remove();
  }
}

function result_realisasi(hasil) {
  $("#list_realisasi").removeClass("hide");
  $("#input_realisasi").addClass("hide");
  $("#list_realisasi").html(hasil.combo);
}

function show_realisasi(hasil) {
  $("#input_realisasi").removeClass("hide");
  $("#list_realisasi").addClass("hide");
  $("#input_realisasi").html(hasil.combo);
  $(".select2").select2();
  $(".datepicker").datetimepicker({
    timepicker: false,
    format: "d-m-Y",
    closeOnDateSelect: true,
    validateOnBlur: true,
    mask: false,
  });
}

$(function () {
  $("#add_cause").click(function () {
    // $(this).addClass('disabled');
    var theTable = document.getElementById("instlmt_cause");
    var rl = theTable.tBodies[0].rows.length;

    if (theTable.rows[rl].cells[1].childNodes[0].value == "0") {
      alert("Groups Tidak boleh Kosong!");
    } else {
      var lastRow = theTable.tBodies[0].rows[rl];
      var tr = document.createElement("tr");

      if ((rl - 1) % 2 == 0) tr.className = "dn_block";
      else tr.className = "dn_block_alt";

      var td1 = document.createElement("TD");
      td1.setAttribute("style", "text-align:center;width:10%;");
      var td2 = document.createElement("TD");
      td2.setAttribute("align", "left");
      var td3 = document.createElement("TD");
      td3.setAttribute("style", "text-align:center;width:10%;");

      ++rl;
      td1.innerHTML = rl + editCouse;
      td2.innerHTML = cboCouse;
      td3.innerHTML =
        '<span nilai="0" style="cursor:pointer;" onclick="remove_install_cause(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';

      tr.appendChild(td1);
      tr.appendChild(td2);
      tr.appendChild(td3);
      theTable.tBodies[0].insertBefore(tr, lastRow);
      $(".select2").select2({
        allowClear: false,
        placeholder: " - Select - ",
        width: "100%",
      });
    }
    $("#add_new_cause").removeClass("disabled");
  });
});

function remove_install_cause(t, iddel) {
  if (
    confirm(
      "Are you sure you want to permanently delete this transaction ?\nThis action cannot be undone"
    )
  ) {
    var ri = t.parentNode.parentNode.rowIndex;
    $("#spinner-save-tepat").show();
    //form = $("#frm_data_dashbord").serialize();
    var form = { iddel: iddel };
    var url = base_url + "risk-event-library/del-library";
    $.ajax({
      type: "POST",
      url: url,
      data: form,
      success: function (msg) {
        t.parentNode.parentNode.parentNode.deleteRow(ri - 1);
        // alert(msg + " record sukses dihapus");
      },
      failed: function (msg) {
        alert("gagal");
      },
    });
  }
  return false;
}

function add_install_impact() {
  $("#add_impact").removeClass("disabled").addClass("disabled");
  var theTable = document.getElementById("instlmt_impact");
  var rl = theTable.tBodies[0].rows.length;

  if (theTable.rows[rl].cells[1].childNodes[0].value == "0") {
    alert("Groups Tidak boleh Kosong!");
  } else {
    var lastRow = theTable.tBodies[0].rows[rl];
    var tr = document.createElement("tr");

    if ((rl - 1) % 2 == 0) tr.className = "dn_block";
    else tr.className = "dn_block_alt";

    var td1 = document.createElement("TD");
    td1.setAttribute("style", "text-align:center;width:10%;");
    var td2 = document.createElement("TD");
    td2.setAttribute("align", "left");
    var td3 = document.createElement("TD");
    td3.setAttribute("style", "text-align:center;width:10%;");

    ++rl;
    // td1.innerHTML = rl + editImpact;
    // td2.innerHTML = cboImpact;
    td2.innerHTML =
      '<select name="risk_impact_no[]" class="select2 form-control" style="width:100%;" id="impactno' +
      rl +
      '">';
    ("</select>");
    td3.innerHTML =
      '<span nilai="0" style="cursor:pointer;" onclick="remove_install_impact(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';

    // tr.appendChild(td1);
    tr.appendChild(td2);
    tr.appendChild(td3);
    theTable.tBodies[0].insertBefore(tr, lastRow);
    $(".select2").select2({
      allowClear: false,
      placeholder: " - Select - ",
      width: "100%",
    });
  }

  var parent = $(this).parent();
  var nilai = $(this).val();
  var data = {
    id: nilai,
    type: 3,
  };
  var target_combo = $("#impactno" + rl);
  var url = "ajax/get_ajax_libray_impact";
  cari_ajax_combo("post", parent, data, target_combo, url);
  // $("#add_impact").removeClass('disabled');
}
function add_new_install_impact() {
  $("#add_new_impact").removeClass("disabled").addClass("disabled");
  var theTable = document.getElementById("instlmt_impact");
  var rl = theTable.tBodies[0].rows.length;

  if (theTable.rows[rl].cells[1].childNodes[0].value == "0") {
    alert("Groups Tidak boleh Kosong!");
  } else {
    var lastRow = theTable.tBodies[0].rows[rl];
    var tr = document.createElement("tr");

    if ((rl - 1) % 2 == 0) tr.className = "dn_block";
    else tr.className = "dn_block_alt";

    var td1 = document.createElement("TD");
    td1.setAttribute("style", "text-align:center;width:10%;");
    var td2 = document.createElement("TD");
    td2.setAttribute("align", "left");
    var td3 = document.createElement("TD");
    td3.setAttribute("style", "text-align:center;width:10%;");

    ++rl;
    // td1.innerHTML = rl + editImpact;
    td2.innerHTML = cbiImpact;
    td3.innerHTML =
      '<span nilai="0" style="cursor:pointer;" onclick="remove_install_impact(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';

    // tr.appendChild(td1);
    tr.appendChild(td2);
    tr.appendChild(td3);
    theTable.tBodies[0].insertBefore(tr, lastRow);
    $(".select5").select2({
      allowClear: false,
      placeholder: " - Select - ",
      width: "100%",
    });
  }
  $("#add_new_impact").removeClass("disabled");
}

function remove_install_impact(t, iddel) {
  if (
    confirm(
      "Are you sure you want to permanently delete this transaction ?\nThis action cannot be uneefewfedone"
    )
  ) {
    var ri = t.parentNode.parentNode.rowIndex;
    $("#spinner-save-tepat").show();
    //form = $("#frm_data_dashbord").serialize();
    var form = { iddel: iddel };
    var url = '<?php echo base_url("risk-event-library/del-library");?>';
    $.ajax({
      type: "POST",
      url: url,
      data: form,
      success: function (msg) {
        t.parentNode.parentNode.parentNode.deleteRow(ri - 1);
        // alert(msg + " record sukses dihapus");
      },
      failed: function (msg) {
        alert("gagal");
      },
    });
  }
  return false;
}

function result_show_modal_reset(hasil) {
  $("#modal_general").find(".modal-body").html(hasil.cek);
  $("#modal_general").find(".modal-title").html("RESET DRAFTING RISK REGISTER");
  $("#modal_general").modal("show");
  //   console.log(hasil.id_rcsa[0]);
}

function result_proses_reset(hasil) {
  if (hasil.status == "success") {
    pesan_toastr(
      hasil.message,
      hasil.status,
      "Success",
      "toast-top-center",
      true
    );
  } else {
    pesan_toastr(
      hasil.message,
      hasil.status,
      "Error",
      "toast-top-center",
      true
    );
  }

  // Tambahkan waktu penundaan sebelum halaman di-reload
  setTimeout(function () {
    location.reload();
  }, 5000); // 3000 ms = 3 detik (sesuaikan sesuai kebutuhan)
}
