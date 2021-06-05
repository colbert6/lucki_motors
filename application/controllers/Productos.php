<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productos extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->controller = 'Productos';//Siempre define las migagas de pan
        
    }


    public function lista()
    {
        
        $this->metodo = 'Lista';//Siempre define las migagas de pan

        $this->load->library('grocery_CRUD');
        $crud = new grocery_CRUD();

        $crud->set_table('producto');
        $crud->columns('codproducto', 'nombre','estado');

        /*$crud->display_as('marca_idmarca','Marca');*/
        $crud->display_as('area_idarea','Area');
        $crud->display_as('presentacion_minima','Unidad Medida');
        $crud->unset_fields('codproducto');


        $crud->set_subject('Producto');
        $crud->set_relation('presentacion_minima','presentacion','nombre');
        $crud->set_relation('area_idarea','area','nombre');        

        $crud->required_fields('codproducto','nombre','presentacion_minima');//'codbarras','marca_idmarca'

        //$crud->required_fields(array('codbarras','nombre'));
        $crud->unique_fields(array('codbarras', 'codproducto' ));

        $crud->field_type('precio_venta', 'integer');
        $crud->field_type('precio_unitario', 'integer');
        $crud->field_type('control_stock', 'integer');

        $crud->add_fields('codproducto','nombre','area_idarea','presentacion_minima','precio_venta','precio_unitario','control_stock');
        $crud->edit_fields('codproducto','nombre','area_idarea','presentacion_minima','precio_venta','precio_unitario','control_stock');
        $crud->fields('codproducto','nombre','area_idarea','presentacion_minima','precio_venta','precio_unitario','control_stock');


        $crud->order_by('nombre','desc');

        $crud->unset_add_fields('estado');
        
        $crud->unset_delete();
        $output = $crud->render();
        $output->title = 'Productos';

        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
    }
    
    
    public function json_lista_id($id=""){
        $this->load->model('producto');
        print json_encode($this->producto->get_lista_id($id));
    }

    public function json_lista_barras($id=""){
        $this->load->model('producto');
        print json_encode($this->producto->get_lista_barras($id));
    }

	

}
