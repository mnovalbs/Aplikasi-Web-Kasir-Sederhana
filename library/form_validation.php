<?php
  defined('base_path') OR die('Akses langsung tidak dapat dilakukan');
  class Form_Validation {
    public $sukses;
    public $error_message;
    public $rules;

    public function __construct()
    {
      $this->error_message = array();
      $this->rules = array();
      $this->sukses = true;
    }

    public function set_rules($array = array())
    {
      $this->rules = $array;
    }

    public function cek_rules()
    {
      foreach ($this->rules as $item) {
        $rules = explode('|',$item['rules']);
        $input = $item['field'];

        $post_input = '';

        if(!empty($_POST[$input]))
        {
          $post_input = trim($_POST[$input]);
        }

        $label = $post_input;

        if(!empty($item['name']))
        {
          $label = $item['name'];
        }

        foreach ($rules as $rule) {
          if($rule == 'required')
          {
            if(empty($post_input))
            {
              $this->sukses = false;
              array_push($this->error_message, $label." wajib Terisi");
            }
          }
          else if (str_before('[', $rule) == 'max_length'){
            $max_length = str_between('[',']',$rule);
            if(strlen($post_input)>$max_length)
            {
              $this->sukses = false;
              array_push($this->error_message, $label." tidak boleh lebih dari ".$max_length." karakter.");
            }
          }
          else if($rule == 'numeric')
          {
            if(!is_numeric($post_input))
            {
              $this->sukses = false;
              array_push($this->error_message, $label." harus berupa angka");
            }
          }
          else if($rule == 'valid_email')
          {
            if(!filter_var($post_input,FILTER_VALIDATE_EMAIL))
            {
              $this->sukses = false;
              array_push($this->error_message, $label." bukan format email yang benar");
            }
          }
          else if($rule == 'alpha_dash_space')
          {
            if (! preg_match('/^[a-zA-Z\s]+$/', $post_input))
            {
              $this->sukses = false;
              array_push($this->error_message, $label." hanya dapat berisi huruf dan spasi");
            }
          }

        }
      }
    }

    public function run()
    {
      if(!empty($_POST)){
        $this->cek_rules();
        return $this->sukses;
      }else{
        return false;
      }
    }

    public function error_message($pembuka='',$penutup='')
    {
      $hasil = '';
      foreach ($this->error_message as $error_message) {
        $hasil .= $pembuka.$error_message.$penutup;
      }
      return $hasil;
    }

  }

  function str_after ($this, $inthat) //From http://php.net/manual/en/function.substr.php
  {
    return substr($inthat, strpos($inthat,$this)+strlen($this));
  };

  function str_before ($this, $inthat) //From http://php.net/manual/en/function.substr.php
  {
    return substr($inthat, 0, strpos($inthat, $this));
  }

  function str_between ($this, $that, $inthat) //From http://php.net/manual/en/function.substr.php
  {
    return str_before($that, str_after($this, $inthat));
  };
