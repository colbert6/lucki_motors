<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Creditos extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->controller = 'Reporte creditos';//Siempre define las migagas de pan
    }

    

    public function index()
    {

        // CARGANDO MODELO DE ALMACENES           
        $this->metodo = 'Creditos';//Siempre define las migagas de pan
        $this->_init(true,false,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        
        // ACCEDIENDO A LOS MODELOS           
        $this->load->library('grocery_CRUD');

        $crud = new grocery_CRUD();

        //$crud->columns('codproducto','producto','presentacion', 'precio_venta','stock');
        $crud->set_table('creditos'); //Change to your table name
        $crud->set_primary_key('idingreso');

        $crud->order_by('idingreso','asc');

        // $crud->unset_operations();
        $crud->unset_add();
        $crud->unset_delete();
        $crud->unset_edit();
        $crud->unset_read();
        $output = $crud->render();

        $output->title = 'Creditos :: ';
        
        // CARGANDO TEMPLATE DEL SISTEMA    
        $this->load->view('grocery_crud/basic_crud', $output ) ;
    } 


	

}
