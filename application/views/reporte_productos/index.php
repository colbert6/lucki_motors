
  
 <!-- Default box -->
  <div class="box">
      <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $title; ?> </h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
      </div>
      <div class="box-body">
        <div class="col-md-3">
          <div class="form-group">
            <label for="fecha_inicio">Fecha Inicio</label>
            <input type="date" class="form-control" id="fecha_inicio" value="<?php echo date('Y-m-d');?>" >
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="fecha_inicio">Fecha Fin</label>
            <input type="date" class="form-control" id="fecha_fin" value="<?php echo date('Y-m-d');?>" >
          </div>
        </div>
        
        <div class="col-md-3">
          <div class="form-group">
            <label for="fecha_fin">Tipo</label>
            <select class="form-control" id="tipo_reporte">
              <option value="Monto_Vendido" >Top Monto</option>
              <option value="Cant_Vendida" >Top Rotación</option>
            </select>
          </div>          
        </div>
        <div class="col-md-3">
          <br>
          <div class="form-group">
            <button type="button" class="btn btn-primary" onclick="cargar_reporte()">Generar</button>
          </div>
        </div>

        <br>

        <div class="col-md-12 table-responsive" id="conten_reporte">
         
        </div> 
     
      </div>
      <!-- /.box-body -->
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->

<script type="text/javascript"> base_url = "<?php echo base_url();  ?>"</script>