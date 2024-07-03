<?php 

include_once('control.php');
include_once ("conexion.php");
?>
<?php
include ("conexion.php");
$tab	= '*tab*';
$accion = $_POST['accion'];
$accion = 'consultar';
 echo 1 ;
 
		$sucursal = 1 ;
		$fecha = '2017-08-09';
		$sql = "
			select columna col, cupo fila, nombre cliente, servicio 
			from fichas 
			where id_sucursal = $sucursal 
			and fecha = '$fecha' ;
		";
		$exq = pg_query($con, $sql);
		if ( !$exq )
		{
			exit( "Error en la consulta SQL" );
		}
		$valor = array();
		while( $row = pg_fetch_array($exq) ){
			$valor[] = $row;
		}
		echo json_encode( $valor ); //fco esta linea codifica para ser leido como json 	
		

?>