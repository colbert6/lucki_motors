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
	
	$onSelected = isset($onSelected)? $onSelected: '';

?>

<div class="input-group input-lg">

    <input class="form-control input-lg" id="input_buscar_codigo" type="hidden" placeholder="Buscar codigo barra..." autofocus="autofocus" tabindex="1">

    <input class="form-control input-lg" id="productos" type="text" placeholder="Buscar producto..." autofocus="autofocus" tabindex="1" autocomplete="off"> 
    <span class="input-group-addon">
        <!--button id="get_lista_productos" type="button" class="btn btn-info btn-flat" tabindex="-1"><i class="fa fa-refresh"></i></button-->
        <button id="set_new_product" type="button" class="btn btn-info btn-flat" tabindex="-1" onclick="set_new_product();"><i class="fa fa-keyboard-o"></i></button>
    </span>

 
</div>


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
                url: base_url + 'get_datas/get_productos',
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

