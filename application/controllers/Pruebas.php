<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pruebas extends MY_Controller {

  function __construct()
  {
      parent::__construct();
      $this->controller = 'Almacenes';//Siempre define las migagas de pan
  }

  public function prueba()
  {
  	$this->load->library('envio_cpe');
  	$this->envio_cpe->enviar();
  }


}

