<?php 
class Det_ingreso extends CI_Model {

    public $iddetalle_ingreso;
    public $codigo_producto;
    public $descripcion_producto;
    public $producto_idproducto;
    public $descripcion_area;
    public $cantidad;
    public $medida;
    public $precio_unitario;
    public $descuento_porcentanje;
    public $descuento_monto;
    public $igv_monto;
    public $subtotal;
    public $ingreso_idingreso;
    public $tipo_gasto;
    public $estado;

    
    public function insert_det_ingreso()
    {   
        $cont = count($this->input->post('nro_item'));

        for ($i=0; $i < $cont ; $i++) { 
            # code..
            $this->codigo_producto = empty($_POST['codigo'][$i])? 0 : $_POST['codigo'][$i];
            $this->descripcion_producto = empty($_POST['productos'][$i])? 'NONE' : $_POST['productos'][$i];
            $this->producto_idproducto = empty($_POST['idproducto'][$i])? 0 : $_POST['idproducto'][$i];
            $this->descripcion_area = empty($_POST['idarea_nombre'][$i])? 'NONE' : $_POST['idarea_nombre'][$i];
            $this->cantidad =  empty($_POST['cantidad_producto'][$i])? 0 : $_POST['cantidad_producto'][$i];
            $this->medida = empty($_POST['unidad_medida'][$i])? 'UND' : $_POST['unidad_medida'][$i]; 
            $this->precio_unitario = empty($_POST['precio_unitario_producto'][$i])? 0 : $_POST['precio_unitario_producto'][$i];
            $this->descuento_porcentanje = empty($_POST['porcentaje_descuento_producto'][$i])? 0 : $_POST['porcentaje_descuento_producto'][$i];
            $this->descuento_monto = empty($_POST['descuento_producto'][$i])? 0 : $_POST['descuento_producto'][$i];
            $this->igv_monto = empty($_POST['igv_producto'][$i])? 0 : $_POST['igv_producto'][$i];
            $this->subtotal = empty($_POST['subtotal_producto'][$i])? 0 : $_POST['subtotal_producto'][$i];
            $this->tipo_gasto = $this->producto_idproducto>0 ? 'directo' : 'indirecto';           
            
            $this->estado = 'Activo';
            $this->db->insert('detalle_ingreso', $this);
        }


    }

    public function edit_det_ingreso()
    {   
        $cont = count($this->input->post('iddetalle_ingreso'));

        for ($i=0; $i < $cont ; $i++) { 
            # code..
            $data = array(
                'cantidad'=> empty($_POST['cantidad_producto'][$i])? 0 : $_POST['cantidad_producto'][$i], 
                'precio_unitario'=>  empty($_POST['precio_unitario_producto'][$i])? 0 : $_POST['precio_unitario_producto'][$i] ,
                'subtotal'=>  empty($_POST['subtotal_producto'][$i])? 0 : $_POST['subtotal_producto'][$i] ,
                'igv_monto'=>  empty($_POST['igv_producto'][$i])? 0 : $_POST['igv_producto'][$i] ,
                'descuento_porcentanje'=>  empty($_POST['porcentaje_descuento_producto'][$i])? 0 : $_POST['porcentaje_descuento_producto'][$i] ,
                'descuento_monto'=>  empty($_POST['descuento_producto'][$i])? 0 : $_POST['descuento_producto'][$i] 

            );

            $this->db->where('iddetalle_ingreso', $_POST['iddetalle_ingreso'][$i]);
            $this->db->update('detalle_ingreso', $data);
        }


    }

    public function get_detalle_ingreso($idmovimiento)
    {        
        $this->db->select("
                        
                        detm.*     ");
        $this->db->from('detalle_ingreso detm');    

        $this->db->where('detm.ingreso_idingreso',$idmovimiento);
        $query = $this->db->get();

        return $query->result_array();
    }
    

    public function anular_det_venta($idventa)
    {   
        $this->db->set('estado', 'Inactivo');
        $this->db->where('venta_idventa',$idventa);
        $this->db->update('detalle_venta');
    }

    public function get_print_det_movimiento($idmovimiento)
    {        
        $this->db->select("
                        
                        LPAD(detm.codigo_producto,5,'0') as codigo,
                        detm.descripcion_producto as producto,
                                             
                        medida,
                        FORMAT(cantidad,0), 
                        precio_unitario,
                        subtotal,
                        igv_monto,
                        descuento_monto,

                        descripcion_area as area  

                           ");
        $this->db->from('detalle_ingreso detm');   

        $this->db->where('detm.ingreso_idingreso',$idmovimiento);
        $query = $this->db->get();

        return $query->result_array();
    }
    
}

