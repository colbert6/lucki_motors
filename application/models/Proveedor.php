<?php 
class Proveedor extends CI_Model {

        public $title;
        public $content;
        public $date;


        public function get_lista($id)
        {       
                $where = "estado = 'Activo' ";
                if($id != ''){
                    $where .= "and idproveedor = {$id}";
                }
                $this->db->select("idproveedor as id, razon_social as text, ruc,direccion,contacto");
                $this->db->from('proveedor');
                $this->db->where($where);
                $query = $this->db->get();

                return $query->result();
        }

}

