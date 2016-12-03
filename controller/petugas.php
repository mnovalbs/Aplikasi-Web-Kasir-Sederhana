<?php

  class Petugas extends CD_Controller
  {

    public function login()
    {
      if(isset($_POST['login']))
      {

        if( !empty($_POST['email']) && !empty($_POST['password']) )
        {
          $email = $_POST['email'];
          $password = $_POST['password'];

          if( $this->do_login($email, $password) != false )
          {
            echo "Berhasil login";
          }
          else
          {
            echo "Gagal Login";
          }
        }

      }
      $this->load->view('petugas/petugas_login');

    }

    protected function do_login($email, $password)
    {
      $password = sha1($password);
      return $this->load->model('petugas_model')->cek_login($email, $password);
    }

    public function listPetugas()
    {
      $petugas = $this->load->model('petugas_model')->listPetugas();
      print_r($petugas);
    }

  }

?>
