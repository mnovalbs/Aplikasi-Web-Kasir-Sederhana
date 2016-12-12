<?php

  class Petugas_model extends CD_Model
  {

    public function login($email, $password)
    {
      $email = $this->db->escape($email);
      $cek = $this->db->query("SELECT * FROM petugas WHERE email = $email");
      if($cek->num_rows!=0)
      {
        $fetch = $cek->fetch_object();
        $password_salt = $fetch->password_salt;
        $password = $this->db->escape(sha1($password_salt.$password));
        $query = $this->db->query("SELECT * FROM petugas WHERE email = $email AND password = $password");
        if($query->num_rows!=0)
        {
          return $query->fetch_object();
        }
        else
        {
          return false;
        }
      }
      else
      {
        return false;
      }
    }

    public function cek_petugas($kunci_login, $num)
    {
      $kunci_login = $this->db->escape($kunci_login);
      $query = $this->db->query("SELECT * FROM petugas WHERE kunci_login = $kunci_login AND kategori = $num");
      if($query->num_rows!=0)
      {
        return true;
      }
      else
      {
        return false;
      }
    }

    public function listPetugas()
    {
      $this->db->query("SELECT * FROM petugas");
      return $this->db->get_all();
    }

    public function get_current_invoice()
    {
      $query = $this->db->query("SELECT idpelanggan FROM transaksi ORDER BY idpelanggan DESC LIMIT 1");
      if($query->num_rows!=0){
        return $query->fetch_object()->idpelanggan + 1;
      }else{
        return 1;
      }
    }

    public function list_barang($start = 0, $limit = 5)
    {
      $this->db->query("SELECT *,a.nama AS nama_barang, b.nama AS nama_kategori FROM barang AS a INNER JOIN kategori AS b ON a.idkategori = b.idkategori WHERE a.stok > 0 ORDER BY idbarang DESC LIMIT $start, $limit");
      return $this->db->get_all();
    }

    public function cari_barang($q = '')
    {
      // $q = $this->db->escape($q);
      $this->db->query("SELECT *,a.nama AS nama_barang, b.nama AS nama_kategori FROM barang AS a INNER JOIN kategori AS b ON a.idkategori = b.idkategori WHERE a.nama LIKE '%$q%' AND a.stok > 0 ORDER BY a.nama ASC");
      return $this->db->get_all();
    }

    public function get_barang($id = 0)
    {
      $id = (int)$id;
      $query = $this->db->query("SELECT *,a.nama AS nama_barang, b.nama AS nama_kategori FROM barang AS a INNER JOIN kategori AS b ON a.idkategori = b.idkategori WHERE idbarang = $id");
      if($query->num_rows!=0){
        return $query->fetch_assoc();
      }else{
        return false;
      }
    }

    public function get_petugas($kunci_login = '')
    {
      $kunci_login = $this->db->escape($kunci_login);
      $query = $this->db->query("SELECT nama, email, kategori, idpetugas FROM petugas WHERE kunci_login = $kunci_login");
      return $query->fetch_assoc();
    }

    public function add_transaksi($current_invoice,$tgl_transaksi,$total_item,$total_harga,$petugas)
    {
      $tgl_transaksi = $this->db->escape($tgl_transaksi);
      $this->db->query("INSERT INTO transaksi (idpelanggan, tgl_transaksi, total_item, total_harga, id_petugas) VALUES($current_invoice, $tgl_transaksi, $total_item, $total_harga, $petugas)");
    }

    public function add_detail_transaksi($idpelanggan, $idbarang, $jumlah, $harga)
    {
      $this->db->query("UPDATE barang AS a, (SELECT b.stok-$jumlah AS stok_baru FROM barang AS b WHERE b.idbarang = $idbarang)AS c SET a.stok = c.stok_baru WHERE a.idbarang = $idbarang");
      $this->db->query("INSERT INTO detail_transaksi (idtransaksi, idbarang, jumlah, harga) VALUES ((SELECT idtransaksi FROM transaksi WHERE idpelanggan = $idpelanggan),$idbarang, $jumlah, $harga)");
    }

    public function get_detail_transaksi($id)
    {
      $this->db->query("SELECT *, d.nama AS nama_barang, b.nama AS nama_petugas, c.harga AS harga_jual FROM transaksi AS a INNER JOIN petugas AS b ON a.id_petugas = b.idpetugas INNER JOIN detail_transaksi AS c ON c.idtransaksi = a.idtransaksi INNER JOIN barang AS d ON d.idbarang = c.idbarang WHERE a.idtransaksi = $id");
      return $this->db->get_all();
    }

  }

?>
