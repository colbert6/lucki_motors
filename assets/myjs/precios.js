
function table(obj){
    
    if(typeof obj != "undefined"){
        id = obj.idproducto;
        refresh_table(id);
        $("#table_precios").html('<i class="fa fa-cog fa-spin fa-3x fa-fw"></i><span style="font-size: 25px;"> Cargando...</span>');  
    }  
}

function refresh_table(id){

    $.get(base_url + "precios/table_historial/"+id,function (data){
        $("#table_precios").empty().html(data);   
        $("#div_buscar_producto").find('input').val('');
    });
}

function save_precio(){

    precio = $('#precio_venta').val();
    id = $('#idproducto_save').val(); 

    if(precio != "" && precio > 0 ){
        $.ajax({
            type: 'POST',
            url: base_url +"precios/save",
            data:{
                "precio":precio,
                "idprod":id
            },
            dataType: 'json',
            success: function (result) {
                alerta("Precio Guardado","Registro Guardado con Exito","success");
                $('#precio_venta').val("");
                $('#precio_venta').focus();
                refresh_table(id)
            },
            error:function (result) {
                alerta("Error al Guardar","ocurrio un problema al guardar","error");
            }
        });
    }else{
        alerta("Precio no valido","El nuevo precio debe ser mayor a cero.","error");
    }
    
}