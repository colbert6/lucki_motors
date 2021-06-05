var lista_productos ;
var total_compra = 0;

$(document).ready(function () {
    get_lista_proveedor();
    get_lista_productos();
    get_correlativo();
    shortcut.add("F9",function() {
        save();
    });
    shortcut.add("Ctrl+b",function() {
        $("#codbarras").focus();
    });
    
});

function get_correlativo(){

    $.ajax({
        url: base_url + "orden_compras/correlativo",
        type: 'GET',
        data: {},
        dataType: 'JSON',
        async: true,
        success: function (data) {
            correlativo = "ORD-";
            if(data.length>0){
                 correlativo+=(parseInt(data[0].correlativo)+1);   
                 $('#nro_comprobante_compra').val(correlativo);
            }else{
                correlativo+="1";
                $('#nro_comprobante_compra').val(correlativo);
            }
        }
    });
}


function get_lista_proveedor(){
    $.ajax({
        url: base_url + "proveedores/json_lista",
        type: 'GET',
        dataType: 'JSON',
        async: true,
        success: function (data) {
            lista_proveedor = data;
            $('#idproveedor').select2({
                placeholder: 'Elija Proveedor',
                data : lista_proveedor
            });
        }
    });
} 

function asignaNroDoc(){

    id = $('#idproveedor').val();
    
    $.ajax({
        url: base_url + "proveedores/json_lista/"+id,
        type: 'GET',
        dataType: 'JSON',
        async: true,
        success: function (data) {
            $("#numdoc_proveedor").val(data[0].ruc);
        }
    });
}


function get_lista_productos(){
    $.ajax({
        url: base_url + "orden_compras/lista_productos",
        type: 'GET',
        dataType: 'JSON',
        async: true,
        success: function (data) {
            lista_productos = data;
            $('#input_buscar_producto').select2({
                data : lista_productos
            });
        }
    });
} 

function table(){
    id = $("#input_buscar_producto").val();
    $.ajax({
        url: base_url + "productos/json_lista_id/"+id,
        type: 'GET',
        dataType: 'JSON',
        async: true,
        success: function (data) {
            if(data.length > 0){
                for(i=0;i<data.length;i++){
                    tr(data[i]);
                }
            }
        }
    });   
}

function hoy(){
    var f = new Date();
    var mes = ((f.getMonth() +1)<10)?"0"+(f.getMonth() +1):(f.getMonth() +1); 
    var dia = (f.getDate()<10)?"0"+f.getDate():f.getDate(); 
    return f.getFullYear()+"-"+mes +"-"+dia ;
}

function tr(t){
    var insert = true;
    $("tr[row='row']").each(function(){
        var id = $(this).attr("id");
        if (id == t.id){
            insert = false;
        }        
    });  
    
    if(insert){
        reg = "";
        reg+= "<tr row='row' id='"+t.id+"'>";
        reg+= " <td>"+t.text+"\
                    <input \n\
                            type='hidden' \n\
                            name='idprod[]' \n\
                            value='"+t.id+"' \n\
                            readonly />\n\
                    <input \n\
                            type='hidden' \n\
                            name='prodtext[]' \n\
                            value='"+t.text+"' \n\
                            readonly />\n\
                </td>";
        
        reg+= " <td>\n\
                    <input  \n\
                            style='width:70px;'\n\
                            class='form-control' \n\
                            name='cant[]' \n\
                            id='cant"+t.id+"' \n\
                            onkeyup=\"calcular_pc('"+t.id+"')\" \n\
                            onchange=\"calcular_pc('"+t.id+"')\" \n\
                            type='text' \n\
                            value='1'/>\n\
                </td>";
        reg+= " <td>\n\
                    <input  \n\
                            style='width:70px;'\n\
                            class='form-control' \n\
                            tot='sub'\n\
                            name='sub[]' \n\
                            id='sub"+t.id+"' \n\
                            onkeyup=\"calcular_pc('"+t.id+"')\" \n\
                            onchange=\"calcular_pc('"+t.id+"')\" \n\
                            type='text' \n\
                            value='0.00'/>\n\
                </td>";
        reg+= " <td>\n\
                    <input \n\
                            style='width:70px;'\n\
                            readonly \n\
                            class='form-control' \n\
                            name='prec_c_act[]' \n\
                            id='prec_c"+t.id+"' \n\
                            type='text' \n\
                            value='0.00'/>\n\
                </td>";
        reg+= " <td>\n\
                    <input \n\
                            style='width:70px;'\n\
                            class='form-control' \n\
                            style='width:70px;'\n\
                            name='prec_v_act[]' \n\
                            id='prec_v"+t.id+"' \n\
                            onkeyup=\"\" \n\
                            type='text' \n\
                            value='"+t.precio_venta+"'/>\n\
                    </td>";
        reg+= " <td>\n\
                    <input \n\
                            readonly\n\
                            style='width:70px;'\n\
                            class='form-control' \n\
                            name='prec_c_ant[]' \n\
                            id='prec_c_ant"+t.id+"' \n\
                            onkeyup=\"\" \n\
                            type='text' \n\
                            value='"+t.precio_compra+"'/>\n\
                    </td>";
        reg+= " <td>\n\
                    <input \n\
                            readonly\n\
                            style='width:70px;'\n\
                            class='form-control' \n\
                            name='prec_v_ant[]' \n\
                            id='prec_c_ant"+t.id+"' \n\
                            onkeyup=\"\" \n\
                            type='text' \n\
                            value='"+t.precio_venta+"'/>\n\
                    </td>";
        reg+= " <td>\n\
                    <input \n\
                            placeholder='Lote' \n\
                            class='form-control' \n\
                            name='lt[]' \n\
                            id='lt"+t.id+"'  \n\
                            type='text' \n\
                            value=''/>\n\
                </td>";
        reg+= " <td>\n\
                    <input \n\
                        style='width:150px;'\n\
                        class='form-control' \n\
                         name='venc[]' \n\
                        id='venc"+t.id+"' \n\
                        type='date' \n\
                        value='"+hoy()+"'/>\n\
                </td>";
        
      
        reg+= " <td><button class='btn btn-danger' onclick='remove_tr("+t.id+")'>X</button></td>";
        reg+= "</tr>";

        $("#table_detalle_compra").append(reg);
        calcular_pc(t.id);
        items();
        
         $('#input_buscar_producto').val('0').trigger('change.select2');
         $('#codbarras').val('');
    }else{
        $('#input_buscar_producto').val('0').trigger('change.select2');
    }   
}

function remove_tr(id){
	$('#'+id).remove();
	items();
	calcular_total();
}
function items(){
    fila = $("tr[row='row']").length;
    $("#cantidadItem").text(fila);
}

function calcular_pc(item){
    cantidad = $("#cant"+item).val();
    precio_sub = $("#sub"+item).val();
    
    precio_sub = isNaN(precio_sub) || precio_sub=='' ?0:parseFloat(precio_sub);        
    cantidad = isNaN(cantidad) || cantidad=='' || !Number.isInteger(parseFloat(cantidad))?0:parseFloat(cantidad); 
    
    pc = Math.round((precio_sub/cantidad)*100)/100;
    
    $("#prec_c"+item).val(pc.toFixed(2));
    
    calcular_total();
}

function calcular_total(){
    var subtotales = 0;
    var total = 0;
    $("input[tot='sub']").each(function(){
        var st_det = $(this).val();
        if (!isNaN(st_det) && st_det!=''){
            subtotales+=parseFloat(st_det);
        }        
    });  
    total = parseFloat(subtotales).toFixed(2);
    $("#subtotal").val(parseFloat(total).toFixed(2));  
     neto_pagar();
}

function neto_pagar(){
    subtotal = parseFloat($("#subtotal").val());
    
    igv = $("#igv").val();
    igv = isNaN(igv) || igv=='' ?0:parseFloat(igv);
    
    descuento = $("#descuento").val();        
    descuento = isNaN(descuento) || descuento=='' ?0:parseFloat(descuento);        
    
    total = subtotal + igv;
    $("#total_compra").val(parseFloat(total).toFixed(2));
    
    neto_pago = total - descuento;
    
    $("#neto_compra").val(parseFloat(neto_pago).toFixed(2))
    
    
}

function get_listproduct(){
    barras = $("#codbarras").val();
    
    if(barras!=""){
        $.ajax({
            url: base_url + "productos/json_lista_barras/"+barras,
            type: 'GET',
            dataType: 'JSON',
            async: true,
            success: function (data) {
                if(data.length > 0){
                    for(i=0;i<data.length;i++){
                        tr(data[i]);
                    }
                }
            }
        });   
    }
    
}

function save(e) {
    
    if($("#btn_save").is(":disabled") ){
        alerta("Procesando Compra","En estos momentos se esta procesando la Compra",'warning');
        return 0;
    }else{
        $("#btn_save").attr({'disabled':'disabled'});
    }
    
    fallas=true;
    
    if(
            $("#tienda").val()=="" || 
            $("#fecha_compra").val()=="" || 
            $("#idproveedor").val() == "" ||
            $("#nro_comprobante_compra").val() == ""
    ){
        alerta("Campos en Blanco","Llene todos los Campos",'warning');
    }else{
        if($("tr[row='row']").length == 0){
            alerta("No hay Productos","La compra no tiene Productos",'warning');
        }else{
            fallas=false;
        }
    }
    
    
    if(!fallas){
        $.ajax({
            type: 'POST',
            url: base_url +"orden_compras/save",
            data:$("#form-compras").find("select,textarea,input").serialize(),
            dataType: 'json',
            success: function (result) {
                alerta("Se Guardo Correctamente","Registro Guardado con Exito","success");
                setTimeout(function(){
                        window.location.replace(base_url +"orden_compras/lista");
                }, 1700);
                
            },
            error:function (result) {
	       	alerta("Error al guardar","La Orden de Compra no fue guardada.",'danger');
            },
            complete:function (result){
                $("#btn_save").removeAttr('disabled');
            }
        });
    }else{
    	$("#btn_save").removeAttr('disabled');
    }
    
}

