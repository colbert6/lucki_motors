
 <!-- Default box -->
  <form class="form-horizontal" >
<div class="row">
    <div class="col-md-4">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">DATOS MOVIMIENTO</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                          title="Collapse">
                    <i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body" >
               

                    <div class="form-group">
                      <label class="control-label col-sm-2" for="fecha">FECHA:</label>
                      <div class="col-sm-10">
                          <input type="text" readonly class="form-control" id="fecha" name="fecha" value="<?= $data_movimiento[0]->fecha  ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="tienda">TIENDA:</label>
                      <div class="col-sm-10">
                        <input type="text" readonly class="form-control" id="tienda" name="tienda" value="<?= $data_movimiento[0]->tienda  ?>" >
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="tipo">TIPO:</label>
                      <div class="col-sm-10">
                          <input type="text" readonly class="form-control" id="tipo" value="<?= $data_movimiento[0]->tipo_movimiento  ?>" name="tipo">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="nrocomprobante">NRO:</label>
                      <div class="col-sm-10">
                          <input type="text" readonly class="form-control" id="nrocomprobante" value="<?= $data_movimiento[0]->nrocomprobante  ?>" name="nrocomprobante">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="colaborador">COLAB:</label>
                      <div class="col-sm-10">
                        <input type="text" readonly class="form-control" id="colaborador" value="<?= $data_movimiento[0]->colaborador  ?>" name="colaborador">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="obs">OBS:</label>
                      <div class="col-sm-10">
                        
                        <textarea readonly class="form-control" id="observacion" name="observacion"><?= $data_movimiento[0]->observacion ?></textarea>
                      </div>
                    </div>
            </div>
            
            
            <div class="text-center">
                <a type="button" class="btn btn-danger" href="<?php echo base_url('movimientos/lista'); ?>">Cancelar</a>
            </div>
            <br>
            <!-- /.box-body -->
          <!-- /.box-footer-->
        </div>
    </div>
     <div class="col-md-8">
         <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">PRODUCTOS DETALLADOS</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                          title="Collapse">
                    <i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body" >
                <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>CANT.</th>
                        <th>DESCRIPCION</th>
                        <th>P. UNIT</th>
                        <th>IMPORTE</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data_det_movimiento as $d): ?>
                        <tr>
                            <td><?= $d->cantidad ?></td>
                            <td><?= $d->descripcion ?></td>
                            <td><?= $d->precioxpresentacion ?></td>
                            <td><?= $d->subtotal ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-right" colspan="3">TOTAL S/.</th>
                            <th><?= $data_movimiento[0]->total  ?></th>
                        </tr>
                    </tfoot>
                  </table>

            </div>
            <!-- /.box-body -->
          <!-- /.box-footer-->
        </div>
    </div>
</div>
</form>

  <!-- /.box -->

