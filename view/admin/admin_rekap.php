<?php
  $this->load->view('admin/admin_menu');
?>
<h3 class='subtitle'>Rekap</h3>
<div id='rekap'>
  <div class='kotak-cari'>
    <input type='date' id='from-date' value='<?php echo date("Y-m-01"); ?>'/> -
    <input type='date' id='to-date' value='<?php echo date("Y-m-d"); ?>'/>
    <select id='from-kasir'>
      <option value=''>- Pilih Kasir -</option>
      <?php
        foreach ($list_petugas as $petugas) {
          echo "<option value='".$petugas['idpetugas']."'>".safe_echo_html($petugas['nama'])."</option>";
        }
      ?>
    </select>
    <button type='button' onclick='admin_cari_rekap()'>Cari</button>
  </div>

  <table class='cd-table'>
    <thead>
      <tr>
        <th width='10'>No</th>
        <th>Kasir</th>
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
