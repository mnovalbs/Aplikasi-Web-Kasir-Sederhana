<?php
  /************************
    Codedicate Controller
    Officially made by :
    - Muhammad Noval Bintang Salim
    - Hafidh Aulia Wirandi
    - Afif Aminulyo
    - Khanif Fauzi Pambudi
    - Primanggala Surya
  ************************/

  class CD_Controller{

    public $load;
    public $config;

    public function __construct(){
      $this->load = new CD_Loader();
      $this->config = new CD_Config();
    }

  }

?>
