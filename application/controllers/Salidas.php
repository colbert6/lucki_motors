    <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salidas extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->controller = 'Salidas';//Siempre define las migagas de pan
    }


    public function lista()
    {

        $this->metodo = 'Lista';//Siempre define las migagas de pan
        

        $this->load->library('grocery_CRUD');
        $this->load->js('assets/js/bootbox.min.js');
        $this->load->js('assets/myjs/groceryCRUD.js');
        $crud = new grocery_CRUD();

        $crud->set_table('salida');
        // $crud->columns( 'fecha_emision', 'colaborador_registro','tipo_comprobante_idtipo_comprobante','nrocomprobante','motivo_movimiento_idmotivo','nombre_recepciona');
         $crud->columns( 'fecha_emision', 'colaborador_registro','tipo_comprobante_idtipo_comprobante','nrocomprobante','motivo_movimiento_idmotivo','nombre_recepciona');

        //$crud->display_as('fecha_creacion','Fecha');
        $crud->display_as('tipo_comprobante_idtipo_comprobante','Tipo Comp.');
        $crud->display_as('motivo_movimiento_idmotivo','Motivo');

        $crud->set_subject('Salida');
        $crud->set_relation('tipo_comprobante_idtipo_comprobante','tipo_comprobante','descripcion');
        $crud->set_relation('motivo_movimiento_idmotivo','motivo_movimiento','descripcion');
        $crud->set_relation('colaborador_registro','colaborador','nombre');

        
        
        // $crud->field_type('fecha_emision', 'datetime');               
        //acciones js revisar groceryCRUD.js
        // $crud->add_action('Anular venta', '', base_url('ventas/anular?idventa='),'fa fa-close anular');
         $crud->add_action('Imprimir', '', base_url('salidas/print_detalle?idsalida='),'fa fa-print imprimir');
        // $crud->add_action('Guia', '', base_url('ventas/print_guia?idventa='),'fa fa-bus guia');

        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_clone();
        $crud->unset_delete();

        $crud->order_by('fecha_emision','desc');

        $output = $crud->render();

        $output->title = "Salida :: <a href='".base_url('salidas/add')."'> crear nueva salida</a>";
       
        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
        
    }

    public function add()
    {

        
        $this->metodo = 'Nueva salida';//Siempre define las migagas de pan

        $this->_init(true,false,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )

        $this->load->js('assets/myjs/genericos/calculos_movimientos.js');//genericos
        $this->load->js('assets/myjs/genericos/set_data.js');//genericos

        $this->load->js('assets/myjs/salidas.js');
        $this->load->js('assets/js/bootbox.min.js');

        $this->load->js('assets/js/shortcut.js');//activación de teclas 
        $this->load->js('assets/js/typeahead/typeahead.min.js');

        //Cargando modelos
        $this->load->model('almacen');
        $this->load->model('get_data');

        $output = array(); 
        $get_proveedores = $this->load->view('get_data/proveedores', $output,true) ;

        $output = array( 'onSelected' => 'set_info_producto(obj);', 'areas' => $this->get_data->get_areas() ); 
        $get_productos = $this->load->view('get_data/productos_salidas', $output,true) ;

        $output = array(
            'comprobantes' => $this->get_data->get_tipocomprobantes(array( $this->id_factura,$this->id_boleta) ),
            'title' => 'Ingreso',
            'get_proveedores' =>  $get_proveedores,
            'get_productos' =>  $get_productos ,
            'colaboradores' =>  $this->get_data->get_colaboradores() ,
            'motivo_movimiento' =>  $this->get_data->get_motivo_movimiento('%','salida' ) 
        ); 

        $this->load->view('salidas/add', $output ) ;
    }

    public function save()
    {   


        $return = array( 'estado_validacion' => true , 'estado' => false, 'msj' => '' , 'error'=> '' , 'idsave' => '' , 'enlace' => '');  

        //Guardar movimiento
        $this->db->trans_start();//Inicio de transaccion
        
        //Guardar ingreso
        $this->load->model('salida');        
        $this->salida->insert_salida();
        $idsalida = $this->db->insert_id();

        //Guardar Detalle Venta
        $this->load->model('det_salida');   
        $this->det_salida->salida_idsalida = $idsalida; 
        $this->det_salida->insert_det_salida();
    
        //Modificar Stock
        $this->load->model('stock');       
        $this->stock->modificar_stock_movimiento("-");

        //Agregar Kardex
        // $this->load->model('kardex');      
        // $this->kardex->codmotivo = $idsalida;
        // $this->kardex->insert_kardex("S","ingreso");
        
        $return['idsave'] = $idsalida;
       
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

    public function print_detalle()
    {   
        $this->load->model('salida');
        $this->load->model('det_salida');

        $orientation = 'P' ;
        $format = 'A4';
        if(isset($_GET['orientation'])){
            $orientation = $this->input->get('orientation');

        }
        if(isset($_GET['format'])){
            $format = $this->input->get('format');
        }

        $movimiento = $this->salida->get_print($this->input->get('idsalida'));
        $det_movimiento = $this->det_salida->get_print_det_movimiento($this->input->get('idsalida'));

        if( count($movimiento) == 0 OR count($det_movimiento) == 0 ){ die('NO SE ENCONTRARON RESULTADOS'); exit();};
        
        $nombrepdf  = 'Salida_'.$this->input->get('idsalida');
        
        $this->load->library('Pdf_comprobantes');
        $pdf = new Pdf_comprobantes($orientation, 'mm', $format , true, 'UTF-8', false);
       
        $pdf->tipo_documento = 'SALIDA';
        $pdf->nro_documento = $this->input->get('idsalida');       

        //Parametros del PDF
        $pdf->SetTitle($nombrepdf);
        
        $pdf->SetAutoPageBreak(TRUE, 10);
        $pdf->AddPage();


        $data_comprobante = array('Registro fecha' => array($movimiento['Fecha_registro'],'1'),
                                  'Registro usuario' => array($movimiento['Usuario_registra'],'1'),  
                                  'Comprobante' => array($movimiento['Comprobante'],'1'),

                                  'Fecha' => array($movimiento['Fecha_emision'],'1'),
                                  'Quien LLeva ' => array($movimiento['Quien_lleva'],'2'), 

                                  'Serie' => array($movimiento['Serie'],'1'),
                                  'Motor ' => array($movimiento['Motor'],'1'),  
                                  'Color' => array($movimiento['Color'],'1'),
                                  'Observacion' => array($movimiento['Observacion'],'3')  );

        $pdf->comprobante_data_b( 3 ,$data_comprobante);


        $width_cols = array(  array('Codigo',20 ,'L') ,  
                            array('Producto',30 ,'L') , 
                            array('Area',20, 'R'),
                            array('Cant.',10, 'R'),
                            array('P.compra',10, 'R'),
                            array('Medida',10,'R')
                        );

        $pdf->data_table( $det_movimiento ,  $width_cols, true , 'general');
        // public function data_table( $data, $head_cols, $flag_nro_item = false, $formato = 'basico'  ) {//suma de $widthcols 
       
        $data_footer = array('monto_letra' => array('mil lucas'),
                            'monto' => array('op_importe'=>$movimiento['Total'])   );
        $pdf->data_table_footer( 'monto_general',  $data_footer , 'msj');
        ob_end_clean();
        $pdf->Output($nombrepdf, 'I');
    }


}  