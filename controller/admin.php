<?php
  defined('base_path') OR die('Akses langsung tidak dapat dilakukan');
  class Admin extends CD_Controller
  {

    public function index()
    {
      $this->arahLogin();
    }

    public function kategori()
    {
      $site['custom_title'] = 'Kategori';
      $this->load->view('header',$site);
      $this->load->view('admin/admin_kategori');
      $this->load->view('footer');
    }

    protected function isLoggedIn()
    {
      return get_cookie('petugas');
    }

    protected function arahLogin()
    {
      if($this->isLoggedIn()==false)
      {
        die(redirect('petugas/login'));
      }
      else
      {
        $this->load->model('petugas_model');
        $kunci_login = get_cookie('petugas');
        if($this->petugas_model->cek_petugas($kunci_login, 1)==false)
        {
          set_cookie('petugas','',time()-3,'/',NULL,NULL,TRUE);
          die(redirect('petugas/login'));
        }
      }
    }

  }

?>
