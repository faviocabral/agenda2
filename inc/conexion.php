<?php
$env = parse_ini_file('.env');
$puerto_ = $env["DB_PORT"];
$usuario_ = $env["DB_USER"];
$contrasena_ = $env["DB_PASSWORD"];
$base_ = $env["DB"];

//session_start();
$dbhost 	= 'localhost';
$dbpuerto 	= $puerto_;
$dbusuario	= $usuario_;
$dbcontrasena = $contrasena_;
$db			= $base_;
$con		= pg_connect("host=$dbhost port=$dbpuerto password=$dbcontrasena user=$dbusuario dbname=$db") or die( 'No se pudo conectar'.$con);
$user = "";
$password = "";

?>