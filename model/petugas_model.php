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

  }

?>
