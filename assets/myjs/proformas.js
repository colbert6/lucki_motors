
$(document).ready(function () {

  
    shortcut.add("F9",function() {
        save();
    });
   	 	

});

function add_detalle(obj){
	
	if($(".item[id_prod='"+obj.idproducto+"']").length)
	{
		alerta("Producto agregado","El producto ya se encuentra en la lista.",'warning');

	}else{

	idp = obj.idproducto;	
	html = "<div class='col-xs-12 col-md-6 item' style='padding-right: 0px;padding-bottom: 4px;' id_prod=\'"+idp+"\'>";
	html += "<div class='input-group'>";
	html += "<span class='input-group-btn'>";	
	html += "<button type='button' class='btn btn-danger btn-flat' ><i class='fa fa-times'  onclick=\'remover_detalle_venta("+idp+")\'></i></button>";
	html += "</span>";
	html += "<input class='form-control' name='prodtext[]' value=\'"+obj.producto+"\'>";
	html += "<input type='hidden' name='idprod[]'  value=\'"+idp+"\'>";
	html += "</div>  ";
	html += "</div>  ";

	html += "<div class='col-xs-4 col-md-2 item_cantidad' style='padding-right: 0px;padding-bottom: 4px;' id_prod=\'"+idp+"\'>";
	html += "<input type='number' name='cant[]' class='form-control' placeholder='Cantidad'   value=\'1\'  onkeyup=\'calcular_subtotal("+idp+")\' onchange=\'calcular_subtotal("+idp+")\'>";
	html += "</div>";

	html += "<div class='col-xs-4 col-md-2 item_precio' style='padding-right: 0px;padding-bottom: 4px;' id_prod=\'"+idp+"\'>";
	html += "<input type='number' name='prec[]' class='form-control' placeholder='Precio'  value=\'"+obj.precio_venta+"\'  onkeyup=\'calcular_subtotal("+idp+")\' onchange=\'calcular_subtotal("+idp+")\'>";
	html += "</div>";

	html += "<div class='col-xs-4 col-md-2 item_subtotal' style='padding-right: 0px;padding-bottom: 4px;' id_prod=\'"+idp+"\'>";
	html += "<input type='number' class='form-control' readonly tabindex='-1'  value=\'"+obj.precio_venta+"\'>";
	html += "</div>";

	$("#div_detalle_venta").append(html);
  	$('#cantidadItem').html($('.item').length);

  	}
   
  	calcular_total();

}

function remover_detalle_venta(idproducto){
	$('div[id_prod='+idproducto+']').remove();
	$('#cantidadItem').html($('.item').length);
	calcular_total();
}

var save = function(){
    var fallas, total;

    //Validar campos 
    fallas=true;
    
    if($("#btn_save").is(":disabled") ){
            alerta("Procesando proforma","En estos momentos se esta procesando la venta",'warning');
            return 0;
    }else{
        $("#btn_save").attr({'disabled':'disabled'});
    }
    
    
    if( $("#correlativo").val() == ""  ){
        alerta("Campos en Blanco","Llene todos los Campos",'warning');

    }else if($(".item").length == 0){
        alerta("No hay Productos","La venta no tiene Productos",'warning');

    } else if ($("#total").val() <= 0 ){
    	alerta("Total en cero","El total debe ser mayor a cero",'warning');

    } else {
		total = calcular_total();        
        fallas=false;
        
    }

            
    if(!fallas){
    	

        var obj = new Object();

        obj.type = 'POST';
        obj.url_save = base_url +'proformas/save';
        obj.data = $('#form').find('select, textarea, input').serialize();
        obj.async = true;
        obj.url_reload = base_url +'proformas/add';
        obj.msj_success_true = 'Proforma guardada';
        obj.btn_disabled = 'btn_save';

        obj.buttons_respuesta = {
                                    imprimir: {
                                      label: "Imprimir",
                                      className: 'btn-info',
                                      callback: function() {
                                            open_imprimir('proformas/print_proforma?idproforma=', idsave);   
                                      }
                                    },
                                    
                                    refrescar: {
                                      label: "Aceptar",
                                      className: 'btn-default',
                                      callback: function() {
                                         $(location).attr('href', url_reload);    
                                      }
                                    }

                                    
                                };

	

        set_data(obj);
    	
    }else{
        $("#btn_save").removeAttr('disabled');
    }

    //Validar segun el comprobante


}


