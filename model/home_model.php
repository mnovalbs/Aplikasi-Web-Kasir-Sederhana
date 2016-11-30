<?php
  class home_model extends CD_Model{

    public function getUser(){
      $query = $this->db->query("SELECT * FROM mhs_user");
      return $query->num_rows;
    }

  }
?>
