<style type="text/css">

	.typeahead{
	        font-size: 16px;
	        width: 100%;
	    }
    .dropdown-menu>li>a {
        white-space: normal !important;
    }    
    .typeahead>li:nth-child(odd) {
        background-color:#fbfbfb;
    }
    .typeahead, .tt-query, .tt-hint {
		width: 100%;	
	}

</style>

<?php
	
	$dni = isset($cliente_base[0]->dni)? $cliente_base[0]->dni: '';
	$idproveedor = isset($cliente_base[0]->idcliente)? $cliente_base[0]->idcliente: '';
	$ruc = isset($cliente_base[0]->ruc)? $cliente_base[0]->ruc: '';
	$razon_social = isset($cliente_base[0]->razon_social)? $cliente_base[0]->razon_social: '';
	$direccion = isset($cliente_base[0]->direccion)? $cliente_base[0]->direccion: '';

?>

 <div class="form-group" style="margin-bottom: 0px;">
    <label for="ruc_cliente" class="col-xs-3 col-sm-4 control-label" style="text-align: left;">Ruc </label>
    <div class="col-xs-9 col-sm-8" >
     	<input type="text" class="form-control" id="ruc_proveedor" name="ruc_proveedor" placeholder="Ruc" value="<?php echo $ruc; ?>" onkeypress="soloNumeros(event,'ruc')" maxlength="11">
    </div>
 </div>

<div class="form-group" style="margin-bottom: 0px;">
    <label for="cliente" class="col-xs-10 col-sm-2 control-label">Proveedor </label>
    <div class="col-xs-12 col-sm-10">      
        <input type="text" class="form-control tt-query" id="proveedor" name="proveedor" value="<?php echo $razon_social; ?>" autocomplete="off">
        <input type="hidden" name="idproveedor" id="idproveedor" value="<?php echo $idproveedor; ?>">            
    </div>
</div>

<div class="form-group" >
    <label for="dirección_cliente" class="col-xs-8 col-sm-2 control-label">Direccion </label>
    <div class="col-xs-12 col-sm-12">
      <input type="text" class="form-control input-sm" id="direccion_proveedor" name="direccion_proveedor" placeholder="Dirección" value="<?php echo $direccion; ?>" >
    </div>
</div>



<script type="text/javascript">
  
  $(document).ready(function () {   

  	$('#proveedor').typeahead({
  		source: function (query, process) {
            $.ajax({
                url: base_url + 'get_datas/get_proveedores',
                type: 'GET',
                data: 'query=' + query,
                dataType: 'JSON',
                async: true,
                success: function (data) {
                    objects = [];
                    map = {};
                    $.each(data, function (i, object) {
                        map[object.razon_social] = object;
                        objects.push(object.razon_social);
                    });
                    process(objects);
                }
            });
        },
        items: 10,
        minLength:3,
        updater: function (item ) {
        	obj = map[item];
            $('#idproveedor').val(obj.idproveedor);
        	$('#direccion_proveedor').val(obj.direccion);
			$('#ruc_proveedor').val(obj.ruc);
            return item;
        }

  	}); 

  });


  //Solo permite introducir numeros.
    function soloNumeros(e , tipo){
      var key = window.event ? e.which : e.keyCode;
      if(key == 13 ){
        get_cliente_document(tipo);
      }
      if (key < 48 || key > 57) {
        e.preventDefault();
      }
    }



</script>

