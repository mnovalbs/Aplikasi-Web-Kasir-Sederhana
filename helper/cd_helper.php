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

  function delete_cookie($name)
  {
    set_cookie($name, '', time()-3, '/', null, null, true);
  }

  function redirect($str)
  {
    header("Location:".base_url($str));
  }

  if(!function_exists('toRupiah'))
  {
    function toRupiah($num){
      return "Rp <span class='rp-harga'>".number_format($num,0,'','.')."</span>";
    }
  }

  if(!function_exists('safe_echo_html'))
  {
    function safe_echo_html($string)
    {
      return trim(strip_tags(htmlspecialchars($string, ENT_QUOTES)));
    }
  }

  if(!function_exists('safe_echo_input'))
  {
    function safe_echo_input($string='')
    {
      return trim(preg_replace('/\s+/',' ', htmlspecialchars($string, ENT_QUOTES)));
    }
  }

  function kategori_petugas($num)
  {
    if($num == 1)
    {
      return "Administrator";
    }
    else
    {
      return "Kasir";
    }
  }

  function intToStr($num)
  {
    $num = (int)$num;
    if(strlen($num)==1){$num = "0".$num;}
    return $num;
  }

?>
