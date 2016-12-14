
    <div id='cetakan-transaksi'>
      <div class='tengah'>
        <b><?php echo safe_echo_html("#CDINV".$detail_transaksi[0]['idpelanggan']); ?></b>
        <p><?php echo safe_echo_html($detail_transaksi[0]['nama_petugas']); ?></p>
      </div>
      <table class='cd-table'>
        <tbody>
          <?php
            foreach ($detail_transaksi as $transaksi) {
              echo "<tr>\n";
              echo "\t<td>".safe_echo_html($transaksi['nama_barang'])."</td>\n";
              echo "\t<td>".safe_echo_html($transaksi['jumlah'])."</td>\n";
              echo "\t<td>".toRupiah($transaksi['harga_jual'])."</td>\n";
              echo "\t<td>".toRupiah($transaksi['harga_jual'] * $transaksi['jumlah'])."</td>\n";
              echo "</tr>\n";
            }
          ?>
          <tr class='harga-jual'>
            <td colspan='3'>Harga Jual</td>
            <td> : <?php echo toRupiah($transaksi['total_harga']); ?></td>
          </tr>
        </tbody>
      </table>
    </div>
