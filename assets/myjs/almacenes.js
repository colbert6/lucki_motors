 var tableData;
$(document).ready(function () {
    $("#listCategorias").select2({
        placeholder: "Seleccione ...",
        allowClear: true
    });
    $("#listMarcas").select2({
        placeholder: "Seleccione ...",
        allowClear: true
    });
    obtenerProductos_cf();
    
});

function obtenerProductos_cf(){
    
    if($("#tienda_cf").val()!=""){
        $.get(base_url +"almacenes/lista_productos_cf",
        {
            t: $("#tienda_cf").val(),
            c: $("#listCategorias").val(),
            m: $("#listMarcas").val()
        },function(data){
            $("#showtable").empty().html(data);
        });
    }
}

function obtenerProductos_sf(){

    if($("#tienda_sf").val()!=""){

    }
}


function cargaMarcas(){
    
}

//https://stackoverflow.com/questions/51358233/jquery-datatable-server-side-processing-pagination-and-search-not-working
//https://es.stackoverflow.com/questions/238027/c%C3%B3mo-agregar-botones-editar-y-eliminar-al-datatables-js-al-hacer-el-procesamie