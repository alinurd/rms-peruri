var asal_event;
 


$(function () {
	$("#add_sasaran").click(function () {
		var row = $("#tbl_sasaran > tbody");
		// row.append('<tr><td class="text-center">' + edit + '</td><td>' + sasaran + '</td><td>' + statement + '</td><td>' + appetite + '</td><td>' + tolerance + '</td><td>' + limit +'</td><td class="text-center"><span class="text-primary" nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"<i class="fa fa-cut"></span></td></tr>');
		row.append('<tr><td class="text-center">' + edit + '</td><td>' + sasaran + '</td><td class="text-center"><span class="text-primary" nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut"></span></td></tr>');
	});

	// $("#add_sasaran_new").click(function () {
	// 	var row = $("#tbl_sasaran_new > tbody");
	// 	// row.append('<tr><td class="text-center">' + edit + '</td><td>' + sasaran + '</td><td>' + statement + '</td><td>' + appetite + '</td><td>-</td><td>' + appetite_max + '</td><td>' + tolerance + '</td><td>-</td><td>' + tolerance_max + '</td><td>' + limit + '</td><td>-</td><td>' + limit_max + '</td><td class="text-center"><span class="text-primary" nilai="0" style="cursor:pointer;" onclick="remove_installx(this,0)"><i class="fa fa-cut"></span></td></tr>');
	// 	row.append('<tr><td class="text-center">' + edit + '</td><td>' + sasaran + '</td><td>' + statement + '</td><td>' + appetite + '</td><td>-</td><td>' + appetite_max + '</td><td>' + tolerance + '</td><td>-</td><td>' + tolerance_max + '</td><td>' + limit + '</td><td class="text-center"><span class="text-primary" nilai="0" style="cursor:pointer;" onclick="remove_installx(this,0)"><i class="fa fa-cut"></span></td></tr>');
	// });

	$("#add_sasaran_new").click(function () {
		var row = $("#tbl_sasaran_new > tbody");
		var rowCount = row.children().length;  // Menghitung jumlah baris yang ada
	
		// Menyusun HTML untuk baris baru, dengan nomor urut yang benar
		var newRow = '<tr>';
		newRow += '<td class="text-center">' + (rowCount + 1) + edit + '</td>';  // Menambahkan nomor urut
		newRow += '<td>' + sasaran + '</td>';
		newRow += '<td>' + statement + '</td>';
		newRow += '<td>' + appetite + '</td>';
		newRow += '<td>-</td>';
		newRow += '<td>' + appetite_max + '</td>';
		newRow += '<td>' + tolerance + '</td>';
		newRow += '<td>-</td>';
		newRow += '<td>' + tolerance_max + '</td>';
		newRow += '<td>' + limit + '</td>';
		newRow += '<td class="text-center"><span class="text-primary" nilai="0" style="cursor:pointer;" onclick="remove_installx(this,0)"><i class="fa fa-cut"></i></span></td>';
		newRow += '</tr>';
		row.append(newRow);
	});


	$("#add_internal").click(function () {
		var row = $("#tbl_internal > tbody");
		row.append('<tr><td class="text-center">' + edit_in + '</td><td>' + stakeholder_in + '</td><td>' + peran_in + '</td><td>' + komunikasi_in + '</td><td>' + potensi_in + '</td><td class="text-center"><span class="text-primary" nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut"></span></td></tr>');
	});
	$("#add_external").click(function () {
		var row = $("#tbl_external > tbody");
		row.append('<tr><td class="text-center">' + edit_ex + '</td><td>' + stakeholder_ex + '</td><td>' + peran_ex + '</td><td>' + komunikasi_ex + '</td><td>' + potensi_ex + '</td><td class="text-center"><span class="text-primary" nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut"></span></td></tr>');
	});
	$("#add_probabilitas").click(function () {
		var row = $("#tbl_probabilitas > tbody");
		row.append('<tr><td class="text-center">' + edit_p + '</td><td>' + deskripsi_p + '</td><td>' + sangat_kecil_p + '</td><td>' + kecil_p + '</td><td>' + sedang_p + '</td><td>' + besar_p + '</td><td>' + sangat_besar_p + '</td><td class="text-center"><span class="text-primary" nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut"></span></td></tr>');
	});
	$("#add_dampak").click(function () {
		var row = $("#tbl_dampak > tbody");
		row.append('<tr><td class="text-center">' + edit_d + '</td><td>' + deskripsi_d + '</td><td>' + sangat_kecil_d + '</td><td>' + kecil_d + '</td><td>' + sedang_d + '</td><td>' + besar_d + '</td><td>' + sangat_besar_d + '</td><td class="text-center"><span class="text-primary" nilai="0" style="cursor:pointer;" onclick="remove_install(this,0)"><i class="fa fa-cut"></span></td></tr>');
	});

	$(document).on("click", "#cmdRisk_Register, .showRegister", function () {
		var id = $(this).data('id');
		var owner = $(this).data('owner');
		var data = { 'id': id, 'owner_no': owner };
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name + "/get-register";

		cari_ajax_combo("post", parent, data, '', url, 'show_register');
	})

	$(document).on("click", "#add_peristiwa, .edit-peristiwa", function () {
		var id = $(this).data('rcsa');
		var edit_no = $(this).data('id');
		var data = { 'id': id, 'edit': edit_no };
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name + "/add-peristiwa";

		cari_ajax_combo("post", parent, data, '', url, 'show_peristiwa');
	})

	$(document).on("click", ".edit-level", function () {
		var id = $(this).data('rcsa');
		var edit_no = $(this).data('id');
		var data = { 'id': id, 'edit': edit_no };
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name + "/edit-level";

		cari_ajax_combo("post", parent, data, '', url, 'show_peristiwa');
	})

	$(document).on("click", ".show-mitigasi", function () {
		var id = $(this).data('rcsa');
		var edit_no = $(this).data('id');
		var data = { 'id': id, 'edit': edit_no };
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name + "/input-mitigasi";

		cari_ajax_combo("post", parent, data, '', url, 'show_peristiwa');
	})

	$(document).on("click", ".show-realisasi", function () {
		var id = $(this).data('rcsa');
		var edit_no = $(this).data('id');
		var data = { 'id': id, 'edit': edit_no };
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name + "/list-realisasi";

		cari_ajax_combo("post", parent, data, '', url, 'show_peristiwa');
	})

	$(document).on("click", ".delete-peristiwa", function () {
		if (confirm('Yakin akan menghapus data ini ?')) {
			var id = $(this).data('rcsa');
			var edit_no = $(this).data('id');
			var data = { 'rcsa_no': id, 'edit': edit_no };
			var parent = $(this).parent();
			var target_combo = "";
			var url = modul_name + "/delete-peristiwa";
			cari_ajax_combo("post", parent, data, '', url, 'result_save_peristiwa');
		}
	})

	$(document).on("click", ".del_realisasi", function () {
		if (confirm("Yakin akan menghapus data ini ?")) {
			var id = $(this).data('rcsa');
			var edit_no = $(this).data('id');
			var data = { 'rcsa_no': id, 'edit': edit_no };
			var parent = $(this).parent();
			var target_combo = "";
			var url = modul_name + "/delete-realisasi";
			asal_event = $(this).closest('tr');

			cari_ajax_combo("post", parent, data, '', url, 'result_delete_realisasi');
		}
	})

	$(document).on("click", ".del_mitigasi", function () {
		if (confirm("Yakin akan menghapus data ini ?")) {
			var id = $(this).data('rcsa');
			var edit_no = $(this).data('id');
			var data = { 'rcsa_no': id, 'edit': edit_no };
			var parent = $(this).parent();
			var target_combo = "";
			var url = modul_name + "/delete-mitigasi";
			asal_event = $(this).closest('tr');
			cari_ajax_combo("post", parent, data, '', url, 'result_delete_mitigasi');
		}
	})

	$(document).on("click", ".add-event", function () {
		var row = $(this).closest("tbody");
		row.append('<tr><td style="padding-left:0px;">' + riskEvent + riskEvent_no + '</td><td class="text-center"><i class="fa fa-search browse-event text-primary pointer"></i> | <i class="fa fa-trash text-warning pointer" title="menghapus data" id="sip"></i></td></tr>');
	})
	$(document).on("click", ".add-couse", function () {
		var row = $(this).closest("tbody");
		row.append('<tr><td style="padding-left:0px;">' + riskCouse + riskCouse_no + '</td><td class="text-center"><i class="fa fa-search browse-couse text-primary pointer"></i> | <i class="fa fa-trash  text-warning pointer" title="menghapus data" id="sip"></i></td></tr>');
	})
	$(document).on("click", ".add-impact", function () {
		var row = $(this).closest("tbody");
		row.append('<tr><td style="padding-left:0px;">' + riskImpact + riskImpact_no + '</td><td class="text-center"><i class="fa fa-search browse-impact text-primary pointer"></i> | <i class="fa fa-trash text-warning pointer" title="menghapus data" id="sip"></i></td></tr>');
	})

	$(document).on("click", "table.peristiwa .fa-trash", function () {
		var ada = true;
		if (confirm("Are you sure?")) {
			if ($(this).hasClass("del-couse")) {
				ada = false;
				$(this).closest("tr").find('textarea[name="risk_couse[]"]').html('');
				$(this).closest("tr").find('input[name="risk_couse_no[]"]').val(0);
			} else if ($(this).hasClass("del-impact")) {
				ada = false;
				$(this).closest("tr").find('textarea[name="risk_impact[]"]').html('');
				$(this).closest("tr").find('input[name="risk_impact_no[]"]').val(0);
			} else if ($(this).hasClass("del-attact")) {
				ada = false;
				$(this).closest("tr").find('td:first-child').html('').append(attDetail);
			} else if ($(this).hasClass("del-event")) {
				var id = $(this).data('id');
				var data = { 'id': id };
				var parent = $(this).closest("tr");
				asal_event = parent;
				var target_combo = "";
				var url = modul_name + "/delete-event";

				cari_ajax_combo("post", parent, data, '', url);
			} else if ($(this).hasClass("del-mitigasi")) {
				var id = $(this).data('id');
				var data = { 'id': id };
				var parent = $(this).closest("tr");
				asal_event = parent;
				var target_combo = "";
				var url = modul_name + "/delete-mitigasi";

				cari_ajax_combo("post", parent, data, '', url);
			}

			if (ada) {
				var row = $(this).closest("tr");
				row.remove();
			}
		}
	})

	$(document).on("click", ".browse-couse, .browse-impact, .browse-event", function () {
		// var event_no = $("#peristiwa").val();
		// var nilaidd = $('input[name="risk_event_no[]"]').val();
		// asal_event.find('input[name="risk_event_no[]"]').val(data[0]);

		if ($(this).hasClass("browse-event")) {
			event_no = $("#peristiwa").val()
		}
		else {

			var hiddenInputs = document.getElementsByName("risk_event_no[]");
			var nilai = hiddenInputs[0].value;
			var x = hiddenInputs;
			console.log(x);
			console.log(nilai);
		}

		// var nilai = hiddenInputs[0].value;
		console.log(nilai);


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
		}
		if (kel == 0) {
			alert("Salah Klik");
			return false;
		}
		var data = { 'id': nilai, 'kel': kel };
		var parent = $(this).closest("tr");
		asal_event = parent;
		var target_combo = "";
		var url = modul_name + "/get-library";
		console.log(kel)
		if (kel == 1) {
			var url = modul_name + "/get-library-event";
		}

		cari_ajax_combo("post", parent, data, '', url, 'show_event');
	})

	$(document).on("click", ".close-library", function () {
		$("#input_peristiwa").removeClass("hide");
		$("#input_library").addClass("hide");
	})

	$(document).on("click", ".pilih-event", function () {
		var pilih = $(this).data("value");
		console.log(pilih)
		var data = pilih.split("#");
		if ($(this).hasClass("pilih-event")) {
			var arr = [];
			$('input[name="risk_event_no[]"]').each(function () {
				var value = $(this).val();
				if (value != 0) {
					arr.push(value);
				}
			});
			// console.log(data)
			if (arr.indexOf(data[0]) == -1) {
				asal_event.find('textarea[name="risk_event[]"]').html(data[1]);
				asal_event.find('input[name="risk_event_no[]"]').val(data[0]);
				$(".close-library").trigger("click");
			} else {
				alert('Data Penyebab Ini Telah Di Pilih, Silahkan Pilih Data Yang Lain!!');
			}
		}


	})


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
				$(".close-library").trigger("click");
			} else {
				alert('Data Penyebab Ini Telah Di Pilih, Silahkan Pilih Data Yang Lain!!');
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
				$(".close-library").trigger("click");
			} else {
				alert('Data Dampak Ini Telah Di Pilih, Silahkan Pilih Data Yang Lain!!');
			}

		}


	})



	$(document).on("click", "#simpan_peristiwa", function () {
		var id = $(this).data('id');
		var data = $("form#form_peristiwa").serialize();
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name + "/simpan-peristiwa";
		console.log(data)
		console.log(url)
		cari_ajax_combo("post", parent, data, '', url, 'result_save_peristiwa');
	})

	$(document).on("click", "#simpan_level", function () {
		var id = $(this).data('id');
		var data = $("form#form_level").serialize();
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name + "/simpan-level";

		cari_ajax_combo("post", parent, data, '', url, 'result_save_peristiwa');
	})

	$(document).on("click", "#simpan_mitigasi", function () {
		var id = $(this).data('id');
		var data = $("form#form_mitigasi").serialize();
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name + "/simpan-mitigasi";

		cari_ajax_combo("post", parent, data, '', url, 'result_save_peristiwa');
	})

	$(document).on("change", "#residual_impact, #residual_likelihood", function () {
		var likelihood = $("#residual_likelihood").val();
		var impact = $("#residual_impact").val();
		var data = { 'likelihood': likelihood, 'impact': impact };
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name + "/cek-level";

		cari_ajax_combo("post", parent, data, '', url, 'result_level');
	});

	$(document).on("change", "#inherent_impact, #inherent_likelihood", function () {
		var likelihood = $("#inherent_likelihood").val();
		var impact = $("#inherent_impact").val();
		var data = { 'likelihood': likelihood, 'impact': impact };
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name + "/cek-level";

		cari_ajax_combo("post", parent, data, '', url, 'result_level');
	});

	$(document).on("click", "#add_realisasi, .edit_realisasi", function () {
		var id = $(this).data('id');
		var rcsa_detail_no = $(this).data('parent');
		var rcsa_no = $(this).data('rcsa');
		var data = { 'id': id, 'rcsa_detail_no': rcsa_detail_no, 'rcsa_no': rcsa_no };
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name + "/input-realisasi";

		cari_ajax_combo("post", parent, data, '', url, 'show_realisasi');
	})

	$(document).on("click", "#add_mitigasi, .edit_mitigasi", function () {
		var id = $(this).data('id');
		var rcsa_detail_no = $(this).data('parent');
		var rcsa_no = $(this).data('rcsa');
		var data = { 'id': id, 'rcsa_detail_no': rcsa_detail_no, 'rcsa_no': rcsa_no };
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name + "/input-mitigasi";

		cari_ajax_combo("post", parent, data, '', url, 'show_mitigasi');
	})

	$(document).on("click", "#close_input_realisasi", function () {
		$("#list_realisasi").removeClass("hide");
		$("#input_realisasi").addClass("hide");
	});

	$(document).on("click", "#simpan_realisasi", function () {
		var id = $(this).data('id');
		var data = $("form#form_realisasi").serialize();
		var parent = $(this).parent();
		var target_combo = "";
		var url = modul_name + "/simpan-realisasi";

		cari_ajax_combo("post", parent, data, target_combo, url, 'result_realisasi');
	})

	$(document).on("click", "#close_input_mitigasi", function () {
		$("#modal_general").modal("hide");
	});

	$(document).on("click", "#close_mitigasi", function () {
		var id = $(this).data('id');
		var rcsa_detail_no = $(this).data('parent');
		var rcsa_no = $(this).data('rcsa');
		var data = { 'id': id, 'rcsa_detail_no': rcsa_detail_no, 'rcsa_no': rcsa_no };
		var parent = $("#list_peristiwa").parent();
		var target_combo = $("#list_peristiwa");
		var url = modul_name + "/close-mitigasi";

		cari_ajax_combo("post", parent, data, target_combo, url);
		$("#modal_general").modal("hide");
	})

	$(document).on("click", "#close_realisasi", function () {
		var id = $(this).data('id');
		var rcsa_detail_no = $(this).data('parent');
		var rcsa_no = $(this).data('rcsa');
		var data = { 'id': id, 'rcsa_detail_no': rcsa_detail_no, 'rcsa_no': rcsa_no };
		var parent = $("#list_peristiwa").parent();
		var target_combo = $("#list_peristiwa");
		var url = modul_name + "/close-realisasi";

		cari_ajax_combo("post", parent, data, target_combo, url);
		$("#modal_general").modal("hide");
	})

	$(document).on("click", ".tab_lanjut", function () {
		var id = $(this).data('id');
		$('#' + id).tab('show');
	})
	// $(document).on("change","#inherent_level_label",function(){
	// 	// var parent = $(this).parent();
	// 	var ab = $("input[name='inherent_name']").val();
	// 	console.log(ab);
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
			$('.mitigasi_1').removeClass('hide');
			$('.mitigasi_2').addClass('hide');
		} else if (nil == 1) {
			$('.mitigasi_1').addClass('hide');
			$('.mitigasi_2').removeClass('hide');
		}
	});

	$(document).on("click", "#add_library", function () {
		$("#konten_event").addClass('hide');
		$("#konten_add_library").removeClass('hide');
	})

	$(document).on("click", "#cancel_library", function () {
		$("#konten_event").removeClass('hide');
		$("#konten_add_library").addClass('hide');
	})
	$(document).on("click", "#add_new_cause", function () {
		$(this).addClass('disabled');
		var theTable = document.getElementById("instlmt_cause");
		var rl = theTable.tBodies[0].rows.length;

		if (theTable.rows[rl].cells[1].childNodes[0].value == "0") {
			alert("Groups Tidak boleh Kosong!");
		} else {

			var lastRow = theTable.tBodies[0].rows[rl];
			var tr = document.createElement("tr");

			if ((rl - 1) % 2 == 0)
				tr.className = "dn_block";
			else
				tr.className = "dn_block_alt";

			var td1 = document.createElement("TD");
			td1.setAttribute("style", "text-align:center;width:10%;");
			var td2 = document.createElement("TD");
			td2.setAttribute("align", "left");
			var td3 = document.createElement("TD");
			td3.setAttribute("style", "text-align:center;width:10%;");

			++rl;
			td1.innerHTML = rl + editCouse;
			td2.innerHTML = cbnCouse;
			td3.innerHTML = '<span nilai="0" style="cursor:pointer;" onclick="remove_install_cause(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';

			tr.appendChild(td1);
			tr.appendChild(td2);
			tr.appendChild(td3);
			theTable.tBodies[0].insertBefore(tr, lastRow);
			$(".select4").select2({
				allowClear: false,
				placeholder: " - Select - ",
				width: '600px'
			});
		}
		$("#add_new_cause").removeClass('disabled');

	})


	$(document).on("click", "#add_cause_news", function () {
		var theTable = document.getElementById("instlmt_cause");
		var rl = theTable.tBodies[0].rows.length;

		if (theTable.rows[rl].cells[1].childNodes[0].value == "0") {
			alert("Groups Tidak boleh Kosong!");
		} else {

			var lastRow = theTable.tBodies[0].rows[rl];
			var tr = document.createElement("tr");

			if ((rl - 1) % 2 == 0)
				tr.className = "dn_block";
			else
				tr.className = "dn_block_alt";

			var td1 = document.createElement("TD");
			td1.setAttribute("style", "text-align:center;width:10%;");
			var td2 = document.createElement("TD");
			td2.setAttribute("align", "left");
			var td3 = document.createElement("TD");
			td3.setAttribute("style", "text-align:center;width:10%;");

			++rl;
			td1.innerHTML = rl + editCouse;
			td2.innerHTML = cboCouse;
			td3.innerHTML = '<span nilai="0" style="cursor:pointer;" onclick="remove_install_cause(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';

			tr.appendChild(td1);
			tr.appendChild(td2);
			tr.appendChild(td3);
			theTable.tBodies[0].insertBefore(tr, lastRow);
			$(".select4").select2({
				allowClear: false,
				placeholder: " - Select - ",
				width: '600px'
			});
		}
		$("#add_new_cause").removeClass('disabled');
	})


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


		var selectElements = document.querySelectorAll('select[name="new_cause_no[]"]');
		var arrCous_no = [];
		selectElements.forEach(function (select) {
			var selectedOption = select.options[select.selectedIndex];
			var selectedValue = selectedOption.value;

			arrCous_no.push(selectedValue);
		});

		var selectElementsx = document.querySelectorAll('select[name="new_impact_no[]"]');
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
			'library': library,
			'kel': kel,
			'event_no': event_no,
			// Data cause
			'cause_name': arrCousx, // Menggunakan arrCous secara langsung
			'cause_no': arrCous_nox,
			// Data impact
			'impact_name': arrImpactx, // Menggunakan arrImpact secara langsung
			'impact_no': arrImpact_nox,
		};

		console.log(data);

		var parent = $(this).parent();
		var url = modul_name + "/simpanLibrary";
		
		// alert("Tambahkan sebagai library peristiwa ? ");
		$(".close-library").trigger('click')

		cari_ajax_combo("post", parent, data, parent, url, "proses_simpan_library");
	})

	// $(document).on('click', '.simpan_propose', function () {
	// 	var parent = $('.tbl-risk-register');
	// 	var data = [];
	// 	$('.table-risk-register > tbody > tr').each(function () {
	// 		var id = parseInt($(this).find('td button').attr('data-urgency'));
	// 		data.push(id);
	// 	});
	// 	var rcsa_no = $("#project_no").val();
	// 	var note = $("#note").val();
	// 	var data = {
	// 		data: data,
	// 		rcsa_no: rcsa_no,
	// 		note: note
	// 	};
	// 	var url = "rcsa/simpan-propose";
	// 	cari_ajax_combo("post", parent, data, $(".tbl-risk-register"), url, "get_register");
	// });
});

function proses_simpan_library(hasil) {
	// $("#cancel_library").trigger('click')
	$(".close-library").trigger('click')
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
	$("#modal_general").find(".modal-title").html('RISK REGISTER');
	$("#modal_general").modal("show");
}

function show_peristiwa(hasil) {
	$("#modal_general").find(".modal-dialog").removeClass('fullscreen').addClass('semi-fullscreen');
	$("#modal_general").find(".modal-body").html(hasil.peristiwa);
	$("#modal_general").find(".modal-title").html('');
	$("#modal_general").modal("show");

	$(".datepicker").datetimepicker({
		timepicker: false,
		format: 'd-m-Y',
		closeOnDateSelect: true,
		validateOnBlur: true,
		mask: false
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
		$(document).on('focusin.modal', function (e) {
			if ($(e.target).hasClass('select2-open')) {
				return true;
			}

			if (that.$element[0] !== e.target && !that.$element.has(e.target).length) {
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
	$("#input_library").find('.x_panel').find(".x_content").html(hasil.library);
}

function result_save_peristiwa(hasil) {
	$("#list_peristiwa").html(hasil.combo);
	// $("#modal_general").modal("hide");
	if (hasil.back) {
		$("#modal_general").modal("hide");
	}

}

function result_level(hasil) {
	$("#inherent_level_label").html(hasil.level_text);
	$("input[name='inherent_level']").val(hasil.level_no);
	$("input[name='inherent_name']").val(hasil.level_name);

	var bobo = '<option value="">' + hasil.level_resiko[""] + '</option>';
	Object.keys(hasil.level_resiko).forEach(key => {
		if (key != "") {
			bobo += '<option value="' + key + '">' + hasil.level_resiko[key] + '</option>';
		}

		// console.log(key, hasil.level_resiko[key]);
	});
	// console.log(hasil.level_resiko[""]);
	$('#treatment_no').html(bobo).change();
	console.log(bobo);
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
		format: 'd-m-Y',
		closeOnDateSelect: true,
		validateOnBlur: true,
		mask: false
	});
}

function result_delete_realisasi(hasil) {
	if (hasil.sts == "1") {
		asal_event.remove();
		console.log(asal_event);
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
		format: 'd-m-Y',
		closeOnDateSelect: true,
		validateOnBlur: true,
		mask: false
	});
}

$(function () {


	$("#add_cause").click(function () {
		console.log('masuk')
		// $(this).addClass('disabled');
		var theTable = document.getElementById("instlmt_cause");
		var rl = theTable.tBodies[0].rows.length;

		if (theTable.rows[rl].cells[1].childNodes[0].value == "0") {
			alert("Groups Tidak boleh Kosong!");
		} else {

			var lastRow = theTable.tBodies[0].rows[rl];
			var tr = document.createElement("tr");

			if ((rl - 1) % 2 == 0)
				tr.className = "dn_block";
			else
				tr.className = "dn_block_alt";

			var td1 = document.createElement("TD");
			td1.setAttribute("style", "text-align:center;width:10%;");
			var td2 = document.createElement("TD");
			td2.setAttribute("align", "left");
			var td3 = document.createElement("TD");
			td3.setAttribute("style", "text-align:center;width:10%;");

			++rl;
			td1.innerHTML = rl + editCouse;
			td2.innerHTML = cboCouse;
			td3.innerHTML = '<span nilai="0" style="cursor:pointer;" onclick="remove_install_cause(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';

			tr.appendChild(td1);
			tr.appendChild(td2);
			tr.appendChild(td3);
			theTable.tBodies[0].insertBefore(tr, lastRow);
			$(".select4").select2({
				allowClear: false,
				placeholder: " - Select - ",
				width: '600px'
			});
		}
		$("#add_new_cause").removeClass('disabled');
	})

	$("#add_new_cause").click(function () {
		$(this).addClass('disabled');
		var theTable = document.getElementById("instlmt_cause");
		var rl = theTable.tBodies[0].rows.length;

		if (theTable.rows[rl].cells[1].childNodes[0].value == "0") {
			alert("Groups Tidak boleh Kosong!");
		} else {

			var lastRow = theTable.tBodies[0].rows[rl];
			var tr = document.createElement("tr");

			if ((rl - 1) % 2 == 0)
				tr.className = "dn_block";
			else
				tr.className = "dn_block_alt";

			var td1 = document.createElement("TD");
			td1.setAttribute("style", "text-align:center;width:10%;");
			var td2 = document.createElement("TD");
			td2.setAttribute("align", "left");
			var td3 = document.createElement("TD");
			td3.setAttribute("style", "text-align:center;width:10%;");

			++rl;
			td1.innerHTML = rl + editCouse;
			td2.innerHTML = cbnCouse;
			td3.innerHTML = '<span nilai="0" style="cursor:pointer;" onclick="remove_install_cause(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';

			tr.appendChild(td1);
			tr.appendChild(td2);
			tr.appendChild(td3);
			theTable.tBodies[0].insertBefore(tr, lastRow);
			$(".select4").select2({
				allowClear: false,
				placeholder: " - Select - ",
				width: '600px'
			});
		}
		$("#add_new_cause").removeClass('disabled');
	})

	

});


function remove_install_cause(t, iddel) {
	if (confirm("Are you sure you want to permanently delete this transaction ?\nThis action cannot be undone")) {
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

	$("#add_impact").removeClass('disabled').addClass('disabled');
	var theTable = document.getElementById("instlmt_impact");
	var rl = theTable.tBodies[0].rows.length;

	if (theTable.rows[rl].cells[1].childNodes[0].value == "0") {
		alert("Groups Tidak boleh Kosong!");
	} else {

		var lastRow = theTable.tBodies[0].rows[rl];
		var tr = document.createElement("tr");

		if ((rl - 1) % 2 == 0)
			tr.className = "dn_block";
		else
			tr.className = "dn_block_alt";

		var td1 = document.createElement("TD");
		td1.setAttribute("style", "text-align:center;width:10%;");
		var td2 = document.createElement("TD");
		td2.setAttribute("align", "left");
		var td3 = document.createElement("TD");
		td3.setAttribute("style", "text-align:center;width:10%;");

		++rl;
		td1.innerHTML = rl + editImpact;
		td2.innerHTML = cboImpact;
		td3.innerHTML = '<span nilai="0" style="cursor:pointer;" onclick="remove_install_impact(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';

		tr.appendChild(td1);
		tr.appendChild(td2);
		tr.appendChild(td3);
		theTable.tBodies[0].insertBefore(tr, lastRow);
		$(".select5").select2({
			allowClear: false,
			placeholder: " - Select - ",
			width: '600px'
		});
	}
	$("#add_impact").removeClass('disabled');
}
function add_new_install_impact() {

	$("#add_new_impact").removeClass('disabled').addClass('disabled');
	var theTable = document.getElementById("instlmt_impact");
	var rl = theTable.tBodies[0].rows.length;

	if (theTable.rows[rl].cells[1].childNodes[0].value == "0") {
		alert("Groups Tidak boleh Kosong!");
	} else {

		var lastRow = theTable.tBodies[0].rows[rl];
		var tr = document.createElement("tr");

		if ((rl - 1) % 2 == 0)
			tr.className = "dn_block";
		else
			tr.className = "dn_block_alt";

		var td1 = document.createElement("TD");
		td1.setAttribute("style", "text-align:center;width:10%;");
		var td2 = document.createElement("TD");
		td2.setAttribute("align", "left");
		var td3 = document.createElement("TD");
		td3.setAttribute("style", "text-align:center;width:10%;");

		++rl;
		td1.innerHTML = rl + editImpact;
		td2.innerHTML = cbiImpact;
		td3.innerHTML = '<span nilai="0" style="cursor:pointer;" onclick="remove_install_impact(this,0)"><i class="fa fa-cut" title="menghapus data" id="sip"></i></span>';

		tr.appendChild(td1);
		tr.appendChild(td2);
		tr.appendChild(td3);
		theTable.tBodies[0].insertBefore(tr, lastRow);
		$(".select5").select2({
			allowClear: false,
			placeholder: " - Select - ",
			width: '600px'
		});
	}
	$("#add_new_impact").removeClass('disabled');
}

function remove_install_impact(t, iddel) {
	if (confirm("Are you sure you want to permanently delete this transaction ?\nThis action cannot be undone")) {
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

function remove_installx(element, id) {
	$(element).closest('tr').remove();
}

