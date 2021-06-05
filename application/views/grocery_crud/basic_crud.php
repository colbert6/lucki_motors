<style type="text/css">
  .anular {
    color: red !important;
  }

  .imprimir {
    color: black !important;
  }

  .guia {
    color: green !important;
  }


</style>

<?php 
foreach($css_files as $file): ?>
  <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
  
 <!-- Default box -->
  
 <?php
  
  $output = isset($output)? $output: 'Tabla no definida';
  $title = isset($title)? $title: 'Titulo';

?>

 

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

