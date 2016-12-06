<?php
	require_once('functions.php');

	$date = $_POST["date"];
	$idPetugas = $_POST["id"];
	$status = $_POST["status"];

	$rekap = getTransaksiByDate($date,$idPetugas,$status);

  echo '<thead>';
  echo '<tr>';
  echo '<th>No.</th>';
  echo '<th>Id pelanggan</th>';
  echo '<th>Tanggal transaksi</th>';
  echo '<th>Total barang</th>';
  echo '<th>Total harga</th>';
	if ($status == 0 || $status == 2) {
		echo '<th>Id petugas / kasir</th>';
	}
  echo '</tr>';
  echo '</thead>';
  echo '<tbody>';

  $id = 1;
	if ($rekap->num_rows > 0) {
		while ($row = $rekap->fetch_object()){
	    echo '<tr>';
	    echo '<td>'.$id.'</td>';
	    echo '<td>'.$row->idpelanggan.'</td>';
	    echo '<td>'.$row->tgl_transaksi.'</td>';
	    echo '<td>'.$row->total_item.'</td>';
	    echo '<td>'.$row->total_harga.'</td>';
			if ($status == 0 || $status == 2) {
				echo '<td>'.$row->id_petugas.'</td>';
			}
	    echo '</tr>';
	    $id++;
		}
	}
	else {
		if ($status == 0 || $status == 2) {
			echo '<tr><td colspan="6">Tidak ada transaksi</td></tr>';
		}
		else {
			echo '<tr><td colspan="5">Tidak ada transaksi</td></tr>';
		}
	}

  echo '</tbody>';

?>
