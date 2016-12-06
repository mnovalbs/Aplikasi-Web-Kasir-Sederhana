<?php

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=hasil.xls");

require_once 'functions.php';

if(isset($_GET['id'])) {
  $idTransaksi = $_GET['id'];
  $transaksi = getTransaksi($idTransaksi);
}

?>
<h3>Nota transaksi</h3>
<table>
  <tbody>
    <?php
    while ($row = $transaksi->fetch_object()) {
      echo '<tr><th>No Transaksi</th><td></td><td> : '.$row->idpelanggan.'</td></tr>';
      echo '<tr><th>Tanggal</th><td></td><td> : '.$row->tgl_transaksi.'</td></tr>';
      echo '<tr><td></td><th>Barang</th><td>Jumlah</td>';
      $detail = getDetailTransaksi($row->idtransaksi);
      while ($row2 = $detail->fetch_object()) {
        echo '<tr><td></td><td>'.getNamaBarang($row2->idbarang).'('.$row2->jumlah.')</td><td> : '.$row2->harga.'</td></tr>';
      }
      echo '<tr><th>Total barang</th><td></td><td> : '.$row->total_item.'</td></tr>';
      echo '<tr><th>Total harga</th><td></td><td> : '.$row->total_harga.'</td></tr>';
      echo '<tr><th>Kasir</th><td></td><td> : '.$row->id_petugas.'</td></tr>';
      echo '<tr><td colspan="3">--Terimakasih--</td></tr>';
    }
    ?>
  </tbody>
</table>
