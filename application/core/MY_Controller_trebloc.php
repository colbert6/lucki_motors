<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

    //constructor, debe llamar al constructor de la clase parent
    public $sistema = 'TREBLOCs';
    
    public $controller = '';
    public $metodo = '';
    public $menu = '';
    
    public $nombre_usuario = '';
    public $perfil_usuario = '';

    public $nombre_empresa = 'PETROLMECANICA JC';
    public $nombre_empresa_abreviado = 'PETROLMECANICA JC';
    public $logo_empresa = 'assets/img/logo_empresa.jpg';
    public $razon_social = 'PETROLMECANICA JC S.A.C.';
    public $ruc = '20602440908';
    public $direccion = 'Pj. La Amistad nro. 145 Bar. Mollepampa Cajamarca - Cajamarca';//'Jr. Alfonso ugarte Nro. 1800, Bar. Shucapampa - CAJAMARCA';
    public $contacto = 'Telf.76622268 - cel.978833002 - petrolmecanica.jc@gmail.com';
    public $rubro = 'Venta al por mayor de otros tipos de maquinaria y equipo <br> Fabricación de productos metalicos para uso estructural';

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