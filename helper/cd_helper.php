<?php

  function base_url($str = '')
  {
    global $config;
    $root_url = $config['url']['base_url'];
    return $root_url.$str;
  }

?>
