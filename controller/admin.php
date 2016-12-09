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
      $this->arahLogin();
      $site['custom_title'] = 'Kategori';

      $this->load->model('admin_model');
      $data['list_kategori'] = $this->admin_model->listKategori();

      $this->load->view('header',$site);
      $this->load->view('admin/admin_kategori',$data);
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

    public function list_kategori()
    {
      $this->arahLogin();
      $this->load->model('admin_model');

      $data['list_kategori'] = $this->admin_model->listKategori();

      echo json_encode($data['list_kategori']);
    }

    public function edit_kategori()
    {
      $this->arahLogin();
      $this->load->library('input');
      $this->load->model('admin_model');
      $id_kategori = (int)$this->input->post('id');
      $nama_kategori = $this->input->post('nama');

      $nama_kategori_lama = $this->admin_model->get_kategori($id_kategori)['nama'];

      $hasil['success'] = true;
      $hasil['erorr'] = '';

      if($nama_kategori != $nama_kategori_lama)
      {
        if(empty($nama_kategori))
        {
          $hasil['success'] = false;
          $hasil['error'] = "Nama kategori harus terisi";
        }
        else if (!preg_match('/^[a-zA-Z-\s]+$/', $nama_kategori))
        {
          $hasil['success'] = false;
          $hasil['error'] = "Nama kategori tidak valid";
        }
        else if(strlen($nama_kategori>50))
        {
          $hasil['success'] = false;
          $hasil['error'] = "Nama kategori terlalu panjang (max : 50 karakter)";
        }
        else if($this->admin_model->is_kategori_exists($nama_kategori))
        {
          $hasil['success'] = false;
          $hasil['error'] = "Nama kategori sudah dipakai";
        }
      }


      if($hasil['success']!=false){
        $this->admin_model->editKategori($id_kategori,$nama_kategori);
      }

      echo json_encode($hasil);

    }

    public function delete_kategori()
    {
      $this->arahLogin();
      $this->load->library('input');
      $id_kategori = 0;
      $id_kategori = (int)$this->input->post('id');

      $this->load->model('admin_model');
      if($this->admin_model->delete_kategori($id_kategori)){
        echo json_encode(array('success'=>true));
      }else{
        echo json_encode(array('success'=>false));
      }
    }

    public function add_kategori()
    {
      $this->arahLogin();
      $this->load->library('input');
      $this->load->model('admin_model');
      $nama_kategori = $this->input->post('nama');

      $hasil['success'] = true;
      $hasil['error'] = array();

      if(empty($nama_kategori))
      {
        $hasil['success'] = false;
        array_push($hasil['error'], "Nama kategori harus terisi");
      }
      if (!preg_match('/^[a-zA-Z-\s]+$/', $nama_kategori))
      {
        $hasil['success'] = false;
        array_push($hasil['error'], "Nama kategori tidak valid");
      }
      if($this->admin_model->is_kategori_exists($nama_kategori)!=false)
      {
        $hasil['success'] = false;
        array_push($hasil['error'], "Kategori sudah ada sebelumnya");
      }
      if(strlen($nama_kategori)>50)
      {
        $hasil['success'] = false;
        array_push($hasil['error'], "Nama kategori terlalu panjang (max : 50 karakter)");
      }

      if($hasil['success'])
      {
        $this->admin_model->add_kategori($nama_kategori);
      }
      echo json_encode($hasil);
    }

    public function petugas()
    {
      $this->arahLogin();
      $site['custom_title'] = "Petugas";

      $kunci_login = get_cookie('petugas');
      $this->load->model('admin_model');

      $data['list_petugas'] = $this->admin_model->get_petugas($kunci_login);

      $this->load->view('header', $site);
      $this->load->view('admin/admin_petugas', $data);
      $this->load->view('footer');
    }

    public function logout()
    {
      delete_cookie('petugas');
      die(redirect('admin'));
    }

    public function list_petugas()
    {
      $this->arahLogin();
      $this->load->model('admin_model');

      echo json_encode($this->admin_model->list_petugas());
    }

    public function list_barang($limit = 5, $start = 0)
    {

    }

    public function barang()
    {
      $this->arahLogin();
      $this->load->model('admin_model');
      $site['custom_title'] = "List Barang";

      $this->load->view('header', $site);
      $this->load->view('admin/admin_barang');
      $this->load->view('footer');
    }

  }

?>
