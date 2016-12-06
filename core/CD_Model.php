<?php
  defined('base_path') OR die('Akses langsung tidak dapat dilakukan');
  class CD_Model{

    public $db;

    public function __construct()
    {
      // require_once('config/config.php');
      global $config;
      $configs = $config['database'];
      $this->db = new Database($configs['host'], $configs['user'], $configs['pass'], $configs['name']);
    }

  }
