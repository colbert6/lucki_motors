<?php 
class Perfil extends CI_Model {

     


    public function get_perfil($id)
    {       
                
        $this->db->select("id_perfil as id, nombre");
        $this->db->from('seg_perfil');
        $this->db->where('id_perfil',$id);
        $query = $this->db->get();
        return $query->row();
    }

}

