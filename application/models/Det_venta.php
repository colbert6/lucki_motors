<?php 
class Det_venta extends CI_Model {

    public $venta_idventa;
    public $producto_idproducto;
    public $tienda_idtienda;
    public $descripcion;
    public $cantidadxpresentacion;
    public $precioxpresentacion;
    public $cantidad;
    public $descuento;
    public $subtotal;
    public $estado;

    
    public function insert_det_venta()
    {   
        $cont = count($this->input->post('idprod'));

        for ($i=0; $i < $cont ; $i++) { 
            # code..
            $this->producto_idproducto =  $_POST['idprod'][$i];
            $this->tienda_idtienda = $this->input->post('tienda');

            $producto = $this->db->get_where('producto', array('idproducto' => $_POST['idprod'][$i] ))->row(); 
            $this->idpresentacion = $producto->presentacion_minima;
            $this->tipo_producto = $producto->tipo;
            $this->descripcion = $_POST['prodtext'][$i];
            $this->cantidadxpresentacion = 1;

            $this->precioxpresentacion = $_POST['prec'][$i];

            $this->cantidad = $_POST['cant'][$i];

            $this->descuento = 0;
            $this->subtotal = $_POST['prec'][$i] * $_POST['cant'][$i];
            
            $this->estado = 'Activo';

            $this->db->insert('detalle_venta', $this);
        }


    }

    public function det_venta_byId($idventa)
    {        
        $this->db->select("
                        
                        detv.descripcion as descripcion,
                        detv.cantidad as cantidad,
                        detv.precioxpresentacion as 'precio',
                        detv.subtotal as subtotal    ");
        $this->db->from('detalle_venta detv');    

        $this->db->where('detv.venta_idventa',$idventa);
        $query = $this->db->get();

        return $query->result_array();
    }
    

    public function anular_det_venta($idventa)
    {   
        $this->db->set('estado', 'Inactivo');
        $this->db->where('venta_idventa',$idventa);
        $this->db->update('detalle_venta');
    }

    public function cpe_detventa($idventa)
    {    

        /*
        "NIU" as unidad_de_medida,
                  prod.codigo as codigo ,
                  cat.codigo_std as codigo_producto_sunat,
                  detv.descripcion  as descripcion,
                  dvent.cantidad as cantidad,
                  dvent.precio  as valor_unitario,
                  dvent.precio  as precio_unitario,
                  "0" as    descuento,
                  ( dvent.cantidad * dvent.precio )  as subtotal,
                  "8" as tipo_de_igv,
                  "0" as igv,
                  ( dvent.cantidad * dvent.precio )  as total,
                  "false" as anticipo_regularizacion,
                  "" as anticipo_documento_serie,
                  "" as anticipo_documento_numero
        */    
        $this->db->select('


                  IF(tipo_producto = "servicio", "ZZ" ,"NIU" )as unidad_de_medida,
                  detv.producto_idproducto as codigo ,
                  pp.codproducto as codigo_producto_sunat,
                  detv.descripcion  as descripcion,
                  detv.cantidad  as cantidad,
                  (detv.precioxpresentacion )  as valor_unitario,
                  (detv.precioxpresentacion * 1.18)  as precio_unitario,
                  "0" as    descuento,
                  ( detv.cantidad * detv.precioxpresentacion )  as subtotal,
                  "1" as tipo_de_igv,
                  (detv.precioxpresentacion * 1.18) - (detv.precioxpresentacion )   as igv,
                  ( detv.cantidad * detv.precioxpresentacion ) * 1.18  as total,
                  "false" as anticipo_regularizacion,
                  "" as anticipo_documento_serie,
                  "" as anticipo_documento_numero

        ');

        $this->db->from('detalle_venta detv');   
        $this->db->join('producto pp', 'pp.idproducto = detv.producto_idproducto');
        $this->db->where('detv.venta_idventa',$idventa);

        $query = $this->db->get();

        return $query->result_array();
    }

}

