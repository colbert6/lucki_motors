<?php 
class Ingreso extends CI_Model {

    public $tienda_idtienda;
    public $proveedor_idproveedor;
    public $colaborador_recepcion;
    public $colaborador_registro;
    public $idperiodo_pago;
    public $tipo_comprobante_idtipo_comprobante;
    public $nrocomprobante;
    public $guia_remision_remitente;
    public $guia_remision_transportista;

    public $fecha_compra;
    public $fecha_recepcion;
    public $fecha_pago;

    public $observacion;
    public $subtotal;
    public $igv;
    public $total;
    public $descuento;
    public $fecha_creacion;
    public $estado;
    public $estado_pago;

    
    public function insert_ingreso()
    {   

        $this->tienda_idtienda = 1;
        $this->proveedor_idproveedor = $this->input->post('idproveedor');

        $this->colaborador_recepcion = $this->input->post('colaborador_recepcion');//FALTA
        $this->colaborador_registro = $this->session->userdata('id_user');//FALTA

        $this->idperiodo_pago = $this->input->post('idperiodo_pago');//FALTA
        $this->tipo_comprobante_idtipo_comprobante = $this->input->post('idtipo_comprobante');
        $this->nrocomprobante = $this->input->post('nrocomprobante');
        $this->guia_remision_remitente = $this->input->post('guia_remision_remitente');
        $this->guia_remision_transportista = $this->input->post('guia_remision_transportista');
        $this->observacion = $this->input->post('observacion');

        $this->fecha_compra = $this->input->post('fecha_compra');
        $this->fecha_recepcion = $this->input->post('fecha_recepcion');

        $this->igv = $this->input->post('igv');
        $this->subtotal = $this->input->post('subtotal');
        $this->descuento = $this->input->post('descuento');
        $this->total = ($this->input->post('subtotal') - $this->input->post('descuento') + $this->input->post('igv'));
        
        
        $this->fecha_creacion = date('Y-m-d H:i:s');
        $this->estado = 'vigente';      

        if( $this->input->post('estado_pago') == 'debe' ){
            $this->fecha_pago = 'null';
            $this->estado_pago = $this->input->post('estado_pago');
        }else{            

            if($this->input->post('idperiodo_pago') == 1){
                $this->fecha_pago = date('Y-m-d H:i:s');     
            }else{
                $this->fecha_pago = $this->input->post('fecha_pago');     
            }
                      
            $this->estado_pago ='cancelado' ;
        }


        return  $this->db->insert('ingreso', $this);
    }

    public function edit_ingreso($idingreso)
    {   

        $data = array(
                'subtotal'=> $this->input->post('subtotal'),
                'igv'=> $this->input->post('igv'),
                'descuento'=> $this->input->post('subtotal') +  $this->input->post('igv') - $this->input->post('descuento'),
                'total'=> $this->input->post('total')
        );

        $this->db->where('idingreso', $idingreso);
        $this->db->update('ingreso', $data);
        
        return  $idingreso;
    }

    public function anular_venta($idventa)
    {   
        $this->db->set('estado', 'anulado');
        $this->db->where('idventa',$idventa);
        $this->db->update('venta');
    }

    public function get_ingreso($idmovimiento)
    {        
        
        $this->db->select("
                mov.* ");
        $this->db->from('ingreso mov');
        $this->db->where('mov.idingreso',$idmovimiento);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function get_print($idmovimiento)
    {        
        
        $this->db->select("                

                mov.idingreso as id_ingreso,
                mov.fecha_compra as Fecha_compra, 
                mov.fecha_recepcion as Fecha_recepción, 
                prov.razon_social as proveedor,

                col_reg.nombre as Usuario_registra,
                col_rec.nombre as Usuario_recepciona,
                tc.descripcion Comprobante,

                mov.fecha_creacion as fecha_creacion,

                mov.total as total ");

        $this->db->from('ingreso mov');
        $this->db->join('tipo_comprobante tc', 'tc.idtipo_comprobante = mov.tipo_comprobante_idtipo_comprobante');
        
        $this->db->join('proveedor prov', 'mov.proveedor_idproveedor = prov.idproveedor');
        $this->db->join('colaborador col_reg', 'col_reg.idcolaborador = mov.colaborador_registro');
        $this->db->join('colaborador col_rec', 'col_rec.idcolaborador = mov.colaborador_recepcion');
        $this->db->where('mov.idingreso',$idmovimiento);
        $query = $this->db->get();

        return $query->row_array();
    }


}

