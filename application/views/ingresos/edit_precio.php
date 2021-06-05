<style type="text/css">
  tbody>tr>td>input{
    width: 100%;
  }
</style>

<?php

 // print_r($ingreso); die();

?>

<div class="row" id="form">

  <!-- left column -->
  <div class="col-md-12">
    <div class="box box-success">
      <div class="box-body">

        <div id="div_detalle_venta">

          <div class="box-body table-responsive no-padding"  id="table_detalle_ingreso">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th width="5%">COD</th>
                  <th width="5%">UND</th>
                  <th width="20%">PRODUCTO</th>
                  <th width="10%">AREA</th>
                  <th width="5%">CANTIDAD</th>
                  <th width="5%">PRECIO</th>
                  <th width="10%">SUBTOTAL</th>
                  <th width="10%">IGV</th>
                  <th width="10%"> % DESCUENTO</th>
                  <th width="10%">DESCUENTO</th>
                  <th width="10%">TOTAL</th>
                </tr>      
              </thead>
              <tbody id="tbody_detalle_ingreso">   

                <input type="hidden" value="<?= $ingreso['idingreso'] ?>" name="idingreso">  

                <?php foreach ($det_movimiento as $key => $val) : ?>
                <tr class="item" nro_item="<?= $val['iddetalle_ingreso'] ?>"> 

                  <input type="hidden" value="<?= $val['iddetalle_ingreso'] ?>" name="iddetalle_ingreso[]">  

                  <td> 
                    <?= $val['codigo_producto'] ?>
                  </td> 
                  <td> 
                    <?= $val['medida'] ?>
                  </td> 
                  <td>
                   <?= $val['descripcion_producto'] ?>
                  </td> 
                  <td> 
                     <?= $val['descripcion_area'] ?>
                  </td> 
                  <td> 
                    <input type="number" value="<?= $val['cantidad'] ?>" name="cantidad_producto[]" onkeyup="calcular_subtotal_edit(this)" onchange="calcular_subtotal_edit(this)">
                  </td> 
                  <td> 
                    <input type="text" value="<?= $val['precio_unitario'] ?>" name="precio_unitario_producto[]" onkeyup="calcular_subtotal_edit(this)" onchange="calcular_subtotal_edit(this)"> 
                  </td> 
                  <td> 
                    <input type="text" value="<?= $val['subtotal'] ?>" name="subtotal_producto[]" readonly>
                  </td>                      
                  <td> 
                    <input type="checkbox" name="afecto_igv[]" style="width: 10%"
                    <?php if($val['igv_monto']>0){ echo "checked='checked'";}?> onchange="calcular_subtotal_edit(this)"
                    >
                    <input type="text" value="<?= $val['igv_monto'] ?>" name="igv_producto[]"  style="width: 60%"> 
                  </td> 
                  <td> 
                    <input type="text" value="<?= $val['descuento_porcentanje'] ?>" name="porcentaje_descuento_producto[]" onkeyup="calcular_subtotal_edit(this)" onchange="calcular_subtotal_edit(this)"> 
                  </td> 
                  <td> 
                    <input type="text" value="<?= $val['descuento_monto'] ?>" name="descuento_producto[]" readonly> 
                  </td> 
                  <td> 
                      <input type="text" value="<?= number_format($val['subtotal']+ $val['igv_monto']+ $val['descuento_monto'],2,'.','')  ?>" name="total_producto[]" readonly> 
                  </td> 
                  </tr>
                <?php endforeach; ?>

              </tbody>
            </table>
          </div>
        </div>  
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <div class="row">

          <div class="col-xs-3 ">
              <label for="text_total_venta">SUBTOTAL      </label>
              <h3>S/. <span class="subtotal"><?= number_format($ingreso['subtotal'],2,'.','') ?></span></h3>
          </div> 
          <div class="col-xs-3 ">
              <label for="text_total_venta">IGV      </label>
              <h3>S/. <span class="igv"><?= number_format($ingreso['igv'],2,'.','') ?></span></h3>
          </div> 
          <div class="col-xs-3 ">
              <label for="text_total_venta">DESCUENTO      </label>
              <h3>S/. <span class="descuento"><?= number_format($ingreso['descuento'],2,'.','') ?></span></h3>
          </div>  
          <div class="col-xs-3 ">
              <label for="text_total_venta">TOTAL      </label>
              <h3>S/. <span class="total"><?= number_format($ingreso['subtotal']+ $ingreso['igv']+ $ingreso['descuento'],2,'.','')  ?></span></h3>
          </div> 

          <input type="hidden" id="subtotal" name="subtotal" value="<?= number_format($ingreso['subtotal'],2,'.','') ?>">
          <input type="hidden" id="igv" name="igv" value="<?= number_format($ingreso['igv'],2,'.','') ?>">
          <input type="hidden" id="descuento" name="descuento" value="<?= number_format($ingreso['descuento'],2,'.','') ?>">
          <input type="hidden" id="total" name="total" value="<?= number_format($ingreso['subtotal']+ $ingreso['igv']+ $ingreso['descuento'],2,'.','')  ?>">
          
        </div>

        <br>

        <a href="<?php echo base_url('ingresos/lista'); ?>">ir a Lista ingresos</a>
        <button type="button" class="btn btn-success pull-right" id="btn_save" onclick="save_edit()">Guardar</button>

        <br>
        
      </div>

    </div>
  </div>

  

</div>

<script type="text/javascript"> base_url = "<?php echo base_url();  ?>"


</script>
