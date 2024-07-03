<?php
 session_start();
$accion = $_POST['accion'];

$env = parse_ini_file('.env');
$puerto_ = $env["DB_PORT"];
$usuario_ = $env["DB_USER"];
$contrasena_ = $env["DB_PASSWORD"];
$base_ = $env["DB"];

switch ($accion)
{
	case 'autenticar':
			$host 		= 'localhost';
			$puerto 	= $puerto;
			$contrasena = $contrasena_;
			$usuario	= $usuario_;
			$db			= $base_;
			
			$documento = $_POST['documento'];
			$pass = $_POST['pass'];
 			
			$con	= pg_connect("host=$host port=$puerto password=$contrasena user=$usuario dbname=$db") or die('No se pudo conectar');
			$q		= "select * from funcionarios where documento =  '$documento'";
			$exq	= pg_query($con, $q);
			$res	= pg_fetch_array($exq);
			
			if (!empty($res['documento']))
			{
				echo "ok";	
			}else{
				echo "Este usuario no existe";			
			}
  			 
 	break;
}

?>