<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link href='<?php echo base_url('assets/css_style.css'); ?>' rel='stylesheet'/>
    <style>
      body{
        background: #fff;
      }
      p{
        margin: 0px;
      }

      /* A4 Landscape*/
      /*@page {
          size: A5 Portrait;
          margin: 10%;
      }*/

      @media print {
        @page {
          size: A5;
        }
      }
    </style>
  </head>
  <body>
    <div id='cetakan-transaksi'>
      <div class='tengah'>
        <p>NGESREP TIMUR 6</p>
        <p>JL. NGESREP TIMUR V SUMURBOTO BANYUMANIK</p>
        <p>SEMARANG. 50269</p>
      </div>
      <div class='tanggal-petugas'>
        <div class='kiri'>
          <?php echo date("Y-m-d H:i:s"); ?>
        </div>
        <div class='kanan'>
          <?php echo safe_echo_html("#CDINV".$detail_transaksi[0]['idpelanggan']." ".$detail_transaksi[0]['nama_petugas']); ?>
        </div>
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

      <div class='tengah' style='margin-top:20px;'>
        <p>TERIMA KASIH SELAMAT BELANJA KEMBALI</p>
        085694325922
      </div>
    </div>

    <script>
      window.print();
    </script>
  </body>
</html>
