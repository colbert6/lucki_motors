<?php 
class Salida extends CI_Model {

    public $tienda_idtienda;
    public $colaborador_registro;
    public $motivo_movimiento_idmotivo;
    public $nombre_recepciona;
    public $fecha_emision;
    public $serie;
    public $motor;
    public $color;
    public $tipo_comprobante_idtipo_comprobante;
    public $observacion;
    public $nrocomprobante;    
    public $fecha_creacion;
    public $estado;

    
    public function insert_salida()
    {   
        $this->tienda_idtienda = 1;
        $this->colaborador_registro = $this->session->userdata('id_user');
        $this->motivo_movimiento_idmotivo = $this->input->post('idmotivo');
        $this->tipo_comprobante_idtipo_comprobante = $this->input->post('idtipo_comprobante');        
        $this->nrocomprobante = $this->input->post('nrocomprobante');
        $this->nombre_recepciona = $this->input->post('nombre_recepciona');
        $this->fecha_emision = $this->input->post('fecha_emision');
        $this->serie = $this->input->post('serie');
        $this->motor = $this->input->post('motor');
        $this->color = $this->input->post('color');
        $this->observacion = $this->input->post('observacion');
        $this->fecha_creacion = date('Y-m-d H:i:s');
        $this->estado = 'vigente';

        
        return  $this->db->insert('salida', $this);
    }


    public function get_print($idmovimiento)
    {        
        
        $this->db->select(" 
                
                mov.idsalida as id_salida,
                mov.fecha_creacion as Fecha_registro, 
                col.nombre as Usuario_registra,
                tc.descripcion Comprobante,                 
                mov.fecha_creacion as Fecha_emision,
                mov.nombre_recepciona as Quien_lleva,
                mov.serie as Serie,
                mov.motor as Motor,
                mov.color as Color,
                mov.observacion as Observacion  ");

        $this->db->from('salida mov');
        $this->db->join('tipo_comprobante tc', 'tc.idtipo_comprobante = mov.tipo_comprobante_idtipo_comprobante');
        $this->db->join('colaborador col', 'col.idcolaborador = mov.colaborador_registro');
        $this->db->where('mov.idsalida',$idmovimiento);
        $query = $this->db->get();

        return $query->row_array();
    }



}

