<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orden_compras extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->controller = 'Orden de Compras';//Siempre define las migagas de pan
    }


    public function lista()
    {

        $this->metodo = 'Lista';//Siempre define las migagas de pan

        $this->load->library('grocery_CRUD');
        $crud = new grocery_CRUD();

        $crud->set_table('orden_compra');
        $crud->columns('fecha_creacion','proveedor_idproveedor','nrocomprobante','total','estado');

        $crud->display_as('proveedor_idproveedor','Proveedor');
        $crud->display_as('nrocomprobante','Comprobante');

        $crud->set_subject('Orden de Compra');
        $crud->set_relation('proveedor_idproveedor','proveedor','razon_social');


        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_clone();
        $crud->unset_delete();

        $crud->order_by('fecha_creacion','desc');
        $crud->add_action('Detalle', '', base_url('orden_compras/detalle/'),'fa fa-tasks');
        
        $output = $crud->render();
        $output->title = "Orden de Compra :: <a href='".base_url('orden_compras/add')."'> Crear nueva Orden</a>";

        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
    }


    public function add()
    {

        $this->metodo = 'Nueva Orden de Compra';//Siempre define las migagas de pan
        
        // CARGANDO LIBRERIA DE SELECT2
        $this->load->js('assets/js/select2/js/select2.full.min.js');
        $this->load->css('assets/js/select2/css/select2.css');
        
        
         $this->load->js('assets/js/shortcut.js');
         $this->load->js('assets/js/bootbox.min.js');
        
        $this->load->js('assets/myjs/orden_compra.js');
        
        $this->_init(true,false,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        
        
        $this->load->model('almacen');
        $this->load->model('comprobante');
        
        $output = array(
            'title' => 'Compra',
            'tiendas' => $this->almacen->get_tienda(),
            'tipo_comprobantes' => $this->comprobante->get_tipo_comprobantes()
        ); 
        
        
        $this->load->view('orden_compras/add', $output ) ;
    }
    
    public function save(){
        
        //Guardar Compra
        $this->load->model('orden_compra');        
        $this->orden_compra->insert_compra();
        $idcompra = $this->db->insert_id();
        
        //Guardar Detalle Venta
        $this->load->model('det_orden_compra');   
        $this->det_orden_compra->compra_idcompra = $idcompra;     
        $this->det_orden_compra->insert_det_compra();

        print true;
    }
    
    public function detalle($id)
    {

        $this->metodo = 'Detalle Compra';//Siempre define las migagas de pan
 
        $this->_init(true,false,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )

        $this->load->model('orden_compra');
        $this->load->model('det_orden_compra');
        
        $output = array(
            'title' => 'Detalle de Orden de Compra',
            'compra' =>$this->orden_compra->compra_byId($id),
            'det_compra' => $this->det_orden_compra->det_compras_bycompra($id)
        ); 
        
        
        $this->load->view('orden_compras/detalle', $output ) ;
    }
    
    //--PEDIDOS AJAX
    public function ajax_orden(){
        $this->load->model('orden_compra');
        $ordCmp = $this->orden_compra->get_id();
        
        if(count($ordCmp)>0){
            $id = $ordCmp[0]->idcompra;
            $oc = $this->orden_compra->compra_byId($id);
        }else{
            $oc = 0;
        }
        print json_encode($oc);
    }
    public function ajax_detorden(){
        $this->load->model('orden_compra');
        $this->load->model('det_orden_compra');
        $ordCmp = $this->orden_compra->get_id();
        if(count($ordCmp)>0){
            $id = $ordCmp[0]->idcompra;
            $oc = $this->det_orden_compra->det_compras_bycompra($id);
        }else{
            $oc = 0;
        }
       
        print json_encode($oc);
    }
    public function lista_productos()
    {
        $this->load->model('producto');
        print json_encode($this->producto->get_lista());
    }
    
    public function correlativo()
    {
        $this->load->model('orden_compra');
        print json_encode($this->orden_compra->get_correlativo());
    }
    
    // ORDEN DE COMPRA
    public function autogenearate_ordencompra(){
        //Guardar Compra
        $this->load->model('orden_compra');        
        $this->orden_compra->autogenerate();
        $idcompra = $this->db->insert_id();
        print json_encode($idcompra);
    }
    
    public function updateOrdenCompra(){
        //Guardar Compra
        $this->load->model('orden_compra');        
        $this->orden_compra->updateOrden();
        
        print true;
    }
    public function isUpdated(){
        $this->load->model('orden_compra');        
        $this->orden_compra->deleteOrden();
        print true;
    }
    // DETALLE ORDEN DE COMPRA
    
    public function autogenearate_det_ordencompra(){
        $this->load->model('det_orden_compra');        
        $this->det_orden_compra->autogenerate();
        $iddet_ordencompra = $this->db->insert_id();
        print json_encode($iddet_ordencompra);
    }
    
    public function updateDetOrdenCompra(){
        //Guardar Compra
        $this->load->model('det_orden_compra');        
        $this->det_orden_compra->updateDetOrden();
        
        print true;
    }
    public function deleteDetOrdenCompra(){
        //Guardar Compra
        $this->load->model('det_orden_compra');        
        $this->det_orden_compra->deleteDetOrden();
        
        print true;
    }
    
}
