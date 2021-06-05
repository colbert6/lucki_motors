<?php 
class Comprobante extends CI_Model {

        public $title;
        public $content;
        public $date;


        public function get_tipo_serie($idserie )
        {
            $tipo_comprobante = $this->db->get_where('serie_comprobante', array('idserie_comprobante' => $idserie ))->row(); 
            return $tipo_comprobante->tipo_comprobante_idtipocomprobante;
        }

        public function update_serie_correlativo($idserie,$campo,$value )
        {
            $this->db->set($campo,$value , FALSE);
            $this->db->where('idserie_comprobante', $idserie);
            return $this->db->update('serie_comprobante');
        }

        public function get_tipo_comprobantes( $idtipocomprobante = '%')
        {
            if( $idtipocomprobante !=  '%') {
                $where = ' idtipo_comprobante IN (';

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
            
            $tipo_comprobante = $this->db->get('tipo_comprobante');
            return $tipo_comprobante->result();
        }

}

