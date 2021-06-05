<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Compras extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->controller = 'Compras';//Siempre define las migagas de pan
    }


    public function lista()
    {

        $this->metodo = 'Lista';//Siempre define las migagas de pan

        $this->load->library('grocery_CRUD');
        $this->load->js('assets/myjs/groceryCRUD.js');
        $crud = new grocery_CRUD();

        $crud->set_table('compra');
        $crud->columns('fecha_creacion','colaborador_registro','proveedor_idproveedor', 'tipo_comprobante_idtipo_comprobante', 'nrocomprobante','total','estado');

        $crud->display_as('colaborador_registro','Registrado');
        $crud->display_as('proveedor_idproveedor','Proveedor');
        $crud->display_as('nrocomprobante','Nro Comprobante');
        $crud->display_as('tipo_comprobante_idtipo_comprobante','Tipo Comp.');

        $crud->set_subject('Compra');
        $crud->set_relation('proveedor_idproveedor','proveedor','razon_social');
        $crud->set_relation('colaborador_recepcion','colaborador','nombre');
        $crud->set_relation('colaborador_registro','colaborador','nombre');
        $crud->set_relation('tipo_comprobante_idtipo_comprobante','tipo_comprobante','descripcion');

        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_clone();
        $crud->unset_delete();

        $crud->order_by('fecha_creacion','desc');
        $crud->add_action('Detalle', '', base_url('compras/detalle/'),'fa fa-tasks');
        $crud->add_action('Imprimir', '', base_url('compras/print_compra?idcompra='),'fa fa-print imprimir');
        
        $output = $crud->render();
        $output->title = "Compras :: <a href='".base_url('compras/add')."'> Crear nueva Compra</a>";

        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
    }


    public function add()
    {

        $this->metodo = 'Nueva Compra';//Siempre define las migagas de pan
        
        // CARGANDO LIBRERIA DE SELECT2
        $this->load->js('assets/js/select2/js/select2.full.min.js');
        $this->load->css('assets/js/select2/css/select2.css');
        
        
         $this->load->js('assets/js/shortcut.js');
         $this->load->js('assets/js/bootbox.min.js');
        
        $this->load->js('assets/myjs/compras.js');
        
        $this->_init(true,false,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        
        
        $this->load->model('almacen');
        $this->load->model('comprobante');
        $this->load->model('orden_compra');

         $this->load->model('get_data');
        
        $output = array(
            'title' => 'Compra',
            'tiendas' => $this->almacen->get_tienda(),
            'tipo_comprobantes' => $this->comprobante->get_tipo_comprobantes(array( $this->id_factura,$this->id_boleta))
        ); 
        
        
        
        $this->load->view('compras/add', $output ) ;
    }
    
    public function save(){
        
        //Guardar Compra
        $this->load->model('compra');        
        $this->compra->insert_compra();
        $idcompra = $this->db->insert_id();
        
        //Guardar Detalle Venta
        $this->load->model('det_compra');   
        $this->det_compra->compra_idcompra = $idcompra;     
        $this->det_compra->insert_det_compra();
        
        //Modificar Stock
        $this->load->model('stock');       
        $this->stock->modificar_stock("+");
        
        //Agregar Kardex
        $this->load->model('kardex');      
        $this->kardex->codmotivo = $idcompra;
        $this->kardex->insert_kardex("E","compra");
        
        // AGREGAR Unidad Medida
        $this->load->model('unidad_medida'); 
        $this->unidad_medida->insert_unidadmedida();
        
        // Actualizar Orden de Compra
        $this->load->model('orden_compra');        
        $this->orden_compra->finishOrden();
        
        print true;
    }
    
    public function detalle($id)
    {

        $this->metodo = 'Detalle Compra';//Siempre define las migagas de pan
 
        $this->_init(true,false,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )

        $this->load->model('compra');
        $this->load->model('det_compra');
        
        $output = array(
            'title' => 'Detalle de Compra',
            'compra' =>$this->compra->compra_byId($id),
            'det_compra' => $this->det_compra->det_compras_bycompra($id)
        ); 
        
        
        $this->load->view('compras/detalle', $output ) ;
    }
    
    //--PEDIDOS AJAX
    public function lista_productos()
    {
        $this->load->model('producto');
        print json_encode($this->producto->get_lista());
    }
    
    public function print_compra()
    {   
        $this->load->model('compra');
        $this->load->model('det_compra');
        
        $compra = $this->compra->compra_byId_print($this->input->get('idcompra'));
        $det_compra = $this->det_compra->det_compras_bycompra_print($this->input->get('idcompra'));

        $orientation = 'P' ;
        $format = 'A4';
        if(isset($_GET['orientation'])){
            $orientation = $this->input->get('orientation');

        }
        if(isset($_GET['format'])){
            $format = $this->input->get('format');
        }

        //echo "<pre>";print_r($compra);exit();

        $nombrepdf  = 'Compra';
        $this->load->library('Pdf_comprobantes');
        $pdf = new Pdf_comprobantes($orientation, 'mm', $format , true, 'UTF-8', false);

        $pdf->motivo = 'compra';
        $pdf->tipo_documento = $compra['tipo_comprobante'];
        $pdf->nro_documento = $compra['nrocomprobante'];       

        //Parametros del PDF
        $pdf->SetTitle($nombrepdf);
        
        $pdf->SetAutoPageBreak(TRUE, 10);
        $pdf->AddPage();

        $pdf->set_formato('basico');

        $data_usuario_receptor = array('Proveedor' => array($compra['razon_social'],'4'),
                                  'RUC/DNI' => array($compra['ruc'],'1'),
                                  'Dirección' => array($compra['direccion'],'5')  );
        $pdf->receptor_data( 5 ,$data_usuario_receptor);

        $data_comprobante = array('Creado' => array($compra['fecha_creacion'],'1'),
                                  'Tienda' => array($compra['tienda'],'1'),  
                                  'F. Emisión' => array($compra['fecha_compra'],'1'),
                                  'F. Recepción' => array($compra['fecha_recepcion'],'1'),
                                  'Tipo' => array($compra['tipo_comprobante'],'1'),
                                  'Nro' => array($compra['nrocomprobante'],'1'),  
                                  'Registro ' => array($compra['usu_registro'],'1'),
                                  'Recepción ' => array($compra['usu_recepcion'],'1'),
                                  
                                  'Observación' => array($compra['observacion'],'4')  );
        $pdf->comprobante_data( 4 ,$data_comprobante);

        $width_cols = array( array('Descripcion',40 ,'L') , array('Cant.',20, 'R'),array('P.unit',20,'R'),array('Subtotal',20,'R') );
        $pdf->data_table( $det_compra ,  $width_cols, true);

/*        $data_footer = array( 'monto_letra' => array('width'=>150) );

        $data_footer = array('monto_letra' => array( 'texto'=> 'mil lucas'),
                            'monto' => array('op_importe'=>$venta['Total'])   );

        $pdf->data_table_footer( 'monto_venta', $data_footer );*/
        
        $pdf->Output($nombrepdf, 'I');
    }
    
  
	
}
