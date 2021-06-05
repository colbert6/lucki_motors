<?php 
class Unidad_medida extends CI_Model {

    public $presentacion_idpresentacion;
    public $producto_idproducto;
    public $cantidad;
    public $precio_compra;
    public $precio_venta;
    public $utilidad;
    public $estado;
    public $fecha_modificacion;

    
    public function insert_unidadmedida()
    {   
        $idproductos = $this->input->post('idprod');
        $pc_act = $this->input->post('prec_c_act');
        $pv_act = $this->input->post('prec_v_act');
        $pc_ant = $this->input->post('prec_c_ant');
        $pv_ant = $this->input->post('prec_v_ant');
        
        $cont = count($idproductos);
        
        for ($i=0; $i < $cont ; $i++) { 
            $producto = $this->db->get_where('producto', array('idproducto' => $idproductos[$i] ))->row(); 
            
            $insert = true;
            if($pv_ant[$i] == $pv_act[$i] && $pc_ant[$i]==$pc_act[$i]){
                $insert = false;
            }
            
            if($insert){

                $this->db->set('estado', 'Inactivo');
                $this->db->where('producto_idproducto', $idproductos[$i] );
                $this->db->update('unidad_medida');
                
                $this->presentacion_idpresentacion = $producto->presentacion_minima;
                $this->producto_idproducto = $idproductos[$i];
                $this->cantidad = 1;
                $this->precio_compra = $pc_act[$i];
                $this->precio_venta = $pv_act[$i];
                $this->utilidad = 0;
                $this->estado = 'Activo';
                $this->fecha_modificacion = date('Y-m-d H:i:s');
            
                $this->db->insert('unidad_medida', $this);
            }
        }
    }
    
    public function insert_byProducto()
    {   
            $id = $this->input->post("idprod");
            
            $producto = $this->db->get_where('unidad_medida', array('producto_idproducto' => $id,'estado'=>'Activo'))->result(); 
          
            if(count($producto)>0){
                $this->db->set('estado', 'Inactivo');
                $this->db->where('producto_idproducto', $id );
                $this->db->update('unidad_medida');

                $this->presentacion_idpresentacion = $producto[0]->presentacion_idpresentacion;
                $this->producto_idproducto = $producto[0]->producto_idproducto;
                $this->cantidad = $producto[0]->cantidad;
                $this->precio_compra = $producto[0]->precio_compra;
                $this->precio_venta =  $this->input->post("precio");
                $this->utilidad = $producto[0]->utilidad;
                $this->estado = 'Activo';
                $this->fecha_modificacion = date('Y-m-d H:i:s');
            }else{
                $producto = $this->db->get_where('producto', array('idproducto' => $id,'estado'=>'Activo'))->result(); 
                $this->presentacion_idpresentacion = $producto[0]->presentacion_minima;
                $this->producto_idproducto = $producto[0]->idproducto;
                $this->cantidad = 1;
                $this->precio_compra = 0;
                $this->precio_venta =  $this->input->post("precio");
                $this->utilidad = 0;
                $this->estado = 'Activo';
                $this->fecha_modificacion = date('Y-m-d H:i:s');
            }
            
            

            $this->db->insert('unidad_medida', $this);
            
        
    }

}

