 <!-- Default box -->
  <form class="form-horizontal" >
<div class="row">
    <div class="col-md-4">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">DATOS COMPRA</h3>

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
                      <label class="control-label col-sm-2" for="nrocomprobante">NRO:</label>
                      <div class="col-sm-10">
                        <input type="text" readonly class="form-control" id="nrocomprobante" name="nrocomprobante" value="<?= $compra[0]->nrocomprobante ?>" >
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="proveedor">SR(ES):</label>
                      <div class="col-sm-10">
                          <input type="text" readonly class="form-control" id="proveedor" value="<?= $compra[0]->razon_social ?>" name="proveedor">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="ruc">RUC:</label>
                      <div class="col-sm-10">
                          <input type="text" readonly class="form-control" id="ruc" value="<?= $compra[0]->ruc ?>" name="ruc">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="direccion">DIREC:</label>
                      <div class="col-sm-10">
                        <input type="text" readonly class="form-control" id="direccion" value="<?= $compra[0]->direccion ?>" name="direccion">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="fecha">FECHA:</label>
                      <div class="col-sm-10">
                          <input type="text" readonly class="form-control" id="fecha" value="<?= $compra[0]->fecha ?>" name="fecha">
                      </div>
                    </div>
                
                
                
                <legend>Observaciones</legend>
                    
                <div class="form-group">
                    
                    <div class="col-sm-12">
                        <textarea readonly class="form-control" id="observacion" name="observacion"><?= $compra[0]->observacion ?></textarea>
                    </div>
                  </div>
            </div>
            
            
            <div class="text-center">
                <a type="button" class="btn btn-danger" href="<?php echo base_url('orden_compras/lista'); ?>">Cancelar</a>
            </div>
            <br>
            <!-- /.box-body -->
          <!-- /.box-footer-->
        </div>
    </div>
     <div class="col-md-8">
         <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">PRODUCTOS COMPRADOS</h3>

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
                        <?php foreach ($det_compra as $d): ?>
                        <tr>
                            <td><?= $d->cantidad ?></td>
                            <td><?= $d->descripcion ?></td>
                            <td><?= $d->pc_actual ?></td>
                            <td><?= $d->subtotal ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-right" colspan="3">SUB-TOTAL S/.</th>
                            <th><?= $compra[0]->subtotal ?></th>
                        </tr>
                        
                        <tr>
                            <th class="text-right" colspan="3">TOTAL S/.</th>
                            <th><?= $compra[0]->total ?></th>
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

