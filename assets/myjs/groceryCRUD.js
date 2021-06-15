
$(document).ready(function () {

    $('.anular').on('click', function (e){

        e.preventDefault();

        href = $(this).attr('href'); 

        bootbox.confirm({
            message: "Seguro de eliminar registro?",
            buttons: {
                cancel: {
                    label: 'No',
                    className: 'btn-default'
                },
                confirm: {
                    label: 'Yes',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                
                if(result){
                    $.ajax({
                        url: href,
                        type: 'GET',
                        dataType: 'JSON',
                        async: true,
                        success: function (result) {
                            //  var rpta = JSON.parse(datos);

                            bootbox.dialog({
                                title: 'Solicitud de anulacion',
                                message: result.msj
                            });
                        }
                    });
                }                

            }
        });


    })

    $('.imprimir , .guia').on('click', function (e){

        e.preventDefault();

        href = $(this).attr('href'); 

        window.open(href, '_blank');


    })


    

    
    $('.ver_imagen').on('click', function (e){

        e.preventDefault();
        href = $(this).attr('href'); 
        console.log("on click");
        $.ajax({
            url: href,
            type: 'GET',
            dataType: 'JSON',
            async: true,
            success: function (datos) {
                //  var rpta = JSON.parse(datos);

                url_base_img = "http://localhost/lucki_motors/assets/uploads/productos/"

                bootbox.dialog({
                    title: "Imagen del producto: "+datos.nombre ,
                    message: "<img src='" + url_base_img + datos.imagen + "'>",
                    size: 'large',
                    buttons: {
                        confirm: {
                            label: '<i class="fa fa-check"></i> Aceptar'
                        }
                    },
                });
                return false;
            }
        });
        return false;
     

    })

	
});


function ver_img(id_prod){
     event.preventDefault();
        href = $(this).attr('href'); 
        console.log("on click");
        $.ajax({
            url: "http://localhost/lucki_motors/almacenes/ver_imagen_producto?idproducto="+id_prod,
            type: 'GET',
            dataType: 'JSON',
            async: true,
            success: function (datos) {
                //  var rpta = JSON.parse(datos);

                url_base_img = "http://localhost/lucki_motors/assets/uploads/productos/"

                bootbox.dialog({
                    title: "Imagen del producto: "+datos.nombre ,
                    message: "<img src='" + url_base_img + datos.imagen + "'>",
                    size: 'large',
                    buttons: {
                        confirm: {
                            label: '<i class="fa fa-check"></i> Aceptar'
                        }
                    },
                });
                return false;
            }
        });
        return false;
}

