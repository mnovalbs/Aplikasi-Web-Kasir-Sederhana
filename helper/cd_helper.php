<?php

  function base_url($str = '')
  {
    global $config;
    $root_url = $config['url']['base_url'];
    return $root_url.$str;
  }

  function set_cookie($name, $value, $time=3600, $path='/', $domain=NULL, $secure=false, $httpOnly = false )
  {
    setcookie($name, $value, $time, $path, $domain, $secure, $httpOnly);
  }

  function get_cookie($name)
  {
    if(!empty($_COOKIE[$name]))
    {
      return $_COOKIE[$name];
    }
    else
    {
      return false;
    }
  }

  function redirect($str)
  {
    header("Location:".base_url($str));
  }

?>
