<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comprobantes extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->controller = 'Comprobantes';//Siempre define las migagas de pan
        $this->load->library('grocery_CRUD');
    }


    public function lista()
    {
        $this->metodo = 'Lista';//Siempre define las migagas de pan

        $crud = new grocery_CRUD();

        $crud->set_table('serie_comprobante');

        $crud->columns( 'tipo_comprobante_idtipocomprobante','serie','correlativo','estado');

        $crud->display_as('tipo_comprobante_idtipocomprobante','Tipo');

        $crud->set_subject('Serie');
        $crud->set_relation('tipo_comprobante_idtipocomprobante','tipo_comprobante','descripcion');

        $crud->unset_add();
        $crud->unset_clone();
        $crud->unset_delete();        

        $output = $crud->render();
        $output->title = 'Serie comprobante';
        //validación del tipo de comprbante de documento de cliente es ventas.js


        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
    }

	

}
