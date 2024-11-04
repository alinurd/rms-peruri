$(document).ready(function() {
	$('.skala-dropdown').change(function() {

		var selectedOption = $(this).find(':selected');
	   	var bobot = parseFloat(selectedOption.data('bobot')); 
	   	var penilaian = parseFloat(selectedOption.data('penilaian'));
		var hasil = bobot > 0 ? (bobot/ 100 * penilaian) : penilaian;
		var inputId = $(this).data('input-id');
		var urut = $(this).data('urut');
		var idParent = $(this).data('id-parent');
 
	   	$('#' + inputId).val(hasil);
	  	var rumus = $(this).data('input-rumus-id');
	   	$('#' + rumus).val(bobot > 0 ?   + bobot + ' X ' + penilaian : penilaian);

		   var total = 0;
		   $('.subTotalDetail-'+ idParent).each(function() {
			   total += parseFloat($(this).val()) || 0; // Jika nilai kosong, set 0
		   });
 // total=urut+idParent;
        $('#totalDetail-' + idParent).val(total); // Mengatur 2 angka desimal jika diperlukan
		   });
});