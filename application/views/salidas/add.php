
<div class="row" id="form" style="padding-left:15px;padding-right:15px;">

  
  <div class="box box-info">     

    <form class="form-horizontal">
      <div class="box-body">
        <input type="hidden" name="tienda" value="1" >   
        <div class="col-md-4">
          <div class="form-group" style="margin-bottom: 0px;">
            <div class="col-sm-4 col-xs-4">
              <label for="fecha_compra" class="control-label">Fecha emision</label>  
            </div>
            <div class="col-sm-8 col-xs-8">
              <input type="date" class="form-control" id="fecha_emision" name="fecha_emision" value="<?php echo date('Y-m-d');?>" >               
            </div>
          </div>
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
               <input type="text" class="form-control" id="nrocomprobante" name="nrocomprobante" placeholder="Nro Comprobante" >               
            </div>
          </div>

            
        </div>

        <div class="col-md-5"> 
          <div class="form-group"  style="margin-bottom: 0px;">
            <div class="col-sm-4 col-xs-4" > 
              <label for="idserie" class="control-label">Motivo</label>
            </div>
            <div class="col-sm-8 col-xs-8">              
              <select class="form-control" id="idmotivo" name="idmotivo" onchange="permitir_ingreso_precio_compra(this)"> 
                  <?php foreach($motivo_movimiento as $mot) {
                    echo "<option value='{$mot->id}' > {$mot->descripcion} </option>";
                  }
                ?>
              </select>               
            </div>
          </div>
          <div class="form-group" style="margin-bottom: 0px;">
            <div class="col-sm-4 col-xs-4">  
              <label for="nombre_recepciona" class="control-label">Quien recepciona</label>
            </div>
            <div class="col-sm-8 col-xs-8">              
              <input type="text" class="form-control" id="nombre_recepciona" name="nombre_recepciona" placeholder="NOMBRE DEL QUE RECEPCIONA" >               
            </div>
          </div>
          <div class="form-group" style="margin-bottom: 0px;">
            <div class="col-sm-4 col-xs-4">  
              <label for="serie" class="control-label">Serie</label>
            </div>
            <div class="col-sm-8 col-xs-8">              
              <input type="text" class="form-control" id="serie" name="serie" placeholder="SERIE" >               
            </div>
          </div>
          <div class="form-group" style="margin-bottom: 0px;">
            <div class="col-sm-4 col-xs-4">  
              <label for="motor" class="control-label">Motor</label>
            </div>
            <div class="col-sm-8 col-xs-8">              
              <input type="text" class="form-control" id="motor" name="motor" placeholder="MOTOR">
            </div>
          </div> 
          <div class="form-group" style="margin-bottom: 0px;">
            <div class="col-sm-4 col-xs-4">  
              <label for="serie" class="control-label">Color</label>
            </div>
            <div class="col-sm-8 col-xs-8">              
              <input type="text" class="form-control" id="color" name="color" placeholder="COLOR" >               
            </div>
          </div>        

        </div>

        <div class="col-md-3"> 

        <textarea class="form-control" rows="4" placeholder="Observaciones ..." id="observacion" name="observacion"></textarea>

        </div>

      </div>
      <!-- /.box-body -->
      <div class="box-footer">
        <a href="<?php echo base_url('salidas/lista'); ?>">ir a Lista salidas</a>
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
                  <th>P.Compra</th>
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
