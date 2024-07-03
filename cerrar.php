<?php
 
session_start();
include_once ("inc/conexion.php");

// Eliminar todas fichas pre abiertas si posee activa.
$qupdate= " UPDATE 
				fichas_abiertas
			SET 
				eliminado='1'
			WHERE 
				usuario = '".$_SESSION['usuario']."'
			";
pg_query($con, $qupdate);
session_destroy();
if (isset($_GET['fecha'])){$recordarfecha=$_GET['fecha'];}else{$recordarfecha=$_POST['fecha'];}
header('location:index.php?login=y&fecha='.$recordarfecha);
?>