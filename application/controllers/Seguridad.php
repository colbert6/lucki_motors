<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Seguridad extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->controller = 'Seguridad';//Siempre define las migagas de pan

	}

	public function modulos()
    {       
        $this->metodo = 'Modulos';//Siempre define las migagas de pan

        $this->load->library('grocery_CRUD');
        $crud = new grocery_CRUD();
        $crud->set_table('seg_modulo');
        $crud->columns('nombre','url','nivel','icono','id_modulo_padre','orden');
        $crud->display_as('id_modulo_padre','Mod Padre');
        $crud->set_subject('Modulo');
        $crud->set_relation('id_modulo_padre','seg_modulo','nombre', array('id_modulo_padre' => null),'nivel ASC');        

        $crud->required_fields('nombre','nivel','url');

        $output = $crud->render();
        $output->title = 'Modulos';

        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
    }

    public function perfiles()
    {       
        $this->metodo = 'Modulos';//Siempre define las migagas de pan   

        $this->load->library('grocery_CRUD');
        $crud = new grocery_CRUD();
        $crud->set_table('seg_perfil');
        $crud->set_relation_n_n('menu','seg_menus','seg_modulo','id_perfil','id_modulo','nombre', 'priority', 'seg_modulo.nivel != \'primer\' ' );
        //$crud->set_relation_n_n('acciones','seg_restricciones','seg_acciones','id_perfil','id_accion','{nombre} {regex}', 'priority' );
        $crud->unset_columns('menu');

        $crud->add_action('Ver permisos', '', base_url('seguridad/permisos/'),'fa fa-eye');
        
        $crud->set_subject('Perfil');
        $crud->required_fields('nombre');

        $output = $crud->render();
        $output->title = 'Perfiles';

        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
    }

    public function acciones()
    {       
        $this->metodo = 'Modulos';//Siempre define las migagas de pan   

        $this->load->library('grocery_CRUD');   

        $crud = new grocery_CRUD();
        $crud->set_table('seg_acciones');
        $crud->columns('nombre','regex');
        $crud->display_as('id_modulo','Modulo');
        $crud->set_subject('Acciones');
        $crud->set_relation('id_modulo','seg_modulo','nombre');
        

        $crud->required_fields('nombre','regex');

        $output = $crud->render();
        $output->title = 'Modulos';

        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
    }


    public function permisos($idperfil)
    {
        $this->metodo = 'Perfil / Permisos ';//Siempre define las migagas de pan

        $output['title'] = "<a href='".base_url('seguridad/perfiles')."'> Lista perfiles </a> :: Permisos de ";

        $this->load->model('menus');
        $output['modulos'] = $this->menus->get_modulos($idperfil);

        $this->load->model('perfil');
        $output['perfil'] = $this->perfil->get_perfil($idperfil);


        $this->_init(true,false,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('seguridad/permisos', $output ) ;
    }



    public function usuarios()
    {       
        $this->metodo = 'Modulos';//Siempre define las migagas de pan   

        $this->load->library('grocery_CRUD');   

        $crud = new grocery_CRUD();
        $crud->set_table('seg_usuario');
        $crud->columns('id_perfil','nombres','apellidos','user');
        $crud->display_as('id_perfil','Perfil');
        $crud->set_subject('Acciones');
        $crud->set_relation('id_perfil','seg_perfil','nombre');
        
        $crud->field_type('clave', 'password');
        $crud->change_field_type('password_field','clave');
        $crud->callback_before_insert(array($this,'encrypt_password_callback'));
        $crud->callback_before_update(array($this,'encrypt_password_callback'));

        $crud->callback_edit_field('clave',array($this,'decrypt_password_callback'));


        $crud->required_fields('user','nombres','id_perfil', 'clave' );

        $output = $crud->render();
        $output->title = 'Modulos';

        $this->_init(true,true,true);//Carga el tema ( $cargar_menu, $cargar_url, $cargar_template )
        $this->load->view('grocery_crud/basic_crud', (array)$output ) ;
    }

    function encrypt_password_callback($post_array, $primary_key = null)
    {
        $this->load->library('encryption');
        $post_array['clave'] = $this->encryption->encrypt($post_array['password']);

        return $post_array;
    }
     
    function decrypt_password_callback($value)
    {
        $this->load->library('encryption');      
        $decrypted_password = $this->encryption->decrypt($value);
        return "<input type='password' name='password' value='$decrypted_password' />";
    }

    public function prueba()
    {
        $this->load->model('menus');
        $this->menus->get_modulos();
    }


}
