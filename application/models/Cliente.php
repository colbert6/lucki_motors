<?php 
class Cliente extends CI_Model {

    public $title;
    public $content;
    public $date;

    
    public function get_cliente($filtro, $valor)
    {   
        $where_filtro = '';
        if( $filtro == 'dni' || $filtro == 'ruc' ){
            $where_filtro = " cli.{$filtro} = '{$valor}' ";
        }if( $filtro == 'nombre' ){
            $where_filtro = " cli.razon_social LIKE '%{$valor}%' OR cli.nombre_comercial LIKE '%{$valor}%' "; ;
        }else{
            $where_filtro = " cli.{$filtro} = '{$valor}' ";
        }

        //$query = $this->db->get('producto', 10);
        $this->db->select("cli.idcliente as idcliente, cli.dni, cli.ruc, cli.razon_social as razon_social, cli.nombre_comercial as nombre_comercial,  cli.direccion as direccion ");
        $this->db->from('cliente as cli');
        $this->db->where('cli.estado','Activo');
        $this->db->where($where_filtro);
        $query = $this->db->get();
        return $query->result();
    }

    


}

