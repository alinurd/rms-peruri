$(document).ready(function() {
	$('.skala-dropdown').change(function() {
		var selectedOption = $(this).find(':selected');
	   var bobot = parseFloat(selectedOption.data('bobot')); 
	   var penilaian = parseFloat(selectedOption.data('penilaian'));
		var hasil = bobot > 0 ? (bobot/ 100 * penilaian) : penilaian;
	   var inputId = $(this).data('input-id');
	   $('#' + inputId).val(hasil);
	   var rumus = $(this).data('input-rumus-id');
	   $('#' + rumus).val(bobot > 0 ?   + bobot + ' X ' + penilaian : penilaian);
   });
});