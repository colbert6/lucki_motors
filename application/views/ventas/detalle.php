 
<div class="row" id="detalle-venta">
  <div class="col-md-4">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $title ?></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                      title="Collapse">
                <i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body" >

            <?php foreach ($data_venta as $sub_key => $sub_value): ?>
                <div class="form-group">
                  <label> <?= $sub_key ?> </label>
                  <h5 style="margin: 0px" class="text-center"><?= $sub_value ?></h5>
                </div>
            <?php endforeach ?>
            
        </div>
        
        <!-- /.box-body -->
      <!-- /.box-footer-->
    </div>
  </div>

  <div class="col-md-8">
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title"><?php echo $subtitle ?></h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                      title="Collapse">
                <i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                <i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body" >

          <div class="table-responsive">
            <table class="table table-striped"> 
                <thead>
                    <tr>

                    <?php if( count($data_det_venta)){foreach ($data_det_venta[0] as $key => $value): ?>
                        <th> <?= $key ?> </th>
                    <?php endforeach; } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data_det_venta as $key => $value): ?>
                       <tr> 
                            <?php foreach ($value as $sub_key => $sub_value): ?>
                                <td> <?= $sub_value ?> </td>
                            <?php endforeach ?>      
                       </tr> 
                    <?php endforeach ?> 
                    
                </tbody>

                <?php 
                  $total_campo_suma = 0 ;
                  if(count($data_det_venta) ) : 
                    $total_campo_suma = array_sum(array_column($data_det_venta, 'Importe'));
                  endif;
                ?>

                <tfoot>
                  <tr>                    
                      <th class="text-right" colspan="3"> TOTAL S/.</th>
                      <th><?php echo  number_format($total_campo_suma, 2, '.', ','); ?></th>                     
                  </tr>
                </tfoot> 
                    
            </table>
          </div>    
            
        </div>
        
        <!-- /.box-body -->
      <!-- /.box-footer-->
    </div>
  </div>
</div>
     

  <!-- /.box -->

