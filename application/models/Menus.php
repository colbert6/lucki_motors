<?php 
class Menus extends CI_Model {

    public $id_modulo;
    public $id_perfil;
    public $priority;

    
    public function get_modulos($idperfil)
    {   
        $this->db->select("modu.id_modulo as id, modu.nombre as modulo, '' as hijos  ");
        $this->db->from("seg_modulo as modu ");
        $this->db->where("modu.nivel", "primer");
        $this->db->order_by("modu.orden", "ASC");
        $query = $this->db->get();
        $modulos_primer = $query->result();
        
        //print_r($modulos_primer);
        foreach ($modulos_primer as $k => $val) {

            $this->db->select("modu.id_modulo as id, modu.nombre as modulo, '' as estado  ,'' as hijos  ");
            $this->db->from("seg_modulo as modu ");
            $this->db->where("modu.id_modulo_padre", $val->id);
            $this->db->where("modu.nivel", "segundo");
            $this->db->order_by("modu.orden", "ASC");
            $query = $this->db->get();
            $val->hijos = $query->result();

            foreach ($val->hijos as $kh => $valh) {

                $this->db->select("1 as estado");
                $this->db->from("seg_menus as menu ");
                $this->db->where("menu.id_modulo", $valh->id);
                $this->db->where("menu.id_perfil", $idperfil);
                $query = $this->db->get();
                $estado = $query->row_array();
                $valh->estado = $estado['estado'];

            }

        }

        return $modulos_primer;
    }

    public function get_menu($idperfil)
    {   
        $this->db->select("padres.nombre as papa , modu.nombre as nombre, modu.url as url, modu.icono as icono");
        $this->db->from("seg_modulo modu");
        $this->db->join('seg_modulo padres','padres.id_modulo = modu.id_modulo_padre');
        $this->db->join('seg_menus men','men.id_modulo = modu.id_modulo');
        $this->db->where("men.id_perfil", $idperfil);
        $this->db->order_by("padres.orden", "ASC");
        $this->db->order_by("modu.orden", "ASC");
        $query = $this->db->get();

        return $query->result();
    }

}


