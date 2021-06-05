
  
 <!-- Default box -->
  <div class="box">
      <div class="box-header with-border">
          <h3 class="box-title"> <?php echo $title ?>  <?php echo $perfil->nombre ?>  </h3>

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
          <?php foreach ($modulos as $kp => $padre) : ?>
          <div class="col-md-12 ">
            
                  
            <label ><?php echo $padre->modulo ?></label> 
            <div class="col-md-12">
            <?php foreach ($padre->hijos as $kh => $hijos) : ?>
            
              <div class="input-group">
                    <span class="input-group-addon" value="accion">
                      <input type="checkbox" <?php echo ($hijos->estado)?"checked":"";?> >
                    </span>
                <input type="text" class="form-control" value="<?php echo $hijos->modulo ?>">
              </div>              
            
            <?php endforeach; ?> 
            </div> 
          </div>  
          <?php endforeach; ?>  
            


          <!-- /.col-lg-6 -->
        </div>   
      </div>
        <!-- /.box-body -->
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->

