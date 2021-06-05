<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Motivos_movimiento extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->controller = 'Motivos_movimiento';//Siempre define las migagas de pan
        $this->load->library('grocery_CRUD');
    }


    public function lista()
    {
        $this->metodo = 'Lista';//Siempre define las migagas de pan

        $crud = new grocery_CRUD();

        $crud->set_table('motivo_movimiento');

        $crud->columns('tipo','descripcion','estado');

        
        $crud->unset_delete();
        $output = $crud->render();
        $output->title = 'Areas';

        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
    }

     public function json_lista($id = "")
    {
        $this->load->model('proveedor');
        print json_encode($this->proveedor->get_lista($id));
    }

	

}
