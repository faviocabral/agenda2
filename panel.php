<?php
 
//require ("inc/conexion.php");
if (!isset($_SESSION)){
	session_start();
}
if (isset($_SESSION['id_usuario'])) header( 'Location: panel/listado.php' ) ;
?>
<!doctype html>
<html><head>
<meta charset="iso-8859-1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
 
<!-- JAVASCRIPT Y CSS PARA EL BOOTSTRAP -->
<script src="js/jquery.js"></script> <!--jQuery JavaScript Library v1.11.0-->

<script src="js/bootstrap.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>

<link href="css/datepicker.css" rel="stylesheet">
<link href="css/bootstrap.css" rel="stylesheet">
<!--<link href="css/bootstrap.css.map" rel="stylesheet">-->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-theme.css" rel="stylesheet">
<!--<link href="css/bootstrap-theme.css.map" rel="stylesheet">-->
<link href="css/bootstrap-theme.min.css" rel="stylesheet">
 
<script >
function autenticar()
{
	var error=0;
	var documento	= $("#doc").val();
	var pass		= $("#pass").val();

	if (!documento || !pass) error++;
	
	if (error != 0) alert(error);
	
 	accion ="autenticar";
	var respuesta = $.ajax({
				url: "inc/procesos.php",
				global:true,
				type: "POST",
				data: "documento="			+documento+
					  "&pass="				+pass+
					  "&accion="			+accion,
				contentType: "application/x-www-form-urlencoded",
				dataType: "html",
				async: true,					
				ifModified: false,
				processData:true,
				beforeSend: function(objeto){ },
				complete: function(objeto, exito){  
					if(exito=="success"){ }},
					error: function(objeto, quepaso, otroobj){ },
					success: function(datos){
					///////////////////// --- Acciones con los datos obtenidos --- /////////////////////
				 
				// alert(datos);
						var resdatos;
				 		resdatos = datos.split("*tab*");
					 	if (resdatos[0] == 'ok')
						{
						/*	$('#cell_estado_conexion').html('<img src="img/estado_conectado.png" width="16" height="16" align="top" />'+
															'<span style="color:#006600";>&nbsp;Conectado</span>');
 							$('#cell_internet_alerta').html('Conexion establecida');
							$('#b_conectar_internet').attr('disabled', true);
							$('#b_conectar_internet').css('display', 'none');
							bandera_conexion = 1;
							monitorear_conexion();*/
							// similar behavior as clicking on a link
							window.location.href = "panel/listado.php";
						}
						if (resdatos[0] == 'error')
						{
								$('#cell_estado_conexion').fadeIn(500).html('<img src="img/estado_desconectado.png" width="16" height="16" align="top" />'+
														 '<span style="color:#400000";>&nbsp;Desconectado</span>');
								$('#b_conectar_internet').attr('disabled', false);
								$('#b_conectar_internet').css('display', '');
							bandera_conexion = 0;
 						}
 						 
					},							
				}
			).responseText;		
}

function enfocar()
{
	$('#doc').focus();
}
</script>
 
<title>Reservas Garden</title>
</head>

<body onLoad="enfocar()">
<div class="container" style=" padding-top:20px;">
 <div style="margin:auto; position:relative">
    <div class="col-sm-4">
        <div class="panel panel-warning">
            <div class="panel-heading">
              <h1 class="panel-title">Panel Administrativo</h1>
            </div>
            <div class="panel-body">
                <form class="form-signin" action="inc/conexion.php" method="post">
                     
                    <label for="doc">Documento </label>
                    <input id="doc" name="doc" class="input-block-level" type="text" placeholder="c.i.">
                    <br>
                    <label for="pass">Contrase�a </label>
                    <input id="pass" name="pass" class="input-block-level" type="password" placeholder="*****">
                    <!--<label class="checkbox">
                      <input type="checkbox" value="remember-me">
                    Remember me
                    </label>-->
                    <br><br>
                    <button class="btn btn-success" type="button" onClick="autenticar();">Ingresar</button>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>
<?php
	$host 		= 'localhost';
	$puerto 	= '5432';
	$contrasena = 'nautilus';
	$usuario	= 'postgres';
	$db			= 'reservas';
	$con=pg_connect("host=$host port=$puerto password=$contrasena user=$usuario dbname=$db") or die('No se pudo conectar');

	$q		= "select * from fichas";
	$exq	= pg_query($con, $q);
	$res	= pg_fetch_array($exq);
	
	echo $res[0].' - '.
		$res[1].' - '.
		$res[2].' - '.
		$res[3].' - '.
		$res[4].' - '.
		$res[5].' - '.
		$res[6].' - '.
		$res[7].' - '.
		$res[8].' - ';

?>
</body>
</html>
