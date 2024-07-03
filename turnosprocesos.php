<?php 
	include_once ("inc/conexion.php");
	session_start();
	//fco setear los parametros
	if( isset($_POST['funcion']) ) {
		$funcion = $_POST['funcion']; //para sager que funcion utilizar 
	} else {
		die("Solicitud no valida - Debe ingresar que funcion utilizar....");
	}

	if ( $funcion == 'actualizar' )
	{	
		//fco setear los parametros para actualizar .... 
		if( isset($_POST['codigo']) && isset($_POST['estado']) && isset($_POST['casilla']) ) {
		  $codigo  = $_POST['codigo'];
		  $estado  = $_POST['estado'];
		  $casilla = $_POST['casilla'];
		} else {
		  die("Solicitud no valida - Debe ingresar los valores para actualizar...");
		}

		//////////////////////////////////////////////////////////////////////////////////////////
		/* estado de atencion 
		1 = en espera 
		2 = llamado 
		3 = atendido 
		4 = llamar 
		*/
		
		if ($estado == 1) {
			$query = " UPDATE public.fichas SET ESTADO_ATENCION = " . $estado . ", ESTADO = '1' , CASILLA = NULL WHERE ID_FICHA = " . $codigo ; //EN ESPERA 
		} elseif ($estado == 2) {
			$query = " UPDATE public.fichas SET ESTADO_ATENCION = " . $estado . ", ESTADO = '1' , CASILLA = NULL WHERE ID_FICHA = " . $codigo ; // LLAMADO
		} elseif ($estado == 3) {
			
			$id_usuario = $_SESSION['id_funcionario'];
			$query = " UPDATE public.fichas SET ESTADO_ATENCION = " . $estado . ", ESTADO = '2' , CASILLA = NULL , hora_atencion = localtime  , id_funcionario_atencion = " . $id_usuario . "  WHERE ID_FICHA = " . $codigo ; //ATENDIDO 
		} elseif ($estado == 4) {
			if ($casilla == -1 ) 
			{
				$query = " UPDATE public.fichas SET ESTADO_ATENCION = " . $estado . ", ESTADO = '1',  casilla = null WHERE ID_FICHA = " . $codigo ; //LLAMAR 
			}else {
				if ( $casilla == 1){
					$box = 'BOX 01';
				}elseif ( $casilla == 2) {
					$box = 'BOX 02';
				}elseif ( $casilla == 3) {
					$box = 'BOX 03';
				}elseif ( $casilla == 4) {
					$box = 'BOX 04';
				}elseif ( $casilla == 5) {
					$box = 'BOX 05';
				}elseif ( $casilla == 6) {
					$box = 'BOX 06';
				}elseif ( $casilla == 7) {
					$box = 'BOX 07';
				}elseif ( $casilla == 8) {
					$box = 'BOX 08';
				}elseif ( $casilla == 9) {
					$box = 'BOX 09';
				}elseif ( $casilla == 10) {
					$box = 'BOX 10';
				}elseif ( $casilla == 11) {
					$box = 'BOX 11';
				}elseif ( $casilla == 12) {
					$box = 'BOX 12';
				}
				$query = " UPDATE public.fichas SET ESTADO_ATENCION = " . $estado . ", ESTADO = '1' , casilla = '" . $box . "' WHERE ID_FICHA = " . $codigo ; //LLAMAR 
			}
		} elseif ($estado == 5) {
			
			$query = " UPDATE public.fichas SET ESTADO_ATENCION = " . $estado . ", ESTADO = '1' , casilla = NULL , hora_llamada = localtime  WHERE ID_FICHA = " . $codigo ; //LLEGO
		}	
		$exq	= pg_query($con, $query) ;
		echo "ok";
		
	}elseif ($funcion == 'controlbox'){
		//PARA CONTROLAR ONLINE QUE BOX ESTA SIENDO UTILIZADO.... ESTO DEVUELVE UN JSON ...
		$query8 = "	
					SELECT box , CASE WHEN CASILLA IS NULL THEN '' ELSE 'disabled' END estado 
					FROM ( 
							SELECT 'BOX 01' AS BOX UNION ALL SELECT 'BOX 02' UNION ALL SELECT 'BOX 03' UNION ALL SELECT 'BOX 04' UNION ALL SELECT 'BOX 05' UNION ALL SELECT 'BOX 06' UNION ALL
							SELECT 'BOX 07' UNION ALL SELECT 'BOX 08' UNION ALL SELECT 'BOX 09' UNION ALL SELECT 'BOX 10' UNION ALL SELECT 'BOX 11' UNION ALL SELECT 'BOX 12'
						 ) AS BOXES LEFT OUTER JOIN public.fichas ON BOX = CASILLA AND fecha = date( to_char(now(), 'YYYYMMDD')) 
				";
		$jsondata = array(); //PARA EL JSON 
		$exq	= pg_query($con, $query8);
		while ($res = pg_fetch_array($exq))
		{
			$jsondata['data'][] = $res['box'];
			$jsondata['estado'][] = $res['estado'];
		}
		echo json_encode($jsondata, JSON_FORCE_OBJECT);
		
	}elseif ($funcion == "ControlAtencion"){
		
		//fco setear los parametros para actualizar .... 
		if( isset($_POST['codigo']) ) {
		  $codigo  = $_POST['codigo'];
		} else {
		  die("Solicitud no valida - ControlAtencion - Debe ingresar el codigo de la ficha...");
		}
		//PARA CONTROL DE LLAMADAS DESHABILITAR BOTONES... 
		$query = "
					SELECT ESTADO_ATENCION , ESTADO  
					FROM FICHAS WHERE ID_FICHA = $codigo 
			     ";
		$exq	= pg_query($con, $query);
		$jsondata = array();
		while ($res = pg_fetch_array($exq))
		{
			$jsondata['estado_atencion'][]= $res['estado_atencion'];
			$jsondata['estado'][]= $res['estado'];
		}
		echo json_encode($jsondata, JSON_FORCE_OBJECT);
		
	}elseif ($funcion == "ControlUsuario"){
		
		if( isset($_SESSION['id_funcionario']) ) {
		  echo "si";
		} else {
		  echo "no";
		}
		
	}elseif ( $funcion == "CuantoBoxHay"){
		
		$query = "
					SELECT COUNT(*) cantidad
					FROM public.fichas 
					WHERE fecha = date( to_char(now(), 'YYYYMMDD')) AND casilla IS NOT NULL 			     
				";
		$exq	= pg_query($con, $query);
		while ($res = pg_fetch_array($exq))
		{
			$valor = $res['cantidad'];
		}
		echo $valor ;
		
	}elseif ( $funcion == "FechaHora" ){
		
		$query = "
					SELECT to_char( localtime , 'HH:MI' ) hora , to_char( current_date , 'DD-MM-YYYY' ) fecha 
				";
		$exq	 = pg_query($con, $query);
		$jsondata = array();
		while ($res = pg_fetch_array($exq))
		{
			$jsondata['fecha'][]= $res['fecha'];
			$jsondata['hora'][] = $res['hora'] ;
			
		}
		echo json_encode($jsondata, JSON_FORCE_OBJECT);
	}
	
?>