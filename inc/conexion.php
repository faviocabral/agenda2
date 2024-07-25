<?php
$env = parse_ini_file('.env');
$puerto_ = $env["DB_PORT"];
$usuario_ = $env["DB_USER"];
$contrasena_ = $env["DB_PASSWORD"];
$base_ = $env["DB"];
$base2_ = $env["DB2"];

//session_start();
$dbhost 	= 'localhost';
$dbpuerto 	= $puerto_;
$dbusuario	= $usuario_;
$dbcontrasena = $contrasena_;
$db			= $base_;
$db2			= $base2_;
$con		= pg_connect("host=$dbhost port=$dbpuerto password=$dbcontrasena user=$dbusuario dbname=$db") or die( 'No se pudo conectar'.$con);
$con2		= pg_connect("host=$dbhost port=$dbpuerto password=$dbcontrasena user=$dbusuario dbname=$db2") or die( 'No se pudo conectar'.$con2);
$user = "";
$password = "";

?>