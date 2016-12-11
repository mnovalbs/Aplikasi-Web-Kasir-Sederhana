<?php
  $this->load->view('petugas/petugas_menu');
?>
<h3 class='subtitle'>Transaksi</h3>
<p>
  <b>ID Pelanggan</b> : CDINV<?php echo $current_invoice; ?>
</p>
<div class='panel' id='cari-barang'>
  <div class='panel-head'>
    Cari Barang
  </div>
  <div class='panel-body'>
    <input placeholder="Pencarian..."/>
    <div id='cari-barang-list'>
      <table class='cd-table table-hover'>
        <thead>
          <tr>
            <th width='10'>No</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Tambah</td>
          </tr>
        </thead>
        <tbody>
          <?php
            $no = 1;
            foreach ($list_barang as $barang) {
              echo "<tr>\n";
              echo "\t<td>".$no."</td>\n";
              echo "\t<td>".safe_echo_html($barang['nama_barang'])."</td>\n";
              echo "\t<td>".safe_echo_html($barang['nama_kategori'])."</td>\n";
              echo "\t<td>".toRupiah($barang['harga'])."</td>\n";
              echo "\t<td>".safe_echo_html($barang['stok'])."</td>\n";
              echo "\t<td><label onclick='tambah_transaksi(".$barang['idbarang'].")'><i class='fa fa-plus'></i></label></td>\n";
              echo "</tr>\n";
              $no++;
            }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class='panel' id='keranjang'>
  <div class='panel-head'>
    Keranjang
  </div>
  <div class='panel-body'>
    <table class='cd-table table-hover'>
      <thead>
        <tr>
          <th>Nama Barang</th>
          <th>Harga</th>
          <th>Qty</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>

      </tbodY>
    </table>
  </div>
</div>
