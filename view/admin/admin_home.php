<?php
  $this->load->view('admin/admin_menu');
?>
<h3 class='subtitle'>List Petugas</h3>
<div id='list-total'>
  <div class='total'>
    <h2><?php echo $list_total['total_barang'] ?></h2>
    <h3>Total Barang</h3>
  </div>
  <div class='total'>
    <h2><?php echo $list_total['total_transaksi'] ?></h2>
    <h3>Total Transaksi</h3>
  </div>
  <div class='total'>
    <h2><?php echo $list_total['total_kasir'] ?></h2>
    <h3>Total Kasir</h3>
  </div>
  <div class='total'>
    <h2><?php echo $list_total['total_admin'] ?></h2>
    <h3>Total Admin</h3>
  </div>
</div>

<h3>Statistik Bulan Ini (<?php echo date("Y/m"); ?>)</h3>
<div id='month-statistic' class='statistic'>
  <?php
    $sizeArr = count($month_statistic);
    $tiapBatang = 100/$sizeArr;
    $max = max($month_statistic);
    foreach ($month_statistic as $key => $value) {
      echo "<div style='width:".$tiapBatang."%;height:".($value*100/$max)."%'><span>".$key."</span></div>";
    }
  ?>
</div>
