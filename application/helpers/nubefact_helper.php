<?php


/*public function generar_comprobante_json($id){ //11925->12018

  //FACTURA O BOLETA
  $sql='SELECT
        "generar_comprobante" as operacion,
        tipo_comp.codigo_nubefact as tipo_de_comprobante, -- 1 factura  2 boleta 3 3 = NOTA DE CRÉDITO   4 = NOTA DE DÉBITO
        (SUBSTRING(venta.numero_documento, 1, 4) as serie, -- serie
        (SUBSTRING(venta.numero_documento, 6, 8) * 1) as numero, -- correlativo solo numero
        "1" as sunat_transaction, 

        IF( LENGTH(clientes.ruc) = 11, 6 , 1) AS cliente_tipo_de_documento,-- documento ruc 1
        IF( LENGTH(clientes.ruc) = 11, clientes.ruc, clientes.dni) AS cliente_numero_de_documento, -- dni

        clientes.razon_social as cliente_denominacion,
        CONVERT(clientes.direccion USING utf8) as cliente_direccion,
        COALESCE(clientes.correo, "") as cliente_email,
        "" as cliente_email_1,
        "" as cliente_email_2,
        DATE_FORMAT( venta.fecha,"%d-%m-%Y") as fecha_de_emision, -- ventas.fecha
        "" as fecha_de_vencimiento, -- DATE_FORMAT(NOW(),"%d-%m-%Y")
        "1" as moneda ,-- 1 es soles 2 dolares 3 euros
        "" as tipo_de_cambio,
        "18.00" as porcentaje_de_igv,
        "" as descuento_global,
        "" as descuento_global,                  
        "" as total_descuento,                  
        "" as total_anticipo,                  
        "" as total_gravada,
        "" as total_inafecta,
        venta.total  as total_exonerada,
        "0" as total_igv,
        "" as total_gratuita,
        "" as total_otros_cargos,
        venta.total  AS total,
        "" as percepcion_tipo,
        "" as percepcion_base_imponible,
        "" as total_percepcion,
        "" as total_incluido_percepcion,
        "false" as detraccion,
        "" as observaciones,
        "" as documento_que_se_modifica_tipo,
        "" as documento_que_se_modifica_serie,
        "" as documento_que_se_modifica_numero,
        "" as tipo_de_nota_de_credito,
        "" as tipo_de_nota_de_debito,
        "true" as enviar_automaticamente_a_la_sunat,
        "false" as enviar_automaticamente_al_cliente,
        "" as codigo_unico,
        "" as condiciones_de_pago,
        "" as medio_de_pago,
        "" as placa_vehiculo,
        "" as orden_compra_servicio,
        "" as tabla_personalizada_codigo,
        "TICKET" as formato_de_pdf

    FROM  ventas as venta
    INNER JOIN tipo_comprobantes as tipo_comp ON tipo_comp.id = venta.tipo_comprobante
    LEFT JOIN clientes on clientes.id=venta.idcliente

    WHERE venta.id = '.$id;

  $data= $this->db->query($sql)->row_array();
      $data_json =json_encode($data);
  return $data_json;exit();

  if( count($data) ) {

       $sql_d='SELECT
              "NIU" as unidad_de_medida,
              medicamentos.codigo as codigo ,
              CONCAT(medicamentos.nombre_producto," (",laboratorios.nombre,")" )  as descripcion,
              det_ventas.cantidad as cantidad,
              det_ventas.precio_producto  as valor_unitario,
              det_ventas.precio_producto  as precio_unitario,
              "0" as    descuento,
              det_ventas.precio_total  as subtotal,
              "8" as tipo_de_igv,
              "0" as igv,
              det_ventas.precio_total as total,
              "false" as anticipo_regularizacion,
              "" as anticipo_documento_serie,
              "" as anticipo_documento_numero

          FROM    ventas
          INNER JOIN  det_ventas ON ventas.id=det_ventas.idventa
          INNER JOIN  almacenes ON det_ventas.id_prod_almacen=almacenes.id_prod_almacen
          INNER JOIN  medicamentos ON medicamentos.id=almacenes.idmedicamento
          INNER JOIN laboratorios on medicamentos.idlaboratorio=laboratorios.id

          WHERE  ventas.id = '.$id;

          $data_d = $this->db->query($sql_d)->result_array();
          $data["items"]= $data_d;

          $data_json =json_encode($data);

  }else{
      $data_json = array();
  }
 

  return $data_json;
}*/

function envio_json($data_json){
  $ruta = "https://api.nubefact.com/api/v1/7c92877b-af51-4d0d-9864-4c6353564ed3";
  $token = "77c4d732e0794f5e883d141b6c7af55080f917be1eb64b66947a346d158208de";

  $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $ruta);
          curl_setopt(
              $ch, CURLOPT_HTTPHEADER, array(
              'Authorization: Token token="'.$token.'"',
              'Content-Type: application/json',
              )
          );
          curl_setopt($ch, CURLOPT_POST, 1);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $respuesta  = curl_exec($ch);
          curl_close($ch);

          $leer_respuesta = json_decode($respuesta, true);

  return $leer_respuesta;
}




?>