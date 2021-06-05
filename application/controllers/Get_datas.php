<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Get_datas extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        $this->controller = 'Get_datas';//Siempre define las migagas de pan
    }


    public function get_clientes()
    {
        $get_query = $this->input->get('query');
        $this->load->model('get_data');
        print json_encode($this->get_data->get_clientes($get_query) );
    }

    public function get_proveedores()
    {
        $get_query = $this->input->get('query');
        $this->load->model('get_data');
        print json_encode($this->get_data->get_proveedores($get_query) );
    }

    public function get_cliente_document()
    {
        $tipo_doc = $this->input->get('tipo');
        $numero_doc = $this->input->get('numero');
        $this->load->model('get_data');
        print json_encode($this->get_data->get_cliente_document($tipo_doc, $numero_doc) );
    }

    public function get_productos()
    {
        $get_query = $this->input->get('query');
        $filtro = isset($_GET['filtro'])? $this->input->get('filtro'): '';

        $this->load->model('get_data');
        print json_encode($this->get_data->get_productos($get_query,$filtro) );
    }

    public function get_productos_directo()
    {
        $get_query = $this->input->get('query');
        $filtro = isset($_GET['filtro'])? $this->input->get('filtro'): '';

        $this->load->model('get_data');
        print json_encode($this->get_data->get_productos_directo($get_query,$filtro) );
    }

    

    public function get_correlativo()
    {
        $idserie = $this->input->get('idserie');
        $this->load->model('get_data');
        print json_encode($this->get_data->get_correlativo($idserie) );
    }

    public function get_datos_documentacion()
    {   
        $result = array();

        $idserie = $this->input->get('idserie');
        $this->load->model('get_data');

        $result['get_datos_documentacion'] = $this->get_data->get_datos_documentacion($idserie);

        $result['get_correlativo'] = $this->get_data->get_correlativo($idserie);


        print json_encode($result);


    }




	

}
