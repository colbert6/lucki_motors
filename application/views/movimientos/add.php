
<div class="row" id="form">
  <!-- left column -->
  <div class="col-md-8">
    <div class="box box-success">
      <div class="box-header with-border">

        <?php echo $get_productos; ?>
        
      </div>
      <div class="box-body">

        <div id="div_detalle_venta">
          <table class="table table-striped" id="table_detalle_venta">
            
            <tbody>   
              <!--DETALLE DE VENTA-->
              
            </tbody>
          </table>
        </div>  
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <div class="row">

          <div class="col-xs-7">
            <p># Articulos : <span id="cantidadItem">0</span></p>
          </div>
          <div class="col-xs-5 ">
            <!--h3 class="box-title" id="text_total_venta" > TOTAL S/. <span id="total_venta">0.00</span></h3-->
            <div class="form-group">
                <h3>TOTAL S/. <span class="total">0.00</span> </h3>
            
            </div>
          </div>  
          
        </div>
        
        <p><code>F9: Guardar movimiento</code></p>
        <p><code>Ctrl + B: Busqueda rápida</code></p>
      </div>

    </div>
  </div>

  <div class="col-md-4">
    <div class="box box-info">     

      <form class="form-horizontal">
        <div class="box-body">
          <div class="form-group">
         
              <label for="fecha" class="control-label col-sm-3">Fecha</label>
         
            <div class="col-sm-9">
              <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo date('Y-m-d');?>" readonly="readonly">
              
            </div>
          </div>
            
          <div class="form-group">
           
              <label for="tienda" class="control-label col-sm-3">Tienda</label>  
            
            <div class="col-sm-9">
              
              <select class="form-control" id="tienda" name="tienda">
           
                <?php foreach ($tiendas as $tienda): ?>
                <option value="<?= $tienda->idtienda ?>"><?= $tienda->descripcion ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
            
          <div class="form-group">
           
              <label for="tienda" class="control-label col-sm-4" style="text-align: left;">Tipo Mov.</label>  
            
              <div class="col-sm-8">
                    <select class="form-control" id="idserie" name="idserie" onchange="get_correlativo();"> 
                        <?php foreach($series as $tc) {
                          echo "<option value='{$tc->idserie}' > {$tc->tipo_comprobante} </option>";
                        }
                      ?>
                    </select> 
                    <input type="text" class="form-control" id="correlativo" name="correlativo" placeholder="Correlativo" readonly="readonly" value="<?php echo $series[0]->correlativo; ?>">
              </div>
          </div>

         
            
          <div class="form-group">
            <label for="idserie" class="col-sm-2 control-label">Total</label>
            
            <div class="col-sm-10">
              <input type="text" class="form-control" id="total" readonly name="total" value="0.00" >
              
            </div>
          </div>

          <textarea class="form-control" rows="2" placeholder="Observaciones ..." id="observacion" name="observacion"></textarea>
          

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <a type="button" class="btn btn-danger" href="<?php echo base_url('movimientos/lista'); ?>">Cancelar</a>
          <button type="button" class="btn btn-success pull-right" id="btn_save" onclick="save()">Guardar</button>

        </div>
        <!-- /.box-footer -->
      </form>
    </div>

  </div>  

</div>
