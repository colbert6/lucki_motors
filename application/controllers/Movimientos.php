<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Movimientos extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->controller = 'Movimientos';//Siempre define las migagas de pan
    }


    public function lista()
    {

        $this->metodo = 'Lista';//Siempre define las migagas de pan

        $this->load->library('grocery_CRUD');        
        $this->load->js('assets/myjs/groceryCRUD.js');
        $crud = new grocery_CRUD();

        $crud->set_table('movimiento');
        $crud->columns('fecha_creacion','tipo_comprobante','nro_documento','colaborador_idcolaborador','total','estado');

        //$crud->display_as('fecha_creacion','Fecha');
        $crud->display_as('tipo_comprobante','Tipo mov.');
        $crud->display_as('colaborador_idcolaborador','Colaborador');        

        $crud->set_subject('Movimiento');
        $crud->set_relation('tienda_idtienda','tienda','descripcion');
        $crud->set_relation('colaborador_idcolaborador','colaborador','nombre');
        $crud->set_relation('tipo_comprobante','tipo_comprobante','descripcion');        

        $crud->field_type('fecha_creacion', 'datetime');
    

        $crud->unset_add();
        $crud->unset_edit();
        $crud->unset_clone();
        $crud->unset_delete();

        $crud->order_by('fecha_creacion','desc');
        $crud->add_action('Imprimir', '', base_url('movimientos/print_movimiento?idmovimiento='),'fa fa-print imprimir');

        $output = $crud->render();
        $output->title = "Movimientos :: <a href='".base_url('movimientos/add')."'> Crear nuevo Movimiento</a>";

        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
    }

    public function add()
    {

        $this->metodo = 'Nuevo movimiento';//Siempre define las migagas de pan

        $this->_init(true,false,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )

        $this->load->js('assets/myjs/genericos/calculos.js');//genericos
        $this->load->js('assets/myjs/genericos/get_data.js');//genericos
        $this->load->js('assets/myjs/genericos/set_data.js');//genericos
        $this->load->js('assets/myjs/movimientos.js');
        
        $this->load->js('assets/js/bootbox.min.js');
        $this->load->js('assets/js/typeahead/typeahead.min.js');
        $this->load->js('assets/js/shortcut.js');

        $this->load->model('almacen');
        $this->load->model('get_data');

        $output = array( 'onSelected' => 'add_detalle(obj);' ); //cuando se seleccione el valor
        $get_productos = $this->load->view('get_data/productos', $output,true) ;

        $output = array(
            'title' => 'Movimiento',
            'tiendas' => $this->almacen->get_tienda(),            
            'series' => $this->get_data->get_series(array($this->id_nota_entrada,$this->id_nota_salida) ), 
            'get_productos'=>$get_productos
        ); 

        $this->load->view('movimientos/add', $output ) ;
    }


    public function save()
    {   
        //Guardar movimiento
        $this->db->trans_start();//Inicio de transaccion

        $this->load->model('get_data');
        $idserie = $this->input->post('idserie');
        $serie = $this->get_data->get_correlativo($idserie);//Obtener correlativo actual

        $this->load->model('comprobante');  
        $tipo_comprobante = $this->comprobante->get_tipo_serie($idserie);//Obtener tipo de comprobante         
        $this->comprobante->update_serie_correlativo($idserie,'correlativo','correlativo + 1' );//idserie , campo , valor //Actualizar el correlativo de la serie 

        $this->load->model('movimiento');
        $this->movimiento->tipo_comprobante = $tipo_comprobante; 
        $this->movimiento->nro_documento = $serie->correlativo; 
        $this->movimiento->insert_movimiento();
        $idmovimiento = $this->db->insert_id();//obtener ultimmo id insertado
        
        //Guardar Detalle Venta
        $this->load->model('det_movimiento');   
        $this->det_movimiento->movimiento_idmovimiento = $idmovimiento;     
        $this->det_movimiento->insert_det_movimiento();
    
        //Modificar Stock
        $this->load->model('stock');    
        
        if($this->input->post("idserie")== $this->id_nota_entrada){//Nota ENTRADA
            $action = "+";
            $movimiento = "E";
            $motivo = "nota entrada";
        }else if($this->input->post("idserie")== $this->id_nota_salida){//Nota ENTRADA
            $action = "-";
            $movimiento = "S";
            $motivo = "nota salida";
        }
        $this->stock->modificar_stock($action);

        //Agregar Kardex
        $this->load->model('kardex');      
        $this->kardex->codmotivo = $idmovimiento;
        $this->kardex->insert_kardex($movimiento,$motivo);


        $return = array('estado' => false, 'msj' => '' , 'error'=> '' , 'idsave' => $idmovimiento);
        
        if ($this->db->trans_status() === FALSE) {
            
            $error = $this->db->error();
            $this->db->trans_rollback(); 

            $return['msj']= $error['message'];
        } else {

            $this->db->trans_commit();
            $return['estado']=true;
        }
        print json_encode($return);
    }

    public function print_movimiento()
    {   
        $this->load->model('movimiento');
        $this->load->model('det_movimiento');

        $orientation = 'P' ;
        $format = 'A4';
        if(isset($_GET['orientation'])){
            $orientation = $this->input->get('orientation');

        }
        if(isset($_GET['format'])){
            $format = $this->input->get('format');
        }

        $movimiento = $this->movimiento->get_print_movimiento($this->input->get('idmovimiento'));
        $det_movimiento = $this->det_movimiento->get_print_det_movimiento($this->input->get('idmovimiento'));

        if( count($movimiento) == 0 OR count($det_movimiento) == 0 ){ die('NO SE ENCONTRARON RESULTADOS'); exit();};

        $nombrepdf  = 'Movimiento_'.$movimiento['Nro_documento'];

        $this->load->library('Pdf_comprobantes');
        $pdf = new Pdf_comprobantes($orientation, 'mm', $format , true, 'UTF-8', false);

        $pdf->tipo_documento = $movimiento['Comprobante'];
        $pdf->nro_documento = $movimiento['Nro_documento'];       

        //Parametros del PDF
        $pdf->SetTitle($nombrepdf);
        
        $pdf->SetAutoPageBreak(TRUE, 10);
        $pdf->AddPage();

        $data_comprobante = array('Emitido' => array($movimiento['Fecha'],'1'),
                                  'Tienda' => array($movimiento['Tienda'],'1'),  
                                  'Usuario' => array($movimiento['Usuario'],'1'),
                                  'Observacion' => array($movimiento['Observacion'],'3')  );
        $pdf->comprobante_data( 3 ,$data_comprobante);

        $width_cols = array(  array('Descripcion',40 ,'L') , array('Cant.',20, 'R'),array('P.unit',20,'R'),array('Subtotal',20,'R') );
        $pdf->data_table( $det_movimiento ,  $width_cols, true);

       
        $data_footer = array('monto_letra' => array('mil lucas'),
                            'monto' => array('op_importe'=>$movimiento['Total'])   );
        $pdf->data_table_footer( 'monto_general',  $data_footer , 'msj');
        
        $pdf->Output($nombrepdf, 'I');
    }


	

}
