<?php 
class Det_compra extends CI_Model {

    public $compra_idcompra;
    public $producto_idproducto;
    public $tienda_idtienda;
    public $descripcion;
    public $idpresentacion;
    public $cantidadxpresentacion;
    public $precioxpresentacion;
    public $cantidad;
    public $descuento;
    public $subtotal;
    public $lote;
    public $fecha_vencimiento;
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
        
        $cont = count($idproductos);

        for ($i=0; $i < $cont ; $i++) { 
            # code..
            $this->producto_idproducto =  $idproductos[$i];
            $this->tienda_idtienda = $tienda;

            $producto = $this->db->get_where('producto', array('idproducto' => $idproductos[$i] ))->row(); 
            $this->idpresentacion = $producto->presentacion_minima;
            $this->descripcion = $desc[$i];
            $this->cantidadxpresentacion = 1;

            
            // ESTO VARIARA PRECIO DE COMPRA
            $this->precioxpresentacion = $pc_actual[$i];

            $this->cantidad = $cant[$i];

            $this->descuento = 0;
            $this->subtotal = $sub[$i];
            $this->lote =  $lt[$i];
            $this->fecha_vencimiento = $venc[$i];
            
            $this->estado = 'Activo';

            $this->db->insert('detalle_compra', $this);
        }


        //return  $this->db->insert('venta', $this);
    }
    

    public function det_compras_bycompra($id = "")
    {

        $where = "estado='Activo'";
        if($id != ""){
            $where .= "and compra_idcompra = {$id}";
        }
        $this->db->select("*");
        $this->db->from('detalle_compra');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function det_compras_bycompra_print($id = "")
    {
        $this->db->select("
                        
                        detc.descripcion as descripcion,
                        detc.cantidad as cantidad,
                        detc.precioxpresentacion as 'precio',
                        detc.subtotal as subtotal    ");
        $this->db->from('detalle_compra detc');
        $this->db->where("compra_idcompra = {$id}");
        $query = $this->db->get();
        return $query->result_array();
    }
}

