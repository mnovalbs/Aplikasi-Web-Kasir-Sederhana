<?php
  class home_model extends CD_Model{

    public function getUser(){
      $query = $this->db->query("SELECT * FROM barang");
      return $query->num_rows;
    }

  }
?>
