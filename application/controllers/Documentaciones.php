<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documentaciones extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->controller = 'Documentacion';//Siempre define las migagas de pan
        $this->load->library('grocery_CRUD');
    }

    public function lista()
    {

        $this->metodo = 'Lista';//Siempre define las migagas de pan
        
        $this->load->library('grocery_CRUD');
        $this->load->js('assets/js/bootbox.min.js');
        $this->load->js('assets/myjs/groceryCRUD.js');
        $crud = new grocery_CRUD();

        $crud->set_table('documentacion');
        $crud->columns('fecha_creacion','cliente_razon_social', 'tipo_comprobante_idtipo_comprobante',  'nro_documento','estado');

        //$crud->display_as('fecha_creacion','Fecha');
        $crud->display_as('cliente_razon_social','Cliente');
        $crud->display_as('tipo_comprobante_idtipo_comprobante','Tipo Comp.');
        $crud->display_as('serie_comprobante_idserie_comprobante','Serie');

        $crud->set_subject('Documentacion');
        $crud->set_relation('tienda_idtienda','tienda','descripcion');
        $crud->set_relation('tipo_comprobante_idtipo_comprobante','tipo_comprobante','descripcion');
        $crud->set_relation('serie_comprobante_idserie_comprobante','serie_comprobante','serie');

        $crud->field_type('fecha_creacion', 'datetime');

        //acciones js revisar groceryCRUD.js
        $crud->add_action('Imprimir', '', base_url('documentaciones/print_documentacion?iddocumentacion='),'fa fa-print imprimir');

        $crud->unset_add();
        //$crud->unset_edit();
        $crud->unset_clone();
        $crud->unset_delete();

        $crud->edit_fields('texto','observacion','estado');

        $crud->order_by('fecha_creacion','desc');

        $output = $crud->render();

        $output->title = "Documentacion :: <a href='".base_url('documentaciones/add')."'> crear nuevo documento</a>";

        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
        
    }

    public function lista_tipos()
    {
        
        $this->metodo = 'Lista ';//Siempre define las migagas de pan

        $crud = new grocery_CRUD();

        $crud->set_table('serie_comprobante');

        $crud->columns( 'tipo_comprobante_idtipocomprobante','serie','correlativo','estado');

        $crud->display_as('tipo_comprobante_idtipocomprobante','Tipo');

        $crud->set_subject('Serie');
        $crud->set_relation('tipo_comprobante_idtipocomprobante','tipo_comprobante','descripcion');

        $crud->where('idtipo_comprobante',$this->id_certificado);
        $crud->or_where('idtipo_comprobante',$this->id_constancia);
        $crud->or_where('idtipo_comprobante',$this->id_acta);



        $crud->unset_add();
        $crud->unset_clone();
        $crud->unset_delete();        

        $output = $crud->render();
        $output->title = 'Tipo documentación';
        //validación del tipo de comprbante de documento de cliente es ventas.js


        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
    
    }

    public function tipo_datos()
    {
        $this->metodo = 'Lista';//Siempre define las migagas de pan

        $crud = new grocery_CRUD();
        $crud->set_table('dato');
        
        $crud->columns('descripcion','tipo', 'estado');
        $crud->unset_delete();
        $crud->unique_fields(array('descripcion'));
        $output = $crud->render();
        $output->title = 'Tipos de Datos';

        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
    }

    public function datos_documento()
    {
        $this->metodo = 'Lista';//Siempre define las migagas de pan

        $crud = new grocery_CRUD();
        $crud->set_table('datos_documentacion');

        $crud->required_fields('iddocumento','priority' );

        $crud->set_relation('iddato','dato','descripcion');
        $crud->set_relation('iddocumento','serie_comprobante','serie');

         $crud->unset_texteditor(array('valor','full_text'));

        $crud->display_as('priority','Orden');
        //$crud->columns('descripcion','tipo', 'estado');
        $crud->unset_delete();
        //$crud->unique_fields(array(''));}

        $crud->order_by('priority','asc');
        $crud->order_by('iddocumento','asc');
        $output = $crud->render();
        $output->title = 'Datos x Documento';

        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
    }




    public function add()
    {
        
        $this->metodo = 'Nuevo Documento';//Siempre define las migagas de pan

        $this->_init(true,false,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )

        //Cargando js y css
        $this->load->js('assets/myjs/genericos/get_data.js');//genericos
        $this->load->js('assets/myjs/genericos/set_data.js');//genericos
        $this->load->js('assets/myjs/documentacion.js');
        
        $this->load->js('assets/js/bootbox.min.js');
        $this->load->js('assets/js/typeahead/typeahead.min.js');
        $this->load->js('assets/js/shortcut.js');//actiacion de teclasv
        

        //$this->load->model('almacen');
        $this->load->model('get_data');
        $this->load->model('cliente');


        $output = array(); 
        $get_clientes = $this->load->view('get_data/clientes', $output,true) ;

        /*$output = array( 'onSelected' => 'add_detalle(obj);' ); //cuando se seleccione el valor
        $get_productos = $this->load->view('get_data/productos', $output,true) ;*/

        $output = array('title' => 'Documentacion', 
                        'series' => $this->get_data->get_series(array($this->id_certificado,$this->id_constancia, $this->id_acta,$this->id_garantia) ),                        
                        'get_clientes' =>  $get_clientes,
                        /*'get_productos' =>  $get_productos,
                        'tipo_pagos' =>  $this->get_data->get_tipo_pagos('%'),//'%' es todos
                        'periodo_pagos' =>  $this->get_data->get_periodo_pagos('%'),
                        'correlativo_proforma' => $this->get_data->get_series($this->id_proforma)*/
                        ); 
        //Cargando ultima
        $this->load->view('documentacion/add', $output ) ;
    }

    public function save()
    {   
        
        //print_r($_POST);exit();
        $return = array( 'estado_validacion' => true , 'estado' => false, 'msj' => '' , 'error'=> '' , 'idsave' => '' , 'enlace' => '');  

        //VALIDACIONES

        //Guardar movimiento
        $this->db->trans_start();//Inicio de transaccion

        $this->load->model('get_data');
        $idserie = $this->input->post('idserie');
        $serie = $this->get_data->get_correlativo($idserie);//Obtener correlativo actual

        $this->load->model('comprobante');  
        $tipo_comprobante = $this->comprobante->get_tipo_serie($idserie);//Obtener tipo de comprobante         
        $this->comprobante->update_serie_correlativo($idserie,'correlativo','correlativo + 1' );//idserie , campo , valor //Actualizar el correlativo de la serie 

        $ruc_cliente = $this->input->post('ruc_cliente');
        $dni_cliente = $this->input->post('dni_cliente');

        if( $ruc_cliente != '00000000000' AND strlen($ruc_cliente) == 11 ){
            $nro_documento_cliente = $ruc_cliente;
        }else if($dni_cliente != '00000000' AND strlen($dni_cliente) == 8){
            $nro_documento_cliente = $dni_cliente;                          
        }else{
            $nro_documento_cliente = '-' ;    
        }        

        //Guardar Venta
        $this->load->model('documentacion');        
        $this->documentacion->tipo_comprobante_idtipo_comprobante = $tipo_comprobante; 
        $this->documentacion->nro_documento = $serie->correlativo;   
        $this->documentacion->cliente_documento = $nro_documento_cliente;
        
           
        $this->documentacion->insert_documentacion();
        $iddocumentacion = $this->db->insert_id();

        //Guardar Detalle Venta
        $this->load->model('det_documentacion');   
        $this->det_documentacion->documentacion_iddocumentacion = $iddocumentacion;     
        $this->det_documentacion->insert_det_documentacion();
    
        /*//Modificar Stock
        $this->load->model('stock');       
        $this->stock->modificar_stock("-");

        //Agregar Kardex
        $this->load->model('kardex');      
        $this->kardex->codmotivo = $idventa;
        $this->kardex->insert_kardex("S","venta");*/
        
        $return['idsave'] = $iddocumentacion;
       
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
    
    public function print_documentacion()
    {   

        $this->load->model('documentacion');
        $this->load->model('det_documentacion');
        $this->load->helper('calculo');

        $orientation = 'P' ;
        $format = 'A4';
        if(isset($_GET['orientation'])){
            $orientation = $this->input->get('orientation');

        }
        if(isset($_GET['format'])){
            $format = $this->input->get('format');
        }
        
        $documentacion = $this->documentacion->get_print_documentacion($this->input->get('iddocumentacion'));
        $det_documentacion = $this->det_documentacion->get_print_det_documentacion($this->input->get('iddocumentacion'));
        //echo '<pre>';print_r($documentacion);print_r($det_documentacion);exit();

        if( count($documentacion) == 0 OR count($det_documentacion) == 0 ){ die('NO SE ENCONTRARON RESULTADOS'); exit();};

        //$orientation = ())? $this->input->get('orientation') : 'P' ;
        //$format = (isset($this->input->get('format')))? $this->input->get('format'):'A4';
        
        $nombrepdf  = $documentacion['Comprobante'].'_'.$documentacion['Nro_documento'];
        
        $this->load->library('Pdf_documentacion');
        $pdf = new Pdf_documentacion($orientation, 'mm', $format , true, 'UTF-8', false);

        $pdf->tipo_documento = $documentacion['Comprobante'];
        $pdf->nro_documento = $documentacion['Nro_documento'];       

        //Parametros del PDF
        $pdf->SetTitle($nombrepdf);
        
        $pdf->SetAutoPageBreak(TRUE, 15);
        $pdf->AddPage();

        $pdf->comprobante_data_title($documentacion['Texto']);
        //$pdf->comprobante_data_title($documentacion['Texto']);

        $pdf->Ln(2);     
        
        $pdf->comprobante_data($det_documentacion);



        //$pdf->comprobante_data_title('El que suscribe Gerente General de la empresa PETROLMECANICA JC SAC   CON RUC  N° 20602440908.');

        /*$data_usuario_receptor = array('Cliente' => array($venta['Cliente'],'4'),
                                  'RUC/DNI' => array($venta['RUC/DNI'],'1'),
                                  'Dirección' => array($venta['Direccion'],'5')  );
        $pdf->receptor_data( 5 ,$data_usuario_receptor);

        $data_comprobante = array('Emitido' => array($venta['Fecha'],'1'),
                                  'Tienda' => array($venta['Tienda'],'1'),  
                                  'Vendedor' => array($venta['Usuario'],'1'),
                                  'Observacion' => array($venta['Observacion'],'3')  );
        $pdf->comprobante_data( 3 ,$data_comprobante);

        $width_cols = array(  array('Descripcion',40 ,'L') , array('Cant.',20, 'R'),array('P.unit',20,'R'),array('Subtotal',20,'R') );
        $pdf->data_table( $det_venta ,  $width_cols, true);       
        

       


        $cod_documento_client = '0';
        if( strlen($venta['RUC/DNI']) == 11 ){
            $cod_documento_client = '6';
        }else if( strlen($venta['RUC/DNI']) ==8) {
            $cod_documento_client = '1';
        }


        $comprobante = explode("-", $venta['Nro_documento']); // Separamos serie de correlativo

        $data_resumen = $this->ruc.'|'.$venta['codsunat'].'|'.$comprobante[0].'|'.$comprobante[1].'|'.$venta['Igv'].'|'.$venta['Total'].'|'.$venta['Fecha'].'|'.$cod_documento_client.'|'.$venta['RUC/DNI'].'|' ;
        $qr_code = $this->crear_qr($data_resumen); 


        $data_footer = array('monto_letra' => array( 'texto' => num_to_letras($venta['Total'])),
                            'monto' => array('op_importe'=>$venta['Total'] ,  'op_exonerados'=>$venta['Total'] , 'op_igv'=>$venta['Igv'] , ) ,
                            'qr_code' =>  $qr_code   );
        $pdf->data_table_footer( 'monto_venta',  $data_footer , 'msj');


         /* Limpiamos la salida del búfer y lo desactivamos */
        ob_end_clean();
        $pdf->Output($nombrepdf.'.pdf', 'I');
    }
	

}
