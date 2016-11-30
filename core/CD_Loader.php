<?php

  class CD_Loader{

    public function view($str, $arr = array())
    {
      foreach ($arr as $key => $value) {
        $$key = $value;
      }
      if(!file_exists('view/'.$str.'.php')){
        die("View tidak ditemukan");
      }else{
        require_once('view/'.$str.'.php');
      }
    }

    public function model($str)
    {
      if(!file_exists('model/'.$str.'.php')){
        die("Model tidak ditemukan");
      }else{
        require_once('model/'.$str.'.php');
      }
      $model = new $str;
      return $model;
    }

  }

?>
