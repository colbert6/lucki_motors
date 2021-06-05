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
	$idcliente = isset($cliente_base[0]->idcliente)? $cliente_base[0]->idcliente: '';
	$ruc = isset($cliente_base[0]->ruc)? $cliente_base[0]->ruc: '';
	$razon_social = isset($cliente_base[0]->razon_social)? $cliente_base[0]->razon_social: '';
	$direccion = isset($cliente_base[0]->direccion)? $cliente_base[0]->direccion: '';

?>

<!--div class="form-group" style="margin-bottom: 0px;">
    <label for="dni_cliente" class="col-xs-3 col-sm-4 control-label" style="text-align: left;">Dni </label>
    <div class="col-xs-9 col-sm-8">
			<input type="text" class="form-control" id="dni_cliente" name="dni_cliente" placeholder="Dni" value="<?php echo $dni; ?>" onkeypress="soloNumeros(event,'dni')" maxlength="8">
			<span class="input-group-btn">
              <button type="button" class="btn btn-info btn-flat" onclick="buscar_cliente()"><i class="fa fa-plus"></i></button>
            </span>

    </div>
 </div-->

 <div class="form-group" style="margin-bottom: 0px;">
    <label for="ruc_cliente" class="col-xs-3 col-sm-4 control-label" style="text-align: left;">Ruc </label>
    <div class="col-xs-9 col-sm-8" >
     	<input type="text" class="form-control" id="ruc_cliente" name="ruc_cliente" placeholder="Ruc" value="<?php echo $ruc; ?>" onkeypress="soloNumeros(event,'ruc')" maxlength="11">
    </div>
 </div>

<div class="form-group" style="margin-bottom: 0px;">
    <label for="cliente" class="col-xs-10 col-sm-2 control-label">Cliente </label>
    <div class="col-xs-12 col-sm-10">      
        <input type="text" class="form-control tt-query" id="cliente" name="cliente" value="<?php echo $razon_social; ?>" autocomplete="off">
        <input type="hidden" name="idcliente" id="idcliente" value="<?php echo $idcliente; ?>">            
    </div>
</div>

<div class="form-group" >
    <label for="dirección_cliente" class="col-xs-8 col-sm-2 control-label">Direccion </label>
    <div class="col-xs-12 col-sm-12">
      <input type="text" class="form-control input-sm" id="direccion_cliente" name="direccion_cliente" placeholder="Dirección" value="<?php echo $direccion; ?>" >
    </div>
</div>



<script type="text/javascript">
  
  $(document).ready(function () {   

  	$('#cliente').typeahead({
  		source: function (query, process) {
            $.ajax({
                url: base_url + 'get_datas/get_clientes',
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
            $('#idcliente').val(obj.idcliente);
        	$('#dni_cliente').val(obj.dni);
			$('#ruc_cliente').val(obj.ruc);
			$('#direccion_cliente').val(obj.direccion);
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

    function get_cliente_document(tipo){

        //String valor;
        valor = $('#'+tipo+'_cliente').val();


        if( valor.length != $('#'+tipo+'_cliente').attr('maxlength')){
            alerta("Valor Incorrecto","El número de digitos no corresponde al tipo de documento",'warning');

        }else{
            //String valor = $('#'+tipo+'_cliente').val();

            $.ajax({
                url: base_url + 'get_datas/get_cliente_document',
                type: 'GET',
                data: 'tipo='+tipo+'&numero='+valor,
                dataType: 'JSON',
                success: function (obj) {
                    if(obj=== null){
                        alerta("No encontrado","No se encontro cliente con el documento indicado",'warning');
                    }else{
                        $('#idcliente').val(obj.idcliente);
                        $('#dni_cliente').val(obj.dni);
                        $('#ruc_cliente').val(obj.ruc);
                        $('#direccion_cliente').val(obj.direccion)
                        $('#cliente').val(obj.razon_social);

                    }
                    
                }
            });
        }
        

    }


</script>

