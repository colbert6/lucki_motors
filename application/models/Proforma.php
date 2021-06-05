<?php 
class Proforma extends CI_Model {

    

    public $nro_documento;
    public $nro_pre_documento;
    public $cliente_razon_social;
    public $cliente_documento;
    public $cliente_direccion;
    public $contacto;

    public $colaborador_idcolaborador;
    public $observacion;
    public $fecha_emision;
    public $fecha_vencimiento;
    public $total;

    public $serie_comprobante_idserie_comprobante;
    public $tipo_comprobante_idtipo_comprobante;
    public $cliente_idcliente;
    public $tienda_idtienda;
    public $tipo_pago_idtipo_pago;
    public $periodo_pago_idperiodo_pago;
    
    public $subtotal;
    public $igv;
    public $descuento;
    public $fecha_creacion;
    public $estado = 'Pendiente';


    
    public function insert_proforma()
    {   
        $this->fecha_emision = $this->input->post('fecha_emision');
        $this->fecha_vencimiento = $this->input->post('fecha_emision');
        $this->nro_documento = $this->input->post('correlativo');        
        $this->nro_pre_documento = $this->input->post('correlativo');


        $this->serie_comprobante_idserie_comprobante = $this->input->post('idserie');
        $this->tienda_idtienda = 1;//$this->input->post('tienda');

        $tipo_comprobante = $this->db->get_where('serie_comprobante', array('idserie_comprobante' => $this->input->post('idserie') ))->row(); 
        $this->tipo_comprobante_idtipo_comprobante = $tipo_comprobante->tipo_comprobante_idtipocomprobante;

        

        $this->igv = $this->input->post('igv');
        $this->subtotal = $this->input->post('subtotales');
        $this->descuento = $this->input->post('descuento');
        $this->total = ($this->input->post('subtotales') - $this->input->post('descuento') + $this->input->post('igv'));
        
        $this->tipo_pago_idtipo_pago =  $this->input->post('idtipo_pago');
        $this->periodo_pago_idperiodo_pago =  $this->input->post('idperiodo_pago');

        $this->cliente_idcliente =  $this->input->post('idcliente');
        $this->cliente_razon_social = $this->input->post('cliente');
        $this->cliente_documento = ($tipo_comprobante->tipo_comprobante_idtipocomprobante == 2 ) ? $this->input->post('ruc_cliente') :$this->input->post('dni_cliente');
        $this->cliente_direccion = $this->input->post('direccion_cliente');
        $this->colaborador_idcolaborador = $this->session->userdata('id_user');//FALTA
        
        $this->observacion = $this->input->post('observacion');     
        
        $this->fecha_creacion = date('Y-m-d H:i:s');
        $this->estado = 'vigente';

        return  $this->db->insert('proforma', $this);
    }

    public function anular_proforma($idproforma)
    {   
        $this->db->set('estado', 'anulado');
        $this->db->where('idproforma',$idproforma);
        $this->db->update('proforma');
    }

    public function get_print_proforma($idproforma)
    {        
        $this->db->select(" pro.estado as Estado,
                tt.descripcion as Tienda,
                pro.fecha_creacion as Fecha, 
                pro.cliente_razon_social as Cliente, 
                pro.cliente_documento as 'RUC/DNI',
                pro.cliente_direccion as Direccion,
                pp.descripcion as Periodo_pago,
                tp.descripcion as Tipo_pago,
                col.nombre as Usuario,
                tc.descripcion Comprobante, 
                pro.nro_documento as Nro_documento, 
                pro.total as Total,
                pro.observacion as Observacion  ");

        $this->db->from('proforma pro');
        $this->db->join('tienda tt', 'tt.idtienda = pro.tienda_idtienda');
        $this->db->join('tipo_comprobante tc', 'tc.idtipo_comprobante = pro.tipo_comprobante_idtipo_comprobante');
        $this->db->join('colaborador col', 'col.idcolaborador = pro.colaborador_idcolaborador');
        $this->db->join('tipo_pago tp', 'tp.idtipo_pago = pro.tipo_pago_idtipo_pago');
        $this->db->join('periodo_pago pp', 'pp.idperiodo_pago = pro.periodo_pago_idperiodo_pago');
        $this->db->where('pro.idproforma',$idproforma);
        $query = $this->db->get();

        return $query->row_array();
    }
    
    public function proforma_byId($idproforma)
    {        
        $this->db->select(" pro.*  ");

        $this->db->from('proforma pro');
        $this->db->where('pro.idproforma',$idproforma);
        $query = $this->db->get();

        return $query->row_array();
    }
    

    
    

}

