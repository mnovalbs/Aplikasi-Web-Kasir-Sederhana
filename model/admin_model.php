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

    public function is_kategori_exists($nama)
    {
      $nama = $this->db->escape($nama);
      $query = $this->db->query("SELECT nama FROM kategori WHERE nama = $nama");
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
      $query = $this->db->query("SELECT nama, email, kategori, idpetugas FROM petugas WHERE kunci_login != $kunci_login");
      return $this->db->get_all();
    }

    public function list_petugas()
    {
      $this->db->query("SELECT email, idpetugas, nama, kategori FROM petugas ORDER BY nama ASC");
      return $this->db->get_all();
    }

  }
