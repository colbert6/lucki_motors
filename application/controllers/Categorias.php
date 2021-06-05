<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categorias extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->controller = 'Categoria';//Siempre define las migagas de pan
        $this->load->library('grocery_CRUD');
    }


    public function lista()
    {
        $this->metodo = 'Lista';//Siempre define las migagas de pan

        $crud = new grocery_CRUD();
        $crud->set_table('categoria');
        
        $crud->unset_delete();
        $crud->unique_fields(array('nombre'));
        $output = $crud->render();
        $output->title = 'Categoria';

        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
    }


	

}
