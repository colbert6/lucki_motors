<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

    function __construct()
    {
        parent::__construct();
        //$this->load->library('session');
    }


	public function index()
	{      
        $parametros ['token'] = $this->generar_token();
        $this->load->view('login/index',$parametros) ;
	}

    public function verificar() 
    {
        if ($this->input->post('token') == $this->session->flashdata('token') ) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');//md5()

            //echo $password;exit();
            if ($this->check_login($username, $password) == FALSE) {
                //echo "false";
                $this->session->set_flashdata('error_login', 'Usuario o Contraseña incorrecta!');
                
                redirect('login', 'location’');
            } else {
                redirect('principal', 'location’');                

            }
        } else {
            //echo "no token";    
            redirect('login', 'location’');

        }
    }

    private function generar_token(){

        $token =  md5(rand(10,999)) ; 
        $this->session->set_flashdata('token',$token );
        return $token;
    }

    private function check_login($username, $password){
             
        $rpta = false;

        $this->db->select("col.idcolaborador as id_user,col.perfil as id_perfil,col.nombre as nombre ,  per.nombre as perfil ");
        $this->db->from('colaborador as col');
        $this->db->join('seg_perfil per','col.perfil = per.id_perfil');
        $this->db->where('usuario',$username);
        $this->db->where('clave',$password);
        $acceso = $this->db->get();

        if($acceso->num_rows()==1){

            $datos = $acceso->row();

            $array = array (
            'id_user' => $datos->id_user,
            'id_perfil' => $datos->id_perfil,
            'username' => $datos->nombre,
            'perfil' => $datos->perfil,
            'logeado_sis' =>  true
            );

            $this->session->set_userdata($array);
            $rpta = true;
        }
        return $rpta;
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect('login', 'location’');
    }

	

}
