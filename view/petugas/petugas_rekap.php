<?php
  $this->load->view('petugas/petugas_menu');
?>
<h3 class='subtitle'>Rekap</h3>
<div id='rekap'>
  <div class='kotak-cari'>
    <input type='date' id='from-date' value='<?php echo date("Y-m-01"); ?>'/> -
    <input type='date' id='to-date' value='<?php echo date("Y-m-d"); ?>'/>
    <button type='button' onclick='petugas_cari_rekap()'>Cari</button>
  </div>

  <table class='cd-table'>
    <thead>
      <tr>
        <th width='10'>No</th>
        <th>Tanggal</th>
        <th>Invoice</th>
        <th>Items</th>
        <th>Harga</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>

    </tbody>
  </table>
</div>

<div class='modal' id='detail-transaksi'>

</div>
