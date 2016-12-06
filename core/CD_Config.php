<?php
  defined('base_path') OR die('Akses langsung tidak dapat dilakukan');
  class CD_Config
  {

    public function item($item)
    {
      return $this->$item;
    }

    public function set_item($item_name, $item_value)
    {
      $this->$item_name = $item_value;
    }

  }
