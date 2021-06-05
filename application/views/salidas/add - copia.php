
<div class="row" id="form" style="padding-left:15px;padding-right:15px;">

  
  <div class="box box-info">     

    <form class="form-horizontal">
      <div class="box-body">
        <input type="hidden" name="tienda" value="1" >   
        <div class="col-md-4">
          <div class="form-group" style="margin-bottom: 0px;">
            <div class="col-sm-4 col-xs-4">
              <label for="fecha_compra" class="control-label">Fecha Compra</label>  
            </div>
            <div class="col-sm-8 col-xs-8">
              <input type="date" class="form-control" id="fecha_compra" name="fecha_compra" value="<?php echo date('Y-m-d');?>" >               
            </div>
          </div>
          <div class="form-group" >
            <div class="col-sm-4 col-xs-4"> 
              <label for="fecha_recepcion" class="control-label">Fecha Recepción</label>  
            </div>
            <div class="col-sm-8 col-xs-8">              
              <input type="date" class="form-control" id="fecha_recepcion" name="fecha_recepcion" value="<?php echo date('Y-m-d');?>" >               
            </div>
          </div>

          <div class="form-group" style="margin-bottom: 0px;">
            <div class="col-sm-4 col-xs-4"> 
              <label for="periodo_pago" class="control-label">Periodo Pago</label>
            </div>
            <div class="col-sm-8 col-xs-8">              
              <select class="form-control" id="idperiodo_pago" name="idperiodo_pago" > 
                  <option value='1' > Contado </option>
                  <option value='2' > Crédito </option>
              </select>            
            </div>
          </div>   
          <div class="form-group" >
            <div class="col-sm-4 col-xs-4"> 
              <label for="fecha_pago" class="control-label">Fecha Pago</label>  
            </div>
            <div class="col-sm-8 col-xs-8">              
              <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" value="<?php echo date('Y-m-d');?>" >             
            </div>
          </div>   
        </div>

        <div class="col-md-5"> 
          <?php echo $get_proveedores; ?>

          <div class="form-group" >
            <div class="col-sm-4 col-xs-4" style="margin-bottom: 0px;"> 
              <label for="idserie" class="control-label">Recepcionado:</label>
            </div>
            <div class="col-sm-8 col-xs-8">              
              <select class="form-control" id="colaborador_recepcion" name="colaborador_recepcion" > 
                  <?php foreach($colaboradores as $cc) {
                    echo "<option value='{$cc->id}' > {$cc->descripcion} </option>";
                  }
                ?>
              </select>               
            </div>
          </div>

        </div>

        <div class="col-md-3"> 

          <div class="form-group" >
            <div class="col-sm-4 col-xs-4" style="margin-bottom: 0px;"> 
              <label for="idserie" class="control-label">Comprobante</label>
            </div>
            <div class="col-sm-8 col-xs-8">              
              <select class="form-control" id="idtipo_comprobante" name="idtipo_comprobante" > 
                  <?php foreach($comprobantes as $tc) {
                    echo "<option value='{$tc->idtipo_comprobante}' > {$tc->tipo_comprobante} </option>";
                  }
                ?>
              </select>               
            </div>
          </div>
          <div class="form-group" style="margin-bottom: 0px;">
            <div class="col-sm-4 col-xs-4"> 
              <label for="nrocomprobante" class="control-label"> Número</label>
            </div>
            <div class="col-sm-8 col-xs-8">              
               <input type="text" class="form-control" id="nrocomprobante" name="nrocomprobante" placeholder="Nro Comprobante" value="0">               
            </div>
          </div>
          <div class="form-group" style="margin-bottom: 0px;">
            <div class="col-sm-4 col-xs-4"> 
              <label for="guia_remision_remitente" class="control-label">Guia Remitente</label>
            </div>
            <div class="col-sm-8 col-xs-8">              
              <input type="text" class="form-control" id="guia_remision_remitente" name="guia_remision_remitente" placeholder="Guia Remitente" value="0">               
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-4 col-xs-4"> 
              <label for="guia_remision_transportista" class="control-label">Guia Transportista</label>
            </div>
            <div class="col-sm-8 col-xs-8">              
              <input type="text" class="form-control" id="guia_remision_transportista" name="guia_remision_transportista" placeholder="Guia Transportista" value="0">              
            </div>
          </div>

        </div>

        <textarea class="form-control" rows="2" placeholder="Observaciones ..." id="observacion" name="observacion"></textarea>

      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <a href="<?php echo base_url('ingresos/lista'); ?>">ir a Lista ingresos</a>
        <button type="button" class="btn btn-success pull-right" id="btn_save" onclick="save()">Guardar</button>

      </div>
      <!-- /.box-footer -->
    </form>
  </div>


    


  <!-- left column -->
  <div class="col-md-12">
    <div class="box box-success">
      <div class="box-header with-border" id="data_detalle">
        
        <?php echo $get_productos; ?>

      </div>
      <div class="box-body">

        <div id="div_detalle">

          <div class="box-body table-responsive no-padding"  id="table_detalle">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>

                  <th>PRODUCTO</th>
                  <th>COD</th>
                  <th>UND</th>
                  <th>CANTIDAD</th>
                  <th>AREA</th>
                </tr>      
              </thead>
              <tbody id="tbody_detalle">    
              </tbody>
            </table>
          </div>
        </div>  
      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <div class="row">

          <div class="col-xs-4">
            <p># Articulos : <span id="cantidadItem">0</span></p>
          </div>
         
          
        </div>
        
        <p><code>F9: Guardar venta</code></p>
        <p><code>Ctrl + B: Busqueda rápida</code></p>
      </div>

    </div>
  </div>

  

</div>

<script type="text/javascript"> base_url = "<?php echo base_url();  ?>"


</script>
