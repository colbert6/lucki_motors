var calcular_subtotal = function(idproducto){    
    
    var cantidad=$('.item_cantidad[id_prod="'+idproducto+'"]').find('input').val();
    var pv=$('.item_precio[id_prod='+idproducto+']').find('input').val();

    pv = isNaN(pv) || pv=='' ?0:parseFloat(pv);        
    cantidad = isNaN(cantidad) || cantidad=='' || !Number.isInteger(parseFloat(cantidad))?0:parseFloat(cantidad); 

    var subtotal = pv * cantidad ; 

    $('.item_subtotal[id_prod='+idproducto+']').find('input').val(subtotal.toFixed(2));  
    calcular_total(); 
}

var calcular_total=function(){
    var subtotales = 0;
    var descuento = $('#descuento').val() || 0;
    var igv = $('#igv').val() || 0;
    var total = 0;

    $(".item_subtotal>input").each(function(){
        var st_det = $(this).val();
        if (!isNaN(st_det) && st_det!=''){
            subtotales=parseFloat(subtotales)+parseFloat(st_det);
        }        
    });  

    descuento = parseFloat(descuento).toFixed(2);

    total = (parseFloat(subtotales) - parseFloat(descuento));

    subtotales = parseFloat(total) / 1.18 ;

    igv = (parseFloat(total) - parseFloat(subtotales));
    igv = parseFloat(igv).toFixed(2);

    /*subtotales = parseFloat(subtotales).toFixed(2);

    igv = parseFloat(subtotales) * 0.18 ;
    igv = parseFloat(igv).toFixed(2);

    descuento = parseFloat(descuento).toFixed(2);

    total = (parseFloat(subtotales) + parseFloat(igv) - parseFloat(descuento));*/

    //console.log('des:'+descuento+'igv:'+igv+'tot:'+total);
    $("#igv").val(parseFloat(igv).toFixed(2));  
    $("#subtotales").val(parseFloat(subtotales).toFixed(2));  

    $(".total").html(parseFloat(total).toFixed(2)); //si es texto grande  
    $("#total").val(parseFloat(total).toFixed(2));  //si es un input 

    return total;


}



