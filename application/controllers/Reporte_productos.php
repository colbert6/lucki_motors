<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reporte_productos extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->controller = 'Reporte_productos';//Siempre define las migagas de pan
    }


    public function index()
    {

        $this->metodo = 'Ver reporte';//Siempre define las migagas de pan

        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $output = array('title' => 'Reporte de Productos' ); 

        $this->load->js('assets/myjs/Reporte_productos.js');

        $this->load->view('Reporte_productos/index', $output ) ;
    }

    public function get_reporte_productos(){

        $fecha_inicio = $this->input->get("fi");
        $fecha_fin = $this->input->get("ff");
        $tipo = $this->input->get("tr");

        $this->load->model('venta');

        $data = $this->venta->get_ventas_productos($fecha_inicio,$fecha_fin,$tipo);//retornar en array
       
        

        if( count($data) == 0 ){
            echo "<h3>No se encontró resultados</h3>";
        }else{
            $output['title'] = 'Ventas vigentes del '.$fecha_inicio.' al '.$fecha_fin.', tipo '.$tipo;
            $output['data'] = $data;
            $output['campo_suma'] = False;
            //echo "<pre>";print_r($data);
            $this->load->view('themes/table_basic', $output ) ;
        }

        

    }



	

}
