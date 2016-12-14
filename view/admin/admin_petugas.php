<?php
  $this->load->view('admin/admin_menu');
?>
  <h3 class='subtitle'>List Petugas</h3>
  <button onclick='openModal("tambah_user")' type='button'>Tambah User</button>
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
            <a href='#!' onclick='edit_user(".$petugas['idpetugas'].")'><i class='fa fa-pencil'></i> Ubah</a>
          </div>
      </div>";
    }
  ?>
  </div>

  <div class='modal' id='tambah_user'>
    <div class='head'>
      Tambah User
    </div>
    <form class='cd-form'>
      <div class='input'>
        <input id='nama-user' placeholder='Nama user' maxlength='50'/>
      </div>
      <div class='input'>
        <input id='email-user' placeholder='Email user' maxlength="50"/>
      </div>
      <div class='input'>
        <input type='password' id='password-user' placeholder='Password'/>
      </div>
      <div class='input'>
        <input type='password' id='confirm-password' placeholder='Confirm password'/>
      </div>
      <div class='input'>
        <select id='kategori-user'>
          <option value=''>- Kategori User -</option>
          <option value='2'>Kasir</option>
          <option value='1'>Administrator</option>
        </select>
      </div>
      <button type='button' onclick='tambah_user()'>Submit</button>
    </form>
  </div>

  <div class='modal' id='edit_user'>
    <div class='head'>
      Edit User
    </div>
    <form class='cd-form'>
      <input type='hidden' class='id-user'/>
      <div class='input'>
        <input class='nama-user' placeholder='Nama user' maxlength='50'/>
      </div>
      <div class='input'>
        <input class='email-user' disabled placeholder='Email user' maxlength="50"/>
      </div>
      <div class='input'>
        <input type='password' class='password-user' placeholder='Password'/>
      </div>
      <div class='input'>
        <input type='password' class='confirm-password' placeholder='Confirm password'/>
      </div>
      <div class='input'>
        <select class='kategori-user'>
          <option value=''>- Kategori User -</option>
          <option value='2'>Kasir</option>
          <option value='1'>Administrator</option>
        </select>
      </div>
      <button type='button' onclick='do_edit_user()'>Submit</button>
    </form>
  </div>
