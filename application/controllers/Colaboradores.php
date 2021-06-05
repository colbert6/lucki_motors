<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Colaboradores extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->controller = 'Colaboradores';//Siempre define las migagas de pan
        $this->load->library('grocery_CRUD');
    }


    public function lista()
    {
        $this->metodo = 'Lista';//Siempre define las migagas de pan

        $crud = new grocery_CRUD();

        $crud->set_table('colaborador');
        $crud->columns('perfil','nombre','dni','fecha_nacimiento');
        $crud->set_relation('perfil','seg_perfil','nombre');  

        $crud->unique_fields(array('nombre','dni'));

        $crud->unset_delete();
        $output = $crud->render();
        $output->title = 'Colaborador';

        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
    }
    
    public function json_lista()
    {
        $this->load->model('colaborador');
        print json_encode($this->colaborador->get_lista());
    }


	

}
