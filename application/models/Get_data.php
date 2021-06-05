<?php 
class Get_data extends CI_Model {


    
    public function get_clientes($valor)
    {   
        $where_filtro = " ( cli.dni LIKE '{$valor}%' OR cli.ruc LIKE '{$valor}%' OR cli.razon_social LIKE '%{$valor}%' OR cli.nombre_comercial LIKE '%{$valor}%' ) ";

        //$query = $this->db->get('producto', 10);
        $this->db->select("cli.idcliente as idcliente, cli.dni, cli.ruc, cli.razon_social as razon_social, cli.nombre_comercial as nombre_comercial,  cli.direccion as direccion ");
        $this->db->from('cliente as cli');
        $this->db->where('cli.estado','Activo');
        $this->db->where($where_filtro);
        $this->db->order_by(' cli.razon_social ');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_proveedores($valor)
    {   
        $where_filtro = " ( pro.ruc LIKE '{$valor}%' OR pro.razon_social LIKE '%{$valor}%' OR pro.nombre_comercial LIKE '%{$valor}%' ) ";

        //$query = $this->db->get('producto', 10);
        $this->db->select("pro.idproveedor as idproveedor , pro.ruc, pro.razon_social as razon_social, pro.nombre_comercial as nombre_comercial,  pro.direccion as direccion ");
        $this->db->from('proveedor as pro');
        $this->db->where('pro.estado','Activo');
        $this->db->where($where_filtro);
        $this->db->order_by(' pro.razon_social ');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_cliente_document($tipo,$doc)
    {   
        $where_filtro = " ( cli.{$tipo} = '{$doc}' ) ";

        //$query = $this->db->get('producto', 10);
        $this->db->select("cli.idcliente as idcliente, cli.dni, cli.ruc, cli.razon_social as razon_social, cli.nombre_comercial as nombre_comercial,  cli.direccion as direccion ");
        $this->db->from('cliente as cli');
        $this->db->where('cli.estado','Activo');
        $this->db->where($where_filtro);
        $this->db->order_by(' cli.razon_social ');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_productos($valor, $filtro = '')
    {   
        if( $filtro =='codbarras'){
            $where_filtro = " ( pro.codbarras = '{$valor}' ) ";
        }else{
            $where_filtro = " ( cat.nombre LIKE '%{$valor}%' OR mar.nombre LIKE '%{$valor}%' OR pro.nombre LIKE '%{$valor}%' ) ";
        }   
        
        //CONCAT(cat.nombre,' ',mar.nombre,' ',pro.nombre,' S/.', COALESCE(med.precio_venta,0) ) as texto
        // CONCAT(cat.nombre,' ',mar.nombre,' ',pro.nombre) as producto
        // COALESCE('(',pre.descripcion,') ',0)
        $this->db->select("pro.idproducto as idproducto, CONCAT( pro.nombre, ' (',COALESCE(pre.abreviatura,''),') ',' S/.', COALESCE(med.precio_venta,0) ) as texto,  , CONCAT(pro.nombre) as producto, pro.presentacion_minima, COALESCE(med.precio_venta,0) as precio_venta ");
        $this->db->from('producto as  pro');
        $this->db->join('marca as mar', 'mar.idmarca = pro.marca_idmarca');
        $this->db->join('categoria as cat', 'cat.idcategoria = pro.categoria_idcategoria');
        $this->db->join('unidad_medida as med',"med.producto_idproducto = pro.idproducto AND med.presentacion_idpresentacion = pro.presentacion_minima AND med.estado = 'Activo' ","LEFT");
        $this->db->join('presentacion as pre',"pro.presentacion_minima = pre.idpresentacion ","LEFT");
        $this->db->where('pro.estado','Activo');
        
        if($valor !=''){
            $this->db->where($where_filtro);
        }        
        
        $query = $this->db->get();
        return $query->result();
    }

    public function get_productos_directo($valor, $filtro = '')
    {   
        if( $filtro =='codbarras'){
            $where_filtro = " ( pro.codbarras = '{$valor}' ) ";
        }else{
            $where_filtro = " (codproducto LIKE '%{$valor}%' OR pro.nombre LIKE '%{$valor}%' ) ";
        }   
        
        //CONCAT(cat.nombre,' ',mar.nombre,' ',pro.nombre,' S/.', COALESCE(med.precio_venta,0) ) as texto
        // CONCAT(cat.nombre,' ',mar.nombre,' ',pro.nombre) as producto
        // COALESCE('(',pre.descripcion,') ',0)
        $this->db->select("pro.idproducto as idproducto, pro.codproducto as codigo, pro.nombre as texto, pre.abreviatura as unidad_medida, pre.idpresentacion as idpresentacion, pro.area_idarea as idarea, pro.precio_unitario as precio_unitario_producto ");
        $this->db->from('producto as  pro');
        $this->db->join('unidad_medida as med',"med.producto_idproducto = pro.idproducto AND med.presentacion_idpresentacion = pro.presentacion_minima AND med.estado = 'Activo' ","LEFT");
        $this->db->join('presentacion as pre',"pro.presentacion_minima = pre.idpresentacion ","LEFT");
        $this->db->where('pro.estado','Activo');
        
        if($valor !=''){
            $this->db->where($where_filtro);
        }        
        
        $query = $this->db->get();
        return $query->result();
    }

    

    public function get_series($idtipocomprobante = '%')//segun el tipo de comprobante
    {
        $this->db->select("serie.idserie_comprobante as idserie, tipo_comp.idtipo_comprobante, tipo_comp.abreviatura, tipo_comp.descripcion as tipo_comprobante, CONCAT( serie.serie,'-',serie.correlativo ) as correlativo ");
        $this->db->from('tipo_comprobante as tipo_comp');
         $this->db->join('serie_comprobante as serie', 'tipo_comp.idtipo_comprobante = serie.tipo_comprobante_idtipocomprobante');
        $this->db->where('serie.estado','Activo');
        $this->db->where('tipo_comp.estado','Activo');

        if( $idtipocomprobante !=  '%') {
            $where = ' tipo_comp.idtipo_comprobante IN (';

            if(is_array($idtipocomprobante)){

                foreach ($idtipocomprobante as $key => $value) {
                    $where .= $value.',';
                }                    
            }else{

                $where .= $idtipocomprobante.',';
            }
            $where = substr($where, 0, -1);
            $where .= ')';
            $this->db->where($where);
        }             
        
        $query = $this->db->get();
        return $query->result();
    }

    public function get_tipocomprobantes($idtipocomprobante = '%')//segun el tipo de comprobante
    {
        $this->db->select("tipo_comp.idtipo_comprobante, tipo_comp.abreviatura, tipo_comp.descripcion as tipo_comprobante ");
        $this->db->from('tipo_comprobante as tipo_comp');
        $this->db->where('tipo_comp.estado','Activo');

        if( $idtipocomprobante !=  '%') {
            $where = ' tipo_comp.idtipo_comprobante IN (';

            if(is_array($idtipocomprobante)){

                foreach ($idtipocomprobante as $key => $value) {
                    $where .= $value.',';
                }                    
            }else{

                $where .= $idtipocomprobante.',';
            }
            $where = substr($where, 0, -1);
            $where .= ')';
            $this->db->where($where);
        }             
        
        $query = $this->db->get();
        return $query->result();
    }

    public function get_correlativo($idserie)
    {
        //$query = $this->db->get('producto', 10);
        $this->db->select(" CONCAT( serie.serie,'-',serie.correlativo ) as correlativo , serie.titulo  ");
        $this->db->from('serie_comprobante as serie');
        $this->db->where('serie.idserie_comprobante',$idserie);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_tipo_pagos($id = '%')
    {
        //$query = $this->db->get('producto', 10);
        $this->db->select(" idtipo_pago as id, descripcion, abreviatura ");
        $this->db->from('tipo_pago as tp');
        if( $id != '%'){
            $this->db->where('tp.idtipo_pago',$id);
        }
        $this->db->where('tp.estado','Activo');
        
        $query = $this->db->get();
        return $query->result();
    }

    public function get_periodo_pagos($id = '%')
    {
        $this->db->select(" idperiodo_pago as id, descripcion, abreviatura ");
        $this->db->from('periodo_pago as pp');

        if( $id != '%'){
            $this->db->where('pp.idperiodo_pago',$id);
        }
        $this->db->where('pp.estado','Activo');

        $query = $this->db->get();
        return $query->result();
    }

    public function get_areas($id = '%')
    {
        $this->db->select(" idarea as id, nombre as descripcion, colaborador_idcolaborador as  idcolaborador");
        $this->db->from('area as aa');

        if( $id != '%'){
            $this->db->where('aa.idarea',$id);
        }
        $this->db->where('aa.estado','Activo');

        $query = $this->db->get();
        return $query->result();
    }

    public function get_colaboradores($id = '%')
    {
        $this->db->select(" idcolaborador as id, nombre as descripcion ");
        $this->db->from('colaborador as col');

        if( $id != '%'){
            $this->db->where('col.idcolaborador',$id);
        }
        $this->db->where('col.estado','Activo');

        $query = $this->db->get();
        return $query->result();
    }


    public function get_datos_documentacion($idserie)
    {
        
        $this->db->select(" dat.iddato, dat.descripcion, dd.priority as orden, dat.tipo, dat.abreviatura, dat.validacion, COALESCE(dd.valor,'') as valor ");

        $this->db->from('datos_documentacion as dd');
        $this->db->join('dato as dat', 'dd.iddato = dat.iddato');
        $this->db->where('dat.estado','vigente');
        $this->db->where('dd.iddocumento',$idserie);

        $this->db->order_by(' orden ASC');

        $query = $this->db->get();

        return $query->result();
    }

    public function get_motivo_movimiento($id = '%' , $tipo = '%')
    {
        $this->db->select(" idmotivo as id, descripcion as descripcion , tipo  ");
        $this->db->from('motivo_movimiento as mot');

        if( $id != '%'){
            $this->db->where('mot.idmotivo',$id);
        }
        if( $id != '%'){
            $this->db->where('mot.tipo',$tipo);
        }
        $this->db->where('mot.estado','Activo');

        $query = $this->db->get();
        return $query->result();
    }






}

