$.asm = {};
$.asm.panels = 1;

$(window).scroll(fixDiv);
  fixDiv();

function fixDiv() {
	var $cache = $('#scrollingDiv');
	if ($(window).scrollTop() > 0){
	  $cache.css({
		'position': 'fixed',
		'top': '0px',
		'width': '80.7%',
		'z-index': '2000',
	  });
	  $cache.find('.col-xs-12').css({'padding': '5px 10px'});
	  
	  $cache.find('.row').addClass('bg-action');
	  $cache.find('.col-xs-12').addClass('bg-action');
	  $cache.find('.row').removeClass('bg-white');
	  $cache.find('.col-xs-12').removeClass('bg-white');
	}else{
	  $cache.css({
		'position': 'relative',
		'top': 'auto',
		'width': '100%',
		'z-index': '100',
	  });
	  $cache.find('.col-xs-12').css({'padding': '5px 10px'});
	  
	  $cache.find('.row').removeClass('bg-action');
	  $cache.find('.col-xs-12').removeClass('bg-action');
	  $cache.find('.row').addClass('bg-white');
	  $cache.find('.col-xs-12').addClass('bg-white');
	 }
}

function stopLooding(parent){
	$(parent).unblock();
}

function looding(tipe, parent){
	if (tipe=='dark'){
		$(parent).block({
			message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
			overlayCSS: {
				backgroundColor: '#1B2024',
				opacity: 0.85,
				cursor: 'wait'
			},
			css: {
				border: 0,
				padding: 0,
				backgroundColor: 'none',
				color: '#fff'
			}
		});
	}else{
		 $(parent).block({
            message: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>',
            overlayCSS: {
                backgroundColor: '#fff',
                opacity: 0.8,
                cursor: 'wait'
            },
            css: {
                border: 0,
                padding: 0,
                backgroundColor: 'none'
            }
        });
	}
}

function pesan_toastr(pesan, tipe, title, posisi, progress){
	if (posisi === undefined) posisi = "toast-bottom-right";
    if (progress === undefined) progress = true;
	
	toastr.options = {
	  "closeButton": true,
	  "debug": false,
	  "newestOnTop": false,
	  "progressBar": progress,
	  "positionClass": posisi,
	  "preventDuplicates": false,
	  "onclick": null,
	  "showDuration": "300",
	  "hideDuration": "5000",
	  "timeOut": "5000",
	  "extendedTimeOut": "5000",
	  "showEasing": "swing",
	  "hideEasing": "linear",
	  "showMethod": "fadeIn",
	  "hideMethod": "fadeOut"
	}
	if (tipe=='danger' || tipe=='warning' || tipe=='err'){
		Command: toastr.error(pesan,title)
	}else if (tipe=='ajax'){
		Command: toastr.ajax(pesan,title)
	}else{
		Command: toastr.info(pesan,title)
	}
}
	
function cari_ajax_combo(tipe, parent, data, target_combo, url, proses_result){
	url = base_url + url;
	looding('light',parent);
	if(typeof(proses_result) == "undefined")
		proses_result="";
	$.ajax({
		type:tipe,
		url:url,
		data:data,
		dataType: "json",
		success:function(result){
			if (proses_result.length==0)	
				target_combo.html(result.combo)
			else
				window[proses_result](result);
			
			stopLooding(parent);
		},
		error:function(msg){
			stopLooding(parent);
			pesan_toastr('Error Load Database','err','Error','toast-top-center');
		},
		complate:function(){
		}
	})
}

function loadTable(url, display, idtbl) {
	if (idtbl === undefined) idtbl = "datatables";
	if (display === undefined) display = 0;
	if (url === undefined) url = "";
	if(url.length>5) {		
        var tr = true;
        var file = url;
	} else  {
		var tr = false;
        var file = null;
	}
	if(display>0){
		var numRec=display;
	}else{
		var numRec=10;
	}
	
	$('table#' + idtbl).show();
	if ($.isFunction($.fn.dataTable)) {
		oTable = $('table#' + idtbl).dataTable({
			responsive: true,
			"iDisplayLength": numRec,
			"processing": tr,
			"bServerSide": tr,
			"autoWidth": true,
			"sAjaxSource": file, 
			"bAutoWidth": false,
			"bScrollCollapse": true,
			"aLengthMenu": [[5, 10, 15, 25, 50, 100, 200, 500, 1000, -1], [5, 10, 15, 25, 50, 100, 200, 500, 1000, "All"]],
			"oLanguage": {
				"sProcessing": "",
				"sLengthMenu": Globals.sLengthMenu,
				"sZeroRecords": Globals.sZeroRecords,
				"sInfo": Globals.sInfo,
				"sInfoEmpty": Globals.sInfoEmpty,
				"sInfoFiltered": Globals.sInfoFiltered,
				"sSearch": Globals.sSearch,
				"oPaginate": {
					"sFirst": Globals.sFirst,
					"sPrevious": Globals.sPrevious,
					"sNext": Globals.sNext,
					"sLast": Globals.sLast,
				},
			},
		});
		
		$('table#' + idtbl + ' tbody').on( 'click', 'tr', function () {
			if ( $(this).hasClass('selected') ) {
				$(this).removeClass('selected');
			}
			else {
				oTable.$('tr.selected').removeClass('selected');
				$(this).addClass('selected');
			}
			// var data = oTable.fnGetData( this );
			// alert(data);
		});
		
		$('table#' + idtbl + ' th input[type="checkbox"]').parents('th').unbind('click.DT');
		if ($.isFunction($.fn.chosen) ) {
			$("select").chosen({disable_search_threshold: 10});
		}				
	}
}

