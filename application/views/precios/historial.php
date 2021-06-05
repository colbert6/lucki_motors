
 <!-- Default box -->
<form role="form" >

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Buscar producto</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                          title="Collapse">
                    <i class="fa fa-minus"></i></button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                    <i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="box-body" > 
                <div class="col-md-12 col-sm-12">
                    <div class="form-group" id="div_buscar_producto">
                        
                        <?php echo $get_productos; ?>

                    </div>
                </div>            
                
                <div id="table_precios">
                    
                </div>
            </div>
                
            </div>

        </div>
    </div>
</div>      

</form>
