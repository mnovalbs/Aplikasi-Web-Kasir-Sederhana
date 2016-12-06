<?php
session_start();
require_once 'connect.php';

function checkQuery($query) {
  global $link;
  if(!$query) {
    return null;
  }
  return $query;
}

function checkQueryBoolean($query) {
  global $link;
  if(!$query) {
    return false;
  }
  else {
    if($query->num_rows > 0) {
      return true;
    }
    else {
      return false;
    }
  }
  return false;
}

function checkQueryReturnValue($query,$field) {
  global $link;
  if(!$query) {
    return null;
  }
  else {
    if($query->num_rows > 0) {
      $data = $query->fetch_object();
      return $data->$field;
    }
    else {
      return null;
    }
  }
  return null;
}

function login($email,$password) {
  global $link;
  $password = sha1($password);
  $result = $link->query("SELECT * FROM petugas WHERE email = '$email' AND password = '$password'");
  return checkQueryBoolean($result);
}

function getId($email,$password) {
  global $link;
  $password = sha1($password);
  $result = $link->query("SELECT * FROM petugas WHERE email = '$email' AND password = '$password'");
  return checkQueryReturnValue($result,'idpetugas');
}

function getStatus($idPetugas) {
  global $link;
  $result = $link->query("SELECT * FROM petugas WHERE idpetugas = '$idPetugas'");
  return checkQueryReturnValue($result,'kategori');
}

function getAllTransaksi($idPetugas,$status) {
  global $link;
  $result = $link->query("SELECT * FROM transaksi");
  if($status == 1) {
    $result = $link->query("SELECT * FROM transaksi WHERE id_petugas='$status'");
  }
  return checkQuery($result);
}

function getTransaksiByDate($date,$idPetugas,$status) {
  global $link;
  $result = $link->query("SELECT * FROM transaksi WHERE tgl_transaksi = '$date'");
  if ($date == "") {
    $result = $link->query("SELECT * FROM transaksi WHERE id_petugas = '$idPetugas'");
  }
  if ($status == 1) {
    $result = $link->query("SELECT * FROM transaksi WHERE tgl_transaksi = '$date' AND id_petugas='$idPetugas'");
  }
  else if ($status == 2){
    $result = $link->query("SELECT * FROM transaksi WHERE tgl_transaksi = '$date' AND id_petugas='$idPetugas'");
  }
  return checkQuery($result);
}

function getTransaksi($idTransaksi) {
  global $link;
  $result = $link->query("SELECT * FROM transaksi WHERE idtransaksi='$idTransaksi'");
  return checkQuery($result);
}

function getDetailTransaksi($idTransaksi) {
  global $link;
  $result = $link->query("SELECT * FROM detail_transaksi WHERE idtransaksi='$idTransaksi'");
  return checkQuery($result);
}

function getNamaBarang($idBarang) {
  global $link;
  $result = $link->query("SELECT * FROM barang WHERE idbarang='$idBarang'");
  return checkQueryReturnValue($result,'nama');
}

?>
