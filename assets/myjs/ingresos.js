
$(document).ready(function () {
	
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

 function estado_pago_udpate(){
        idperiodo_pago = $('#idperiodo_pago').val();
        if (idperiodo_pago == 1) {
            $('#estado_pago').val('cancelado');
            $("#estado_pago").prop('disabled', true);
            $("#div_fecha_pago").hide();
            
        }else{
            $("#estado_pago").prop('disabled', false);
            estado_pago = $('#estado_pago').val();
            if (estado_pago == 'cancelado') {
                $("#div_fecha_pago").show();
            }else{
                $("#div_fecha_pago").hide();
            }
            
            
        }

    }



function set_info_producto(obj){
    if($(".item[id_prod='"+obj.idproducto+"']").length)
    {
        alerta("Producto agregado","El producto ya se encuentra en la lista.",'warning');

    }else{ 
        // obj.forEach(set_data_producto);
        Object.keys(obj).forEach(function(key) {
          $('#'+key+'').val(obj[key]);
        })

        calcular_subtotal();

    }
}

function add_detalle(){

    nro_item = $('#nro_item').val();
    $('#nro_item').val( parseFloat(nro_item) + 1);

    html = "<tr class='item' nro_item='"+nro_item+"' >";
    html += '<td><button type="button" class="btn btn-danger btn-xs" id="btn_save" onclick="remover_detalle_ingreso('+nro_item+')">X</button></td>';


    $("#data_detalle_ingreso").find('input, select').each(function( index ) {
        //console.log( this.id + " : " + index + " : " + this.type + " : " + $(this).val() );
        value = $(this).val();
        if(this.type == 'hidden'){
            html += " <input type='hidden' value='"+value+"' name='"+this.id+"[]'/> ";    
        }else if(this.type == 'checkbox'){
            html += " <input type='hidden' value='"+value+"' name='"+this.id+"[]'/> ";    
        }else if(this.type == 'select-one'){
            html += "<td> <input type='hidden' value='"+value+"' name='"+this.id+"[]'/> "; 
            html += " <input type='hidden' value='"+$(this).find("option:selected").text()+"' name='"+this.id+"_nombre[]'/> ";   
            html += $(this).find("option:selected").text() + "</td> ";    
        }else {
            if(value==''){value=0;}
            html += "<td> <input type='hidden' value='"+value+"' name='"+this.id+"[]'/> ";   
            html += value + "</td> ";  
        }
    });

    html += "</tr>"; 

    $("#tbody_detalle_ingreso").append(html);
    $('#cantidadItem').html($('.item').length);
    
    calcular_total();

    clear_detalle();

}

function clear_detalle(){
    nro_item = $('#nro_item').val();
    $("#data_detalle_ingreso").find('input').each(function( index ) {
        $(this).val('');        
    });
    $('#nro_item').val(nro_item);
}

function remover_detalle_ingreso(nro_item){
	$('tr[nro_item='+nro_item+']').remove();
	$('#cantidadItem').html($('.item').length);
	calcular_total();
}

var save = function(){

	var fallas, total;
	//Deshabilitar boton


	if($("#btn_save").is(":disabled") ){
        alerta("Procesando ingreso","En estos momentos se esta procesando la venta",'warning');
        return 0;
    }else{
        $("#btn_save").attr({'disabled':'disabled'});
    }
    

    //Validar campos 
    fallas=true;

    if($(".item").length == 0){
        alerta("No hay Productos","no cuenta con Productos o items",'warning');

    } else if ($("#idproveedor").val() <= 0 && $("#idproveedor").val() == '' ){
    	alerta("Proveedor no seleccionado","Proveedor no se ha seleccionado",'warning');

    }else{
        fallas=false;
        
    } /*else {     
        
        total = calcular_total();
    	efectivo = $("#efectivo").val();        
    	efectivo = (efectivo === '')? total : efectivo ;
    	if(  total > efectivo   ){
    		alerta("Efectivo incorrecto ","El monto de efectivo es menor al total",'warning');
    	} else {
    		fallas=false;
    	}
        
    }*/

    if(!fallas){
    	// vuelto = parseFloat(efectivo).toFixed(2) - parseFloat(total).toFixed(2) ;

		// text_carga = "<h4>Total de venta :  S/."+parseFloat(total).toFixed(2)+"</h4>";
		// text_carga += "<h4>Efectivo entregado : S/."+parseFloat(efectivo).toFixed(2)+"</h4>";
		// text_carga += "<h3>Vuelto : S/."+parseFloat(vuelto).toFixed(2)+"</h3>";

        text_carga = 'Guardando' ;

		var obj = new Object();

        obj.type = 'POST';
        obj.url_save = base_url +'ingresos/save';
        obj.data = $('#form').find('select, textarea, input').serialize();
        obj.async = true;
        obj.url_reload = base_url +'ingresos/add';
        obj.msj_success_true = 'Ingreso registrado';
        obj.text_carga = text_carga;
        obj.btn_disabled = 'btn_save';

        obj.buttons_respuesta = {
                                    imprimir: {
                                      label: "Imprimir",
                                      className: 'btn-info',
                                      callback: function() {
                                            open_imprimir('ingresos/print_detalle?idingreso=', idsave);   
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

var save_edit = function(){

    var fallas, total;
    //Deshabilitar boton


    if($("#btn_save").is(":disabled") ){
        alerta("Procesando ingreso","En estos momentos se esta procesando la venta",'warning');
        return 0;
    }else{
        $("#btn_save").attr({'disabled':'disabled'});
    }
    

    //Validar campos 
    fallas=true;

    if($(".item").length == 0){
        alerta("No hay Productos","no cuenta con Productos o items",'warning');

    } else if ($("#idproveedor").val() <= 0 && $("#idproveedor").val() == '' ){
        alerta("Proveedor no seleccionado","Proveedor no se ha seleccionado",'warning');

    }else{
        fallas=false;
        
    } /*else {     
        
        total = calcular_total();
        efectivo = $("#efectivo").val();        
        efectivo = (efectivo === '')? total : efectivo ;
        if(  total > efectivo   ){
            alerta("Efectivo incorrecto ","El monto de efectivo es menor al total",'warning');
        } else {
            fallas=false;
        }
        
    }*/

    if(!fallas){
        // vuelto = parseFloat(efectivo).toFixed(2) - parseFloat(total).toFixed(2) ;

        // text_carga = "<h4>Total de venta :  S/."+parseFloat(total).toFixed(2)+"</h4>";
        // text_carga += "<h4>Efectivo entregado : S/."+parseFloat(efectivo).toFixed(2)+"</h4>";
        // text_carga += "<h3>Vuelto : S/."+parseFloat(vuelto).toFixed(2)+"</h3>";

        text_carga = 'Guardando' ;

        var obj = new Object();

        obj.type = 'POST';
        obj.url_save = base_url +'ingresos/save_edit';
        obj.data = $('#form').find('select, textarea, input').serialize();
        obj.async = true;
        obj.url_reload = base_url +'ingresos/lista';
        obj.msj_success_true = 'Ingreso actualizado';
        obj.text_carga = text_carga;
        obj.btn_disabled = 'btn_save';

        obj.buttons_respuesta = {
                                    imprimir: {
                                      label: "Imprimir",
                                      className: 'btn-info',
                                      callback: function() {
                                            open_imprimir('ingresos/print_detalle?idingreso=', idsave);   
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


