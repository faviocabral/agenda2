<?php 

include_once('control.php');
include_once ("conexion.php");

		$evento = 1;
		//parse_str( $_POST["serial"], $serial);
		$serial = array();
		$serial["nombre"] = 'Tema';
		$serial["estado"] = 1;
		$nombre = "Tema";
		$estado = 1;
		if ($evento == 1){ //1 es insertar  2 es modificar 
			$sql = "insert into sucursales ( nombre , estado ) values( '" . $serial["nombre"] . "', " . $serial["estado"] . "); ";
			$exq = pg_query($con, $sql);
			if ( !$exq )
			{
				exit( "Error en la consulta SQL" );
			}
			$valor = array();
			while( $row  = pg_fetch_array($exq) ){
				$valor[] = $row;
			}
			echo json_encode( $valor ); //fco esta linea codifica para ser leido como json 	
			return ;
		}else {
			$sql = "
				update sucursales
					set nombre    = '" . $serial['nombre'] . "' 
					, estado      = "  . $serial['estado'] . "
				where id_sucursal = "  . $serial['id']     . " ;
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
			return ;
		}

?>