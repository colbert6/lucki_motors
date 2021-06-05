<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->controller = 'Principal';//Siempre define las migagas de pan
    }


    public function index()
    {

        $this->metodo = '';//Siempre define las migagas de pan

        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $output = array('title' => 'Principal' ); 
        $output['texto'] =  "";

        $this->load->view('principal/index', $output ) ;
    }



	

}
