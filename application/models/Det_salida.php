<?php 
class Det_salida extends CI_Model {

    public $iddetalle_salida;
    public $codigo_producto;
    public $descripcion_producto;
    public $producto_idproducto;
    public $descripcion_area;
    public $cantidad;    
    public $medida;
    public $salida_idsalida; 
    public $estado;

    
    public function insert_det_salida()
    {   
        $cont = count($this->input->post('nro_item'));

        for ($i=0; $i < $cont ; $i++) { 
            # code..
            $this->codigo_producto = empty($_POST['codigo'][$i])? 0 : $_POST['codigo'][$i];
            $this->descripcion_producto = empty($_POST['productos'][$i])? 'NONE' : $_POST['productos'][$i];
            $this->producto_idproducto = empty($_POST['idproducto'][$i])? 0 : $_POST['idproducto'][$i];
            $this->descripcion_area = empty($_POST['idarea_nombre'][$i])? 'NONE' : $_POST['idarea_nombre'][$i];
            $this->precio_compra =  empty($_POST['precio_compra'][$i])? 0 : $_POST['precio_compra'][$i];
            $this->cantidad =  empty($_POST['cantidad_producto'][$i])? 0 : $_POST['cantidad_producto'][$i];
            $this->medida = empty($_POST['unidad_medida'][$i])? 'UND' : $_POST['unidad_medida'][$i];            
            $this->estado = 'Activo';
            $this->db->insert('detalle_salida', $this);

            
        }


    }

    public function get_print_det_movimiento($idmovimiento)
    {        
        $this->db->select("
                        
                        
                        LPAD(detm.codigo_producto,5,'0') as codigo,
                        detm.descripcion_producto as producto,
                        descripcion_area as area,
                        cantidad, 
                        precio_compra,
                        medida
                           ");
        $this->db->from('detalle_salida detm');   

        $this->db->where('detm.salida_idsalida',$idmovimiento);
        $query = $this->db->get();

        return $query->result_array();
    }
    
  
}

