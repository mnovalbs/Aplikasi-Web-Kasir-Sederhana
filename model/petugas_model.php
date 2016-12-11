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
      $this->db->query("SELECT *,a.nama AS nama_barang, b.nama AS nama_kategori FROM barang AS a INNER JOIN kategori AS b ON a.idkategori = b.idkategori ORDER BY idbarang DESC LIMIT $start, $limit");
      return $this->db->get_all();
    }

    public function cari_barang($q = '')
    {
      // $q = $this->db->escape($q);
      $this->db->query("SELECT *,a.nama AS nama_barang, b.nama AS nama_kategori FROM barang AS a INNER JOIN kategori AS b ON a.idkategori = b.idkategori WHERE a.nama LIKE '%$q%' ORDER BY a.nama ASC");
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

  }

?>
