<?php
  defined('base_path') OR die('Akses langsung tidak dapat dilakukan');
  class Home extends CD_Controller{

    public function index()
    {
      redirect('petugas');
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
        set_cookie('petugas', $do_login->kunci_login, time()+3600*24, NULL, NULL, NULL, TRUE);
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
    }

  }
