<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    //constructor, debe llamar al constructor de la clase parent
    public $sistema = 'LM-sis';
    
    public $controller = '';
    public $metodo = '';
    public $menu = '';
    
    public $nombre_usuario = '';
    public $perfil_usuario = '';

    public $nombre_empresa = 'LUCKI MOTORS ';
    public $nombre_empresa_abreviado = 'Lucki Motors';
    public $logo_empresa = 'assets/img/logo_empresa.jpg';
    public $razon_social = 'LUCKI MOTORS DEL PERU S.R.L.';
    public $ruc = '20531452055';
    public $direccion = 'PZA.PLAZA MAYOR NRO. S-N';//'Jr. Alfonso ugarte Nro. 1800, Bar. Shucapampa - CAJAMARCA';
    public $contacto = 'Telf. 0';
    public $rubro = 'Venta de vehículos automotores, fabricación otros equipos de transporte y venta al por mayor de materiales de construcción, articulos de ferretería y equipo y materiales de fontanería y calefacción ';

    public $id_ticket = 1;
    public $id_boleta = 3;
    public $id_factura = 2;
    public $id_proforma = 4;
    public $id_nota_entrada = 5;
    public $id_nota_salida = 6;
    public $id_certificado = 7;
    public $id_constancia = 8;
    public $id_acta = 9;
    public $id_garantia = 10;
    public $id_guia_remision = 11;

    public function __construct()
    {
        parent::__construct();        
        
        
    }

    public function _init( $cargar_menu, $cargar_url, $cargar_template )
    {       
    	if( !$this->session->userdata('logeado_sis') ){        
            redirect('login', 'location’');   
        }

        $this->nombre_usuario  = $this->session->userdata('username');
        $this->perfil_usuario  = $this->session->userdata('perfil');
        if($cargar_menu) {$this->menu = $this->_get_menu();} //obtener menu para el usuario en sesion
        if($cargar_url) {$this->_request_url();}//obtengo el pedio URL y reemplaza el controlador y metodo    
        if($cargar_template) {$this->output->set_template('adminlte');}//Carga el template
           
    }

    private function _request_url()
    {
        $url = $this->input->server('REQUEST_URI'); 
        $url_solicitados = explode("/", $url);

        $this->controller =  isset($url_solicitados[2])?ucwords($url_solicitados[2]):'';
        $this->metodo =  isset($url_solicitados[3])?ucwords($url_solicitados[3]):'';
    } 

    private function _get_menu()
    {        
        
                
        $this->load->model('menus');
        $menu_usuario = $this->menus->get_menu($this->session->userdata('id_perfil'));

        $modulo_papa_flag = '';
        $menu = '';     

        foreach ( $menu_usuario as $modulo) {

            if( $modulo_papa_flag != $modulo->papa ){

                if($modulo_papa_flag != '' ){
                        $menu .="</ul> </li>";                            
                }

                $menu .= "<li class='treeview'>
                <a href='#'>
                    <i class='fa fa-reorder'></i> <span> {$modulo->papa} </span>
                    <span class='pull-right-container'>
                      <i class='fa fa-angle-left pull-right'></i>
                    </span>
                  </a>
                  <ul class='treeview-menu'>";
                $modulo_papa_flag = $modulo->papa;   

            }
            $menu .=  "<li><a href='".base_url($modulo->url)."'><i class='fa {$modulo->icono}'></i> {$modulo->nombre}</a></li>"; 

        }

        return $menu;
        // exit();
    } 

    
    

}