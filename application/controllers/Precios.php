<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Precios extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->controller = 'Precios';//Siempre define las migagas de pan
        $this->load->library('grocery_CRUD');
    }


    public function historial()
    {
        $this->metodo = 'historial';//Siempre define las migagas de pan

        $this->load->js('assets/js/typeahead/typeahead.min.js');
        $this->load->js('assets/myjs/precios.js');


        $this->_init(true,false,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )

        $output = array( 'onSelected' => 'table(obj);' ); //cuando se seleccione el valor
        $get_productos = $this->load->view('get_data/productos', $output,true) ;

        $output = array('title' => 'Precios historial',
                        'get_productos' =>  $get_productos
                );
        $this->load->view('precios/historial', $output ) ;
    }
    
    public function table_historial($id){
        
        $this->load->model('producto');        
        $producto = $this->producto->get_lista_id($id);
        
        $data['data'] = $this->producto->get_precios_byProducto($id,$producto[0]->presentacion_minima,"10");
        $data['info'] = $producto;

        $this->load->view('precios/table_historial',$data);
    }
    
    public function save(){
        $this->load->model('unidad_medida'); 
        $this->unidad_medida->insert_byProducto();
 
        print true;
    }



}
