
$(document).ready(function () {
    get_control_ventas();
});

function get_control_ventas(){
	$('#get_control_ventas>i').addClass('fa-spin');
	fecha_control= $('#fecha_control').val();
	$.ajax({
        url: base_url + "ventas/control_ventas",
        type: 'GET',
        data: {fecha:fecha_control},
        dataType: 'JSON',
        async: true,
        success: function (data) {

            $('#monto_fecha').html('S/ '+data[0].total_venta_fecha);
            $('#monto_fecha_mes').html('S/ '+data[1].total_venta_mes);
            $('#fecha_consulta').html('Fecha : '+fecha_control);
            $('#get_control_ventas>i').removeClass('fa-spin');


        },
        error: function (data) {
        	$('#get_control_ventas>i').removeClass('fa-spin');
        }
    });
} 


