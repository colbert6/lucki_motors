<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kardex extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->controller = 'Kardex';//Siempre define las migagas de pan
        
    }


    public function lista()
    {
        $this->metodo = 'Lista';//Siempre define las migagas de pan

        $this->load->library('grocery_CRUD');
        $crud = new grocery_CRUD();
        $crud->set_table('kardex')
            ->columns('fecha_hora','tipo_movimiento','motivo','descripcion','cantidad','precioxpresentacion','stock_actual');

        $crud->display_as('tipo_movimiento','Tipo');
        $crud->display_as('precioxpresentacion','Precio');

        $crud->unset_add();
        $crud->unset_read();
        $crud->unset_edit();
        $crud->unset_clone();
        $crud->unset_delete();

        $crud->order_by('fecha_hora','DESC');       

        $output = $crud->render();
        $output->title = 'Kardex';

        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
    }

 
	

}
