<?php
  $this->load->view('admin/admin_menu');
?>
  <h3 class='subtitle'>List Petugas</h3>
  <div id='list-petugas'>
  <?php
    foreach ($list_petugas as $petugas) {
      echo "<div class='petugas'>
          <div class='huruf-petugas'>
          <!--".substr(strip_tags($petugas['nama']),0,1)."-->
          <img src='".base_url('assets/images/petugas.png')."'/>
          </div>
          <div class='detail-petugas'>
            <label>".safe_echo_html($petugas['nama'])."</label>
            <small>".kategori_petugas($petugas['kategori'])."</small>
          </div>
          <div class='edit-petugas'>
            <a href='".base_url('admin/edit_petugas/'.$petugas['idpetugas'])."'><i class='fa fa-pencil'></i> Ubah</a>
          </div>
      </div>";
    }
  ?>
  </div>
