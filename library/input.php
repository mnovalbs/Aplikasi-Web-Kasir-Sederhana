<?php

  class Input{
    public function post($str)
    {
      $ret = '';
      if(!empty($_POST[$str]))
      {
        $ret = strip_tags(trim($_POST[$str]));
      }
      return $ret;
    }

    public function get($str)
    {
      $ret = '';
      if(!empty($_GET[$str]))
      {
        $ret = $_GET[$str];
      }

      return $ret;
    }

  }

  function set_value($str)
  {
    $ret = '';
    if(!empty($_POST[$str]))
    {
      $ret = $_POST[$str];
    }
    return $ret;
  }
