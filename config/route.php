<?php

  $controller = 'home';
  $action = 'index';

  $prm = array();
  if(!empty($_GET['params'])){
    $prm = explode('/',$_GET['params']);
    if(!empty($prm[0])){
      $controller = $prm[0];
      unset($prm[0]);
    }
    if(!empty($prm[1])){
      $action = $prm[1];
      unset($prm[1]);
    }
  }

  if(!file_exists('controller/'.$controller.'.php')){
    die("Controller Tidak Ditemukan!");
  }else{
    require_once('controller/'.$controller.'.php');
  }

  $site = new $controller();
  // $site->$action();

  if (method_exists($site, $action) && is_callable(array($site, $action))){
    call_user_func_array(array($site, $action),$prm);
  }else{
    die("Function Tidak Dapat Dipanggil");
  }

?>
