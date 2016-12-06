<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  define('base_path', $_SERVER['SCRIPT_FILENAME']);

  function & get_instance() {
    return CD_Controller::get_instance();
  }

  include_once('config/config.php');
  require_once('helper/cd_helper.php');
  require_once('core/CD_Controller.php');
  require_once('core/CD_Database.php');
  require_once('core/CD_Model.php');
  require_once('config/route.php');
?>
