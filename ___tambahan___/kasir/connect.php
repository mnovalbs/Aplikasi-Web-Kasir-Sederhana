<?php

$db_host  = 'localhost';
$db_user  = 'root';
$db_pass  = '';
$db_name  = 'db_kasir';

$link = new mysqli($db_host,$db_user,$db_pass,$db_name);

if ($link->connect_errno > 0){
  die ("Could not connect to the database: <br />". $link->connect_error);
}

?>
