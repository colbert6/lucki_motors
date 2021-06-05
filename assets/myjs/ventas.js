

$(document).ready(function () {

	get_correlativo();
	
	shortcut.add("F9",function() {
		save();
	});

	shortcut.add("Ctrl+b",function() {
		$("#iproductos").focus();
	});
	
	$("#efectivo").keypress(function(e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if(code==13){
            save();
        }
    });
 	 	

});


function add_detalle(obj){
	
	if($(".item[id_prod='"+obj.idproducto+"']").length)
	{
		alerta("Producto agregado","El producto ya se encuentra en la lista.",'warning');

	}else{

	idp = obj.idproducto;	
    html = "<div class='row'>";
	html += "<div class='col-xs-12 col-md-6 item' style='padding-bottom: 4px;' id_prod=\'"+idp+"\'>";
	html += "<div class='input-group'>";
	html += "<span class='input-group-btn'>";	
	html += "<button type='button' class='btn btn-danger btn-flat' ><i class='fa fa-times'  onclick=\'remover_detalle_venta("+idp+")\'></i></button>";
	html += "</span>";
	html += "<input class='form-control' name='prodtext[]' value=\'"+obj.producto+"\'>";
	html += "<input type='hidden' name='idprod[]'  value=\'"+idp+"\'>";
	html += "</div>  ";
	html += "</div>  ";

	html += "<div class='col-xs-4 col-md-2 item_cantidad' style='padding-bottom: 4px;' id_prod=\'"+idp+"\'>";
	html += "<input type='number' name='cant[]' class='form-control' placeholder='Cantidad'  tabindex='-1' value=\'1\'  onkeyup=\'calcular_subtotal("+idp+")\' onchange=\'calcular_subtotal("+idp+")\'>";
	html += "</div>";

	html += "<div class='col-xs-4 col-md-2 item_precio' style='padding-bottom: 4px;' id_prod=\'"+idp+"\'>";
	html += "<input type='number' name='prec[]' class='form-control' placeholder='Precio' tabindex='-1' value=\'"+obj.precio_venta+"\'  onkeyup=\'calcular_subtotal("+idp+")\' onchange=\'calcular_subtotal("+idp+")\'>";
	html += "</div>";

	html += "<div class='col-xs-4 col-md-2 item_subtotal' style='padding-bottom: 4px;' id_prod=\'"+idp+"\'>";
	html += "<input type='number' class='form-control' readonly tabindex='-1'  value=\'"+obj.precio_venta+"\'>";
	html += "</div>";
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
	//Deshabilitar boton

	if($("#btn_save").is(":disabled") ){
            alerta("Procesando Venta","En estos momentos se esta procesando la venta",'warning');
            return 0;
        }else{
            $("#btn_save").attr({'disabled':'disabled'});
        }
    

    //Validar campos 
    fallas=true;

    if(  $("#tienda").val()=="" || 
            $("#fecha_almacen").val() == "" ||
            $("#idproveedor").val() == "" ||
            $("#idserie").val() == "" ||
            $("#correlativo").val() == "" ){
        alerta("Campos en Blanco","Llene todos los Campos",'warning');

    }else if($(".item").length == 0){
        alerta("No hay Productos","La venta no tiene Productos",'warning');

    } else if ($("#total").val() <= 0 ){
    	alerta("Total en cero","El total debe ser mayor a cero",'warning');

    } else {     
        
        total = calcular_total();
    	efectivo = $("#efectivo").val();        
    	efectivo = (efectivo === '')? total : efectivo ;
    	if(  total > efectivo   ){
    		alerta("Efectivo incorrecto ","El monto de efectivo es menor al total",'warning');
    	} else {
    		fallas=false;
    	}
        
    }

    //console.log(parseFloat(total));
    /*if(  $("#idserie").val()  == 2  ){

        if( $("#ruc_cliente").val().length != 11 ||  $("#ruc_cliente").val() == '00000000000' ){
            alerta("RUC","Ingrese ruc valido",'warning'); 
            fallas = true;
        }

    }else if(  $("#idserie").val()  == 3  && parseFloat(total) >= 700 ) {

        if( $("#dni_cliente").val().length != 8 ||  $("#dni_cliente").val() == '00000000' ){
            alerta("DNI","Ingrese dni valido",'warning');
            fallas = true;
        }

    }*/

 
    if(!fallas){
    		
    	vuelto = parseFloat(efectivo).toFixed(2) - parseFloat(total).toFixed(2) ;

		text_carga = "<h4>Total de venta :  S/."+parseFloat(total).toFixed(2)+"</h4>";
		text_carga += "<h4>Efectivo entregado : S/."+parseFloat(efectivo).toFixed(2)+"</h4>";
		text_carga += "<h3>Vuelto : S/."+parseFloat(vuelto).toFixed(2)+"</h3>";

		var obj = new Object();

        obj.type = 'POST';
        obj.url_save = base_url +'ventas/save';
        obj.data = $('#form').find('select, textarea, input').serialize();
        obj.async = true;
        obj.url_reload = base_url +'ventas/add';
        obj.msj_success_true = 'Venta guardada';
        obj.text_carga = text_carga;
        obj.btn_disabled = 'btn_save';

        obj.buttons_respuesta = {
                                    imprimir: {
                                      label: "Imprimir",
                                      className: 'btn-info',
                                      callback: function() {
                                            open_imprimir('ventas/print_venta?idventa=', idsave);   
                                      }
                                    },
                                    
                                    refrescar: {
                                      label: "Aceptar",
                                      className: 'btn-default',
                                      callback: function() {
                                         $(location).attr('href', url_reload);    
                                      }
                                    }

                                    
                                }


        set_data(obj);
        //$("#btn_save").removeAttr('disabled');
    }else{
    	$("#btn_save").removeAttr('disabled');
    }

    //Validar segun el comprobante


    
}

