<?php 
class Movimiento extends CI_Model {

    public $tienda_idtienda;
    public $tipo_comprobante;
    public $fecha;
    public $colaborador_idcolaborador;
    public $estado;
    public $nro_documento;
    public $observacion;
    public $total;
    public $fecha_creacion;
        
    public function insert_movimiento()
    {   
        $this->tienda_idtienda = $this->input->post('tienda');
        //$this->tipo_movimiento ;//se define en controlador
        $this->fecha = $this->input->post('fecha');
        $this->colaborador_idcolaborador = $this->session->userdata('id_user');   
        $this->estado = 'vigente';
        $this->observacion = $this->input->post('observacion');
        $this->total = $this->input->post('total');  
        $this->fecha_creacion = date('Y-m-d H:i:s');
       
        return  $this->db->insert('movimiento', $this);
    }
    
    public function movimiento_byId($id="")    {   

        $where = "";
        if($id != ""){
            $where = "mv.idmovimiento = {$id}";
        }
        $this->db->select("mv.*,t.descripcion tienda, col.nombre colaborador");
        $this->db->from('movimiento mv');
        $this->db->join('tienda t', 'mv.tienda_idtienda = t.idtienda');
        $this->db->join('colaborador col', 'col.idcolaborador = mv.colaborador_idcolaborador');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_print_movimiento($idmovimiento)
    {        
        $this->db->select(" mov.estado as Estado,
                tt.descripcion as Tienda,
                mov.fecha_creacion as Fecha, 
                col.nombre as Usuario,
                tc.descripcion Comprobante, 
                mov.nro_documento as Nro_documento, 
                mov.total as Total,
                mov.observacion as Observacion  ");

        $this->db->from('movimiento mov');
        $this->db->join('tienda tt', 'tt.idtienda = mov.tienda_idtienda');
        $this->db->join('tipo_comprobante tc', 'tc.idtipo_comprobante = mov.tipo_comprobante');
        $this->db->join('colaborador col', 'col.idcolaborador = mov.colaborador_idcolaborador');
        $this->db->where('mov.idmovimiento',$idmovimiento);
        $query = $this->db->get();

        return $query->row_array();
    }
    

}

