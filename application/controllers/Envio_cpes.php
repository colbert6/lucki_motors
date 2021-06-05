<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');

class Envio_cpes extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->controller = 'Ventas';//Siempre define las migagas de pan
        $this->load->library('grocery_CRUD');
    }


    public function lista_enviados() {
        $this->metodo = 'Lista';//Siempre define las migagas de pan

        $this->load->js('assets/myjs/groceryCRUD.js');
        $this->load->js('assets/js/bootbox.min.js');

        $crud = new grocery_CRUD();

        $crud->set_table('envio_electronico');
        $crud->columns('fecha_envio','serie','correlativo','envio_pse' ,'tipoenvio', 'estado_envio');
        //$crud->set_relation('usuario_envio','colaborador','nombre');
        
        $crud->order_by('fecha_envio','desc');

        $crud->add_action('consulta cpe', '', base_url('Envio_cpes/consultar_cpe?id='),'fa fa-deaf cpe_consulta');

        
        $crud->unset_delete();
        $crud->unset_clone();

        $output = $crud->render();
        $output->title = 'Enviados cpe';

        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
    }

    public function lista_pendientes() {

        $this->metodo = 'Lista';//Siempre define las migagas de pan

        $this->load->js('assets/myjs/groceryCRUD.js');
        $this->load->js('assets/js/bootbox.min.js');

        $crud = new grocery_CRUD();        

        $crud->columns('idmaster','fecha_emision','comprobante' , 'estado');
        $crud->set_table('cpe_pendientes');
        $crud->set_primary_key('idmaster');
        //$crud->set_relation('usuario_envio','colaborador','nombre');
        
        $crud->unset_delete();

        $crud->order_by('fecha_emision','desc');

        $crud->add_action('envio cpe', '', base_url('Envio_cpes/envio_pse/?tipo_envio=generar_comprobante&id='),'fa fa-send cpe_envio');
        $crud->add_action('envio cpe anulacion', '', base_url('Envio_cpes/envio_pse/?tipo_envio=generar_anulacion&id='),'fa fa-close cpe_envio');

        $crud->unset_delete();
        $crud->unset_clone();

        $output = $crud->render();
        $output->title = 'Pendientes cpe';

        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
        

    }
    public function lista_errores() {
       
        $this->metodo = 'Lista';//Siempre define las migagas de pan

        $crud = new grocery_CRUD();

        $crud->set_table('error_envio_electronico');
        $crud->columns('errors','idmaster','fecha','tipo_envio', 'codigo', 'usuario_envio');
        $crud->set_relation('usuario_envio','colaborador','nombre');
        
        $crud->unset_delete();

        $crud->order_by('fecha','desc');

        $output = $crud->render();
        $output->title = 'Errores envios cpe';

        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
    }

    

    //--------------------------CPE--------------------

    public function consultar_cpe(){

        $idenvio = $this->input->get('id');
        //$idenvio = $_POST["idenvio"];
        $this->load->helper('nubefact');

        $sql = "SELECT IF( tipoenvio = 'generar_comprobante', 'consultar_comprobante' , 'consultar_anulacion') as operacion, 
                       tipo as tipo_de_comprobante,          
                       serie as serie,
                       correlativo as numero , 
                       aceptada_por_sunat 

                FROM envio_electronico 
                WHERE id = ".$idenvio ;
        
        $data = $this->db->query($sql)->row_array();

        //print_r($data);
        $data_json = json_encode($data);   

        $respuesta = envio_json($data_json);



        if ( isset($respuesta["aceptada_por_sunat"]) &&  $respuesta["aceptada_por_sunat"] ) {

            $this->load->model('envio_cpe');

            $datos_result_cpe = array(  
                'fecha_mod'=>date("Y-m-d H:i:s"),
                'aceptada_por_sunat'=>$respuesta["aceptada_por_sunat"],
                'estado_envio' => 'ACEPTADO'                
            );
            $this->envio_cpe->set_envio_update($datos_result_cpe, $idenvio);           
        }

        print_r(json_encode($respuesta));
        
    }

    public function envio_pse() {
        $idventa = $this->input->get('id');
        $tipo_envio = $this->input->get('tipo_envio');
        
        $this->load->helper('nubefact');
        //echo "<pre>";

        $enlace='-';
        $data_json = array();

        //Obtenermos la data en json
        if($tipo_envio == "generar_comprobante"){
            $data_json = $this->generar_comprobante_json($idventa);
        }else if($tipo_envio =="generar_anulacion"){
            $data_json = $this->generar_anulacion_json($idventa);
        }

        //obtenemos el resultado
        //print_r( $data_json);exit();

        if(count($data_json) &&  $data_json != 'null' ){
            
            $result = envio_json($data_json);//la respuesta devuelve en formatojson_decode($result_json, true);
            
        }else{
            $result = array('errors'=>'No se encontro datos en la consulta.', 'codigo'=>666);
        }


        $this->load->model('envio_cpe');

        if (isset($result['errors'])) {
            //Mostramos los errores si los hay
            //echo $result['errors'];
            $datos_result_cpe = array( 'errors' => $result['errors'],
                            'tipo_envio' => $tipo_envio,
                            'idmaster' => $idventa,
                            'fecha' => date("Y-m-d H:i:s"),
                            'codigo' => $result['codigo'],
                            'usuario_envio' => $this->session->userdata('id_user')  );
            $this->envio_cpe->set_error($datos_result_cpe);
           

        } else {
            //Mostramos la respuesta
            $data = json_decode($data_json, true);//algunos parametros que no secomparten

            $datos_result_cpe = array(  

                'idmaster' =>  $idventa,
                'tipo' =>  $data["tipo_de_comprobante"],
                'correlativo' =>  $data["numero"],
                'serie' =>  $data["serie"],
                'sunat_description' =>  $result["sunat_description"],
                'sunat_note' =>  $result["sunat_note"],
                'sunat_responsecode' =>  $result["sunat_responsecode"],
                'sunat_soap_error' =>  $result["sunat_soap_error"],
                'aceptada_por_sunat' =>  $result['aceptada_por_sunat'],
                'usuario_envio' =>  $this->session->userdata('id_user') ,
                'envio_pse' =>  true,
                'fecha_envio' =>  date("Y-m-d H:i:s"),
                'fecha_mod' =>  '',
                'estado_envio' =>  '-',
                'tipoenvio' => $tipo_envio,
                'fecha_emi' =>  '',
                'enlace' =>  $result["enlace"]
             );

            $this->envio_cpe->set_envio($datos_result_cpe);

            $enlace = $result["enlace"];
        }

        print_r(json_encode( $result));
        //echo"<pre>"; print_r($data_json); print_r($result);

    }

    public function generar_comprobante_json($idventa){ 
       
        //FACTURA O BOLETA
        $this->load->model('venta');
        $this->load->model('det_venta');

        $data = $this->venta->cpe_venta($idventa);        

        if( count($data) ) {

            $data_det = $this->det_venta->cpe_detventa($idventa);
            $data["items"]= $data_det;

            $data_json =json_encode($data);

        }else{
            $data_json = array();
        }

        return $data_json;
    }

    public function get_venta_json($idventa,$tipo = 'generar'){ 
       
        
        if($tipo == 'anulacion'){
            $data_json = $this->generar_anulacion_json($idventa); 
        }else{
            $data_json = $this->generar_comprobante_json($idventa);
        }
        echo '<pre>';
        print_r(json_decode($data_json));
    }

    public function generar_anulacion_json($idventa){

        $this->load->model('venta');
        $data = $this->venta->cpe_venta_anulacion($idventa); 
        
        $data_json = json_encode($data);

        return $data_json;
    }





}
