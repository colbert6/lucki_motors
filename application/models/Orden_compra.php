<?php 
class Orden_Compra extends CI_Model {

    public $proveedor_idproveedor;
    public $tienda_idtienda;
    public $nrocomprobante;
    public $fecha;
    public $observacion;
    public $total;
    public $correlativo;
    public $subtotal;
    public $fecha_creacion;
    public $autogenerado;
    public $modificado;
    public $estado;

    
    public function insert_compra()
    {   
        $this->tienda_idtienda = $this->input->post("tienda");
        $this->fecha = $this->input->post("fecha_compra");
        $this->proveedor_idproveedor = $this->input->post("idproveedor");
        
        $this->observacion = $this->input->post("obs_compra");
        
        $this->subtotal = $this->input->post("subtotal");
        $this->total = $this->input->post("subtotal");
       
        $this->fecha_creacion = date('Y-m-d H:i:s');
        
        $this->estado = 'Activo';
        
        
        
        // ASIGNACION DE CORRELATIVO
        $cor = $this->get_correlativo();
        if(count($cor)>0){
            $this->correlativo = $cor[0]->correlativo+1;
        }else{
            $this->correlativo = 1;
        }
        
        $this->nrocomprobante = "ORD-".$this->correlativo ;
        $this->autogenerado = "NO";
        $this->modificado = "NO";
        

        return  $this->db->insert('orden_compra', $this);
    }

    public function compra_byId($id = "")
    {

        $where = "cp.estado='Activo'";
        if($id != ""){
            $where = "cp.idcompra = {$id}";
        }
        $this->db->select("cp.*,t.descripcion tienda,prov.razon_social,prov.ruc,prov.direccion");
        $this->db->from('orden_compra cp');
        $this->db->join('tienda t', 'cp.tienda_idtienda = t.idtienda');
        $this->db->join('proveedor prov', 'cp.proveedor_idproveedor = prov.idproveedor');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_compras($fecha_inicio,$fecha_fin)
    {   

        $this->db->select(""
                . "vent.fecha_creacion as Fecha, "
                . "pv.razon_social as Proveedor, "
                . "vent.nrocomprobante as Nro_documento, "
                . "total as Total ");
        $this->db->from('orden_compra vent');
        $this->db->join("proveedor pv","vent.proveedor_idproveedor = pv.idproveedor");
        $this->db->where('vent.estado="Activo" AND DATE_FORMAT(vent.fecha_compra,"%Y-%m-%d") BETWEEN DATE_FORMAT("'.$fecha_inicio.'","%Y-%m-%d") AND DATE_FORMAT("'.$fecha_fin.'","%Y-%m-%d")' );
        $this->db->order_by('vent.fecha_creacion','desc');
        $result = $this->db->get()->result_array();        
      
        return $result;
    }

    public function get_detallecompras($fecha_inicio,$fecha_fin)    {   
        
        $this->db->select(""
                . "vent.fecha_creacion as Fecha, "
                . "vent.nrocomprobante as Nro_documento, "
                . "dc.descripcion as Producto, "
                . "dc.cantidad as Cantidad, "
                . "dc.precioxpresentacion as Precio, "
                . "dc.subtotal as Total ");
        $this->db->from('orden_compra vent');
        $this->db->join('detalle_ordencompra dc','dc.compra_idcompra = vent.idcompra');
        $this->db->where('vent.estado="Activo" AND dc.estado="Activo" AND DATE_FORMAT(vent.fecha_compra,"%Y-%m-%d") BETWEEN DATE_FORMAT("'.$fecha_inicio.'","%Y-%m-%d") AND DATE_FORMAT("'.$fecha_fin.'","%Y-%m-%d")' );
        $this->db->order_by('vent.fecha_creacion','desc');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function get_correlativo()
    {        
        $this->db->select("*");
        $this->db->from('orden_compra');
        $this->db->order_by("fecha_creacion","desc");
        $this->db->limit("1");
        $query = $this->db->get();
        return $query->result();
    }
    
    
    public function autogenerate()
    {
        $this->correlativo = $this->input->post("corr");
        $this->nrocomprobante = $this->input->post("nrocomp") ;
        $this->fecha_creacion = date('Y-m-d H:i:s');
        $this->autogenerado = "SI";
        $this->modificado = "NO";
        $this->estado = 'Activo';
        return  $this->db->insert('orden_compra', $this);
    }
    public function get_autogenerate()
    {        
        $this->db->select("*");
        $this->db->from('orden_compra');
        $this->db->where("estado='Activo' and autogenerado='SI' and modificado='NO'");
        $this->db->order_by("fecha_creacion","desc");
        $this->db->limit("1");
        $query = $this->db->get();
        return $query->result();
    }
    
    public function updateOrden()
    {        
        $data = array(
            "tienda_idtienda" => $this->input->post("tienda"),
            "proveedor_idproveedor" => $this->input->post("idproveedor"),
            "observacion" => $this->input->post("obs_compra"),
            "total" => $this->input->post("subtotal"),
            "subtotal" => $this->input->post("subtotal"),
            "fecha" => $this->input->post("fecha_compra"),
            "modificado" => "SI",
        );
        $this->db->update("orden_compra",$data,array("idcompra"=>$this->input->post("idorden")));
    }
    public function deleteOrden(){
        $id = $this->input->post("id");
        $where = array(
            "idcompra"=>$id,
            "estado"=>"Activo",
            "modificado"=>"NO"
        );
        $query = $this->db->get_where("orden_compra",$where)->result();
        
        if(count($query)>0){
            $this->db->delete("orden_compra",array("idcompra"=>$id));
        }
    }
    
    
    public function get_id()
    {
        $this->db->select("*");
        $this->db->from('orden_compra');
        $this->db->where("nrocomprobante='".$this->input->post("cod")."' and estado='Activo'");
        $query = $this->db->get();
        return $query->result();
    }
    
    public function finishOrden()
    {        
        $data = array(
            "estado" => "Concluido",
        );
        $this->db->update("orden_compra",$data,array("idcompra"=>$this->input->post("idorden")));
    }
   
}

