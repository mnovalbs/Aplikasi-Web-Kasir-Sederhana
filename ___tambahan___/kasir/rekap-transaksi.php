<?php

require_once 'functions.php';

if(isset($_SESSION['user'])) {

  $status = getStatus($_SESSION['user']);

  $allTransaksi = getAllTransaksi($_SESSION['user'],$status);

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Rekapitulasi Transaksi</title>
    <script src="js/jquery-2.2.4.min.js" type="text/javascript"></script>
    <?php
      echo '<script type="text/javascript">';
      echo 'var idPetugas = '.$_SESSION['user'].';';
      echo 'var status = '.$status.';';
      echo '</script>';
    ?>
    <script src="js/script.js" type="text/javascript"></script>
  </head>
  <body>

    <form>
      Tanggal : <input type="date" id="date">
      <?php if($status == 0){ ?>
      Kasir   : <input type="number" id="kasir" min="1">
      <?php } ?>
      <button type="button" onClick=" javascript:location.reload(); ">Reset</button>
    </form>
    <br>
    <table id="table" border="1">
      <thead>
        <tr>
          <th>No.</th>
          <th>Id pelanggan</th>
          <th>Tanggal transaksi</th>
          <th>Total barang</th>
          <th>Total harga</th>
          <?php if($status == 0){ ?>
          <th>Id petugas / kasir</th>
          <?php } ?>
          <th>Cetak nota</th>
          </tr>
      </thead>
      <tbody>
        <?php
        $id = 1;
        while ($row = $allTransaksi->fetch_object()) {
          echo '<tr>';
          echo '<td>'.$id.'</td>';
          echo '<td>'.$row->idpelanggan.'</td>';
          echo '<td>'.$row->tgl_transaksi.'</td>';
          echo '<td>'.$row->total_item.'</td>';
          echo '<td>'.$row->total_harga.'</td>';
          if ($status == 0) {
            echo '<td>'.$row->id_petugas.'</td>';
          }
          echo '<td><a href="cetak-nota.php?id='.$row->idtransaksi.'">Cetak</a></td>';
          echo '</tr>';
          $id++;
        }
        ?>
      </tbody>
    </table>
    <a href="cetak-nota.php">Cetak</a>
    <a href="logout.php">Logout</a>
  </body>
</html>
<?php
}
else {
  header('Location: index.php');
}
?>
