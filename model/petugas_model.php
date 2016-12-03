<?php

  class Petugas_model extends CD_Model
  {

    public function cek_login($email, $password)
    {
      $email = $this->db->escape($email);
      $password = $this->db->escape($password);
      $cek = $this->db->query("SELECT * FROM petugas WHERE email = $email AND password = $password");
      if($cek->num_rows!=0)
      {
        return $cek->fetch_object();
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
