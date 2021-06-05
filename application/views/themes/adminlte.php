<?php /*$this->nombre_empresa = 'Favalu';
	  $this->metodo = 'Metodo';
	  $this->controller = 'Controlador';*/
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $this->nombre_empresa_abreviado; ?></title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/themes/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/themes/adminlte/bower_components/font-awesome/css/font-awesome.min.css')?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/themes/adminlte/bower_components/Ionicons/css/ionicons.min.css')?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/themes/adminlte/dist/css/AdminLTE.min.css')?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('assets/themes/adminlte/dist/css/skins/_all-skins.min.css')?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/js/toast/css/jquery.toast.css')?>">

	  <!-- jQuery 3 -->
	<script src="<?php echo base_url('assets/themes/adminlte/bower_components/jquery/dist/jquery.min.js')?>"></script>
	<!-- Bootstrap 3.3.7 -->
	<script src="<?php echo base_url('assets/themes/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')?>"></script>
	<!-- AdminLTE App -->
	<script src="<?php echo base_url('assets/themes/adminlte/dist/js/adminlte.min.js')?>"></script>
    <script src="<?php echo base_url('assets/js/toast/js/jquery.toast.js')?>"></script>

    <link rel='shortcut icon' type='image/png' href="<?php echo base_url('assets/img/logo_sistema.png')?>"/>
	

<?php
	/** -- Copy from here -- */
	if(!empty($meta))
	foreach($meta as $name=>$content){
		echo "\n\t\t";
		?><meta name="<?php echo $name; ?>" content="<?php echo $content; ?>" /><?php
			 }
	echo "\n";

	if(!empty($canonical))
	{
		echo "\n\t\t";
		?><link rel="canonical" href="<?php echo $canonical?>" /><?php

	}
	echo "\n\t";

	foreach($css as $file){
	 	echo "\n\t\t";
		?><link rel="stylesheet" href="<?php echo $file; ?>" type="text/css" /><?php
	} echo "\n\t";

	foreach($js as $file){
			echo "\n\t\t";
			?><script src="<?php echo $file; ?>"></script><?php
	} echo "\n\t";
	/** -- to here -- */
?>


  <!-- Google Font -->
  <link rel="stylesheet" href="<?php echo base_url('assets/fonts/fonts.googleapis.css')?>">

  <script type="text/javascript"> base_url = "<?php echo base_url();  ?>";</script>

</head>



<body class="skin-green sidebar-mini fixed " ><!--sidebar-collapse-->
<!-- Site wrapper -->
<div class="wrapper">

 	<header class="main-header">
    <!-- Logo -->
	    <a href="<?php echo base_url('principal');?>" class="logo">
	      <!-- mini logo for sidebar mini 50x50 pixels -->
	      <span class="logo-mini"><b><?php echo $this->nombre_empresa[0] ?></b>-sis</span>
	      <!-- logo for regular state and mobile devices -->
	      <span class="logo-lg"><b><?php echo $this->nombre_empresa ?></b>Sis</span>
	    </a>
	    <!-- Header Navbar: style can be found in header.less -->
	    <nav class="navbar navbar-static-top">
	      <!-- Sidebar toggle button-->
	      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </a>

	      <div class="navbar-custom-menu">
	        <ul class="nav navbar-nav">
	          
	          <!-- User Account: style can be found in dropdown.less -->
	          <li class="dropdown user user-menu">
	            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
	              <img src="<?php echo base_url('assets/themes/adminlte/dist/img/avatar04.png')?>" class="user-image" alt="User Image">
	              <span class="hidden-xs"><?php echo $this->nombre_usuario ?></span>
	            </a>
	            <ul class="dropdown-menu">
	              <!-- User image -->
	              <li class="user-header">
	                <img src="<?php echo base_url('assets/themes/adminlte/dist/img/avatar04.png')?>" class="img-circle" alt="User Image">

	                <p>
	                  <?php echo $this->nombre_usuario ?> - <?php echo $this->perfil_usuario ?>
	                  <small> <?php echo date('d M \d\e\l Y') ?></small>
	                </p>
	              </li>
	              <!-- Menu Body -->
	              <!--li class="user-body">
	                <div class="row">
	                  <div class="col-xs-4 text-center">
	                    <a href="#">Followers</a>
	                  </div>
	                  <div class="col-xs-4 text-center">
	                    <a href="#">Sales</a>
	                  </div>
	                  <div class="col-xs-4 text-center">
	                    <a href="#">Friends</a>
	                  </div>
	                </div>	                
	              </li-->
	              <!-- Menu Footer-->
	              <li class="user-footer">
	                <div class="pull-left">
	                  <a href="<?php echo base_url('principal');?>" target="_blank" class="btn btn-default btn-flat">Nueva Pestaña</a>
	                </div>
	                <div class="pull-right">
	                  <a href="<?php echo base_url('login/logout');?>" class="btn btn-default btn-flat">Cerrar sesion</a>
	                </div>
	              </li>
	            </ul>
	          </li>

	        </ul>
	      </div>
	    </nav>
  	</header>

  	<!-- =============================================== -->

  	<!-- Left side column. contains the sidebar -->
  	<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
	    <section class="sidebar">
	      <!-- Sidebar user panel -->
	      	<div class="user-panel">
		        <div class="pull-left image">
		          <img src="<?php echo base_url('assets/themes/adminlte/dist/img/avatar04.png')?>" class="img-circle" alt="User Image">
		        </div>
		        <div class="pull-left info">
		          <p> <?php echo $this->nombre_usuario ?></p>
		          <a href="#"><i class="fa fa-circle text-success"></i>  <?php echo $this->perfil_usuario ?></a>
		        </div>
	      	</div>
	      <!-- search form -->
		    <!--form action="#" method="get" class="sidebar-form">
		        <div class="input-group">
		          <input type="text" name="q" class="form-control" placeholder="Buscar...">
		          <span class="input-group-btn">
		                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
		                </button>
		              </span>
		        </div>
		    </form-->
	      <!-- /.search form -->
	      <!-- sidebar menu: : style can be found in sidebar.less -->
		    <ul class="sidebar-menu" data-widget="tree">
		        <li class="header">Navegación</li>
		        
                            <?php echo $this->menu ?>

		    </ul>
	    </section>
    <!-- /.sidebar -->
  	</aside>

  	<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->    
    <section class="content-header">
      <h1>
        <?php echo $this->controller ?>
        <small><?php echo $this->metodo ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>principal"><i class="fa fa-home"></i> Inicio</a></li>
        <li><a href="#"><?php echo $this->controller ?></a></li>
        <li class="active"><?php echo $this->metodo ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

     	<?php echo $output;?>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

    <footer class="main-footer">
	    <div class="pull-right hidden-xs">
	      <b>Version</b> 1.0
	    </div>
	    <strong>Copyright &copy; 2019 <a href="https://adminlte.io"><?php echo $this->sistema ?></a></strong> Todos los derechos reservados.
  	</footer>

  


<?php 

	

	

?>


</body>
</html>

<script type="text/javascript">
    function alerta(title,body,type){
        "use strict";
         // toat popup js
         $.toast({
             heading: title,
             text: body,
             position: 'top-right',
             loaderBg: '#fff',
             icon: type,
             hideAfter: 1700,
             stack: 6
         })
    }
</script>



