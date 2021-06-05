var lista_productos ;
var total_compra = 0;
var nrocomprobante;
var correlativo;

$(document).ready(function () {
    get_lista_colaborador("colaborador_compra","Colaborador Compra");
    get_lista_colaborador("colaborador_almacen","Colaborador Almacen");
    get_lista_proveedor();
    get_lista_productos();
    // CORRELATIVO ORDEN DE COMPRA
    get_correlativo(); 
    
    // METODOS ABREVIADOS
    shortcut.add("F9",function() {
        save();
    });
    shortcut.add("Ctrl+b",function() {
        $("#codbarras").focus();
    });
    
});

function updateData(){
    $.ajax({
        url: base_url + "orden_compras/updateOrdenCompra",
        type: 'POST',
        data: $("#form-compras").find("select,textarea,input").serialize(),
        dataType: 'JSON',
        async: true,
        success: function (data) {
            //console.log("Actualizado");
        }
    });
}
function updateDataDet(id){
    //console.log($("[cant='"+id+"']").val());
    $.ajax({
        url: base_url + "orden_compras/updateDetOrdenCompra",
        type: 'POST',
        data: {
            iddetorden:id,
            cant:$("[cant='"+id+"']").val(),
            sub:$("[sub='"+id+"']").val(),
            pc_actual:$("[pc_act='"+id+"']").val(),
            pv_actual:$("[pv_act='"+id+"']").val(),
            pc_anterior:$("[pc_ant='"+id+"']").val(),
            pv_anterior:$("[pv_ant='"+id+"']").val(),
            lt:$("[lt='"+id+"']").val(),
            venc:$("[venc='"+id+"']").val()
        },
        dataType: 'JSON',
        async: true,
        success: function (data) {
            //console.log("Actualizado");
        }
    });
}

function get_correlativo(){

    $.ajax({
        url: base_url + "orden_compras/correlativo",
        type: 'GET',
        data: {},
        dataType: 'JSON',
        async: true,
        success: function (data) {
            
            nro = "ORD-";
            if(data.length>0){
                cor = parseInt(data[0].correlativo)+1;
            }else{
                cor = 1;
            }
            nro+=""+cor;   
            $('#torden').text(nro);
            nrocomprobante = nro;
            correlativo=cor;
            
            generate_orden();
        }
    });
    
}
function generate_orden(){
    $.ajax({
        url: base_url + "orden_compras/autogenearate_ordencompra",
        type: 'POST',
        data: {nrocomp:nrocomprobante,corr:correlativo,autogenerado: $('#autogenerado').val()},
        dataType: 'JSON',
        async: true,
        success: function (data) {
            $('#idorden').val(data);
        }
    });
}

function get_lista_colaborador(id,messange){
    $.ajax({
        url: base_url + "colaboradores/json_lista",
        type: 'GET',
        dataType: 'JSON',
        async: true,
        success: function (data) {
            lista_colaborador = data;
            $('#'+id).select2({
                placeholder: messange,
                data : lista_colaborador
            });
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
    updateData();
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
    $('#input_buscar_producto').val(null);
    $.ajax({
        url: base_url + "compras/lista_productos",
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
    istable = true;
    if(
            $("#tienda").val()=="" || 
            $("#colaborador_compra").val() == "" ||
            $("#colaborador_almacen").val() == "" || 
            $("#fecha_compra").val() == "" ||
            $("#fecha_almacen").val() == "" ||
            $("#idproveedor").val() == "" ||
            $("#tipo_comprobante").val() == "" ||
            $("#nro_comprobante_compra").val() == ""
    ){
        alerta("Llene Datos de compra","Antes de agregar Productos llene Campos de Compra",'warning');
        
        setTimeout(function(){
            get_lista_productos();
        }, 1700);
        istable=false;
    }
    if(istable){
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
        $.ajax({
            url: base_url + "orden_compras/autogenearate_det_ordencompra",
            type: 'POST',
            data: {
                idprod:t.id,
                tienda:$("#tienda").val(),
                prodtext: t.text,
                idcompra:$("#idorden").val()
            },
            dataType: 'JSON',
            async: true,
            success: function (data) {
                reg = "";
                reg+= "<tr row='row' id='"+t.id+"'>";
                reg+= "<td>"+t.text+"\
                            <input type='hidden' id='iddetorden' name='iddetorden' value='"+data+"' />\
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
                                    cant='"+data+"'\n\
                                    onkeyup=\"calcular_pc('"+t.id+"','"+data+"')\" \n\
                                    onchange=\"calcular_pc('"+t.id+"','"+data+"')\" \n\
                                    type='text' \n\
                                    value='1'/>\n\
                        </td>";
                reg+= " <td>\n\
                            <input  \n\
                                    style='width:70px;'\n\
                                    class='form-control' \n\
                                    tot='sub'\n\
                                    sub='"+data+"'\n\
                                    name='sub[]' \n\
                                    id='sub"+t.id+"' \n\
                                    onkeyup=\"calcular_pc('"+t.id+"','"+data+"')\" \n\
                                    onchange=\"calcular_pc('"+t.id+"','"+data+"')\" \n\
                                    type='text' \n\
                                    value='0.00'/>\n\
                        </td>";
                reg+= " <td>\n\
                            <input \n\
                                    style='width:70px;'\n\
                                    readonly \n\
                                    class='form-control' \n\
                                    pc_act='"+data+"'\n\
                                    name='prec_c_act[]' \n\
                                    id='prec_c"+t.id+"' \n\
                                    type='text' \n\
                                    value='0.00'/>\n\
                        </td>";
                reg+= " <td>\n\
                            <input \n\
                                    type='number'\n\
                                    style='width:70px;'\n\
                                    class='form-control' \n\
                                    style='width:70px;'\n\
                                    pv_act='"+data+"'\n\
                                    name='prec_v_act[]' \n\
                                    id='prec_v"+t.id+"' \n\
                                    onkeyup=\"updateDataDet('"+data+"')\" \n\
                                    type='text' \n\
                                    value='"+t.precio_venta+"'/>\n\
                            </td>";
                reg+= " <td>\n\
                            <input \n\
                                    readonly\n\
                                    style='width:70px;'\n\
                                    class='form-control' \n\
                                    pc_ant='"+data+"'\n\
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
                                    pv_ant='"+data+"'\n\
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
                                    lt='"+data+"'\n\
                                    onkeyup=\"updateDataDet('"+data+"')\" \n\
                                    name='lt[]' \n\
                                    id='lt"+t.id+"'  \n\
                                    type='text' \n\
                                    value=''/>\n\
                        </td>";
                reg+= " <td>\n\
                            <input \n\
                                style='width:150px;'\n\
                                class='form-control' \n\
                                venc='"+data+"'\n\
                                onblur=\"updateDataDet('"+data+"')\"\n\
                                name='venc[]' \n\
                                id='venc"+t.id+"' \n\
                                type='date' \n\
                                value='"+hoy()+"'/>\n\
                        </td>";


                reg+= " <td><button class='btn btn-danger' onclick='remove_tr("+t.id+","+data+")'>X</button></td>";
                reg+= "</tr>";

                $("#table_detalle_compra").append(reg);
                calcular_pc(t.id,data);
                items();

                 $('#input_buscar_producto').val('0').trigger('change.select2');
                 $('#codbarras').val('');
            }
        });
        
    }else{
        $('#input_buscar_producto').val('0').trigger('change.select2');
    }   
}

function remove_tr(id,idbase){
    $.ajax({
        url: base_url + "orden_compras/deleteDetOrdenCompra",
        type: 'POST',
        data: {iddetorden:idbase},
        dataType: 'JSON',
        async: true,
        success: function (data) {
            $('#'+id).remove();
            items();
            calcular_total();
        }
    });
	
}
function items(){
    fila = $("tr[row='row']").length;
    $("#cantidadItem").text(fila);
}

function calcular_pc(item,idbase){
    cantidad = $("#cant"+item).val();
    precio_sub = $("#sub"+item).val();
    
    precio_sub = isNaN(precio_sub) || precio_sub=='' ?0:parseFloat(precio_sub);        
    cantidad = isNaN(cantidad) || cantidad=='' || !Number.isInteger(parseFloat(cantidad))?0:parseFloat(cantidad); 
    
    pc = Math.round((precio_sub/cantidad)*100)/100;
    
    $("#prec_c"+item).val(pc.toFixed(2));
    
    updateDataDet(idbase);
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
    // ACTUALIZANDO ORDDEN DE COMPRA
    updateData();
    // CALCULANDO NETO A PAGAR
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
            $("#colaborador_compra").val() == "" ||
            $("#colaborador_almacen").val() == "" || 
            $("#fecha_compra").val() == "" ||
            $("#fecha_almacen").val() == "" ||
            $("#idproveedor").val() == "" ||
            $("#tipo_comprobante").val() == "" ||
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
            url: base_url +"compras/save",
            data:$("#form-compras").find("select,textarea,input").serialize(),
            dataType: 'json',
            success: function (result) {
                alerta("Se Guardo Correctamente","Registro Guardado con Exito","success");
                setTimeout(function(){
                        window.location.replace(base_url +"compras/lista");
                }, 1700);
                
            },
            error:function (result) {
	       	alerta("Error al guardar","La Compra no fue guardada.",'danger');
            },
            complete:function (result){
                $("#btn_save").removeAttr('disabled');
            }
        });
    }else{
    	$("#btn_save").removeAttr('disabled');
    }
    
    
}
function cancelarOrden(){
    id = $("#idorden").val();
    console.log(id);
    $.ajax({
        type: 'POST',
        url: base_url +"orden_compras/isUpdated",
        data:{
            id:id
        },
        dataType: 'json',
        success: function (result) {
            window.location.replace(base_url +"compras/lista");
        }
    });

}

function get_search_orden(){
    codorden = $("#codorden").val();
    if(codorden!=""){
        $.post(base_url +"orden_compras/ajax_orden",{cod:codorden},function (orden) {
                if(orden.length > 0){
                    $.post(base_url +"orden_compras/ajax_detorden",{cod:codorden},function (detalle) {
                        $("#torden").removeClass().addClass("btn btn-warning btn-sm");
                        $("#torden").text(orden[0].nrocomprobante);
                        $("#idorden").val(orden[0].idcompra);
                        $("#tienda").val(orden[0].tienda_idtienda);
                        $("#fecha_compra").val(orden[0].fecha);
                        $("#idproveedor").val(orden[0].proveedor_idproveedor).trigger("change");
                        $("#obs_compra").val(orden[0].observacion);
                        
                        if(detalle.length>0){
                            for (var i = 0; i < detalle.length ; i++) {
                                // VARIABLES
                                data = detalle[i].iddetalle_compra;
                                id= detalle[i].producto_idproducto;
                                text = detalle[i].descripcion;
                                cantidad= detalle[i].cantidad;
                                subtotal= detalle[i].subtotal;
                                lote= detalle[i].lote;
                                vencimiento= detalle[i].fecha_vencimiento;
                                pc_act= detalle[i].pc_actual;
                                pv_act= detalle[i].pv_actual;
                                pc_ant= detalle[i].pc_anterior;
                                pv_ant= detalle[i].pv_anterior;
                                
                                
                                
                                reg = "";
                                reg+= "<tr row='row' id='"+id+"'>";
                                reg+= "<td>"+text+"\
                                            <input type='hidden' id='iddetorden' name='iddetorden' value='"+data+"' />\
                                            <input \n\
                                                    type='hidden' \n\
                                                    name='idprod[]' \n\
                                                    value='"+id+"' \n\
                                                    readonly />\n\
                                            <input \n\
                                                    type='hidden' \n\
                                                    name='prodtext[]' \n\
                                                    value='"+text+"' \n\
                                                    readonly />\n\
                                        </td>";

                                reg+= " <td>\n\
                                            <input  \n\
                                                    style='width:70px;'\n\
                                                    class='form-control' \n\
                                                    name='cant[]' \n\
                                                    id='cant"+id+"' \n\
                                                    cant='"+data+"'\n\
                                                    onkeyup=\"calcular_pc('"+id+"','"+data+"')\" \n\
                                                    onchange=\"calcular_pc('"+id+"','"+data+"')\" \n\
                                                    type='text' \n\
                                                    value='"+cantidad+"'/>\n\
                                        </td>";
                                reg+= " <td>\n\
                                            <input  \n\
                                                    style='width:70px;'\n\
                                                    class='form-control' \n\
                                                    tot='sub'\n\
                                                    sub='"+data+"'\n\
                                                    name='sub[]' \n\
                                                    id='sub"+id+"' \n\
                                                    onkeyup=\"calcular_pc('"+id+"','"+data+"')\" \n\
                                                    onchange=\"calcular_pc('"+id+"','"+data+"')\" \n\
                                                    type='text' \n\
                                                    value='"+subtotal+"'/>\n\
                                        </td>";
                                reg+= " <td>\n\
                                            <input \n\
                                                    style='width:70px;'\n\
                                                    readonly \n\
                                                    class='form-control' \n\
                                                    pc_act='"+data+"'\n\
                                                    name='prec_c_act[]' \n\
                                                    id='prec_c"+id+"' \n\
                                                    type='text' \n\
                                                    value='"+pc_act+"'/>\n\
                                        </td>";
                                reg+= " <td>\n\
                                            <input \n\
                                                    type='number'\n\
                                                    style='width:70px;'\n\
                                                    class='form-control' \n\
                                                    style='width:70px;'\n\
                                                    pv_act='"+data+"'\n\
                                                    name='prec_v_act[]' \n\
                                                    id='prec_v"+id+"' \n\
                                                    onkeyup=\"updateDataDet('"+data+"')\" \n\
                                                    type='text' \n\
                                                    value='"+pv_act+"'/>\n\
                                            </td>";
                                reg+= " <td>\n\
                                            <input \n\
                                                    readonly\n\
                                                    style='width:70px;'\n\
                                                    class='form-control' \n\
                                                    pc_ant='"+data+"'\n\
                                                    name='prec_c_ant[]' \n\
                                                    id='prec_c_ant"+id+"' \n\
                                                    onkeyup=\"\" \n\
                                                    type='text' \n\
                                                    value='"+pc_ant+"'/>\n\
                                            </td>";
                                reg+= " <td>\n\
                                            <input \n\
                                                    readonly\n\
                                                    style='width:70px;'\n\
                                                    class='form-control' \n\
                                                    pv_ant='"+data+"'\n\
                                                    name='prec_v_ant[]' \n\
                                                    id='prec_c_ant"+id+"' \n\
                                                    onkeyup=\"\" \n\
                                                    type='text' \n\
                                                    value='"+pv_ant+"'/>\n\
                                            </td>";
                                reg+= " <td>\n\
                                            <input \n\
                                                    placeholder='Lote' \n\
                                                    class='form-control' \n\
                                                    lt='"+data+"'\n\
                                                    onkeyup=\"updateDataDet('"+data+"')\" \n\
                                                    name='lt[]' \n\
                                                    id='lt"+id+"'  \n\
                                                    type='text' \n\
                                                    value='"+lote+"'/>\n\
                                        </td>";
                                reg+= " <td>\n\
                                            <input \n\
                                                style='width:150px;'\n\
                                                class='form-control' \n\
                                                venc='"+data+"'\n\
                                                onblur=\"updateDataDet('"+data+"')\"\n\
                                                name='venc[]' \n\
                                                id='venc"+id+"' \n\
                                                type='date' \n\
                                                value='"+vencimiento+"'/>\n\
                                        </td>";


                                reg+= " <td><button class='btn btn-danger' onclick='remove_tr("+id+","+data+")'>X</button></td>";
                                reg+= "</tr>";
                                
                                $("#table_detalle_compra").append(reg);
                                calcular_pc(id,data);
                                items();
                            } 
                        }
                    },"json");     
                }else{
                    alerta("Nose Encontro Orden de Compra","El codigo es Incorrecto","warning");
                    $("#codorden").focus(); 
                }
                
        
        },"json");
    }else{
        alerta("Orden Vacia","Ingrese Codigo de Orden","warning");
        $("#codorden").focus();
    }
    
    
    
}
