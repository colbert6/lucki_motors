
function cargar_reporte() {
	// body...
	pedido_get = 'fi='+$("#fecha_inicio").val();
	pedido_get += '&ff='+$("#fecha_fin").val();
	pedido_get += '&tr='+$("#tipo_reporte").val();

	$("#conten_reporte").html("<i class='fa fa-spin fa-refresh fa-2x'></i>");
	$("#conten_reporte").load( base_url+"reporte_productos/get_reporte_productos?"+pedido_get );
}
