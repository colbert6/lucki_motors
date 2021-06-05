<?php 
class Producto extends CI_Model {

               
        public function get_lista()
        {       
                $this->db->select("pro.idproducto as id,  pro.codbarras as codbarra, CONCAT(cat.nombre,' ',mar.nombre,' ',pro.nombre,' ',pres.abreviatura ) as text, COALESCE(med.precio_venta,0) as precio ");
                $this->db->from('producto as  pro');
                $this->db->join('marca as mar', 'mar.idmarca = pro.marca_idmarca');
                $this->db->join('categoria as cat', 'cat.idcategoria = pro.categoria_idcategoria');
                $this->db->join("unidad_medida as med","med.producto_idproducto = pro.idproducto AND med.presentacion_idpresentacion = pro.presentacion_minima AND med.estado = 'Activo' ", 'left');
                $this->db->join('presentacion as pres', 'pres.idpresentacion = pro.presentacion_minima');
                $this->db->where('pro.estado','Activo');
                $this->db->order_by('cat.nombre','asc');
                $query = $this->db->get();
                return $query->result();
        }
        public function get_lista_id($id)
        {       
                $where = "pro.estado = 'Activo' ";
                if($id != ""){
                    $where .="and pro.idproducto = {$id} ";
                }
                $this->db->select("pro.idproducto as id,  pro.codbarras as codbarra, CONCAT(cat.nombre,' ',mar.nombre,' ',pro.nombre) as text,pro.presentacion_minima, COALESCE(med.precio_venta,0) as precio_venta,COALESCE(med.precio_compra,0) as precio_compra,med.fecha_modificacion ");
                $this->db->from('producto as  pro');
                $this->db->join('marca as mar', 'mar.idmarca = pro.marca_idmarca');
                $this->db->join('categoria as cat', 'cat.idcategoria = pro.categoria_idcategoria');
                $this->db->join('unidad_medida as med',"med.producto_idproducto = pro.idproducto AND med.presentacion_idpresentacion = pro.presentacion_minima AND med.estado = 'Activo' ","LEFT");
                $this->db->where($where);
                $query = $this->db->get();
                return $query->result();
        }
        public function get_lista_barras($id)
        {       
                $where = "pro.estado = 'Activo' ";
                if($id != ""){
                    $where .="and pro.codbarras = '{$id}' ";
                }
                $this->db->select("pro.idproducto as id,  pro.codbarras as codbarra, CONCAT(cat.nombre,' ',mar.nombre,' ',pro.nombre) as text,pro.presentacion_minima, COALESCE(med.precio_venta,0) as precio_venta,COALESCE(med.precio_compra,0) as precio_compra,med.fecha_modificacion");
                $this->db->from('producto as  pro');
                $this->db->join('marca as mar', 'mar.idmarca = pro.marca_idmarca');
                $this->db->join('categoria as cat', 'cat.idcategoria = pro.categoria_idcategoria');
                $this->db->join('unidad_medida as med',"med.producto_idproducto = pro.idproducto AND med.presentacion_idpresentacion = pro.presentacion_minima AND med.estado = 'Activo' ","LEFT");
                $this->db->where($where);
                
                $query = $this->db->get();

                return $query->result();
        }
        
        public function get_precios_byProducto($id,$pres_minima,$limit)
        {
                
                $this->db->select("um.*,pre.nombre as presentacion");
                $this->db->from('unidad_medida as  um');
                $this->db->join('presentacion pre', 'um.presentacion_idpresentacion = pre.idpresentacion');
                $this->db->join('producto pro', 'um.producto_idproducto = pro.idproducto');
                $this->db->where("pro.estado = 'Activo' and pre.estado='Activo' and um.producto_idproducto={$id} and um.presentacion_idpresentacion = {$pres_minima}");
                $this->db->order_by("um.fecha_modificacion", "desc");
                $this->db->limit($limit);
                
                $query = $this->db->get();

                return $query->result();
        }
        
       


}

