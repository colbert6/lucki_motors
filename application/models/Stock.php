<?php 
class Stock extends CI_Model {

    public $tienda_idtienda;
    public $producto_idproducto;
    public $stock_almacen;
    public $stock_mostrador;
    public $ultimo_ingreso;

    
    public function modificar_stock($movimiento)
    {   
        $cont = count($this->input->post('idprod')); 

        for ($i=0; $i < $cont ; $i++) { 
            $producto = $this->db->get_where('stock', array('tienda_idtienda' => $this->input->post('tienda'),'producto_idproducto' => $this->input->post('idprod')[$i] ))->num_rows(); 
            
            if($producto==0){
                $this->db->insert("stock", array(
                    "tienda_idtienda"=>$this->input->post('tienda'),
                    "producto_idproducto"=>$this->input->post('idprod')[$i],
                    "stock_almacen"=>0,
                    "stock_mostrador"=>0,
                    "ultimo_ingreso"=>date('Y-m-d')
                ));
            }

            $this->db->set('stock_almacen', 'stock_almacen'.$movimiento.$this->input->post('cant')[$i],FALSE);
            $this->db->where('tienda_idtienda', $this->input->post('tienda'));
            $this->db->where('producto_idproducto', $this->input->post('idprod')[$i]);
            $this->db->update('stock');           
        }


        //return  $this->db->insert('venta', $this);
    }

    public function modificar_stock_movimiento($movimiento)
    {   
        $cont = count($this->input->post('idproducto')); 

        for ($i=0; $i < $cont ; $i++) { 

            if($this->input->post('idproducto')[$i] > 0){


            /*$producto = $this->db->get_where('stock', array('tienda_idtienda' => $this->input->post('tienda'),'producto_idproducto' => $this->input->post('idproducto')[$i] ))->num_rows(); 
            
            if($producto==0){
                $this->db->insert("stock", array(
                    "tienda_idtienda"=>$this->input->post('tienda'),
                    "producto_idproducto"=>$this->input->post('idproducto')[$i],
                    "stock_almacen"=>0,
                    "stock_mostrador"=>0,
                    "ultimo_ingreso"=>date('Y-m-d')
                ));
            }

            $this->db->set('stock_almacen', 'stock_almacen'.$movimiento.$this->input->post('cantidad_producto')[$i],FALSE);
            $this->db->where('tienda_idtienda', $this->input->post('tienda'));
            $this->db->where('producto_idproducto', $this->input->post('idproducto')[$i]);
            $this->db->update('stock');*/   
            $nuevo_precio = empty($_POST['precio_unitario_producto'][$i])? 0 : $_POST['precio_unitario_producto'][$i];
            $movimiento_accion = '+';
                if($movimiento =='+'){
                    $this->db->set('und_ingresadas', 'und_ingresadas'.$movimiento_accion.$this->input->post('cantidad_producto')[$i],FALSE);
                }else{
                    $this->db->set('und_salidas', 'und_salidas'.$movimiento_accion.$this->input->post('cantidad_producto')[$i],FALSE);
                }   
                $this->db->set('precio_unitario', $nuevo_precio);       

                $this->db->where('idproducto', $this->input->post('idproducto')[$i]);
                $this->db->update('producto');


            } 

        }


        //return  $this->db->insert('venta', $this);
    }

    public function devolver_stock($tipo , $id)
    {   
        $lista_producto =  array();
        
        if($tipo=='venta anulada'){
            $lista_producto = $this->db->get_where('detalle_venta', array('venta_idventa' =>$id,'estado' =>'Activo'))->result();
            $movimiento = '+';
        }

        foreach ($lista_producto as $key => $value) {

            $this->db->set('stock_almacen', 'stock_almacen'.$movimiento.$value->cantidad,FALSE);
            $this->db->where('tienda_idtienda', $value->tienda_idtienda);
            $this->db->where('producto_idproducto', $value->producto_idproducto);
            $this->db->update('stock');    
        }

        //return  $this->db->insert('venta', $this);
    }

}

