<?php
  defined('base_path') OR die('Akses langsung tidak dapat dilakukan');
  /************************
    Codedicate Controller
    Officially made by :
    - Muhammad Noval Bintang Salim
    - Hafidh Aulia Wirandi
    - Afif Aminulyo
    - Khanif Fauzi Pambudi
    - Primanggala Surya
  ************************/
  require_once('core/CD_Config.php');
  require_once('core/CD_Loader.php');

  class CD_Controller{
    private static $instance;
    public $config;
    public $load;
    public $input;

    public function __construct()
    {
      self::$instance = $this;
      $this->load = new CD_Loader();
      $this->config = new CD_Config();
    }

    public static function & get_instance()
    {
      return self::$instance;
    }

  }

?>
