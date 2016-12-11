<?php
  defined('base_path') OR die('Akses langsung tidak dapat dilakukan');
  class Petugas extends CD_Controller
  {

    public function index()
    {
      $this->arahLogin();
      $this->load->model('petugas_model');

      $data['current_invoice'] = $this->petugas_model->get_current_invoice();
      $data['list_barang'] = $this->petugas_model->list_barang();
      $site['custom_title'] = "Transaksi";
      $this->load->view('header',$site);
      $this->load->view('petugas/petugas_home',$data);
      $this->load->view('footer');
    }

    public function login()
    {
      $this->load->library('form_validation');
      $this->load->library('input');

      $setRules = array(
        array(
          'field' => 'email',
          'name' => 'Email',
          'rules' => 'required',
        ),
        array(
          'field' => 'password',
          'name' => 'Password',
          'rules' => 'required',
        )
      );
      $this->form_validation->set_rules($setRules);
      if($this->form_validation->run()){
        if($this->do_login()!=false){

        }
        else
        {
          $data['error'] = "Periksa kembali email dan password";
        }
      }
      $site['custom_title'] = "Login Petugas";
      $data['error_form'] = $this->form_validation->error_message('<div class="peringatan merah">','</div>');
      $this->load->view('header', $site);
      $this->load->view('petugas/petugas_login', $data);
      $this->load->view('footer');

    }

    public function js_login()
    {
      $this->load->library('input');
      $do_login = $this->do_login();
      if($do_login!=false)
      {
        set_cookie('petugas', $do_login->kunci_login, time()+3600*24, '/', NULL, NULL, TRUE);
        $hasil['success'] = 'yes';
        if($do_login->kategori==1){
          $hasil['redirect'] = base_url('admin');
        }else{
          $hasil['redirect'] = base_url('petugas');
        }
        echo json_encode($hasil);
      }
      else
      {
        echo json_encode(array('success'=>'no'));
      }
    }

    protected function do_login()
    {
      $email = $this->input->post('email');
      $password = $this->input->post('password');

      $this->load->model('petugas_model');
      return $this->petugas_model->login($email, $password);
    }

    public function listPetugas()
    {
      $this->hai = "Hai";
      $this->load->model('petugas_model');
      $petugas = $this->petugas_model->listPetugas();
      print_r($petugas);
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
        if($this->petugas_model->cek_petugas($kunci_login, 0)==false)
        {
          set_cookie('petugas','',time()-3,'/',NULL,NULL,TRUE);
          die(redirect('petugas/login'));
        }
      }
    }

    public function list_barang($start = 0, $limit = 5)
    {
      $this->arahLogin();
      $this->load->model('petugas_model');
      $start = (int)$start;
      $limit = (int)$limit;
      $data['list_barang'] = $this->petugas_model->list_barang($start, $limit);
      echo json_encode($data['list_barang']);
    }

    public function cari_barang()
    {
      $this->arahLogin();
      $this->load->model('petugas_model');
      $this->load->library('input');

      $q = $this->input->post('q');
      $hasil = $this->petugas_model->cari_barang($q);

      echo json_encode($hasil);
    }

    public function tambah_transaksi()
    {
      $this->arahLogin();
      $this->load->model('petugas_model');
      $this->load->library('input');

      $id_barang = $this->input->post('id');
      $barang = $this->petugas_model->get_barang($id_barang);

      $hasil['success'] = true;

      if($barang!=false){
        $hasil['item'] = $barang;
      }else{
        $hasil['success'] = false;
      }

      echo json_encode($hasil);

    }

  }

?>
