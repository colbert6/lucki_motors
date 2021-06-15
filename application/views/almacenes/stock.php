<style type="text/css">

  .comprar_stock, .suficiente_stock {
    font-weight: bold;
  }

  .comprar_stock{
    color: red;
  }

  .suficiente_stock{
    color: green; 
  }

  .ver_img{
    cursor: pointer;
  }
  
</style>

 <?php 
foreach($css_files as $file): ?>
  <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
  

 <?php
  
  $output = isset($output)? $output: 'Tabla no definida';
  $title = isset($title)? $title: 'Titulo';
  $tiendas = isset($tiendas)? $tiendas: array();
  $idtienda = isset($idtienda)? $idtienda: '-';

?>


  <div class="box">
      <div class="box-header with-border">
          
        
          <!--div class="form-group">
              <div class="col-xs-4 col-sm-2" ><h3 class="box-title"> <?php echo $title ?> </h3></div>
              <div class="col-xs-8 col-sm-4">  
              <select class="form-control" id="tienda_cf" name="tienda_cf">
                  <?php foreach ($tiendas as $tienda): ?>

                  <?php $selected = ($tienda->idtienda == $idtienda)? 'selected':'' ?>
                  <option value="<?= $tienda->idtienda ?>" <?= $selected ?> ><?= $tienda->descripcion ?></option>
                  <?php endforeach; ?>
              </select>
              </div>
          </div-->


          
      </div>
        <div class="box-body" >
          
          <?php  $notificacion_grocery = $this->session->flashdata('notificacion_grocery');
                if ($notificacion_grocery )  :   ?>
                <div id="report-<?php echo $notificacion_grocery ?>" class="report-div <?php echo $notificacion_grocery ?>" style="display: block;">
                  
                  <p><?php echo $this->session->flashdata('msj_notificacion_grocery') ?></p>
                </div>           
          <?php endif;   ?> 


          <?php echo $output; ?>
        </div>
        <!-- /.box-body -->
    <!-- /.box-footer-->
  </div>
  <!-- /.box -->


<?php foreach($js_files as $file): ?>
    <script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

