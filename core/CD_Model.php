<?php
  class CD_Model{

    public $db;

    public function __construct()
    {
      require_once('config/config.php');
      $config = $config['database'];
      $this->db = new Database($config['host'], $config['user'], $config['pass'], $config['name']);
    }

  }
