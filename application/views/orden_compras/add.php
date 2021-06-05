<div class="row">
  
 <div class="form-horizontal" id="form-compras">
  <div class="col-md-12">
    
      <div class="box box-info">
          
        
          
            <div class="box-header with-border">
              <h3 class="box-title">ORDEN DE COMPRA</h3>
            </div>
            <div class="box-body">

          
                <div class="box-body">
                  
                    <div class="row">
                        <div class="col-md-4">
                            
                            <div class="form-group">
                             <label for="inputPassword3" class="control-label">Tienda:</label>


                                 <select class="form-control" id="tienda" name="tienda">
                                  <option value="">Seleccione..</option>
                                 <?php foreach ($tiendas as $tienda): ?>
                                 <option selected value="<?= $tienda->idtienda ?>"><?= $tienda->descripcion ?></option>
                                 <?php endforeach; ?>
                               </select>


                          </div> 
                         </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputPassword3" class="control-label"> # Comprobante:  </label>

                                <input class="form-control" id="nro_comprobante_compra" name="nro_comprobante_compra" placeholder="N° Comprobante" readonly>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="inputEmail3" class="control-label">Fecha:</label>
                                 <input type="date" class="form-control" id="fecha_compra" name="fecha_compra" value="<?php echo date('Y-m-d');?>" >

                            </div>
                    
                        </div>
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputEmail3" class="control-label">Proveedor:</label>
                                <select class="form-control" id="idproveedor" name="idproveedor" onchange="asignaNroDoc()" >
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputEmail3" class="control-label">RUC Proveedor:</label>
                                <input type="text" class="form-control" id="numdoc_proveedor" placeholder="RUC" readonly="readonly">
                              </div> 
                        </div>
                    </div>
                    
                    
                     
                    
                    
                    
                    
                    
                    
                     
                    
                    
                   
                    
                    <div class="form-group">
                        <label for="inputEmail3" class="control-label">Observacion:</label>

                            <textarea class="form-control" id="obs_compra" name="obs_compra"></textarea>
                      
                      </div>


                </div>
                

      </div>
      <!-- /.box-body -->
    </div>
  </div>  
    
    
    <div class="col-md-12">
    
      <div class="box box-warning">
          
        
          
            <div class="box-header with-border">
              <h3 class="box-title">PRODUCTOS ENTRANTES</h3>
            </div>
            <div class="box-body">

          
                <div class="box-body">
                  

                    <div class='col-sm-6'>
                        <!--div class="form-group">
                        <label for="inputPassword3" class="control-label">Nombre del Producto </label>

                        <select class="form-control" id="input_buscar_producto" onchange="table()">
                            <option value="0"></option>
                        </select>

                      </div-->
                        <div class="form-group">
                        <label for="exampleInputEmail1">Producto</label>
                        <div class="input-group input-group-sm">
                            <select class="form-control" id="input_buscar_producto" onchange="table()">
                                <option value="0"></option>
                            </select>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-info btn-flat" onclick="get_lista_productos()">
                                    <i class="fa fa-refresh"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                    </div>
                    <div class='col-sm-6'>
                        <div class="form-group">
                        <label for="inputPassword3" class="control-label">Codigo Barras de Producto </label>


                        <input type="text" class="form-control" id="codbarras" onkeyup="get_listproduct()" y placeholder="Codigo de Barras">

                      </div>
                    </div>
                    
                    <div id="div_detalle_compra">
                        <table class="table table-bordered" id="detalle_compra">
                          <thead>
                            <tr>
                                <th class="text-center" rowspan="2" style="width:10%">Producto</th>
                                <th class="text-center" rowspan="2" style="width:7%">Und. Paq</th>
                                <th class="text-center" rowspan="2" style="width:7%">Total Paq</th>
                                <th class="text-center" colspan="2" style="width:7%">Precio Actual (UNT)</th>
                                <th class="text-center" colspan="2" style="width:7%">Precio Anterior (UNT)</th>
                                
                                <th class="text-center" rowspan="2" style="width:7%">Lote</th>
                                <th class="text-center" rowspan="2" style="width:7%">Vencimiento</th>
                                <th class="text-center" rowspan="2" style="width:7%">Eliminar</th>
                            </tr>
                            <tr>
                                <th class="text-center" style="width:7%">PC</th>
                                <th class="text-center" style="width:7%">PV</th>
                                <th class="text-center" style="width:7%">PC</th>
                                <th class="text-center" style="width:7%">PV</th>
                            </tr>
                          </thead>
                          <tbody id="table_detalle_compra">   
                            <!--DETALLE DE COMPRA-->

                          </tbody>
                        </table>
                      </div>  
                    
                    <div class="box-footer">
                        <div class="row">

                          <div class="col-xs-2">
                            <p>Articulos : <span id="cantidadItem">0</span></p>
                          </div>  
                           
                           <div class="col-xs-6">
                             <p>Leyenda:
                                <code>PC: Precio de Compra</code>
                                <code>PV: Precio de Venta</code>
                              </p>
                              <p>
                                  <code>F9: Guardar Compra</code>
                                <code>Ctrl + B: Busqueda rápida</code>
                              </p>
                          </div>  
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-6 control-label"> SUBTOTAL (S/.) </label>

                                    <div class="col-sm-6">

                                        <input type="number" class="form-control" id="subtotal" name="subtotal" readonly value="0.00">
                                    </div>
                                </div>
                          </div> 
                   
                        </div>

                       
                      </div>
                     <a type="button" class="btn btn-danger" href="<?php echo base_url('orden_compras/lista'); ?>">Cancelar</a>
                    <button type="button" class="btn btn-success pull-right" id="btn_save" onclick="save()">Compra</button>
                  
                    
                    
                  

                  
               

                </div>
                
      </div>
      <!-- /.box-body -->
    </div>
  </div> 

    
    </div>
</div>

<script type="text/javascript"> base_url = "<?php echo base_url();  ?>"</script>
