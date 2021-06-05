 <!-- Default box -->
  <div class="box">
      <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $title ?> </h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
      </div>
      <div class="box-body" >
          <div class="row">
              <div class="form-group">
                <label for="fecha_control" class="col-sm-2 control-label" id="fecha_consulta">Fecha</label>
                <div class="col-sm-4">

                  <div class="input-group input-lg">
                    <input type="date" class="form-control input-lg" id="fecha_control" value="<?php echo date('Y-m-d');?>">
                    <span class="input-group-addon">
                      <button id="get_control_ventas" type="button" class="btn btn-info" onclick="get_control_ventas()"><i class="fa fa-refresh"></i></button>
                    </span>
                  </div>


                </div>
              </div>
          </div>
      </div>
        <!-- /.box-body -->
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->

  <div class="row">

    <div class="col-md-4 col-sm-6 col-xs-12">
      <div class="info-box bg-green">
        <span class="info-box-icon"><i class="fa fa-money"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">monto en Ventas</span>
          <span class="info-box-number" id="monto_fecha">S/ 0.00</span>

          <div class="progress">
            <div class="progress-bar" style="width: 100%"></div>
          </div>
              <span class="progress-description">
                Del Mes : <span id="monto_fecha_mes"> S/ 0.00</span>
              </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
  </div>

<script type="text/javascript"> base_url = "<?php echo base_url();  ?>"</script>

