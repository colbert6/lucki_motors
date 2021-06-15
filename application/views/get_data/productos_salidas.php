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

    .form-control-aux {

    }


</style>

<?php
	
	$onSelected = isset($onSelected)? $onSelected: '';

?>

<input type="hidden" id="nro_item" value="1">
<input type="hidden" id="idproducto">
<input type="hidden" id="idpresentacion">

<div class="col-md-7 col-xs-6 no-padding">
    <input class="form-control " id="productos" type="text" placeholder="BUSCAR PRODUCTO..." autofocus="autofocus"  autocomplete="off">    
</div>
<div class="col-md-1 col-xs-6  no-padding">
    <input type="number" class="form-control " id="precio_compra" value="0.00" placeholder="P.compra" autocomplete="off">    
</div>
<div class="col-md-1 col-xs-6  no-padding">
    <input type="text" class="form-control " id="codigo" readonly value="" placeholder="CODIGO" autocomplete="off">    
</div>
<div class="col-md-1 col-xs-6 no-padding">
    <input type="text" class="form-control " id="unidad_medida" value="" placeholder="UND MEDIDA" autocomplete="off">  
</div>
<div class="col-md-1 col-xs-6  no-padding">
    <input type="number" class="form-control " id="cantidad_producto"  placeholder="CANTIDAD" autocomplete="off" >    
</div>
<div class="col-md-1 col-xs-6  no-padding">
    <select class="form-control" id="idarea"> 
          <?php foreach($areas as $aa) {
            echo "<option value='{$aa->id}' > {$aa->descripcion} </option>";
          }
        ?>
    </select>     
</div>

<!--MONTOS------------------------>
<button onclick="add_detalle()" >Agregar</button>
<button onclick="clear_detalle()" >Limpiar</button>


<script type="text/javascript">

$.fn.delayPasteKeyUp = function(fn, ms)
{
    var timer = 0;
    $(this).on("propertychange input", function()
    {
      clearTimeout(timer);
      timer = setTimeout(fn, ms);
    });
};  

$(document).ready(function () {   

    $("#input_buscar_codigo").delayPasteKeyUp(function(){
        buscar_producto_rapido($('#input_buscar_codigo').val());
        $('#input_buscar_codigo').select();
    }, 200);  

  	$('#productos').typeahead({
  		source: function (query, process) {
            $.ajax({
                url: base_url + 'get_datas/get_productos_directo',
                type: 'GET',
                data: 'query=' + query,
                dataType: 'JSON',
                async: true,
                success: function (data) {
                    objects = [];
                    map = {};
                    $.each(data, function (i, object) {
                        map[object.texto] = object;
                        objects.push(object.texto);
                    });
                    process(objects);
                }
            });
        },
        items: 10,
        minLength:3,
        updater: function (item ) {
        	obj = map[item];
        	<?php echo $onSelected; ?>
            return item;
        }

  	});  	    


});

    function buscar_producto_rapido(valor){ 

        $.ajax({
            url: base_url + 'get_datas/get_productos',
            type: 'GET',
            data: 'query=' + valor +'&filtro=codbarras',
            dataType: 'JSON',
            async: true,
            success: function (data) {
                obj = data[0];
                if( obj){
                    <?php echo $onSelected; ?> 
                }
                
                
            }
        });
    }

    function set_new_product(){
        $('#productos').select();
    }

</script>

