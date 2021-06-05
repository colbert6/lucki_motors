<?php 
class Documentacion extends CI_Model {

      /*`iddocumentacion` int(11) NOT NULL AUTO_INCREMENT,
      `nro_documento` varchar(20) DEFAULT NULL,
      `nro_pre_documento` varchar(20) DEFAULT NULL,
      `cliente_razon_social` varchar(100) DEFAULT NULL,
      `cliente_documento` varchar(15) DEFAULT NULL,
      `cliente_direccion` varchar(100) DEFAULT NULL,
      `contacto` varchar(50) DEFAULT NULL,
      `colaborador_idcolaborador` int(11) DEFAULT NULL,
      `texto` text,
      `observacion` varchar(200) DEFAULT NULL,
      `fecha_emision` date DEFAULT NULL,
      `fecha_vencimiento` date DEFAULT NULL,
      `total` decimal(18,2) DEFAULT NULL,
      `serie_comprobante_idserie_comprobante` int(11) DEFAULT NULL,
      `tipo_comprobante_idtipo_comprobante` int(11) DEFAULT NULL,
      `cliente_idcliente` int(11) DEFAULT NULL,
      `tienda_idtienda` int(11) DEFAULT NULL,
      `fecha_creacion` datetime DEFAULT NULL,
      `descuento` decimal(18,2) DEFAULT NULL,
      `estado` enum('vigente','anulado','atendido') DEFAULT 'vigente',*/
    public $iddocumentacion;
    public $nro_documento;
    public $nro_pre_documento;
    public $cliente_razon_social;
    public $cliente_documento;
    public $cliente_direccion;
    public $contacto;
    public $colaborador_idcolaborador;
    public $texto;
    public $observacion;
    public $fecha_emision;
    public $fecha_vencimiento;
    public $serie_comprobante_idserie_comprobante;
    public $tipo_comprobante_idtipo_comprobante;
    public $cliente_idcliente;
    public $tienda_idtienda;
    public $fecha_creacion;
    public $estado; 

    
    public function insert_documentacion()
    {   
     
        $this->nro_pre_documento = '';
        $this->cliente_razon_social = $this->input->post('cliente');
        $this->cliente_direccion = $this->input->post('direccion_cliente');
        
        $this->fecha_emision= $this->input->post('fecha_emision');
        $this->fecha_vencimiento= $this->input->post('fecha_emision');
        $this->fecha_creacion = date('Y-m-d H:i:s');//$this->input->post('fecha_venta');
        $this->cliente_idcliente = $this->input->post('idcliente');
        $this->tienda_idtienda= 1;
        $this->texto = $this->input->post('texto');  
        $this->colaborador_idcolaborador = $this->session->userdata('id_user');
        $this->observacion = $this->input->post('observacion');
        $this->estado = 'vigente';

        return  $this->db->insert('documentacion', $this);
    }

   
    public function get_print_documentacion($iddocumentacion)
    {        
        $this->db->select(" doc.estado as Estado,
                DATE_FORMAT(doc.fecha_creacion, '%Y-%m-%d') as Fecha, 
                doc.cliente_razon_social as Cliente, 
                doc.cliente_documento as 'RUC/DNI',
                doc.cliente_direccion as Direccion,
                col.nombre as Usuario,
                tc.descripcion Comprobante, 
                doc.nro_documento as Nro_documento, 
                doc.observacion as Observacion,
                doc.texto as Texto  ");

        $this->db->from('documentacion doc');
        $this->db->join('tipo_comprobante tc', 'tc.idtipo_comprobante = doc.tipo_comprobante_idtipo_comprobante');
        $this->db->join('colaborador col', 'col.idcolaborador = doc.colaborador_idcolaborador');
        $this->db->where('doc.iddocumentacion',$iddocumentacion);
        $query = $this->db->get();

        return $query->row_array();
    }
       

}

