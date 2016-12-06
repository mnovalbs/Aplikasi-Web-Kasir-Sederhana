<?php
  defined('base_path') OR die('Akses langsung tidak dapat dilakukan');
  class CD_Loader{

    protected function _init_class($class) {
      $C =& get_instance();
      $name = strtolower($class);
      $this->$name = new $class();
      $C->$name = new $class();
    }

    public function view($str, $arr = array())
    {
      $this->load = new CD_Loader();
      foreach ($arr as $key => $value) {
        $$key = $value;
      }
      if(!file_exists('view/'.$str.'.php')){
        die("View tidak ditemukan");
      }else{
        require_once('view/'.$str.'.php');
      }
    }

    public function library($str)
    {
      if(!file_exists('library/'.$str.'.php')){
        die("Library tidak ditemukan");
      }else{
        require_once('library/'.$str.'.php');
      }
      $this->_init_class($str);
    }

    public function model($str)
    {
      if(!file_exists('model/'.$str.'.php')){
        die("Model tidak ditemukan");
      }else{
        require_once('model/'.$str.'.php');
      }
      $this->_init_class($str);
    }

    public function helper($helper)
    {
      if(!file_exists('helper/'.$helper.'.php')){
        die("Helper tidak ditemukan");
      }else{
        require_once('helper/'.$helper.'.php');
      }
      $this->_init_class($str);
    }

  }

?>
