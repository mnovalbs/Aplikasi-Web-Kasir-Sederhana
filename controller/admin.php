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

      $data['list_petugas'] = $this->admin_model->list_petugas();

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

    public function list_barang($start = 0, $limit = 5)
    {
      $this->arahLogin();
      $this->load->model('admin_model');
      $start = (int)$start;
      $limit = (int)$limit;
      $data['list_barang'] = $this->admin_model->list_barang($start, $limit);
      echo json_encode($data['list_barang']);
    }

    public function get_barang($id=0)
    {
      $this->arahLogin();
      $this->load->model('admin_model');
      $barang = $this->admin_model->get_barang($id);
      echo json_encode($barang);
    }

    public function barang()
    {
      $this->arahLogin();
      $this->load->model('admin_model');
      $site['custom_title'] = "List Barang";
      $data['list_barang'] = $this->admin_model->list_barang(0,10);

      $this->load->view('header', $site);
      $this->load->view('admin/admin_barang', $data);
      $this->load->view('footer');
    }

    public function add_barang()
    {
      $this->arahLogin();
      $this->load->model('admin_model');
      $this->load->library('input');

      $nama_barang = $this->input->post('nama');
      $deskripsi_barang = $this->input->post('deskripsi');
      $kategori_barang = $this->input->post('kategori');
      $harga_barang = $this->input->post('harga');
      $stok_barang = $this->input->post('stok');

      $arr['success'] = true;
      $arr['error'] = array();

      if(empty($nama_barang)){
        $arr['success'] = false;
        array_push($arr['error'], "Nama barang harus terisi");
      }

      if(!preg_match('/^[a-zA-Z0-9- ]+$/',$nama_barang)){
        $arr['success'] = false;
        array_push($arr['error'], "Nama barang tidak valid, hanya boleh alphanumeric dan strip");
      }

      if(strlen($nama_barang)>50){
        $arr['success'] = false;
        array_push($arr['error'], "Nama barang terlalu panjang, maksimal 50 karakter");
      }

      if(empty($deskripsi_barang)){
        $arr['success'] = false;
        array_push($arr['error'], "Deskripsi barang harus terisi");
      }

      if(!is_numeric($kategori_barang)){
        $arr['success'] = false;
        array_push($arr['error'], "Kategori barang tidak valid");
      }

      if(!$this->admin_model->is_kategori_exists('',$kategori_barang)){
        $arr['success'] = false;
        array_push($arr['error'], "Kategori tersebut tidak ditemukan");
      }

      if(!is_numeric($harga_barang)){
        $arr['success'] = false;
        array_push($arr['error'], "Harga barang tidak valid");
      }

      if($harga_barang<1){
        $arr['success'] = false;
        array_push($arr['error'], "Harga barang harus terisi");
      }

      if(!is_numeric($stok_barang)){
        $arr['success'] = false;
        array_push($arr['error'], "Stok barang tidak valid");
      }

      if($stok_barang<1){
        $arr['success'] = false;
        array_push($arr['error'], "Stok barang harus terisi");
      }

      if($arr['success']){
        $petugas = $this->admin_model->get_petugas(get_cookie('petugas'));
        $this->admin_model->tambah_barang($nama_barang, $deskripsi_barang, $kategori_barang, $harga_barang, $stok_barang, $petugas['idpetugas']);
      }

      echo json_encode($arr);
    }

    public function edit_barang()
    {
      $this->arahLogin();
      $this->load->model('admin_model');
      $this->load->library('input');

      $nama_barang = $this->input->post('nama');
      $deskripsi_barang = $this->input->post('deskripsi');
      $kategori_barang = $this->input->post('kategori');
      $harga_barang = $this->input->post('harga');
      $stok_barang = $this->input->post('stok');
      $id_barang = $this->input->post('id');

      $arr['success'] = true;
      $arr['error'] = array();

      $id_barang = (int)$id_barang;

      if(empty($nama_barang)){
        $arr['success'] = false;
        array_push($arr['error'], "Nama barang harus terisi");
      }

      if(!preg_match('/^[a-zA-Z0-9- ]+$/',$nama_barang)){
        $arr['success'] = false;
        array_push($arr['error'], "Nama barang tidak valid, hanya boleh alphanumeric dan strip");
      }

      if(strlen($nama_barang)>50){
        $arr['success'] = false;
        array_push($arr['error'], "Nama barang terlalu panjang, maksimal 50 karakter");
      }

      if(empty($deskripsi_barang)){
        $arr['success'] = false;
        array_push($arr['error'], "Deskripsi barang harus terisi");
      }

      if(!is_numeric($kategori_barang)){
        $arr['success'] = false;
        array_push($arr['error'], "Kategori barang tidak valid");
      }

      if(!$this->admin_model->is_kategori_exists('',$kategori_barang)){
        $arr['success'] = false;
        array_push($arr['error'], "Kategori tersebut tidak ditemukan");
      }

      if(!is_numeric($harga_barang)){
        $arr['success'] = false;
        array_push($arr['error'], "Harga barang tidak valid");
      }

      if($harga_barang<1){
        $arr['success'] = false;
        array_push($arr['error'], "Harga barang harus terisi");
      }

      if(!is_numeric($stok_barang)){
        $arr['success'] = false;
        array_push($arr['error'], "Stok barang tidak valid");
      }

      if($stok_barang<1){
        $arr['success'] = false;
        array_push($arr['error'], "Stok barang harus terisi");
      }

      if($arr['success']){
        $petugas = $this->admin_model->get_petugas(get_cookie('petugas'));
        $this->admin_model->edit_barang($id_barang ,$nama_barang, $deskripsi_barang, $kategori_barang, $harga_barang, $stok_barang, $petugas['idpetugas']);
      }

      echo json_encode($arr);
    }

  }

?>
