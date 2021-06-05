<?php 
class Colaborador extends CI_Model {

        public $title;
        public $content;
        public $date;



        public function get_lista()
        {       

                $this->db->select("idcolaborador as id, nombre as text, dni,contacto,correo");
                $this->db->from('colaborador');
                $this->db->where('estado','Activo');
                $query = $this->db->get();

                return $query->result();
        }

}

