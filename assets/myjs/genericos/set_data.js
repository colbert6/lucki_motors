function close_modals(){
    $('.modal').modal('toggle');
}

function set_data( set_data ){ 

    /////--------SE DEFINE LAS VARIABLES
    msj_success_true = set_data.msj_success_true || 'Datos Guardados';//mensaje en caso la respuesta sera TRUE
    url_reload = set_data.url_reload || base_url; //Direccion a recargar
    btn_disabled = set_data.btn_disabled || 'btn_save'; //Boton a a habilitar en caso error
    text_carga = set_data.text_carga || ''; //Mensaje en carga

    var buttons_respuesta = { refrescar: {label: "Aceptar", className: 'btn-info',
            callback: function() {
                $(location).attr('href', url_reload);    
            } 
        },
    };

    buttons_respuesta = set_data.buttons_respuesta || '';

    
    if(set_data.url_save === undefined ){
        bootbox.alert({
            message:  'ERROR: URL save requerido',
            closeButton: true
        });
        $("#"+btn_disabled).removeAttr('disabled'); 
        return 0;
    }
    
    msj_proceso = bootbox.alert({
        title: 'Solicitud enviada',
        message: text_carga+"<p id='carga_msj'> <i class='fa fa-spin fa-spinner'></i> Procesando ...</p>",
        closeButton: false
    }); 
    	
    $.ajax({
        type:   set_data.type || 'POST',
        url:    set_data.url_save,
        data:   set_data.data,
        dataType: set_data.dataType || 'json',

        success: function (result) {

            if(result.estado){
                msj_proceso.modal('hide');

                idsave = result.idsave;
                bootbox.dialog({
                    title: 'Respuesta',
                    closeButton: false,
                    message: msj_success_true,
                    buttons: buttons_respuesta
                });
                
            }else{
                msj_proceso.find('#carga_msj').html("ERROR : "+result.error+"");
            }           
            
        },
        error:function (result) {
            msj_proceso.find('#carga_msj').html("<p>Error en respuesta desde servidor</p>");
        },
        complete:function (){
            $("#"+btn_disabled).removeAttr('disabled');
        }
    });		
    	
   
}


function open_imprimir (url_controller, idsave){
    url = base_url + url_controller + idsave;
    window.open(url, '_blank');
    $(location).attr('href', url_reload);   
}
