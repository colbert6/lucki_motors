<?php 
class Envio_cpe extends CI_Model {
  

    
    public function set_error($data)
    {   

        $this->errors =  $data['errors'];
        $this->tipo_envio = $data['tipo_envio'];
        $this->idmaster = $data['idmaster'];
        $this->fecha = $data['fecha'];
        $this->codigo =  $data['codigo'];
        $this->usuario_envio =  $data['usuario_envio'];

        return  $this->db->insert('error_envio_electronico', $this);
    }

    public function set_envio($data)
    {   

        $this->idmaster = $data['idmaster'];
        $this->tipo = $data['tipo'];
        $this->correlativo = $data['correlativo'];
        $this->serie = $data['serie'];
        $this->sunat_description = $data['sunat_description'];
        $this->sunat_note = $data['sunat_note'];
        $this->sunat_responsecode = $data['sunat_responsecode'];
        $this->sunat_soap_error = $data['sunat_soap_error'];
        $this->aceptada_por_sunat = $data['aceptada_por_sunat'];
        $this->usuario_envio = $data['usuario_envio'];
        $this->envio_pse = $data['envio_pse'];
        $this->fecha_envio = $data['fecha_envio'];
        $this->fecha_mod = $data['fecha_mod'];
        $this->estado_envio = $data['estado_envio'];
        $this->tipoenvio = $data['tipoenvio'];
        $this->fecha_emi = $data['fecha_emi'];
        $this->enlace = $data['enlace'];

        return  $this->db->insert('envio_electronico', $this);
    }

    public function set_envio_update($data,$id )
    {   

        $this->db->set($data);
        $this->db->where('id',$id);
        $this->db->update('envio_electronico');

        return  1;
    }

    


}

