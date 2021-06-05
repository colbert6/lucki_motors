<?php 
class Det_movimiento extends CI_Model {

    public $movimiento_idmovimiento;
    public $producto_idproducto;
    public $tienda_idtienda;
    public $descripcion;
    public $idpresentacion;
    public $cantidadxpresentacion;
    public $precioxpresentacion;
    public $cantidad;
    public $subtotal;
    public $estado;

    
    public function insert_det_movimiento()
    {   
        $cont = count($this->input->post('idprod'));

        for ($i=0; $i < $cont ; $i++) { 
            # code..
            $this->producto_idproducto =  $_POST['idprod'][$i];
            $this->tienda_idtienda = $this->input->post('tienda');

            $producto = $this->db->get_where('producto', array('idproducto' => $_POST['idprod'][$i] ))->row(); 
            $this->idpresentacion = $producto->presentacion_minima;
            $this->descripcion = $_POST['prodtext'][$i];
            $this->cantidadxpresentacion = 1;
            $this->precioxpresentacion = $_POST['prec'][$i];
            $this->cantidad = $_POST['cant'][$i];
            $this->subtotal = $_POST['prec'][$i] * $_POST['cant'][$i];
            
            $this->estado = 'Activo';

            $this->db->insert('detalle_movimiento', $this);
        }
    }

    public function det_movimiento_bymovimiento($id = "")
    {

        $where = "estado='Activo'";
        if($id != ""){
            $where .= "and movimiento_idmovimiento = {$id}";
        }
        $this->db->select("*");
        $this->db->from('detalle_movimiento');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_print_det_movimiento($idmovimiento)
    {        
        $this->db->select("
                        
                        detm.descripcion as descripcion,
                        detm.cantidad as cantidad,
                        detm.precioxpresentacion as 'precio',
                        detm.subtotal as subtotal    ");
        $this->db->from('detalle_movimiento detm');    

        $this->db->where('detm.movimiento_idmovimiento',$idmovimiento);
        $query = $this->db->get();

        return $query->result_array();
    }
    

    

}

