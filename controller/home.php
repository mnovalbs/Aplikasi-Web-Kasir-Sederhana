<?php
  class Home extends CD_Controller{

    public function index()
    {
      $data['aku'] = "Noval Bintang";
      $data['num_rows'] = $this->load->model('home_model')->getUser();
      $this->load->view('homepage', $data);
    }

  }
