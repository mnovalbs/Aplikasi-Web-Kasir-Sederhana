<?php

require_once 'functions.php';

if(isset($_POST['login'])) {

  if(!empty($_POST['email']) && !empty($_POST['password'])) {
    $email = mysqli_real_escape_string($link,$_POST['email']);
    $password = mysqli_real_escape_string($link,$_POST['password']);
    if(login($email,$password)) {
      $_SESSION['user'] = getId($email,$password);
      header('Location: rekap-transaksi.php');
    }
    else {
      echo 'gagal login';
    }
  }

}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form method="post">
      <input type="text" name="email" value="">
      <input type="text" name="password" value="">
      <button type="submit" name="login">Login</button>
    </form>
  </body>
</html>
