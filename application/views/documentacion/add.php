<style type="text/css">
  #div_detalle_venta{
    max-height: 350px;
    overflow-y: scroll;  
  }


</style>


<div class="row" id="form">
  <!-- left column -->
  <div class="col-md-4">
    <div class="box box-info">     

      <form class="form-horizontal">
        <div class="box-body">

          <div class="form-group" >
            <label for="fecha_venta" class="col-xs-4 col-sm-2 control-label">Fecha</label>
            <div class="col-xs-8 col-sm-10">
              <input type="date" class="form-control" id="fecha_emision" name="fecha_emision" value="<?php echo date('Y-m-d');?>" readonly="readonly">
            </div>
          </div>

          <div class="form-group">
            <label for="idserie" class="col-sm-2 control-label">Comp.</label>

            <div class="col-sm-10">
              <select class="form-control" id="idserie" name="idserie" onchange="load_datos();"> 
                  <?php foreach($series as $tc) {
                    echo "<option value='{$tc->idserie}' > {$tc->tipo_comprobante} </option>";
                  }
                ?>
              </select>
              <input type="text" class="form-control" id="correlativo" name="correlativo" placeholder="Correlativo" readonly="readonly" value="<?php echo $series[0]->correlativo; ?>">
            </div>
          </div>        

          <?php echo $get_clientes; ?>

          <textarea class="form-control" rows="2" placeholder="Observaciones ..." id="observacion" name="observacion"></textarea>
          

        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          <a href="<?php echo base_url('documentaciones/lista'); ?>">ir a Lista documentos</a>
          <button type="button" class="btn btn-success pull-right" id="btn_save" onclick="save()">Generar</button>

        </div>
        <!-- /.box-footer -->
      </form>
    </div>

  </div>  

  <div class="col-md-8">
    <div class="box box-success">

      <div class="box-header with-border">
        <div class="form-group" >
          <label for="texto" class="col-xs-4 col-sm-2 control-label">Titulo</label>
          <div class="col-xs-8 col-sm-10">
            <input type="text" class="form-control" id="texto" name="texto" >
          </div>
        </div>  
      </div>
     
      <div class="box-body" >

        <div id="div_detalle_documentacion" >
        </div>

      </div>
      <!-- /.box-body -->
      <!--div class="box-footer">
        <button type="button" class="btn btn-success pull-left" id="" >Generar</button>
        <button type="button" class="btn btn-success pull-right" id="" onclick="save()">Generar</button>
      </div-->

    </div>
  </div>

  

</div>

<script type="text/javascript"> base_url = "<?php echo base_url();  ?>"</script>
