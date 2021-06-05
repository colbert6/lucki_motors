<?php

	session_name("siincoweb");

	if(!session_start()){session_start();}



	//error_reporting(E_ALL | E_STRICT);

    //ini_set("display_errors", 1);



    set_time_limit(0);

	include("../../../objetos/clsReporte.php");

	include("../../../objetos/clsReporteExcel.php");



   



	class clsPadron extends clsFunciones

	{

		 function contenido($codsuc, $calle, $NroInscripcion) {

            global $conexion;

            

            $Sql = "SELECT f.codantiguo, f.codsector, ";

            $Sql .= " (btrim(to_char(f.codsuc, '00')) || '-' || btrim(to_char(f.codzona, '00')) || '-' || btrim(to_char(f.codsector, '00')) || '-' || ";

            $Sql .= " btrim(to_char(f.codmanzanas::integer, '000')) || '-' || btrim(to_char(f.nrolote::integer, '0000')) || '-' || btrim(f.sublote)) AS codcatastro, ";

            $Sql .= " f.propietario, f.nrodocumento, ";

            //$Sql .= " ts.descripcion AS tipo_servicio, ";

            $Sql .= " cajagua.descripcion AS cajaagua, ";

            $Sql .= " cajdes.descripcion AS cajades, ";



            $Sql .= " f.propietario, f.nrodocumento, ";

            $Sql .= " tipcon.descripcion AS tipo_ingreso, ";

            $Sql .= " catt.descripcion AS categoria_tarifaria, ";

            $Sql .= " CASE f.codtiposervicio WHEN 1 THEN 'A/D' WHEN 2 THEN 'A' WHEN 3 THEN 'D' WHEN 0 THEN 'SIN' ELSE 'NO sabe' END AS tipo_servicio, ";

            $Sql .= " f.nromed, dm.descripcion AS diametro_medidor, ";

            $Sql .= " f.codcalle, ct.descripcioncorta || ' ' || c.descripcion AS direccion, f.nrocalle, f.nrolote, ";

            $Sql .= " es.descripcion AS estado_servicio_agua, da.descripcion AS diametro_agua, f.fechainsagua, ";

            $Sql .= " esd.descripcion AS estado_servicio_desague, dd.descripcion AS diametro_desague, f.fechainsdesague ";

            $Sql .= "FROM gis.catastro f";

            $Sql .= " INNER JOIN gis.tiposervicio ts ON (f.codtiposervicio = ts.codtiposervicio)";

            $Sql .= " LEFT OUTER JOIN gis.categoriatarifaria catt ON (f.catetar = catt.codcategoriatar)";

            $Sql .= " LEFT OUTER JOIN gis.matcajaagua cajagua ON (f.codmatcajaagua = cajagua.codmatcajaagua)";

            $Sql .= " LEFT OUTER JOIN gis.matcajadesague cajdes ON (f.codmatcajadesague = cajdes.codmatcajadesague)";

            $Sql .= " LEFT OUTER JOIN gis.tipoingresoconexion tipcon ON (f.codtipoingresoconexion = tipcon.codtipoingresoconexion)";

            

            $Sql .= " LEFT OUTER JOIN public.diametrosagua da ON (f.coddiametrosagua = da.coddiametrosagua)";

            $Sql .= " INNER JOIN public.calles c ON (f.codemp = c.codemp) AND (f.codsuc = c.codsuc) AND (f.codcalle = c.codcalle)";

            $Sql .= " INNER JOIN public.tiposcalle ct ON (c.codtipocalle = ct.codtipocalle)";

            $Sql .= " INNER JOIN gis.estadoservicio es ON (f.codestadoservicio_agua = es.codestadoservicio)";

            $Sql .= " LEFT OUTER JOIN public.diametrosmedidor dm ON (f.coddiametrosmedidor = dm.coddiametrosmedidor)";

            $Sql .= " INNER JOIN gis.estadoserviciodes esd ON (f.codestadoservicio_desa = esd.codestadoserviciodes)";

            $Sql .= " LEFT OUTER JOIN public.diametrosdesague dd ON (f.coddiametrosdesague = dd.coddiametrosdesague)";

            $Sql .= "WHERE f.codantiguo = '".$NroInscripcion."' ";

         	//die($Sql);               

            $consulta = $conexion->prepare($Sql);

            $consulta->execute(array());

    

            $Row = $consulta->fetch();



            return $Row;

            //echo "<pre>";print_r($Row);exit();



            }



            

    }



    $codsuc	= $_GET["codsuc"];

	$codsector	= $_GET["codsector"];

	$manzanas	= $_GET["manzanas"] + 0;

	$tipousuario	= $_GET["tipousuario"];

	$catetar	= $_GET["catetar"];

	$FechaDesde	= $_GET["FechaDesde"];

	$FechaHasta	= $_GET["FechaHasta"];

    $ChckFechaDig	= $_GET["ChckFechaDig"];

    

    $objReporte = new clsPadron();





    $Sql = "SELECT f.codantiguo ";

	$Sql .= "FROM gis.catastro f";

	$Sql .= " INNER JOIN gis.tiposervicio ts ON (f.codtiposervicio = ts.codtiposervicio)";

	$Sql .= " LEFT OUTER JOIN public.diametrosagua da ON (f.coddiametrosagua = da.coddiametrosagua)";

	$Sql .= " INNER JOIN public.calles c ON (f.codemp = c.codemp) AND (f.codsuc = c.codsuc) AND (f.codcalle = c.codcalle)";

	$Sql .= " INNER JOIN public.tiposcalle ct ON (c.codtipocalle = ct.codtipocalle)";

	$Sql .= " INNER JOIN gis.estadoservicio es ON (f.codestadoservicio_agua = es.codestadoservicio)";

	$Sql .= " LEFT OUTER JOIN public.diametrosmedidor dm ON (f.coddiametrosmedidor = dm.coddiametrosmedidor)";

	$Sql .= " INNER JOIN gis.estadoserviciodes esd ON (f.codestadoservicio_desa = esd.codestadoserviciodes)";

	$Sql .= " LEFT OUTER JOIN public.diametrosdesague dd ON (f.coddiametrosdesague = dd.coddiametrosdesague)";

	$Sql .= " WHERE f.codsuc = ".$codsuc." ";





	$Sql_gtusu = "SELECT f.codtipousuario,gis.tipousuario.descripcion, count(f.codantiguo) ";

	$Sql_gtusu .="FROM gis.catastro f ";

	$Sql_gtusu .="INNER JOIN gis.tipousuario ON f.codtipousuario = gis.tipousuario.codtipousuario ";

	$Sql_gtusu .= " WHERE f.codsuc = ".$codsuc." ";





	$Sql_gcat = "SELECT f.catetar,catt.descripcion, count(f.codantiguo) ";

	$Sql_gcat .="FROM gis.catastro f ";

	$Sql_gcat .="LEFT OUTER JOIN gis.categoriatarifaria catt ON (f.catetar = catt.codcategoriatar)";

	$Sql_gcat .= " WHERE f.codsuc = ".$codsuc." ";



	$Sql_sca = "SELECT f.codestadoservicio_agua,ests.descripcion, count(f.codantiguo) ";

	$Sql_sca .= "FROM gis.catastro f ";

	$Sql_sca .= "LEFT OUTER JOIN gis.estadoservicio ests ON (f.codestadoservicio_agua = ests.codestadoservicio)";

	$Sql_sca .= " WHERE f.codsuc = ".$codsuc." ";



	$Sql_scd = "SELECT f.codestadoservicio_desa,esd.descripcion, count(f.codantiguo) ";

	$Sql_scd .= "FROM gis.catastro f ";

	$Sql_scd .= "LEFT OUTER JOIN gis.estadoserviciodes esd ON (f.codestadoservicio_desa = esd.codestadoserviciodes)";

	$Sql_scd .= " WHERE f.codsuc = ".$codsuc." ";



	$Sql_tipcon = "SELECT f.codtipoingresoconexion,tipcon.descripcion, count(f.codantiguo) ";

	$Sql_tipcon .="FROM gis.catastro f ";

	$Sql_tipcon .="LEFT OUTER JOIN gis.tipoingresoconexion tipcon ON (f.codtipoingresoconexion = tipcon.codtipoingresoconexion)";

	$Sql_tipcon .= " WHERE f.codsuc = ".$codsuc." ";



	$Sql_diaagua = "SELECT f.coddiametrosagua,da.descripcion, count(f.codantiguo) ";

	$Sql_diaagua .="FROM gis.catastro f ";

	$Sql_diaagua .="LEFT OUTER JOIN public.diametrosagua da ON (f.coddiametrosagua = da.coddiametrosagua)";

	$Sql_diaagua .= " WHERE f.codsuc = ".$codsuc." ";


	

	



	if( $codsector != 0){

		$Sql .= "AND f.codsector = ".$codsector." ";

		$Sql_gtusu .="AND f.codsector = ".$codsector." ";

		$Sql_gcat .="AND f.codsector = ".$codsector." ";

		$Sql_tipcon .="AND f.codsector = ".$codsector." ";

		$Sql_sca .="AND f.codsector = ".$codsector." ";

		$Sql_scd .="AND f.codsector = ".$codsector." ";

		$Sql_diaagua .="AND f.codsector = ".$codsector." ";

	}

	if( $manzanas != 0){

		$Sql .= "AND (f.codmanzanas::integer) = '".$manzanas."' ";

		$Sql_gtusu .= "AND (f.codmanzanas::integer) = '".$manzanas."' ";

		$Sql_gcat .="AND (f.codmanzanas::integer) = '".$manzanas."' ";

		$Sql_tipcon .="AND (f.codmanzanas::integer) = '".$manzanas."' ";

		$Sql_sca .="AND (f.codmanzanas::integer) = '".$manzanas."' ";

		$Sql_scd .="AND (f.codmanzanas::integer) = '".$manzanas."' ";

		$Sql_diaagua .="AND (f.codmanzanas::integer) = '".$manzanas."' ";

	}

	if( $tipousuario != 0){

		$Sql .= "AND f.codtipousuario = ".$tipousuario." ";

		$Sql_gtusu .= "AND f.codtipousuario = ".$tipousuario." ";

		$Sql_gcat .="AND f.codtipousuario = ".$tipousuario." ";

		$Sql_tipcon .="AND f.codtipousuario = ".$tipousuario." ";

		$Sql_sca .="AND f.codtipousuario = ".$tipousuario." ";

		$Sql_scd .="AND f.codtipousuario = ".$tipousuario." ";

		$Sql_diaagua .="AND f.codtipousuario = ".$tipousuario." ";

	}

	if( $catetar != 0){

		$Sql .= "AND f.catetar = ".$catetar." ";

		$Sql_gtusu .= "AND f.catetar = ".$catetar." ";

		$Sql_gcat .="AND f.catetar = ".$catetar." ";

		$Sql_tipcon .="AND f.catetar = ".$catetar." ";

		$Sql_sca .="AND f.catetar = ".$catetar." ";

		$Sql_scd .="AND f.catetar = ".$catetar." ";

		$Sql_diaagua .="AND f.catetar = ".$catetar." ";

	}



	if(!$ChckFechaDig){



		$Sql .= " AND ( f.fecha_digitacion BETWEEN '".$objReporte->CodFecha($FechaDesde)."' AND  '".$objReporte->CodFecha($FechaHasta)."' ) ";

		$Sql_gtusu .= " AND ( f.fecha_digitacion BETWEEN '".$objReporte->CodFecha($FechaDesde)."' AND  '".$objReporte->CodFecha($FechaHasta)."' ) ";

		$Sql_gcat .=" AND ( f.fecha_digitacion BETWEEN '".$objReporte->CodFecha($FechaDesde)."' 

		AND  '".$objReporte->CodFecha($FechaHasta)."' ) ";

		$Sql_tipcon .=" AND ( f.fecha_digitacion BETWEEN '".$objReporte->CodFecha($FechaDesde)."' AND  '".$objReporte->CodFecha($FechaHasta)."' ) ";

		$Sql_sca .=" AND ( f.fecha_digitacion BETWEEN '".$objReporte->CodFecha($FechaDesde)."' AND  '".$objReporte->CodFecha($FechaHasta)."' ) ";

		$Sql_scd .=" AND ( f.fecha_digitacion BETWEEN '".$objReporte->CodFecha($FechaDesde)."' AND  '".$objReporte->CodFecha($FechaHasta)."' ) ";

		$Sql_diaagua .=" AND ( f.fecha_digitacion BETWEEN '".$objReporte->CodFecha($FechaDesde)."' AND  '".$objReporte->CodFecha($FechaHasta)."' ) ";



	}





	$Sql .= "ORDER BY f.nrocalle ";

	$Sql_gtusu .="GROUP BY f.codtipousuario,gis.tipousuario.descripcion";

	$Sql_gcat .="GROUP BY f.catetar,catt.descripcion";

	$Sql_tipcon .="GROUP BY f.codtipoingresoconexion,tipcon.descripcion";

	$Sql_sca .="GROUP BY f.codestadoservicio_agua,ests.descripcion";

	$Sql_scd .="GROUP BY f.codestadoservicio_desa,esd.descripcion";

	$Sql_diaagua .="GROUP BY f.coddiametrosagua,da.descripcion";

//die($Sql_gtusu);





	$consulta = $conexion->query($Sql);

    $items = $consulta->fetchAll();



	$resultado = $conexion->query($Sql_gtusu);

    $tipousuario = $resultado->fetchAll();



    $resultadocat = $conexion->query($Sql_gcat);

    $categoria_tar = $resultadocat->fetchAll();



    $resultadotipcon = $conexion->query($Sql_tipcon);

    $tipoingreso_con = $resultadotipcon->fetchAll();



	$resultadoeca = $conexion->query($Sql_sca);

	$tipo_sconagua = $resultadoeca->fetchAll();



	$resultadoecd = $conexion->query($Sql_scd);

	$tipo_scondes = $resultadoecd->fetchAll();



	$resultadodiaagua = $conexion->query($Sql_diaagua);

	$diametros_agua = $resultadodiaagua->fetchAll();





//echo "<pre>";print_r($tipousuario);exit();



	$objReporte	= new clsPadron();

	$fecha		= $objReporte->CodFecha($_GET["fecha"]);

	$Aempresa=	$objReporte->datos_empresa( $codsuc);



	$Empresa	= $Aempresa["razonsocial"];

	$Sucursal	= $Aempresa["descripcion"];

	$Direccion	= $Aempresa["direccion"];

	$ColData = 5;

	$ColImg  = 2;



	$impcancelado	= 0;

	$impamortizado 	= 0;



//Tipo de Usuario



$date = date('Y-m-d H:i:s');

 

header("Content-type: application/vnd.ms-excel; name='excel'");

header("Content-Disposition: filename=padron_usuarios_$date.xls");

header("Pragma: no-cache");

header("Expires: 0");


	

?>



<link href="<?php echo $_SESSION['urldir'];?>css/<?=$StyloJQuery?>" rel="stylesheet" type="text/css"  />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<table class="ui-widget" border="0" cellspacing="0" id="TbCabecera" width="100%" rules="rows">

	<thead class="ui-widget-header" style="font-size:14px">

	  <tr title="Cabecera">

	    <th width="20%" colspan="<?=$ColImg?>" rowspan="5" align="left">&nbsp;&nbsp;

	      <img src="<?php echo $_SESSION['urldir'];?>images/logo_empresa.jpg" height="70"/>

	    </th>

	    <th width="80%" colspan="<?=$ColData?>" align="left" scope="col" ><?=($Empresa)?></th>

	  </tr>

	  <tr title="Cabecera">

	    <th scope="col" colspan="<?=$ColData?>" align="left" ><?=($Direccion)?></th>

	  </tr>

	  <tr title="Cabecera">

	    <th scope="col" colspan="<?=$ColData?>" align="left" >SUCURSAL : <?=$Sucursal?></th>

	  </tr>

	 

	</thead>

</table>



<table class="ui-widget" border="0" cellspacing="0" id="TbTitulo" width="100%" rules="rows">

    <thead class="ui-widget-header" style="font-size:14px">

        <tr title="Cabecera">

            <th scope="col" colspan="7" align="center" >PADRON</th>

        </tr>

        <tr></tr>

        <tr>

          

        </tr>

    </thead>

</table>

<?php  

    

?>

<table>

    <thead>

        

        <tr>

        	<th width="200" scope="col" class="ui-widget-header" >CODCAT</th>

            <th width="50" scope="col" class="ui-widget-header">INSCRINRO</th>

            <th width="50" scope="col" class="ui-widget-header">SECT</th>

            <th width="50" scope="col" class="ui-widget-header">Nombre / Razón Social</th>

            <th width="50" scope="col" class="ui-widget-header">DNI</th>

            <th width="50" scope="col" class="ui-widget-header">Nombre de Calle</th>

            <th width="50" scope="col" class="ui-widget-header">Nro</th>

            <th width="50" scope="col" class="ui-widget-header">LOTE</th>

            <th width="50" scope="col" class="ui-widget-header">T. Serv</th>



            <th width="50" scope="col" class="ui-widget-header">Catetar.</th>

            <th width="50" scope="col" class="ui-widget-header">Nro Medidor</th>

            <!--th width="50" scope="col" class="ui-widget-header">Diámetro.</th-->

            <th width="50" scope="col" class="ui-widget-header">Tipo ingreso</th>

            <th width="50" scope="col" class="ui-widget-header">Est Con Ag.</th>

            <th width="50" scope="col" class="ui-widget-header">Diámetro Ag.</th>

            <th width="50" scope="col" class="ui-widget-header">Caja Ag.</th>

            <th width="50" scope="col" class="ui-widget-header">Est Con Des.</th>

            <th width="50" scope="col" class="ui-widget-header">Diámetro Des.</th>

            <th width="50" scope="col" class="ui-widget-header">Caja Des.</th>

        </tr>

    </thead>



    <tbody>

 	<?php  



	$contador = 0;

    foreach($items as $row) {

		$Row = $objReporte->contenido($codsuc, $calle, $row['codantiguo']);

		



		?>

			<tr>

			<td><?=$Row['codcatastro']?></td>

			<td style="mso-number-format:'\@'"><?=$Row['codantiguo']?></td>

			<td><?=$Row['codsector']?></td>

			<td style="mso-number-format:'\@'"><?=$Row['propietario']?></td>

			<td><?=$Row['nrodocumento']?></td>

			<td style="mso-number-format:'\@'"><?=$Row['direccion']?></td>

			<td><?=$Row['nrocalle']?></td>

			<td><?=$Row['nrolote']?></td>

			<td style="mso-number-format:'\@'"><?=$Row['tipo_servicio']?></td>

			<td ><?=$Row['categoria_tarifaria']?></td>

			<td style="mso-number-format:'\@'"><?=$Row['nromed']?></td>

			<!--td><?=$Row['diametro_medidor']?></td-->

			<td><?=$Row['tipo_ingreso']?></td>

			

			<td style="mso-number-format:'\@'"><?=$Row['estado_servicio_agua']?></td>

			<td style="mso-number-format:'\@'"><?=$Row['diametro_agua']?></td>

			<td><?=$Row['cajaagua']?></td>

			<td style="mso-number-format:'\@'"><?=$Row['estado_servicio_desague']?></td>

			<td ><?=$Row['diametro_desague']?></td>

			<td><?=$Row['cajades']?></td>



			</tr>

			<? $contador++ ?>

			

		<?php		

	} 





?> 



<tfoot>

	<tr></tr>

	<tr></tr>

	<tr>

			<td colspan="3">Tipo servicio</td>

	</tr>

<?php

	foreach($tipousuario as $key => $val) {

?>		

		<tr>

			<td><strong><?= $val['descripcion'] ?></strong></td>

			<td><strong>:</strong></td>

			<td><strong><?= $val['count'] ?></strong></td>

		</tr>

<?php

	

	}

?> 

	<tr></tr>

	<tr>

		<td colspan="3">Categoria Tarifaria</td>

	</tr>



<?php



	foreach($categoria_tar as $key => $val) {

?>

		

		<tr>

			<td><strong><?= $val['descripcion'] ?></strong></td>

			<td><strong>:</strong></td>

			<td><strong><?= $val['count'] ?></strong></td>

		</tr>

<?php

	

	}



?>

	<tr></tr>

	<tr>

		<td colspan="3">Tipo Ingreso</td>

	</tr>



<?php



	foreach($tipoingreso_con as $key => $val) {

?>

		

		<tr>

			<td><strong><?= $val['descripcion'] ?></strong></td>

			<td><strong>:</strong></td>

			<td><strong><?= $val['count'] ?></strong></td>

		</tr>

<?php

	

	}



?>



	<tr></tr>

	<tr>

		<td colspan="3">Estado con agua</td>

	</tr>



	<?php



	foreach($tipo_sconagua as $key => $val) {

		?>



		<tr>

			<td><strong><?= $val['descripcion'] ?></strong></td>

			<td><strong>:</strong></td>

			<td><strong><?= $val['count'] ?></strong></td>

		</tr>

		<?php



	}



	?>



	<tr></tr>

	<tr>

		<td colspan="3">Estado con desague</td>

	</tr>



	<?php



	foreach($tipo_scondes as $key => $val) {

		?>



		<tr>

			<td><strong><?= $val['descripcion'] ?></strong></td>

			<td><strong>:</strong></td>

			<td><strong><?= $val['count'] ?></strong></td>

		</tr>

		<?php



	}



	?>

	<tr></tr>

	<tr>

		<td colspan="3">Diametro Agua</td>

	</tr>

	<?php


	foreach($diametros_agua as $key => $val) {

		?>

		<tr>

			<td><strong><?= $val['descripcion'] ?></strong></td>

			<td><strong>:</strong></td>

			<td><strong><?= $val['count'] ?></strong></td>

		</tr>

		<?php

	}


	?>



</tfoot>



