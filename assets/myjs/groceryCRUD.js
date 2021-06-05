
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


    $('.cpe_consulta').on('click', function (e){

        e.preventDefault();

        href = $(this).attr('href'); 

        $.ajax({
            url: href,
            type: 'GET',
            dataType: 'JSON',
            async: true,
            success: function (datos) {
                //  var rpta = JSON.parse(datos);
                texto = JSON.stringify(datos, null, '    ');


                bootbox.dialog({
                    title: "Consulta de CPE",
                    message: "<pre>"+texto,
                    size: 'large',
                    buttons: {
                        confirm: {
                            label: '<i class="fa fa-check"></i> Aceptar'
                        }
                    },
                });
            }
        });
     

    })


    $('.cpe_envio').on('click', function (e){

        e.preventDefault();

        href = $(this).attr('href'); 

        $.ajax({
            url: href,
            type: 'GET',
            dataType: 'JSON',
            async: true,
            success: function (datos) {
                //  var rpta = JSON.parse(datos);
                texto = JSON.stringify(datos, null, '    ');


                bootbox.dialog({
                    title: "Consulta de CPE",
                    message: "<pre>"+texto,
                    size: 'large',
                    buttons: {
                        confirm: {
                            label: '<i class="fa fa-check"></i> Aceptar'
                        }
                    },
                });
            }
        });
     

    })


	
});

