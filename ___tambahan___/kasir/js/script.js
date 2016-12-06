$(document).ready(function() {
	$("#date").change(function(){
		var selectedDate = $(this).val();
		var selectedKasir = $("#kasir").val();
		if (selectedKasir == "") {
			loadTransaksi(selectedDate,idPetugas,status);
		}
		$("#kasir").change(function(){
			var selectedKasir = $("#kasir").val();
			loadTransaksi(selectedDate,selectedKasir,2);
		})
	});

	$("#kasir").change(function(){
		var selectedKasir = $(this).val();
		var selectedDate = $("#date").val();
		if (selectedDate == "") {
			loadTransaksi(selectedDate,selectedKasir,status);
		}
		$("#date").change(function(){
			var selectedDate = $("#date").val();
			loadTransaksi(selectedDate,selectedKasir,2);
		})
	});

	function loadTransaksi(selectedDate,selectedKasir,status) {
		$("#table").load("rekap.php",{
			date : selectedDate,
			id   : selectedKasir,
			status : status
		},function(){});
	}

});
