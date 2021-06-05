<?php 
class Det_orden_compra extends CI_Model {

    public $compra_idcompra;
    public $producto_idproducto;
    public $tienda_idtienda;
    public $descripcion;
    public $cantidad;
    public $descuento;
    public $subtotal;
    public $lote;
    public $fecha_vencimiento;
    public $pc_actual;
    public $pv_actual;
    public $pc_anterior;
    public $pv_anterior;
    public $estado;

    
    public function insert_det_compra()
    {   
        $tienda = $this->input->post('tienda');
        $idproductos = $this->input->post('idprod');
        $desc = $this->input->post('prodtext');
        $cant = $this->input->post('cant');
        $pc_actual = $this->input->post('prec_c_act');
        $lt = $this->input->post('lt');
        $venc = $this->input->post('venc');
        $sub = $this->input->post('sub');
        $pc_act = $this->input->post('prec_c_act');
        $pv_act = $this->input->post('prec_v_act');
        $pc_ant = $this->input->post('prec_c_ant');
        $pv_ant = $this->input->post('prec_v_ant');
        
        $cont = count($idproductos);

        for ($i=0; $i < $cont ; $i++) { 
            # code..
            $this->producto_idproducto =  $idproductos[$i];
            $this->tienda_idtienda = $tienda;
            $this->descripcion = $desc[$i];
            $this->cantidad = $cant[$i];
            $this->descuento = 0;
            $this->subtotal = $sub[$i];
            $this->lote =  $lt[$i];
            $this->fecha_vencimiento = $venc[$i];
            $this->pc_actual = $pc_act[$i];
            $this->pv_actual = $pv_act[$i];
            $this->pc_anterior = $pc_ant[$i];
            $this->pv_anterior = $pv_ant[$i];
            $this->estado = 'Activo';

            $this->db->insert('detalle_ordencompra', $this);
        }

    }
    

    public function det_compras_bycompra($id = "")
    {

        $where = "estado='Activo'";
        if($id != ""){
            $where .= "and compra_idcompra = {$id}";
        }
        $this->db->select("*");
        $this->db->from('detalle_ordencompra');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function autogenerate()
    {   
        $this->producto_idproducto =  $this->input->post('idprod');
        $this->tienda_idtienda = $this->input->post('tienda');
        $this->compra_idcompra = $this->input->post('idcompra');
        $this->descripcion = $this->input->post('prodtext');
        $this->estado = 'Activo';
        $this->db->insert('detalle_ordencompra', $this);
        //return  $this->db->insert('venta', $this);
    }
    public function updateDetOrden()
    {        
        $data = array(
            "cantidad" => $this->input->post("cant"),
            "subtotal" => $this->input->post("sub"),
            "pc_actual" => $this->input->post("pc_actual"),
            "pv_actual" => $this->input->post("pv_actual"),
            "pc_anterior" => $this->input->post("pc_anterior"),
            "pv_anterior" => $this->input->post("pv_anterior"),
            "lote" => $this->input->post("lt"),
            "fecha_vencimiento" => $this->input->post("venc")
        );
        $this->db->update("detalle_ordencompra",$data,array("iddetalle_compra"=>$this->input->post("iddetorden")));
    }
    public function deleteDetOrden()
    {        
        $this->db->delete("detalle_ordencompra",array("iddetalle_compra"=>$this->input->post("iddetorden")));
    }
}

