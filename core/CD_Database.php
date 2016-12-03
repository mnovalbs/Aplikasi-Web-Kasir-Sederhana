<?php
  class Database{
    private $db;
    protected $result;

    public function __construct($db_host, $db_user, $db_pass, $db_name)
    {
      $this->db = new mysqli($db_host, $db_user, $db_pass, $db_name);
    }

    public function query($query)
    {
      $this->result = $this->db->query($query);
      return $this->result;
    }

    public function escape($str)
    {
      return "'".$this->db->real_escape_string($str)."'";
    }

    public function get_all()
    {
      $arr = array();
      while( $fetch = $this->result->fetch_assoc() ){
        foreach ($fetch as $key => $value) {
          $arrIsi[$key] = $value;
        }
        array_push($arr, $arrIsi);
      }
      return $arr;
    }

  }

  class db_new{

  }
?>
