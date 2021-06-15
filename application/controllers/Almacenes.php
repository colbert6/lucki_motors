<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Almacenes extends MY_Controller {

  function __construct()
  {
      parent::__construct();
      $this->controller = 'Almacenes';//Siempre define las migagas de pan
  }

  public function stock( $idtienda = 1 )
  {   

      // CARGANDO MODELO DE ALMACENES
        
        $this->load->model('almacen');        
        $this->metodo = 'Stock';//Siempre define las migagas de pan
        $this->_init(true,false,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        
        // ACCEDIENDO A LOS MODELOS           
        $this->load->library('grocery_CRUD');
        $this->load->js('assets/js/bootbox.min.js');
        $this->load->js('assets/myjs/groceryCRUD.js');


        $crud = new grocery_CRUD();

        //$crud->columns('codproducto','producto','presentacion', 'precio_venta','stock');
        $crud->set_table('producto_stock'); //Change to your table name
        $crud->set_primary_key('idproducto');

        $crud->order_by('producto','asc');

        // $crud->unset_operations();
        $crud->unset_add();
        $crud->unset_delete();
        $crud->unset_edit();
        $crud->unset_read();
        $output = $crud->render();

        $state = $crud->getState();
        $state_info = $crud->getStateInfo();
        if($state == 'ajax_list' )
        {
            $this->load->js('assets/myjs/groceryCRUD.js');
        }elseif($state == 'ajax_list_info')
        {
            $this->load->js('assets/myjs/groceryCRUD.js');
        }

        $tiendas = $this->almacen->get_tienda();

        $output->title = 'Stock :: ';
        $output->tiendas = $tiendas;
        $output->idtienda = $idtienda;

        
        // CARGANDO TEMPLATE DEL SISTEMA    
        $this->load->view('almacenes/stock', $output ) ;
    }    
    
    public function lista_productos_cf()
    {
       $tienda = $this->input->get("t");
       $categoria = $this->input->get("c");
       $marca = $this->input->get("m");
       $this->load->model('almacen');
       $data["data"] = $this->almacen->get_productos_cfilter($tienda,$categoria,$marca);
       $this->load->view('almacenes/tabla.view.php',$data) ;
    }

    public function ver_imagen_producto()
    {
      $this->load->model('producto');  
      $idproducto = $this->input->get('idproducto');
      print json_encode($this->producto->get_imagen_producto($idproducto));
    }


}
