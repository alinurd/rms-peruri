$(function () {
	$("#owner_no, #period_no").change(function () {
		var parent = $(this).parent();
		var id_owner = $("#owner_no").val();
		var id_period = $("#period_no").val();
		var id = parseFloat(id_owner) + "-" + parseFloat(id_period) + "-" + parseFloat(type_dash);
		var data = {
			'id': id
		};
		var url = "ajax/get_project_name";
		cari_ajax_combo("post", parent, data, $("#project_no"), url);
	});

	$("#project_no").change(function () {
		var id_project = $(this).val();
		if (id_project > 0) {
			$("button#btn-search").removeClass('disabled');
			get_register(id_project);
		} else {
			$("button#btn-search").addClass('disabled');
		}
	});



	$(document).on('click', '.move', function () {
		var row = $(this).closest("tr");
		var table = $(this).closest("table");
		row.detach();

		var tbl_top = $(".table-top-ten");
		var tbl_risk = $(".table-risk-register");
		if (table.is(".table-risk-register")) {
			$(this).text('drop');
			tbl_top.append(row);
		} else {
			$(this).text('select');
			tbl_risk.append(row);
		}
		var l = $(".table-top-ten tbody tr").length;
		if (l == 0) {
			tbl_top.fadeOut();
			$('.propose').addClass('hide');
		} else {
			tbl_top.removeClass('hide');
			tbl_top.fadeIn();
			$('.propose').removeClass('hide');
		}

		row.hide();
		row.fadeIn();
	});



	$(document).on('click', '.propose', function () {
		var parent = $('.tbl-risk-register');
		var data = [];
		$('.table-risk-register > tbody > tr').each(function () {
			var id = parseInt($(this).find('td button').attr('data-urgency'));
			data.push(id);
		});
		var rcsa_no = $("#project_no").val();
		var note = $("#note").val();
		var data = {
			data: data,
			rcsa_no: rcsa_no,
			note: note
		};
		var url = "propose-dept/propose";
		cari_ajax_combo("post", parent, data, $(".tbl-risk-register"), url, "get_register");
	});



});

function get_register(id) {
	var parent = $('.table-top-ten');
	var data = {
		'id': id
	};
	var url = "propose-dept/get-register";
	cari_ajax_combo("post", parent, data, $(".tbl-risk-register"), url, "", true, "Data Tidak ada", "Info");
}

function well(parent, string) {
	parent.empty();
	parent.append('<div class="well">' + string + '<div>');
}