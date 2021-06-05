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
        $crud->columns('codbarras','marca_idmarca','categoria_idcategoria','nombre','estado');

        $crud->display_as('marca_idmarca','Marca');
        $crud->display_as('categoria_idcategoria','Categoria',null,'nombre ASC');
        $crud->unset_fields('codproducto');


        $crud->set_subject('Producto');
        $crud->set_relation('marca_idmarca','marca','nombre');
        $crud->set_relation('categoria_idcategoria','categoria','nombre');   
        $crud->set_relation('presentacion_minima','presentacion','nombre'); 
        //$crud->set_relation('codproducto','categorias_sunat','descripcion');        

        $crud->required_fields('nombre','categoria_idcategoria','presentacion_minima');//'codbarras','marca_idmarca'

        //$crud->required_fields(array('codbarras','nombre'));
        $crud->unique_fields(array('codbarras'));

        $crud->set_field_upload('foto','assets/uploads/productos');

        $crud->order_by('marca_idmarca','desc');

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
