<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Areas extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->controller = 'Areas';//Siempre define las migagas de pan
        $this->load->library('grocery_CRUD');
    }


    public function lista()
    {
        $this->metodo = 'Lista';//Siempre define las migagas de pan

        $crud = new grocery_CRUD();

        $crud->set_table('area');

        $crud->display_as('colaborador_idcolaborador','Colaborador');

        $crud->set_relation('colaborador_idcolaborador','colaborador','nombre');

        $crud->columns('nombre','colaborador_idcolaborador','estado');

        
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
