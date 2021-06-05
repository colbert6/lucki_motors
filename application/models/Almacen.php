<?php 
class Almacen extends CI_Model {
    

   
    // OTRAS COSAS QUE FALTAN VALIDAR
    public function get_productos_cfilter($tienda=1,$categoria="",$marca="")
    {
        $where_filtro =  "td.estado='Activo' and mr.estado='Activo' and ct.estado = 'Activo' and pro.estado = 'Activo' and td.idtienda = {$tienda} ";
        if( $categoria != ""){
            $where_filtro .= "and ct.idcategoria = {$categoria} ";
        }
        if($marca != ""){
            $where_filtro .= "and mr.idmarca = {$marca} ";
        }

        //$query = $this->db->get('producto', 10);
        $this->db->select("pro.idproducto,
                        pro.marca_idmarca as idmarca,
                        pro.categoria_idcategoria as idcategoria,
                        mr.nombre as marca,
                        ct.nombre as categoria,
                        pro.codbarras,
                        pro.nombre as producto,
                        st.stock_almacen as stock,
                        COALESCE(um.precio_venta,0) as precio ");
        $this->db->from('producto pro');
        $this->db->join('categoria ct','pro.categoria_idcategoria = ct.idcategoria');
        $this->db->join('marca mr','pro.marca_idmarca = mr.idmarca');
        $this->db->join('stock st','pro.idproducto = st.producto_idproducto');
        $this->db->join('tienda td','st.tienda_idtienda = td.idtienda');
        $this->db->join('unidad_medida um',"um.producto_idproducto = pro.idproducto AND um.presentacion_idpresentacion = pro.presentacion_minima AND um.estado ='Activo' ","LEFT");
        $this->db->where($where_filtro);
        $query = $this->db->get();
        return $query->result();

    }

    
    public function get_tienda()
    {
        $this->db->select("*");
        $this->db->from('tienda');
        $this->db->where("estado = 'Activo'");
        $query = $this->db->get();
        return $query->result();  

    }
    public function get_categoria()
    {
        $this->db->select("*");
        $this->db->from('categoria');
        $this->db->where("estado = 'Activo'");
        $query = $this->db->get();
        return $query->result();  

    }
    public function get_marca()
    {
        $this->db->select("*");
        $this->db->from('marca');
        $this->db->where("estado = 'Activo'");
        $query = $this->db->get();
        return $query->result();  

    }
    

}

