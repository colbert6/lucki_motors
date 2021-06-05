    <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ingresos extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->controller = 'Ingresos';//Siempre define las migagas de pan
    }


    public function lista()
    {

        $this->metodo = 'Lista';//Siempre define las migagas de pan
        

        $this->load->library('grocery_CRUD');
        $this->load->js('assets/js/bootbox.min.js');
        $this->load->js('assets/myjs/groceryCRUD.js');
        $crud = new grocery_CRUD();

        $crud->set_table('ingreso');
        $crud->columns( 'proveedor_idproveedor','fecha_compra', 'fecha_recepcion','tipo_comprobante_idtipo_comprobante', 'nrocomprobante', 'total', 'estado_pago');

        //$crud->display_as('fecha_creacion','Fecha');
        $crud->display_as('proveedor_idproveedor','Proveedor');
        $crud->display_as('tipo_comprobante_idtipo_comprobante','Tipo Comp.');
        $crud->display_as('periodo_pago','Periodo pago');
        $crud->display_as('estado_pago','Pago');

        $crud->set_subject('Ingreso');
        $crud->set_relation('proveedor_idproveedor','proveedor','razon_social');
        $crud->set_relation('tipo_comprobante_idtipo_comprobante','tipo_comprobante','descripcion');

        $crud->set_relation('colaborador_recepcion','colaborador','nombre');
        $crud->set_relation('colaborador_registro','colaborador','nombre');
        $crud->set_relation('idperiodo_pago','periodo_pago','descripcion');
        
        $crud->field_type('fecha_creacion', 'datetime');
        
        
        //acciones js revisar groceryCRUD.js
        // $crud->add_action('Anular venta', '', base_url('ventas/anular?idventa='),'fa fa-close anular');
        $crud->add_action('Imprimir', '', base_url('ingresos/print_detalle?idingreso='),'fa fa-print imprimir');       
        $crud->add_action('Imprimir', '', base_url('ingresos/editar_precio?idingreso='),'fa fa-money guia');
        // $crud->add_action('Guia', '', base_url('ventas/print_guia?idventa='),'fa fa-bus guia');

        $crud->unset_add();
        // $crud->unset_edit();
        $crud->unset_clone();
        $crud->unset_delete();

        $crud->edit_fields('estado_pago','fecha_pago');


        $crud->order_by('fecha_creacion','desc');

        $output = $crud->render();

        $output->title = "Ingreso :: <a href='".base_url('ingresos/add')."'> crear nuevo ingreso</a>";

        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
        
    }

    public function add()
    {

        
        $this->metodo = 'Nuevo ingreso';//Siempre define las migagas de pan

        $this->_init(true,false,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )

        $this->load->js('assets/myjs/genericos/calculos_movimientos.js');//genericos
        $this->load->js('assets/myjs/genericos/set_data.js');//genericos

        $this->load->js('assets/myjs/ingresos.js');
        $this->load->js('assets/js/bootbox.min.js');

        $this->load->js('assets/js/shortcut.js');//activación de teclas 
        $this->load->js('assets/js/typeahead/typeahead.min.js');

        //Cargando modelos
        $this->load->model('almacen');
        $this->load->model('get_data');

        $output = array(); 
        $get_proveedores = $this->load->view('get_data/proveedores', $output,true) ;

        $output = array( 'onSelected' => 'set_info_producto(obj);', 'areas' => $this->get_data->get_areas() ); 
        $get_productos = $this->load->view('get_data/productos_v2', $output,true) ;

        $output = array(
            'comprobantes' => $this->get_data->get_tipocomprobantes(array( $this->id_factura,$this->id_boleta) ),
            'title' => 'Ingreso',
            'get_proveedores' =>  $get_proveedores,
            'get_productos' =>  $get_productos ,
            'colaboradores' =>  $this->get_data->get_colaboradores() 
        ); 

        $this->load->view('ingresos/add', $output ) ;
    }

    public function editar_precio()
    {

        
        $this->metodo = 'Editar precios ingreso';//Siempre define las migagas de pan

        $this->_init(true,false,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )

        $this->load->js('assets/myjs/genericos/calculos_movimientos.js');//genericos
        $this->load->js('assets/myjs/genericos/set_data.js');//genericos

        $this->load->js('assets/myjs/ingresos.js');
        $this->load->js('assets/js/bootbox.min.js');

        $this->load->js('assets/js/shortcut.js');//activación de teclas 

        $this->load->model('get_data');
        $this->load->model('det_ingreso');
        $this->load->model('ingreso');

        $det_movimiento = $this->det_ingreso->get_detalle_ingreso($this->input->get('idingreso'));
        $movimiento = $this->ingreso->get_ingreso($this->input->get('idingreso'));

        $output = array(); 


        $output = array(
            'title' => 'Ingreso',
            'det_movimiento' => $det_movimiento,
            'ingreso' => $movimiento

        ); 

        $this->load->view('ingresos/edit_precio', $output ) ;
    }
    

    public function save()
    {   


        $return = array( 'estado_validacion' => true , 'estado' => false, 'msj' => '' , 'error'=> '' , 'idsave' => '' , 'enlace' => '');  


        //Guardar movimiento
        $this->db->trans_start();//Inicio de transaccion
        
        //Guardar ingreso
        $this->load->model('ingreso');        
        $this->ingreso->insert_ingreso();
        $idingreso = $this->db->insert_id();

        //Guardar Detalle Venta
        $this->load->model('det_ingreso');   
        $this->det_ingreso->ingreso_idingreso = $idingreso; 
        $this->det_ingreso->insert_det_ingreso();
    
        //Modificar Stock
        $this->load->model('stock');       
        $this->stock->modificar_stock_movimiento("+");

        //Agregar Kardex
        // $this->load->model('kardex');      
        // $this->kardex->codmotivo = $idingreso;
        // $this->kardex->insert_kardex_movimiento("E","ingreso");
        
        $return['idsave'] = $idingreso;
       
        if ($this->db->trans_status() === FALSE) { 

            $error = $this->db->error();
            $return['msj']= $error['message'];
            $return['error']= $error['message'];           
            $this->db->trans_rollback(); 

        } else {

            $this->db->trans_commit();//$this->db->trans_rollback(); 
            $return['estado']=true;


            /*$return['enlace'] = '-';
            $respuesta_pse = $this->envio_pse($idventa,'generar_comprobante');

            if( isset($respuesta_pse['enlace'])  ){
              $return['enlace'] = $respuesta_pse['enlace'];  
            }*/

        }

       

        print json_encode($return);
    }

    public function save_edit()
    {   


        $return = array( 'estado_validacion' => true , 'estado' => false, 'msj' => '' , 'error'=> '' , 'idsave' => '' , 'enlace' => '');  


        //Guardar movimiento
        $this->db->trans_start();//Inicio de transaccion
        
        //Guardar ingreso
        $this->load->model('ingreso');        
        $this->ingreso->edit_ingreso($this->input->post('idingreso'));
        $idingreso = $this->input->post('idingreso');

        //Guardar Detalle Venta
        $this->load->model('det_ingreso');   
        $this->det_ingreso->ingreso_idingreso = $idingreso; 
        $this->det_ingreso->edit_det_ingreso();
    
        
        $return['idsave'] = $idingreso;
       
        if ($this->db->trans_status() === FALSE) { 

            $error = $this->db->error();
            $return['msj']= $error['message'];
            $return['error']= $error['message'];           
            $this->db->trans_rollback(); 

        } else {

            $this->db->trans_commit();//$this->db->trans_rollback(); 
            $return['estado']=true;


            /*$return['enlace'] = '-';
            $respuesta_pse = $this->envio_pse($idventa,'generar_comprobante');

            if( isset($respuesta_pse['enlace'])  ){
              $return['enlace'] = $respuesta_pse['enlace'];  
            }*/

        }

       

        print json_encode($return);
    }

    public function anular()
    {   


        $return = array('estado' => false, 'msj' => '' , 'error'=> '' , 'idsave' => '' , 'enlace' => '');        



        $idventa = $this->input->get('idventa');

        $this->load->model('venta');  
        $venta = $this->venta->venta_byId($idventa);

        
        if($venta['estado'] == 'vigente'){


            //Modificar Stock
            $this->load->model('stock');       
            $this->stock->devolver_stock('venta anulada',$idventa);

            //Agregar Kardex
            $this->load->model('kardex');      
            $this->kardex->insert_devolucion_kardex('venta',$idventa);

            //Anular Venta
            $this->venta->anular_venta($idventa);
            
            //anular detalle ventas
            $this->load->model('det_venta');    
            $this->det_venta->anular_det_venta($idventa);

            /*if($venta['idtipo_comprobante'] == $this->id_factura || $venta['idtipo_comprobante'] == $this->id_boleta ){
                $this->envio_pse($idventa,"generar_anulacion");
            }*/

            //envio cpe
            $return['estado'] = true;
            $return['msj'] = 'Venta anulada'; 

        }else{

            $return['msj']= 'ERROR: no se pudo anular la venta';      
        } 

        print json_encode($return);
        
    }

    //--PEDIDOS AJAX
     
    public function print_detalle()
    {   
        $this->load->model('ingreso');
        $this->load->model('det_ingreso');

        $orientation = 'P' ;
        $format = 'A4';
        if(isset($_GET['orientation'])){
            $orientation = $this->input->get('orientation');

        }
        if(isset($_GET['format'])){
            $format = $this->input->get('format');
        }

        $movimiento = $this->ingreso->get_print($this->input->get('idingreso'));
        $det_movimiento = $this->det_ingreso->get_print_det_movimiento($this->input->get('idingreso'));

        if( count($movimiento) == 0 OR count($det_movimiento) == 0 ){ die('NO SE ENCONTRARON RESULTADOS'); exit();};
        
        $nombrepdf  = 'INGRESO'.$this->input->get('idingreso');
        
        $this->load->library('Pdf_comprobantes');
        $pdf = new Pdf_comprobantes($orientation, 'mm', $format , true, 'UTF-8', false);
       
        $pdf->tipo_documento = 'INGRESO';
        $pdf->nro_documento = $this->input->get('idingreso');       

        //Parametros del PDF
        $pdf->SetTitle($nombrepdf);
        
        $pdf->SetAutoPageBreak(TRUE, 10);
        $pdf->AddPage();


        $data_comprobante = array('Registro' => array($movimiento['Fecha_compra'],'1'),            
                                  'Usuario ' => array($movimiento['Usuario_registra'],'1'),
                                  'Recepción' => array($movimiento['Fecha_recepción'],'1'),
                                  'Usuario' => array($movimiento['Usuario_recepciona'],'1'),

                                  'Proveedor' => array($movimiento['proveedor'],'3'),  

                                  'Fecha creacion' => array($movimiento['fecha_creacion'],'1')

                                    );

        $pdf->comprobante_data_b( 4 ,$data_comprobante);


        $width_cols = array(  array('Codigo',8 ,'L') ,  
                            array('Producto',24 ,'L') ,                             
                            array('Med.',8,'R'),                            
                            array('Cant.',5, 'R'),
                            array('Precio',10, 'R'),
                            array('Sub.',10, 'R'),
                            array('Igv',10, 'R'),
                            array('Desc',10, 'R'),
                            array('Area',15, 'R')
                        );

        $pdf->data_table( $det_movimiento ,  $width_cols, true );
        // public function data_table( $data, $head_cols, $flag_nro_item = false, $formato = 'basico'  ) {//suma de $widthcols 
       
        $data_footer = array('monto_letra' => array('mil lucas'),
                            'monto' => array('op_importe'=>$movimiento['Total'])   );
        $pdf->data_table_footer( 'monto_general',  $data_footer , 'msj');
        ob_end_clean();
        $pdf->Output($nombrepdf, 'I');
    }

	

}
