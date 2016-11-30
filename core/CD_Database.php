<?php
  class Database{
    private $db;

    public function __construct($db_host, $db_user, $db_pass, $db_name)
    {
      $this->db = new mysqli($db_host, $db_user, $db_pass, $db_name);
    }

    public function query($query)
    {
      return $this->db->query($query);
    }

  }
?>
