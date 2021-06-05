var calcular_subtotal = function(){    
    
    var cantidad=$('#cantidad_producto').val();
    var pv=$('#precio_unitario_producto').val();

    pv = isNaN(pv) || pv=='' ?0:parseFloat(pv);        
    cantidad = isNaN(cantidad) || cantidad=='' || !Number.isInteger(parseFloat(cantidad))?0:parseFloat(cantidad); 

    var subtotal = pv * cantidad ;
    $('#subtotal_producto').val(subtotal.toFixed(2));  

    if (document.getElementById('afecto_igv').checked) {
        var igv = subtotal * 0.18;
    } else {
        var igv = 0;
    }

    $('#igv_producto').val(igv.toFixed(2)); 

    var subtotal_2 = parseFloat(subtotal) + parseFloat(igv);

    var p_descuento=$('#porcentaje_descuento_producto').val();
    p_descuento=isNaN(p_descuento) || p_descuento=='' || p_descuento<0 || p_descuento>100 ?0:parseFloat(p_descuento);

    var monto_descuento= subtotal_2 * (p_descuento/100);
    monto_descuento=parseFloat(monto_descuento);
    subtotal_2 -= parseFloat(monto_descuento);

    $('#descuento_producto').val(monto_descuento.toFixed(2)); 
    $('#total_producto').val(subtotal_2.toFixed(2));       
}

var calcular_subtotal_edit = function(obj){  

    tr = $(obj).parent().parent();
    
    var cantidad=$(tr).find("input[name='cantidad_producto[]']").val();
    var pv=$(tr).find("input[name='precio_unitario_producto[]']").val();

    pv = isNaN(pv) || pv=='' ?0:parseFloat(pv);        
    cantidad = isNaN(cantidad) || cantidad=='' || !Number.isInteger(parseFloat(cantidad))?0:parseFloat(cantidad); 

    var subtotal = pv * cantidad ;
    $(tr).find("input[name='subtotal_producto[]']").val(subtotal.toFixed(2));

    if ($(tr).find("input[name='afecto_igv[]']").is(':checked')) {
        var igv = subtotal * 0.18;
    } else {
        var igv = 0;
    }

    $(tr).find("input[name='igv_producto[]']").val(igv.toFixed(2)); 

    var subtotal_2 = parseFloat(subtotal) + parseFloat(igv);

    var p_descuento=$(tr).find("input[name='porcentaje_descuento_producto[]']").val();
    p_descuento=isNaN(p_descuento) || p_descuento=='' || p_descuento<0 || p_descuento>100 ?0:parseFloat(p_descuento);

    var monto_descuento= subtotal_2 * (p_descuento/100);
    monto_descuento=parseFloat(monto_descuento);
    subtotal_2 -= parseFloat(monto_descuento);

    $(tr).find("input[name='descuento_producto[]']").val(monto_descuento.toFixed(2)); 
    $(tr).find("input[name='total_producto[]']").val(subtotal_2.toFixed(2));    

    calcular_total();  
}

var calcular_total=function(){

    subtotal = 0 ;
    igv = 0 ;
    descuento = 0 ;
    total = 0 ;
    
    $("#tbody_detalle_ingreso").find("input[name='subtotal_producto[]']").each(function( index ) {
        value = $(this).val();
        subtotal += parseFloat(value);
    });

    $("#tbody_detalle_ingreso").find("input[name='igv_producto[]']").each(function( index ) {
        value = $(this).val();
        igv += parseFloat(value);
    });

    $("#tbody_detalle_ingreso").find("input[name='descuento_producto[]']").each(function( index ) {
        value = $(this).val();
        descuento += parseFloat(value);
    });

    $("#tbody_detalle_ingreso").find("input[name='total_producto[]']").each(function( index ) {
        //console.log( this.id + " : " + index + " : " + this.type + " : " + $(this).val() );
        value = $(this).val();
        total += parseFloat(value);
    });
    
    $("#subtotal").val(subtotal);   
    $("#igv").val(igv);   
    $("#descuento").val(descuento);   
    $(".subtotal").html(subtotal.toFixed(2));   
    $(".igv").html(igv.toFixed(2));
    $(".descuento").html(descuento.toFixed(2));   
    $(".total").html(total.toFixed(2));   


    return total;


}



