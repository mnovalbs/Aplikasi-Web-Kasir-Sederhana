<?php

  class admin_model extends CD_Model
  {

    public function listKategori()
    {
      $query = $this->db->query("SELECT * FROM kategori ORDER BY nama");
      return $this->db->get_all();
    }

    public function editKategori($id, $nama)
    {
      $nama = $this->db->escape($nama);
      $query = $this->db->query("UPDATE kategori SET nama = $nama WHERE idkategori = $id");
    }

    public function delete_kategori($id)
    {
      $query = $this->db->query("DELETE FROM kategori WHERE idkategori = $id");
      if($query)
      {
        return true;
      }
      else
      {
        return false;
      }
    }

    public function is_kategori_exists($nama='', $id=0)
    {
      if(!empty($nama))
      {
        $nama = $this->db->escape($nama);
        $query = $this->db->query("SELECT nama FROM kategori WHERE nama = $nama");
      }else{
        $id = (int)$id;
        $query = $this->db->query("SELECT nama FROM kategori WHERE idkategori = $id");
      }
      if($query->num_rows!=0)
      {
        return true;
      }
      else
      {
        return false;
      }
    }

    public function add_kategori($nama)
    {
      $nama = $this->db->escape($nama);
      $query = $this->db->query("INSERT INTO kategori (nama) VALUES($nama)");
    }

    public function get_kategori($id)
    {
      $id = (int)$id;
      $query = $this->db->query("SELECT * FROM kategori WHERE idkategori = $id");
      return $query->fetch_assoc();
    }

    public function get_petugas($kunci_login = '')
    {
      $kunci_login = $this->db->escape($kunci_login);
      $query = $this->db->query("SELECT nama, email, kategori, idpetugas FROM petugas WHERE kunci_login = $kunci_login");
      return $query->fetch_assoc();
    }

    public function list_petugas()
    {
      $this->db->query("SELECT email, idpetugas, nama, kategori FROM petugas ORDER BY kategori DESC");
      return $this->db->get_all();
    }

    public function get_barang($id)
    {
      $id = (int)$id;
      $query = $this->db->query("SELECT *,a.nama AS nama_barang, b.nama AS nama_kategori, c.nama AS nama_petugas FROM barang AS a INNER JOIN kategori AS b ON a.idkategori = b.idkategori INNER JOIN petugas AS c ON a.idpetugas = c.idpetugas WHERE idbarang = $id");
      return $query->fetch_assoc();
    }

    public function list_barang($start = 0, $limit = 5)
    {
      $this->db->query("SELECT *,a.nama AS nama_barang, b.nama AS nama_kategori, c.nama AS nama_petugas, (SELECT COUNT(*) FROM barang) AS total_barang, $limit AS limit_barang FROM barang AS a INNER JOIN kategori AS b ON a.idkategori = b.idkategori INNER JOIN petugas AS c ON a.idpetugas = c.idpetugas ORDER BY idbarang DESC LIMIT $start, $limit");
      return $this->db->get_all();
    }

    public function tambah_barang($nama, $deskripsi, $kategori, $harga, $stok, $petugas)
    {
      $nama = $this->db->escape($nama);
      $deskripsi = $this->db->escape($deskripsi);
      $kategori = (int)$kategori;
      $harga = (int)$harga;
      $stok = (int)$stok;
      $petugas = (int)$petugas;

      $this->db->query("INSERT INTO barang (nama, deskripsi, idkategori, harga, stok, idpetugas) VALUES ($nama, $deskripsi, $kategori, $harga, $stok, $petugas) ");
    }

    public function edit_barang($id ,$nama, $deskripsi, $kategori, $harga, $stok, $petugas)
    {
      $id = (int)$id;
      $nama = $this->db->escape($nama);
      $deskripsi = $this->db->escape($deskripsi);
      $kategori = (int)$kategori;
      $harga = (int)$harga;
      $stok = (int)$stok;
      $petugas = (int)$petugas;

      $this->db->query("UPDATE barang SET nama = $nama, deskripsi = $deskripsi, idkategori = $kategori, harga = $harga, stok = $stok, idpetugas = $petugas WHERE idbarang = $id");
    }

    public function hapus_barang($id)
    {
      $this->db->query("DELETE FROM barang WHERE idbarang = $id");
    }

  }
