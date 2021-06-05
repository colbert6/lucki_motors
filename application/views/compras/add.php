<?php 

?>

<div class="row">
  
 <div class="form-horizontal" id="form-compras">
  <div class="col-md-7">
    
      <div class="box box-info">
          
        
          
            <div class="box-header with-border">
              <h3 class="box-title">INFORMACION DE COMPRA</h3>
            </div>
            <div class="box-body">

          
                <div class="box-body">
                  
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="col-sm-2 control-label">Auto-Guardado</label>
                        <div class="col-sm-10">
                            
                            <button type="button" class="btn btn-success btn-sm" id='torden' name='torden' ></button>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="col-sm-2 control-label">COD. Orden</label>
                        <div class="col-sm-10">
                            <div class="input-group input-group-sm">
                                <input type="hidden" name="idorden" id="idorden" />
                                <input class="form-control" type="text" name="codorden" id="codorden" placeholder="Cod. Orden de Compra" value="" />
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-info btn-flat" onclick="get_search_orden()">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    
                     <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Tienda *</label>

                        <div class="col-sm-10">
                            <select class="form-control" id="tienda" name="tienda" onchange="updateData()">
                                <option value="">Seleccione..</option>
                                <?php foreach ($tiendas as $tienda): ?>
                                <option value="<?= $tienda->idtienda ?>"><?= $tienda->descripcion ?></option>
                                <?php endforeach; ?>
                          </select>

                        </div>
                     </div>
                    
                    
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Fecha *</label>
                        <!--div class="col-sm-6">
                          <select class="form-control select2" id="colaborador_compra" name="colaborador_compra" >
                            <option></option>
                          </select>
                        </div-->
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="fecha_compra" name="fecha_compra" onblur="updateData()" value="<?php echo date('Y-m-d');?>" >
                        </div>
                        
                    </div>
                    
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">Recep *</label>
                        <div class="col-sm-6">
                         <select class="form-control" id="colaborador_almacen" name="colaborador_almacen">
                            <option></option>
                          </select>
                        </div>
                        <div class="col-sm-4">
                          <input type="date" class="form-control" id="fecha_almacen" name="fecha_almacen" value="<?php echo date('Y-m-d');?>">
                        </div>
                        
                    </div>
                    
                    
                  <div class="form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Prov *</label>

                    <div class="col-sm-10">
                        <select class="form-control" id="idproveedor" name="idproveedor" onchange="asignaNroDoc()" >
                            <option></option>
                          </select>
                    </div>
                    <div class="col-sm-2"></div>
                    <div class="col-sm-10">
                     
                      <input type="text" class="form-control" id="numdoc_proveedor" placeholder="RUC" readonly="readonly">
                    </div>
                  </div> 
                    


                </div>
                

      </div>
      <!-- /.box-body -->
    </div>
  </div>  
     <div class="col-md-5">
    
      <div class="box box-info">
          
          
            <div class="box-header with-border">
              <h3 class="box-title">COMPROBANTE DE COMPRA</h3>
            </div>
            <div class="box-body">

          
                <div class="box-body">
                  

                  
                  <div class="form-group">
                    <label for="inputPassword3" class="col-sm-3 control-label">COMP. * </label>

                    <div class="col-sm-9">
                        <select class="form-control" id='tipo_comprobante' name='tipo_comprobante'>
                            <option value="">Seleccione..</option>
                            <?php foreach ($tipo_comprobantes as $tc): ?>
                            <option value="<?= $tc->idtipo_comprobante ?>"><?=  $tc->descripcion ?> </option>
                            <?php endforeach; ?>
                      </select>
                      
                    </div>
                    
                  </div>
                    
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label"> N° DOC * </label>
                        <div class="col-sm-9">

                        <input class="form-control" id="nro_comprobante_compra" name="nro_comprobante_compra" placeholder="N° Comprobante">
                      </div>
                     
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label"> REMISION</label>
                        
                      <div class="col-sm-9">

                        <input class="form-control" id="guia_remision" name="guia_remision" placeholder="Guia Remision">
                      </div>
                    </div>
                  

                  
                   <div class="form-group">
                    <label for="inputEmail3" class="col-sm-3 control-label">OBS.</label>

                    <div class="col-sm-9">
                        <textarea class="form-control" id="obs_compra" name="obs_compra" onblur="updateData()"></textarea>
                    </div>
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
                            <select class="form-control" id="input_buscar_producto" onchange="table(this)">
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

                                        <input type="number" onchange="updateData()" class="form-control" id="subtotal" name="subtotal" readonly value="0.00">
                                    </div>
                                </div>
                          </div> 
                   
                        </div>

                       
                      </div>
                  
                    
                    
                  

                  
               

                </div>
                
      </div>
      <!-- /.box-body -->
    </div>
  </div> 
    <div class="col-md-12">
    
      <div class="box box-warning">
          
  
            <div class="box-body">

          
                <div class="box-body">
                  
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputPassword3" class="control-label"> IGV (+) </label>
                            <input type="number" class="form-control" id="igv" name="igv" onblur="neto_pagar()" value="0.00">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputPassword3" class="control-label"> DESCUENTO (-) </label>
                            <input type="number" class="form-control" id="descuento" onblur="neto_pagar()"  name="descuento" value="0.00">
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="inputPassword3" class="control-label"> NETO A PAGAR </label>
                            <input type="number" class="form-control" readonly id="neto_compra" name="neto_compra" placeholder="Total" value="0.00">   
                        </div>
                    </div>
              
                    
                  
                    
                    
                    
                  

                  
               

                </div>
                <button type="button" class="btn btn-danger" onclick="cancelarOrden()">Cancelar</button>
                <button type="button" class="btn btn-success pull-right" id="btn_save" onclick="save()">Compra</button>
                
      </div>
      <!-- /.box-body -->
    </div>
  </div>
    
    </div>
</div>

<script type="text/javascript"> base_url = "<?php echo base_url();  ?>"</script>
