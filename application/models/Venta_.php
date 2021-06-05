<?php 
class Venta extends CI_Model {

    public $serie_comprobante_idserie_comprobante;
    public $tipo_comprobante_idtipo_comprobante;
    public $cliente_idcliente;
    public $tienda_idtienda;
    public $cliente_razon_social;
    public $cliente_documento;
    public $cliente_direccion;
    public $nro_documento;
    public $nro_pre_documento;
    public $colaborador_idcolaborador;
    public $fecha_venta;
    public $observacion;
    public $subtotal;
    public $igv;
    public $total;
    public $descuento;
    public $fecha_creacion;
    public $estado;

    
    public function insert_venta()
    {   
        $this->fecha_venta = $this->input->post('fecha_venta');
        $this->serie_comprobante_idserie_comprobante = $this->input->post('idserie');
        $this->tienda_idtienda = $this->input->post('tienda');

        $tipo_comprobante = $this->db->get_where('serie_comprobante', array('idserie_comprobante' => $this->input->post('idserie') ))->row(); 
        $this->tipo_comprobante_idtipo_comprobante = $tipo_comprobante->tipo_comprobante_idtipocomprobante;

        $this->nro_documento = $this->input->post('correlativo');        
        $this->nro_pre_documento = $this->input->post('correlativo');

        $this->igv = $this->input->post('igv');
        $this->subtotal = $this->input->post('subtotales');
        $this->descuento = $this->input->post('descuento');
        $this->total = ($this->input->post('subtotales') - $this->input->post('descuento'));
        
        $this->cliente_idcliente = 1;//FALTA
        $this->cliente_razon_social = $this->input->post('cliente');
        $this->cliente_documento = ($tipo_comprobante->tipo_comprobante_idtipocomprobante == 2 ) ? $this->input->post('ruc_cliente') :$this->input->post('dni_cliente');
        $this->cliente_direccion = $this->input->post('direccion_cliente');
        $this->colaborador_idcolaborador = $this->session->userdata('id_user');//FALTA
        
        $this->observacion = $this->input->post('observacion');     
        
        $this->fecha_creacion = date('Y-m-d H:i:s');
        $this->estado = 'Vigente';

        return  $this->db->insert('venta', $this);
    }

    public function anular_venta($idventa)
    {   
        $this->db->set('estado', 'Anulado');
        $this->db->where('idventa',$idventa);
        $this->db->update('venta');
    }

    public function control($fecha)
    {

        $this->db->select(" COALESCE(SUM(vent.total),0) as total_venta_fecha  ");
        $this->db->from('venta vent');
        $this->db->where('vent.estado','Vigente');
        $this->db->where('DATE_FORMAT(vent.fecha_venta,"%Y-%m-%d") = DATE_FORMAT("'.$fecha.'","%Y-%m-%d")');
        $result[] = $this->db->get()->row();

        $this->db->select(" COALESCE(SUM(vent.total),0) as total_venta_mes  ");
        $this->db->from('venta vent');
        $this->db->where('vent.estado','Vigente');
        $this->db->where('DATE_FORMAT(vent.fecha_venta,"%Y-%m") = DATE_FORMAT("'.$fecha.'","%Y-%m")');
        $result[] = $this->db->get()->row();
      
        return $result;
    }

    public function get_ventas($fecha_inicio,$fecha_fin)
    {   

        $this->db->select("fecha_creacion as Fecha, cliente_razon_social as Cliente, nro_documento as Nro_documento, total as Total ");
        $this->db->from('venta vent');
        $this->db->where('vent.estado="Vigente" AND DATE_FORMAT(vent.fecha_venta,"%Y-%m-%d") BETWEEN DATE_FORMAT("'.$fecha_inicio.'","%Y-%m-%d") AND DATE_FORMAT("'.$fecha_fin.'","%Y-%m-%d")' );
        $this->db->order_by('fecha_creacion','desc');
        $result = $this->db->get()->result_array();        
      
        return $result;
    }

    public function get_detalleventas($fecha_inicio,$fecha_fin)    {   

        $this->db->select("vent.fecha_creacion as Fecha, vent.nro_documento as Nro_documento, dv.descripcion as Producto, cantidad as Cant, precioxpresentacion as Precio, total as Total");
        $this->db->from('venta vent');
        $this->db->join('detalle_venta dv','dv.venta_idventa = vent.idventa');
        $this->db->where('vent.estado="Vigente" AND dv.estado="Activo" AND DATE_FORMAT(vent.fecha_venta,"%Y-%m-%d") BETWEEN DATE_FORMAT("'.$fecha_inicio.'","%Y-%m-%d") AND DATE_FORMAT("'.$fecha_fin.'","%Y-%m-%d")' );
        $this->db->order_by('fecha_creacion','desc');
        $result = $this->db->get()->result_array();        
      
        return $result;
    }

    public function get_ventas_productos($fecha_inicio,$fecha_fin, $order)    {   

        $this->db->select("CONCAT(cat.nombre,' ',mar.nombre,' ',pro.nombre) as Producto,
            SUM(dv.cantidad) Cant_Vendida,
            SUM(dv.subtotal) Monto_Vendido");
        $this->db->from('venta vent');
        $this->db->join('detalle_venta dv','dv.venta_idventa = vent.idventa');
        $this->db->join('producto pro','dv.producto_idproducto = pro.idproducto');
        $this->db->join('categoria cat','cat.idcategoria = pro.categoria_idcategoria');
        $this->db->join('marca mar','mar.idmarca = pro.marca_idmarca');


        $this->db->where('vent.estado="Vigente" AND dv.estado="Activo" AND DATE_FORMAT(vent.fecha_venta,"%Y-%m-%d") BETWEEN DATE_FORMAT("'.$fecha_inicio.'","%Y-%m-%d") AND DATE_FORMAT("'.$fecha_fin.'","%Y-%m-%d")' );
        $this->db->group_by("pro.idproducto");
        $this->db->order_by($order,'desc');

        $result = $this->db->get()->result_array();        
      
        return $result;
    }

    public function venta_byId($idventa)
    {        
        $this->db->select(" vent.estado as Estado,
                tt.descripcion as Tienda,
                vent.fecha_creacion as Fecha, 
                vent.cliente_razon_social as Cliente, 
                vent.cliente_documento as 'RUC/DNI',
                vent.cliente_direccion as Direccion,
                col.nombre as Usuario,
                tc.descripcion Comprobante, 
                vent.nro_documento as Nro_documento, 
                vent.total as Total,
                vent.observacion as Observacion  ");

        $this->db->from('venta vent');
        $this->db->join('tienda tt', 'tt.idtienda = vent.tienda_idtienda');
        $this->db->join('tipo_comprobante tc', 'tc.idtipo_comprobante = vent.tipo_comprobante_idtipo_comprobante');
        $this->db->join('colaborador col', 'col.idcolaborador = vent.colaborador_idcolaborador');
        $this->db->where('vent.idventa',$idventa);
        $query = $this->db->get();

        return $query->row_array();
    }
    
    

}

