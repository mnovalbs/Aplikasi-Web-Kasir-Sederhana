<?php
  $this->load->view('admin/admin_menu');
?>
  <h3 class='subtitle'>List Barang</h3>
  <button onclick='openModal("tambah-barang")'>Tambah Barang</button>
  <table id='list-barang' class='cd-table'>
    <thead>
      <tr>
        <th width='10'>No</th>
        <th>Nama Barang</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
  <?php
    $no = 1;
    foreach ($list_barang as $barang) {
      ?>
      <tr>
        <td><?php echo $no; ?></td>
        <td><?php echo safe_echo_html($barang['nama_barang']); ?></td>
        <td><?php echo safe_echo_html($barang['nama_kategori']); ?></td>
        <td><?php echo toRupiah($barang['harga']); ?></td>
        <td><?php echo safe_echo_html($barang['stok']); ?></td>
        <td>Action</td>
      </tr>
      <?php
      $no++;
    }
  ?>
    </tbody>
  </table>

  <div id='navigasi'>
    <?php
      echo "<label class='prev non-aktif'>Prev</label>";
      if($barang['total_barang'] > $barang['limit_barang'])
      {
        echo "<label class='next' onclick='get_list_barang(".$barang['limit_barang'].",".$barang['limit_barang'].")'>Next</label>";
      }else{
        echo "<label class='next non-aktif'>Next</label>";
      }
    ?>
  </div>

  <div class='modal' id='tambah-barang'>
    <div class='head'>Tambah Data Barang</div>
    <form class='cd-form'>
      <div class='input'>
        <input id='nama-barang' placeholder='Nama barang&hellip;' maxlength='50'/>
      </div>
      <div class='input'>
        <textarea id='deskripsi-barang' placeholder='Deskripsi barang&hellip;' maxlength='300'></textarea>
      </div>
      <div class='input'>
        <div class='dibagi-tiga'>
          <div>
            <select id='pilih-kategori'>
              <option value=''>Pilih Kategori</option>
            </select>
          </div>
          <div>
            <input id='harga-barang' placeholder='Harga barang' min='1' type='number'/>
          </div>
          <div>
            <input id='stok-barang' placeholder='Stok barang' min='1' type='number'/>
          </div>
        </div>
      </div>
      <div class='input'>
        <button type='button' onclick='tambah_barang()'>Tambah</button>
      </div>
    </form>
  </div>

  <!-- <script>
    function openAddBarang()
    {
      window.open("<?php echo base_url('admin/add_barang'); ?>","windowName", "width=200,height=200,scrollbars=no");
    }
    function popUpClosed() {
      window.location.reload();
    }
  </script> -->
