<?php 
class Compra extends CI_Model {

    public $proveedor_idproveedor;
    public $tienda_idtienda;
    public $colaborador_recepcion;
    public $colaborador_registro;
    public $tipo_comprobante_idtipo_comprobante;
    public $nrocomprobante;
    public $guia_remision;
    public $fecha_compra;
    public $fecha_recepcion;
    public $observacion;
    public $total;
    public $igv;
    public $descuento;
    public $subtotal;
    public $fecha_creacion;
    public $estado;

    
    public function insert_compra()
    {   
        $this->colaborador_registro = $this->session->userdata('id_user');
        $this->tienda_idtienda = $this->input->post("tienda");
        $this->fecha_compra = $this->input->post("fecha_compra");
        $this->colaborador_recepcion = $this->input->post("colaborador_almacen");
        $this->fecha_recepcion = $this->input->post("fecha_almacen");
        $this->proveedor_idproveedor = $this->input->post("idproveedor");
        $this->tipo_comprobante_idtipo_comprobante = $this->input->post("tipo_comprobante");
        $this->nrocomprobante = $this->input->post("nro_comprobante_compra") ;
        $this->guia_remision = $this->input->post("guia_remision") ;
        $this->observacion = $this->input->post("obs_compra");
        
        $this->subtotal = $this->input->post("subtotal");
        $this->igv = $this->input->post("igv");
        $this->descuento = $this->input->post("descuento");
        $this->total = $this->input->post("neto_compra");
       
        $this->fecha_creacion = date('Y-m-d H:i:s');
        $this->estado = 'Activo';

        return  $this->db->insert('compra', $this);
    }

    public function compra_byId($id = "")
    {

        $where = "cp.estado='Activo'";
        if($id != ""){
            $where = "cp.idcompra = {$id}";
        }
        $this->db->select("cp.*,t.descripcion tienda, tc.descripcion tipo_comprobante, prov.razon_social, prov.ruc, prov.direccion, col.nombre usu_recepcion, cols.nombre usu_registro");
        $this->db->from('compra cp');
        $this->db->join('tienda t', 'cp.tienda_idtienda = t.idtienda');
        $this->db->join('proveedor prov', 'cp.proveedor_idproveedor = prov.idproveedor');
        $this->db->join('tipo_comprobante tc', 'cp.tipo_comprobante_idtipo_comprobante = tc.idtipo_comprobante');
        $this->db->join('colaborador col', 'col.idcolaborador = cp.colaborador_recepcion');
        $this->db->join('colaborador cols', 'cols.idcolaborador = cp.colaborador_registro');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function get_compras($fecha_inicio,$fecha_fin)
    {   

        $this->db->select(""
                . "vent.fecha_creacion as Fecha, "
                . "pv.razon_social as Proveedor, "
                . "tc.descripcion as Tipo_comprobante, "
                . "vent.nrocomprobante as Nro_documento, "
                . "total as Total ");
        $this->db->from('compra vent');
        $this->db->join("proveedor pv","vent.proveedor_idproveedor = pv.idproveedor");
        $this->db->join("tipo_comprobante tc","vent.tipo_comprobante_idtipo_comprobante = tc.idtipo_comprobante");
        $this->db->where('vent.estado="Activo" AND DATE_FORMAT(vent.fecha_compra,"%Y-%m-%d") BETWEEN DATE_FORMAT("'.$fecha_inicio.'","%Y-%m-%d") AND DATE_FORMAT("'.$fecha_fin.'","%Y-%m-%d")' );
        $this->db->order_by('vent.fecha_creacion','desc');
        $result = $this->db->get()->result_array();        
      
        return $result;
    }

    public function get_detallecompras($fecha_inicio,$fecha_fin)    {   
        
        $this->db->select(""
                . "vent.fecha_creacion as Fecha, "
                . "tc.descripcion as Tipo_comprobante, "
                . "vent.nrocomprobante as Nro_documento, "
                . "dc.descripcion as Producto, "
                . "dc.cantidad as Cantidad, "
                . "dc.precioxpresentacion as Precio, "
                . "dc.subtotal as Total ");
        $this->db->from('compra vent');
        $this->db->join('detalle_compra dc','dc.compra_idcompra = vent.idcompra');
        $this->db->join("tipo_comprobante tc","vent.tipo_comprobante_idtipo_comprobante = tc.idtipo_comprobante");
        $this->db->where('vent.estado="Activo" AND dc.estado="Activo" AND DATE_FORMAT(vent.fecha_compra,"%Y-%m-%d") BETWEEN DATE_FORMAT("'.$fecha_inicio.'","%Y-%m-%d") AND DATE_FORMAT("'.$fecha_fin.'","%Y-%m-%d")' );
        $this->db->order_by('vent.fecha_creacion','desc');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function compra_byId_print($id)
    {

        $this->db->select("cp.*,t.descripcion tienda, tc.descripcion tipo_comprobante, prov.razon_social, prov.ruc, prov.direccion, col.nombre usu_recepcion, cols.nombre usu_registro");
        $this->db->from('compra cp');
        $this->db->join('tienda t', 'cp.tienda_idtienda = t.idtienda');
        $this->db->join('proveedor prov', 'cp.proveedor_idproveedor = prov.idproveedor');
        $this->db->join('tipo_comprobante tc', 'cp.tipo_comprobante_idtipo_comprobante = tc.idtipo_comprobante');
        $this->db->join('colaborador col', 'col.idcolaborador = cp.colaborador_recepcion');
        $this->db->join('colaborador cols', 'cols.idcolaborador = cp.colaborador_registro');
        $this->db->where("cp.idcompra = {$id} ");
        $query = $this->db->get();
        return $query->row_array();
    }

    

}

