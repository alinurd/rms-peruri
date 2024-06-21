var myRadar_lengkap;
var myRadar_tepat;
var myRadar_alert;
var myRadar;
var kel_lengkap="propinsi";
var kel_tepat="propinsi";
var kel_alert="propinsi";
var sts_puskesmas=true;
var sts_rs=true;
var sts_lab=true;
var sts_ebs=true;
var sts_kel="puskesmas";

$(function(){
	$("#slide_left").click(function(){
		if ($.asm.panels === 1) {
			 $.asm.panels = 2;
			  $('#pullout-6').animate({
					left: 0,
			  });
		} else if ($.asm.panels === 2) {
			 $.asm.panels = 1;
			$('#pullout-6').animate({
				left: -203,
			});
		}
	})
	
	$("#refresh_lengkap_puskesmas").click(function(){
		var url=modul_name + "/grafik-awal";
		cari_ajax_combo("get", $("#bar-chart-lengkap-puskesmas").closest(".box-body"), {'kel':"lengkap",'tab':"puskesmas"}, "bar-chart-lengkap", url, "proses_chart");
	})
	$("#refresh_tepat_puskesmas").click(function(){
		var url=modul_name + "/grafik-awal";
		cari_ajax_combo("get", $("#bar-chart-tepat-puskesmas").closest(".box-body"), {'kel':"tepat",'tab':"puskesmas"}, "bar-chart-tepat", url, "proses_chart");
	})
	$("#refresh_alert_puskesmas").click(function(){
		var url=modul_name + "/grafik-awal";
		cari_ajax_combo("get", $("#bar-chart-alert-puskesmas").closest(".box-body"), {'kel':"alert",'tab':"puskesmas"}, "bar-chart-alert", url, "proses_chart");
	})
	$("#refresh_map_puskesmas").click(function(){
		var url=modul_name + "/refresh-map";
		cari_ajax_combo("get", $("#content_map_puskesmas"), {'kel':sts_kel}, "content_map", url, "proses_map");
	})
	
	$(document).on("click",".editalert",function(){
		var id_edit = $(this).data('edit');
		var id_detail = $(this).data('detail');
		var data={'id_edit':id_edit,'id_detail':id_detail};
		var url=modul_name + "/verifikasi-alert";
		cari_ajax_combo("post", $("#content_map_puskesmas"), data, "alert_"+id_edit, url, "proses_verifikasi");
	})
	
	$(document).on("click","#proses_alert",function(){
		var id_edit = $(this).data('edit');
		var id_detail = $(this).data('detail');
		var data=$("form#form_alert").serialize();
		var url=modul_name + "/simpan-verifikasi-alert";
		cari_ajax_combo("post", $("#content_map_puskesmas"), data, "alert_"+id_edit, url, "proses_simpan_verifikasi");
	})
	
	$("#cboPropinsi").change(function(){		
		var parent = $("#tbl_chart");
		var nilai = $(this).val();
		var data={'id':nilai};
		var target_combo = $("#cboKota");
		var url = "ajax/get_kota";
		cari_ajax_combo("post", parent, data, target_combo, url);
	})
	$("#cboKota").change(function(){		
		var parent = $("#tbl_chart");
		var nilai = $(this).val();
		var data={'id':nilai};
		var target_combo = $("#cboDistrik");
		var url = "ajax/get_distrik";
		cari_ajax_combo("post", parent, data, target_combo, url);
	})
	$("#cboDistrik").change(function(){		
		var parent = $("#tbl_chart");
		var nilai = $(this).val();
		var data={'id':nilai};
		var target_combo = $("#cboPuskesmas");
		var url = "ajax/get_puskesmas";
		cari_ajax_combo("post", parent, data, target_combo, url);
	})
	$("#cboTahun").change(function(){		
		var parent = $("#tbl_chart");
		var nilai = $(this).val();
		var data={'id':nilai};
		var target_combo = $("#cboMinggu");
		var url = "ajax/get_minggu";
		cari_ajax_combo("post", parent, data, target_combo, url);
	})
	
	$("#bar-chart-lengkap-puskesmas").click( 
		function handleClick(evt){	
			var activePoint = myRadar_lengkap.getElementsAtEvent(evt)[0];
			if (activePoint !== undefined) {
				var label = myRadar_lengkap.data.labels[activePoint._index];
			}else{
				var label ="";
			}
			window.location.replace(base_url + modul_name + "/detail/puskesmas/lengkap/" + label);
		}
	)

	$("#bar-chart-tepat-puskesmas").click( 
		function handleClick(evt){	
			var activePoint = myRadar_tepat.getElementsAtEvent(evt)[0];
			if (activePoint !== undefined) {
				var label = myRadar_tepat.data.labels[activePoint._index];
			}else{
				var label ="";
			}
			window.location.replace(base_url + modul_name + "/detail/puskesmas/tepat/" + label);
		}
	)

	$("#bar-chart-alert-puskesmas").click( 
		function handleClick(evt){	
			var activePoint = myRadar_alert.getElementsAtEvent(evt)[0];
			if (activePoint !== undefined) {
				var label = myRadar_alert.data.labels[activePoint._index];
			}else{
				var label ="";
			}
			window.location.replace(base_url + modul_name + "/detail/puskesmas/alert/" + label);
		}
	)	
	
	$("#btn_proses_alert").click(function(){
		$('#lengkap-chart').html(""); // this is my <canvas> element
		$('#lengkap-chart').append('<canvas id="bar-chart"><canvas>');
		if (mode=="alert"){
			var url=modul_name + "/grafik-alert";
			var ialert = cari_ajax_combo("get", $("#bar-chart").closest(".box-body"), $("form#form_input_alert").serialize(), "bar-chart", url, "proses_chart");
		}else if (mode=="lengkap"){
			var url=modul_name + "/grafik-lengkap";
			var ialert = cari_ajax_combo("get", $("#bar-chart").closest(".box-body"), $("form#form_input_alert").serialize(), "bar-chart", url, "proses_chart");
		}else if (mode=="tepat"){
			var url=modul_name + "/grafik-tepat";
			var ialert = cari_ajax_combo("get", $("#bar-chart").closest(".box-body"), $("form#form_input_alert").serialize(), "bar-chart", url, "proses_chart");
		}
		// var url=modul_name + "/grafik-alert";
		// cari_ajax_combo("get", $("#bar-chart").closest(".box-body"), $("form#form_input_alert").serialize(), "bar-chart", url, "proses_chart");
	})
	
	
	
	$("#cboPropinsiDiagram").change(function(){		
		var parent = $(this).parent();
		var nilai = $(this).val();
		var data={'id':nilai};
		var target_combo = $("#cboKotaDiagram");
		var url = "ajax/get_kota";
		cari_ajax_combo("post", parent, data, target_combo, url);
	})
	$("#cboKotaDiagram").change(function(){		
		var parent = $(this).parent();
		var nilai = $(this).val();
		var data={'id':nilai};
		var target_combo = $("#cboDistrikDiagram");
		var url = "ajax/get_distrik";
		cari_ajax_combo("post", parent, data, target_combo, url);
	})
	$("#cboDistrikDiagram").change(function(){		
		var parent = $(this).parent();
		var nilai = $(this).val();
		var data={'id':nilai};
		var target_combo = $("#cboPuskesmasDiagram");
		var url = "ajax/get_puskesmas";
		cari_ajax_combo("post", parent, data, target_combo, url);
	})
	$("#cboTahunDiagram").change(function(){		
		var parent = $(this).parent();
		var nilai = $(this).val();
		var data={'id':nilai};
		var target_combo = $("#cboMingguDiagram");
		var url = "ajax/get_minggu";
		cari_ajax_combo("post", parent, data, target_combo, url);
	})
	
	$("#btn_proses_diagram").click(function(){
		var tipe=$("#cboTypeDiagram").val();
		var penyakit=$("#cboPenyakitDiagram").val();
		if (tipe=="lap9" || tipe=="lap7" || tipe=="lap2"){
			if (penyakit==0 || penyakit==""){
				alert("Penyakit wajib dipilih");
				return false;
			}
		}
		var parent = $(this).parent();
		var nilai = $(this).val();
		var data=$("form#form_diagram_puskesmas").serialize();
		var target_combo = $("#content_diagram_puskesmas");
		var url = modul_name+"/get_diagram";
		cari_ajax_combo("get", $("#content_diagram_puskesmas"), data, "content_diagram_puskesmas", url, "proses_chart");
	})
	
	$(document).on("click","._cetak", function(){
		var key = $(this).data("id");
		var kel = $(this).data("kel");
		var url=base_url + modul_name + '/get_cetak/'+kel+'/'+key;
		window.open(url);
	})
})

function proses_simpan_verifikasi(hasil){
	$("#alert_" + hasil.id_edit).html(hasil.data);
}

function proses_verifikasi(hasil){
	$(".datepicker").datetimepicker({
		timepicker:false,
		format:'d-m-Y',
		closeOnDateSelect:true,
		validateOnBlur:true,
		 mask:false
	});
	$("#modal_general").find(".modal-body").html(hasil.data);
	$("#modal_general").modal("show");
}

$(document).ready(function() {
	var url=modul_name + "/grafik-awal";
	if (mode=="puskesmas"){
		var url=modul_name + "/grafik-awal";
		var lengkap = cari_ajax_combo("get", $("#bar-chart-lengkap-puskesmas").closest(".box-body"), {'kel':"lengkap",'tab':'puskesmas'}, "bar-chart-lengkap-puskesmas", url, "proses_chart");
		
		var tepat = cari_ajax_combo("get", $("#bar-chart-tepat-puskesmas").closest(".box-body"), {'kel':"tepat",'tab':'puskesmas'}, "bar-chart-tepat-puskesmas", url, "proses_chart");
		
		var ialert = cari_ajax_combo("get", $("#bar-chart-alert-puskesmas").closest(".box-body"), {'kel':"alert",'tab':'puskesmas'}, "bar-chart-alert-puskesmas", url, "proses_chart");
	}else if (mode=="alert"){
		var url=modul_name + "/grafik-alert";
		var ialert = cari_ajax_combo("get", $("#bar-chart").closest(".box-body"), $("form#form_input_alert").serialize(), "bar-chart", url, "proses_chart");
	}else if (mode=="lengkap"){
		var url=modul_name + "/grafik-lengkap";
		var ialert = cari_ajax_combo("get", $("#bar-chart").closest(".box-body"), $("form#form_input_alert").serialize(), "bar-chart", url, "proses_chart");
	}else if (mode=="tepat"){
		var url=modul_name + "/grafik-tepat";
		var ialert = cari_ajax_combo("get", $("#bar-chart").closest(".box-body"), $("form#form_input_alert").serialize(), "bar-chart", url, "proses_chart");
	}
	loadTable("", 10, "table_mapping");
})

function proses_chart(hasil){
	sts_kel=hasil.kel;
	if (hasil.kel=="lengkap"){
		chart_bar("bar-chart-lengkap-"+hasil.tab, hasil.title, hasil.data, "Kelengkapan", 100, false);
	}else if (hasil.kel=="tepat"){
		chart_bar("bar-chart-tepat-"+hasil.tab, hasil.title, hasil.data, "Ketepatan", 100, false);
	}else if (hasil.kel=="alert"){
		chart_bar("bar-chart-alert-"+hasil.tab, hasil.title, hasil.data, "Alert", hasil.mak, true);
	}else if (hasil.kel=="alert-detail"){
		chart_bar("bar-chart", hasil.title, hasil.data, "Alert", hasil.mak, true);
		$("#div-table").html(hasil.table);
	}else if (hasil.kel=="lengkap-detail"){
		chart_bar("bar-chart", hasil.title, hasil.data, "Lengkap", hasil.mak, false);
		$("#div-table").html(hasil.table);
	}else if (hasil.kel=="tepat-detail"){
		chart_bar("bar-chart", hasil.title, hasil.data, "Tepat", hasil.mak, false);
		$("#div-table").html(hasil.table);
	}else if (hasil.kel=="puskesmas"){
		$('#content_diagram_puskesmas').html(""); // this is my <canvas> element
		$('#content_diagram_puskesmas').append('<div class="col-md-10 col-md-offset-1" id="content_diagram_puskesmas"><canvas id="chart-puskesmas" width="500" height="350"></canvas></div>');
		chart_bar("chart-puskesmas", hasil.title, hasil.data, "Puskesmas", 100, true);
	}
}

function proses_chart_detail(hasil){
	$('#lengkap-chart').html(""); // this is my <canvas> element
	$('#lengkap-chart').append('<canvas id="bar-chart"><canvas>');
  
	if (hasil.kel=="lengkap"){
		chart_bar("bar-chart", hasil.title, hasil.data, "Kelengkapan", hasil.mak, false);
	}else if (hasil.kel=="tepat"){
		chart_bar("bar-chart", hasil.title, hasil.data, "Ketepatan", hasil.mak, false);
	}else if (hasil.kel=="alert"){
		chart_bar("bar-chart", hasil.title, hasil.data, "Alert", hasil.mak, true);
	}
}

function proses_map(hasil){
	var jml = hasil.map.length;
	markerCluster.clearMarkers();
	for (var i = 0; i < markers_map.length; i++) {
		markers_map[i].setMap(null);
		// markerCluster.remove(markers_map[i]);
	}
	markers_map = new Array();
	
	for (var i = 0, len = jml; i < len; ++i) { 
		var d = hasil.map[i];

		var lat = parseFloat(d.lat);
		var lng = parseFloat(d.lng);
		var myLatlng = new google.maps.LatLng(lat, lng);

		var marker = {
			map: map,
			position: myLatlng,
			title:d.puskesmas,
		};
		
		var mapx=createMarker_map(marker);
		mapx.set("content",d.info);
		google.maps.event.addListener(mapx, "click", function(event) {
			iw_map.setContent(this.get("content"));
			iw_map.open(map, this);
		});
		// map.panTo(marker.getPosition());
		// map.setZoom(14);
	}
	var clusterOptions = {imagePath: base_url + "themes/default/assets/js/images/m"};
	markerCluster = new MarkerClusterer(map, markers_map, clusterOptions);
			
}
	
function chart_bar(sumber, title, ddata, labeldata, nilMak, legend){
	if (sts_kel=="lengkap"){
		myRadar_lengkap = new Chart(document.getElementById(sumber), {
			type: 'bar',
			data: ddata,
			options: {
				maintainAspectRatio: false,
				legend: { display: legend, position:'bottom' },
				title: {
					display: true,
					text: title
				},
				"animation": {
					"duration": 1,
					"onComplete": function () {
						var chartInstance = this.chart,
						ctx = chartInstance.ctx;
						
						var fontSize = 9;
						var fontStyle = 'normal';
						var fontFamily = 'Helvetica Neue';
						ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);
						
						// ctx.font = Chart.helpers.fontString(9, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
						ctx.textAlign = 'center';
						ctx.textBaseline = 'middle';
								
						this.data.datasets.forEach(function (dataset, i) {
							var meta = chartInstance.controller.getDatasetMeta(i);
							meta.data.forEach(function (bar, index) {
								var data = dataset.data[index];    
								ctx.save();
								ctx.translate(bar._model.x, bar._model.y - 30);

								// Rotate context by -90 degrees
								ctx.rotate(-0.5 * Math.PI);							
								ctx.fillStyle = '#ffffff';
								// ctx.fillText(data, bar._model.x+30, bar._model.y - 15);
								ctx.fillText(data, -40,0);
								ctx.restore();
							});
						});
					}
				},
				scales: {
					xAxes: [{
						stacked: true,
						ticks: {
							autoSkip: false,
							maxRotation: 0,
							minRotation: 90,
							callback: function(value) {
							   return value + " "
						   }
						},
						gridLines: {
						  display: false
						},
					}],
					yAxes: [{
						ticks: {
							beginAtZero:true,
							max:nilMak,
						},
						stacked: true,
					}]
				}
			}
		});
	}else if (sts_kel=="tepat"){
		myRadar_tepat = new Chart(document.getElementById(sumber), {
			type: 'bar',
			data: ddata,
			options: {
				maintainAspectRatio: false,
				legend: { display: legend, position:'bottom' },
				title: {
					display: true,
					text: title
				},
				"animation": {
					"duration": 1,
					"onComplete": function () {
						var chartInstance = this.chart,
						ctx = chartInstance.ctx;
						
						var fontSize = 9;
						var fontStyle = 'normal';
						var fontFamily = 'Helvetica Neue';
						ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);
						
						// ctx.font = Chart.helpers.fontString(9, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
						ctx.textAlign = 'center';
						ctx.textBaseline = 'middle';
								
						this.data.datasets.forEach(function (dataset, i) {
							var meta = chartInstance.controller.getDatasetMeta(i);
							meta.data.forEach(function (bar, index) {
								var data = dataset.data[index];    
								ctx.save();
								ctx.translate(bar._model.x, bar._model.y - 30);

								// Rotate context by -90 degrees
								ctx.rotate(-0.5 * Math.PI);							
								ctx.fillStyle = '#ffffff';
								// ctx.fillText(data, bar._model.x+30, bar._model.y - 15);
								ctx.fillText(data, -40,0);
								ctx.restore();
							});
						});
					}
				},
				scales: {
					xAxes: [{
						stacked: true,
						ticks: {
							autoSkip: false,
							maxRotation: 0,
							minRotation: 90,
							callback: function(value) {
							   return value + " "
						   }
						},
						gridLines: {
						  display: false
						},
					}],
					yAxes: [{
						ticks: {
							beginAtZero:true,
							max:nilMak,
						},
						stacked: true,
					}]
				}
			}
		});
	}else if (sts_kel=="alert"){
		myRadar_alert = new Chart(document.getElementById(sumber), {
			type: 'bar',
			data: ddata,
			options: {
				maintainAspectRatio: false,
				legend: { display: legend, position:'bottom' },
				title: {
					display: true,
					text: title
				},
				"animation": {
					"duration": 1,
					"onComplete": function () {
						var chartInstance = this.chart,
						ctx = chartInstance.ctx;
						
						var fontSize = 9;
						var fontStyle = 'normal';
						var fontFamily = 'Helvetica Neue';
						ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);
						
						// ctx.font = Chart.helpers.fontString(9, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
						ctx.textAlign = 'center';
						ctx.textBaseline = 'middle';
								
						this.data.datasets.forEach(function (dataset, i) {
							var meta = chartInstance.controller.getDatasetMeta(i);
							meta.data.forEach(function (bar, index) {
								var data = dataset.data[index];    
								ctx.save();
								ctx.translate(bar._model.x, bar._model.y - 30);

								// Rotate context by -90 degrees
								ctx.rotate(-0.5 * Math.PI);							
								ctx.fillStyle = '#ffffff';
								// ctx.fillText(data, bar._model.x+30, bar._model.y - 15);
								ctx.fillText(data, -40,0);
								ctx.restore();
							});
						});
					}
				},
				scales: {
					xAxes: [{
						stacked: true,
						ticks: {
							autoSkip: false,
							maxRotation: 0,
							minRotation: 90,
							callback: function(value) {
							   return value + " "
						   }
						},
						gridLines: {
						  display: false
						},
					}],
					yAxes: [{
						ticks: {
							beginAtZero:true,
							max:nilMak,
						},
						stacked: true,
					}]
				}
			}
		});
	}else{
		myRadar = new Chart(document.getElementById(sumber), {
			type: 'bar',
			data: ddata,
			options: {
				maintainAspectRatio: false,
				legend: { display: legend, position:'bottom' },
				title: {
					display: true,
					text: title
				},
				"animation": {
					"duration": 1,
					"onComplete": function () {
						var chartInstance = this.chart,
						ctx = chartInstance.ctx;
						
						var fontSize = 9;
						var fontStyle = 'normal';
						var fontFamily = 'Helvetica Neue';
						ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);
						
						// ctx.font = Chart.helpers.fontString(9, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
						ctx.textAlign = 'center';
						ctx.textBaseline = 'middle';
								
						this.data.datasets.forEach(function (dataset, i) {
							var meta = chartInstance.controller.getDatasetMeta(i);
							meta.data.forEach(function (bar, index) {
								var data = dataset.data[index];    
								ctx.save();
								ctx.translate(bar._model.x, bar._model.y - 30);

								// Rotate context by -90 degrees
								ctx.rotate(-0.5 * Math.PI);							
								ctx.fillStyle = '#ffffff';
								// ctx.fillText(data, bar._model.x+30, bar._model.y - 15);
								ctx.fillText(data, -40,0);
								ctx.restore();
							});
						});
					}
				},
				scales: {
					xAxes: [{
						stacked: false,
						ticks: {
							autoSkip: false,
							maxRotation: 0,
							minRotation: 90,
							callback: function(value) {
							   return value + " "
						   }
						},
						gridLines: {
						  display: false
						},
					}],
					yAxes: [{
						ticks: {
							beginAtZero:true,
							max:nilMak,
						},
						stacked: false,
					}]
				}
			}
		});
	}
}

function chart_pie(sumber, title, ddata, nilMak){
	myRadar = new Chart(document.getElementById(sumber), {
		type: 'pie',
		data: ddata,
		options: {
			maintainAspectRatio: false,
			legend: { display: true, position:'bottom' },
			title: {
				display: true,
				text: title
			},
			pieceLabel: {
				render: 'percentage',
				fontColor: '#fff',
			},
		}
	});
}

function cetak_lap(kel, key){
	
}