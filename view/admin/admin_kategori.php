<?php
  $this->load->view('admin/admin_menu');
?>

  <h3 class='subtitle'>Kategori List</h3>
  <div id='error-message'></div>
  <form id='add-kategori'>
    <input maxlength='50' placeholder='Tambah kategori'/> <label><i class='fa fa-plus'></i></label>
  </form>
  <div id='kategori-list'>
  <?php
    foreach ($list_kategori as $kategori) {
      echo "<div class='li-kategori' kategori-id='".$kategori['idkategori']."'>";
        echo "<table><tr><td width='30'><span>";
        echo "<a href='#!' class='hapus' onclick='delete_kategori(".$kategori['idkategori'].")'><i class='fa fa-trash'></i></a> ";
        echo "<a href='#!' class='ubah'><i class='fa fa-pencil'></i></a>";
        echo "</span></td>";
        echo "<td><label><span class='nama'>".safe_echo_html($kategori['nama'])."</span></label></td></tr></table>";
      echo "</div>";
    }
  ?>
  </div>
