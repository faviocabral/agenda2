<?php 

include_once('control.php');
include_once ("conexion.php"); 
 
?>
<?php
include ("conexion.php");
$tab	 	= '*tab*';
$accion 	= $_POST['accion'];
 
switch ($accion)
{
	case 'traerNombre':
	
			$idfunc 	= 		$_POST['idfun'];	// ID funcionario atencion *
			$q		= "select * from funcionarios 
						where 
						id_funcionario = '" . $idfunc."'
					";
							
			$exq	= pg_query($con, $q);
			$res	= pg_fetch_array($exq);
			if (!empty($res['pantalla']))
			{
				$retorna =  'ok'.$tab.
							$res['pantalla'].$tab ;
			}else{
				$retorna =  "No se encontro el funcionario.".$q.$tab;
			}

	break;

	case 'confirmar':

		$ficha 	= 	$_POST['ficha'];
		$qupdate= " UPDATE fichas
					SET estado='3'
					WHERE id_ficha = '$ficha' ";
		if(pg_query($con, $qupdate)){
			$retorna = "datos actualizados correctamente ";
		}else{
			$retorna = "Hubo un error en la actualizacion de datos.. " . $ficha ;
		}

		break;
	case 'atenderCliente':
			$xficha 	= 		$_POST['xficha'];
			$idfunc		=		$_POST['funcionario']; //$_SESSION['id_funcionario'];

            $hora_atencion = date("H:i:s");
 			
			$qupdate= " UPDATE 
							fichas
						SET 
							estado='2',
							hora_atencion 			= '".$hora_atencion."',
							id_funcionario_atencion = '".$idfunc."'
						WHERE 
							id_ficha = '$xficha'
						";
  			if ( pg_query($con, $qupdate) )
			{
 				$q		= "select * from fichas 
							where 
							id_ficha = '" . $xficha."'
						";
								
 				$exq	= pg_query($con, $q);
				$res	= pg_fetch_array($exq);
				
				if (!empty($res['id_ficha']))
				{
 
 	  			$retorna = 'ok'.								$tab. 
							$res['id_ficha'].					$tab. //	var zficha 			= resdatos[1];
							$res['fecha'].						$tab. //	var zfecha 			= resdatos[2];
							$res['columna'].					$tab. //	var zcolumna 		= resdatos[3];
							$res['cupo'].						$tab. //	var zcupo 			= resdatos[4];
							$res['hora'].						$tab. //	var zhora_selec 	= resdatos[5];
							$res['nombre'].						$tab. //	var znombre 		= resdatos[6];
							$res['id_funcionario'].				$tab. //	var zidfunc 		= resdatos[7];
							$res['documento'].					$tab. //	var zdocumento 		= resdatos[8];
							$res['celular'].					$tab. //	var zcelular		= resdatos[9];	
							$res['servicio'].					$tab. //	var zservicio 		= resdatos[10];
							$res['hora_solicitud'].				$tab. //	var zhora_solicitud = resdatos[11];
							$res['comentario'].					$tab. //	var zcomentario 	= resdatos[12];
							$res['hora_atencion'].				$tab. //	var zhora_atencion 	= resdatos[13];
							$res['id_funcionario_atencion'].	$tab; //	var zidfunat	 	= resdatos[14];
							//------------------------------------------------				
							$q2		= "select * from funcionarios 
										where 
										id_funcionario = '" . $res['id_funcionario_atencion'] ."'
									";
							$exq2	= pg_query($con, $q2);
							$res2	= pg_fetch_array($exq2);
							
							if (!empty($res2['pantalla']))
							{
								$retorna .= $res2['pantalla'].		$tab;  //	var zpantalla	 	= resdatos[15];
							}else{
								$retorna = "No se encontro en la tabla de funcionarios.".$q.$tab;
							}
				}else{
					$retorna =  "No se encontro la ficha.".$insertar.$q.$tab;
				}
 			}else{
				$retorna = "Este usuario no existe".$qupdate.$tab;	
			}
 			
 	break;
 	
	case 'comprobarFichaAbierta':

 			$xfecha 	= $_POST['xfecha'];
 			$xcolumna 	= $_POST['xcolumna'];
			$xcupo 		= $_POST['xcupo'];
			// Comprueba que ya no este agendado
			$q			= "select * from fichas where 
							fecha = '" . $xfecha 			. "' and
							columna='" . $xcolumna			. "' and
							cupo=	'" . $xcupo				. "'";
			$exq		= pg_query($con, $q);
			$rem		= pg_fetch_array($exq);
			
			if ($rem['estado'] != '1') 		// Si el estado es 1(ocupado) se notifica no disponibilidad.  
			{
						$q		= "select * 
										from 
											fichas_abiertas 
										where 
											fecha 	='". $xfecha	. "' and
											columna	= ". $xcolumna	. "  and
											cupo	= ". $xcupo		. " and 
											eliminado = 0 ";
						$exq	= pg_query($con, $q);
						$res	= pg_fetch_array($exq);
						
						if (isset($res['fecha'])) 							// SI EXISTE, PREGUNTAR SI ES MIO O NO
						{
							if ( $res['usuario'] == $_SESSION['usuario']) 		// SI ME PERTENECE, disponible
							{
								$retorna	= 'disponible'.$tab;
							}else{												// SINO ME PERTENECE, ficha-abierta
								$retorna	= 'ficha-abierta'.$tab.$res['usuario'];
							}
						}else{
							$retorna	= 'disponible'.$tab;				// SI NO EXISTE, disponible
						}
						
						if ($retorna == 'disponible'.$tab) 
						{
							$insertar 	= "INSERT INTO fichas_abiertas 
											( 	fecha,
												columna,
												cupo,
												usuario
											) VALUES ( 
												'" . $xfecha 	. "',
												 " . $xcolumna	. ",
												 " . $xcupo		. ",
												'" . $_SESSION['usuario']. "'
											)";	
							pg_query($con, $insertar);
						 	/*$res2	= pg_fetch_array($rin);
							$retorna =$res2['fecha']; */
						}
			}else{
				$retorna 	= 'no-disponible'.$tab.$rem['usuario'];
			}
  	break;
	
  	case 'disponibilidad':
	//#######################//	
	//OBSOLETO. VERSION VIEJA
	//########################################################################//
 	/*		$xfecha 	= $_POST['xfecha'];
 			$xcolumna 	= $_POST['xcolumna'];
			$xcupo = $_POST['xcupo'];
			
			$q		= "select estado from fichas where 
							fecha = '" . $xfecha 			. "' and
							columna='" . $xcolumna			. "' and
							cupo=	'" . $xcupo				. "'";
			$exq	= pg_query($con, $q);
			$res	= pg_fetch_array($exq);
			$retorna = $res[0].$tab;*/
	//########################################################################//		
 	break; 
	
 	case 'desvincularFichaAbierta':
	
			// Eliminar todas fichas pre abiertas si posee activa.
			$qupdate= " UPDATE 
							fichas_abiertas
						SET 
							eliminado='1'
						WHERE 
							usuario = '".$_SESSION['usuario']."'
						";
			pg_query($con, $qupdate);
	break;			
 	case 'confirmarIdentidad':
  			$usuario 	= $_POST['usuario'];
			$contrasena = $_POST['contrasena'];
 			$q		= "select * from funcionarios where usuario = '$usuario' and contrasena = '$contrasena'";
			$exq	= pg_query($con, $q);
			$res	= pg_fetch_array($exq);
 			if (!empty($res['documento'])){ 
				$retorna = "ok".$tab;
			}else{
				$retorna = "error al confirmar identidad".$tab;		
			}
  	break;
	case 'cambiarClave':
  			$usuario 	= $_POST['usuario'];
			$contrasena = $_POST['contrasena'];
			$qupdate= " UPDATE 
							funcionarios
						SET 
							contrasena = '".$contrasena."'
						WHERE 
							usuario = '".$usuario."'
						";
 			if (pg_query($con, $qupdate))
			{
  				$retorna = "ok".$tab;	
			}else{
				$retorna = "Este usuario no existe".$qupdate.$tab;			
			}
  	break;
 	case 'autenticar':

 			$usuario 	= $_POST['usuario'];
			$contrasena = $_POST['contrasena'];
 		
			$q		= "select * from funcionarios where usuario = '$usuario' and contrasena = '$contrasena'";
			$exq	= pg_query($con, $q);
			$res	= pg_fetch_array($exq);
			
			if (!empty($res['documento']))
			{
				// Iniciar sesion y variables
				if(session_id() == '') {
					session_start(['cookie_lifetime' => 86400,]);
				}

 				//$_SESSION['id_funcionario'] = $res['id_funcionario'];
 				$_SESSION['usuario'] 		= $res['usuario'];
				$_SESSION['nombre'] 		= $res['nombre'];
				$_SESSION['privilegios']	= $res['privilegios'];

				switch ($_SESSION['privilegios'])
				{
					case 1:	$_SESSION['tipo'] = 'Administrador'; break;
					case 2:	$_SESSION['tipo'] = 'Funcionario'; break;
				}
				
				//$retorna = "ok".$tab;
				 echo json_encode($res); //fco esta linea codifica para ser leido como json 
				return ;
		
			}else{
				$retorna = "Usuario o clave incorrectas".$tab;		
			}
			
  	break;
	case 'eliminarFicha':
        $xficha 	= 		$_POST['xficha'];
        $xusuario 	= 		$_POST['xusuario'];

		//controlamos que solo puedan eliminar registros del mismo operador o adminsitrador 
		$q= "select count(*) filas from fichas where " .
			"id_ficha = '$xficha' and " .
			"id_funcionario = '$xusuario' ";
		$exq = pg_query($con, $q);
		$res = pg_fetch_array($exq);
		if ( $res['filas'] == 0 ){
			//consultamos si es administrador 
			$q= "select count(*) filas from funcionarios where " .
			"privilegios = '1' and " .
			"id_funcionario = '$xusuario' ";
			$exq = pg_query($con, $q);
			$res = pg_fetch_array($exq);
			if ( $res['filas'] == 0 ){
				$retorna = "Usuario no puede modificar o eliminar este registro ";
				echo $retorna;
				die();
			}
		}

		$qupdate= " UPDATE fichas
					SET estado='0'
					WHERE id_ficha = '$xficha' 
					AND id_funcionario = '$xusuario'
					";
		$exq= pg_query($con, $qupdate);
        $retorna = "OK";

	break;
	case 'nuevaFicha':
			$xcolumna   = 		$_POST['xcolumna'];
			$hora_selec =       $_POST['horario'];
			$xfecha		=		$_POST['xfecha'];
			$xcolumna	=		$_POST['xcolumna'];
			$xcupo		=		$_POST['xcupo'];
			$nombre		=		$_POST['nombre'];
			$nombre 	= 		ucwords($nombre); // Coloca todo el texto en mayusculas
			$nombre 	= 		ucwords(mb_strtolower($nombre,"UTF-8")); // Mayuscula en cada palabra 
			$idfunc		=		 $_POST['id_funcionario'];//$_SESSION['id_funcionario'];
			$documento	=		$_POST['ci'];
			$celular	=		$_POST['celular'];
			$servicio	=		$_POST['servicio'];
			$comentario	=		$_POST['comentario'];
			$sucursal	=		$_POST['sucursal'];
			$reagendar  =       $_POST["reagendar"];

			$km         =       $_POST["km"];
			$vin        =       $_POST["vin"];
			$vehiculo   =       $_POST["vehiculo"];
			$tiempo     =       $_POST["tiempo"];

			$marca     =       $_POST["marca"];
			$modelo     =       $_POST["modelo"];
			$color     =       $_POST["color"];
			$reingreso     =   $_POST["reingreso"];			
			$contactoPreferido     =   $_POST["contactoPreferido"];	

	        $fecha_solicitud = date("d-m-Y");
            $hora_solicitud = $fecha_solicitud.' '.date("H:i:s");
 			$estado = 0;

			//fco control consulta si ya existe registro para ese turno .....
			$control = "select count(*) filas
						from fichas where 
								fecha = '" . $xfecha 			. "' and
								columna='" . $xcolumna			. "' and
								cupo=	'" . $xcupo				. "' and
								hora=	'" . $hora_selec		. "' and
								id_sucursal=	'" . $sucursal	. "' and
								estado <> '0'
						";

			$result = pg_query($con, $control);
			$rows   = pg_fetch_array($result);
			
			if ( $rows['filas'] == 0 )
			{
				$insertar = "INSERT INTO fichas 
								(
									fecha,
									columna,
									cupo,
									hora,
									nombre,
									id_funcionario,
									documento,
									celular,
									servicio,
									hora_solicitud,
									comentario, 
									id_sucursal, 
									km, 
									vin, 
									vehiculo,
									tiempo, 
									marca,
									modelo,
									color, 
									reingreso, 
									contacto_preferido
								)
								VALUES
								(
									'" . $xfecha 			. "',
									'" . $xcolumna			. "',
									'" . $xcupo				. "',
									'" . $hora_selec		. "', 
									'" . $nombre 			. "', 
									'" . $idfunc			. "', 
									'" . $documento 		. "',			
									'" . $celular 			. "',			
									'" . $servicio 			. "',
									'" . $hora_solicitud 	. "',
									'" . $comentario	 	. "',
									'" . $sucursal  	 	. "',
									'" . $km  	 	        . "',
									'" . $vin  	 	        . "',
									'" . $vehiculo  	 	. "',
									'" . $tiempo  	 	    . "',
									'" . $marca  	 	    . "',
									'" . $modelo  	 	    . "',
									'" . $color  	 	    . "',
									'" . $reingreso	 	    . "',
									'" . $contactoPreferido . "'
								)";


				if ($reagendar > 0 ){
					$sql = "update fichas set estado = '0' where id_ficha = $reagendar ";
					$exq	= pg_query($con, $sql);
				}
				
				if (pg_query($con, $insertar) or die($resp = "Error al insertar el registro")) {
					
					
					$q		= "select id_ficha, id_funcionario from fichas where 
									fecha = '" . $xfecha 			. "' and
									columna='" . $xcolumna			. "' and
									cupo=	'" . $xcupo				. "' and
									hora=	'" . $hora_selec		. "' and
									id_sucursal=	'" . $sucursal		. "' and
									estado = '1'";
									
															//	usuario = '$usuario' and contrasena = '$contrasena'";
					$exq	= pg_query($con, $q);
					$res	= pg_fetch_array($exq);
					
					if (!empty($res['id_ficha']))
					{
					
					$retorna = 'ok'.				$tab. 
								$res['id_ficha'].	$tab. 
								$xfecha.			$tab. 
								$xcolumna.			$tab. 
								$xcupo.				$tab. 
								$hora_selec.		$tab. 
								$nombre.			$tab. 
								$idfunc.			$tab. 
								$documento.			$tab. 
								$celular.			$tab. 	
								$servicio.			$tab. 
								$hora_solicitud.	$tab. 
								$comentario; 	
								//------------------------------------------------				
								$q3		= "select * from funcionarios 
											where 
											id_funcionario = '" . $res['id_funcionario'] ."'
										";
								$exq3	= pg_query($con, $q3);
								$res3	= pg_fetch_array($exq3);
								
								if (!empty($res3['id_funcionario']))
								{
									$retorna .= $tab.$res3['nombre'].		$tab; 
								}else{
									$retorna = "No se encontro en la tabla de funcionarios.".$q3.$tab;
								}
					}else{
						$retorna =  "No se encontro la ficha.".$insertar.$q.$tab;
					}
				} else {
					$retorna =  "Ocurrio un error.".$insertar.$tab;
				} 
			} else {
					$retorna =  "Ya existe un registro para este Turno.<br> Actualice la pagina !!!." . $tab;
			}
  		 	pg_close($con);
  			 
 	break;
	case 'actualizar':

 			$idficha = $_POST['idficha'];
			
			$qupdate= " UPDATE 
							fichas
						SET 
							estado='1'
						WHERE 
							id_ficha = '$idficha'
						";
  			$exq	= pg_query($con, $qupdate);
	//		$res	= pg_fetch_array($exq);
 			
			if ($res= pg_fetch_array($exq))
			{
  				$retorna = "ok".$tab;	
				
			}else{
				$retorna = "Este usuario no existe".$tab;			
			}
			
  	break;
	case 'cancelar':
  			$idficha = $_POST['idficha'];
 			$qupdate= " UPDATE 
							fichas
						SET 
							estado='0'
						WHERE 
							id_ficha = '$idficha'
						";
  			$exq	= pg_query($con, $qupdate);
  			if ($res= pg_fetch_array($exq))
			{
  				$retorna = "ok".$tab;
				
			}else{
				$retorna = "Este usuario no existe".$tab;
			}
   	break;
	case 'cerar':
  			$idficha = $_POST['idficha'];
 			$qupdate= " UPDATE 
							fichas
						SET 
							estado='3'
						WHERE 
							id_ficha = '$idficha'
						";
  			$exq	= pg_query($con, $qupdate);
  			if ($res= pg_fetch_array($exq))
			{
  				$retorna = "ok".$tab;
				
			}else{
				$retorna = "Este usuario no existe".$tab;		
			}
   	break;
	case 'reservar':
		$fila = $_POST["fila"];
		$col  = $_POST["col"] ; 
		$sucu = $_POST["sucu"]; 
		$usu  = $_POST["usu"] ; 
		$date = $_POST["fecha"]; 
		//$date = date("Y-m-d") ;
		
		$insertar = "
			insert into fichas_abiertas (fecha , columna , cupo , usuario , eliminado , id_sucursal )
			values ( '$date' , $col , $fila , '$usu' , 0 , $sucu );
		";
		$exq = pg_query ($con, $insertar);	
		if ( $res = pg_fetch_array($exq)) {
			$retorna = 'ok';
		} else {
			$retorna = 'error en la insercion ';
		}
		
	break;
	case 'consultar':
		$fecha    = $_POST["fecha"]; 
		$sucursal = $_POST["sucu"]; 
		// $sql = "
		// 	select columna col, cupo fila, nombre cliente, servicio ,id_ficha ficha , left(cast(hora as varchar(100)),5) horario , documento , celular , comentario , estado , to_char( hora_solicitud , ' DD-MM | HH24:MI hs' ) hora_call , to_char( hora_atencion , ' HH24:MI hs' ) hora_atencion, 
		// 		coalesce( (SELECT LEFT( nombre , position(' ' IN nombre)+1 ) FROM public.funcionarios WHERE CAST( id_funcionario AS VARCHAR(10) ) = public.fichas.id_funcionario ), '') callcenter,
		// 		coalesce( (SELECT LEFT( nombre , position(' ' IN nombre)+1 ) FROM public.funcionarios WHERE CAST( id_funcionario AS VARCHAR(10) ) = public.fichas.id_funcionario_atencion ), '') asesor 
		// 	from fichas 
		// 	where id_sucursal = $sucursal 
		// 	and cupo in ( select row_number() over(order by id_box ) from boxes where estado = 1 order by id_box ) --control de boxes activos 
		// 	and left( cast( hora as varchar(100)),5) in ( select t1.nombre from horarios t1 , turnos t2  where t1.id_turno = t2.id_turno and t1.estado = 1 and t2.estado = 1 )  --control de horario activos	
		// 	and fecha = '$fecha'  and estado in ( '1', '2') ;
		// ";

		$sql = "

		SELECT * 
		FROM ( 

			select (columna + tiempos.hora -1) col, cupo fila, nombre cliente, servicio ,id_ficha ficha , CASE WHEN tiempos.hora = 1 THEN left(cast(fichas.hora as varchar(100)),5) ELSE left(cast(fichas.hora + (tiempos.hora -1) * INTERVAL '30 minute' as varchar(100)),5) END  horario , documento , celular , comentario , estado , to_char( hora_solicitud , ' DD-MM | HH24:MI hs' ) hora_call , to_char( hora_atencion , ' HH24:MI hs' ) hora_atencion, 
				coalesce( (SELECT LEFT( nombre , position(' ' IN nombre)+1 ) FROM public.funcionarios WHERE CAST( id_funcionario AS VARCHAR(10) ) = public.fichas.id_funcionario ), '') callcenter,
				coalesce( (SELECT LEFT( nombre , position(' ' IN nombre)+1 ) FROM public.funcionarios WHERE CAST( id_funcionario AS VARCHAR(10) ) = public.fichas.id_funcionario_atencion ), '') asesor 
			,tiempos.hora item ,  id_ficha % 2 color 
			, coalesce( (SELECT nombre  FROM public.funcionarios WHERE CAST( id_funcionario AS VARCHAR(10) ) = public.fichas.id_funcionario ), '') callcenter_nombre 
			, marca 
			, whatsapp 
			from fichas , tiempos
			where id_sucursal = $sucursal 
			and cupo in ( select row_number() over(order by id_box ) from boxes where estado = 1 order by id_box ) --control de boxes activos 
			and left( cast( fichas.hora as varchar(100)),5) in ( select t1.nombre from horarios t1 , turnos t2  where t1.id_turno = t2.id_turno and t1.estado = 1 and t2.estado = 1 )  --control de horario activos	
			and fecha = '$fecha' and estado in ( '1', '2', '3') 
			AND tiempos.hora <= ( coalesce( fichas.tiempo , 0 ) / 1 ) 

			) tabla 
			ORDER BY fila , col , cliente ;

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
		
	break;
	case 'consultar2':
		$fecha    = $_POST["fecha"]; 
		$sucursal = $_POST["sucu"]; 

		$sql = "

		SELECT row_number() over(PARTITION BY fila ORDER BY fila , horario , cliente )col , * 
		FROM ( 

			select (columna + tiempos.hora -1)*2 -1 cola , cupo fila, nombre cliente, servicio ,id_ficha ficha , CASE WHEN tiempos.hora = 1 THEN left(cast(fichas.hora as varchar(100)),5) ELSE left(cast(fichas.hora + (tiempos.hora -1) * INTERVAL '30 minute' as varchar(100)),5) END  horario , documento , celular , comentario , estado , to_char( hora_solicitud , ' DD-MM | HH24:MI hs' ) hora_call , to_char( hora_atencion , ' HH24:MI hs' ) hora_atencion, 
				coalesce( (SELECT LEFT( nombre , position(' ' IN nombre)+1 ) FROM public.funcionarios WHERE CAST( id_funcionario AS VARCHAR(10) ) = public.fichas.id_funcionario ), '') callcenter,
				coalesce( (SELECT LEFT( nombre , position(' ' IN nombre)+1 ) FROM public.funcionarios WHERE CAST( id_funcionario AS VARCHAR(10) ) = public.fichas.id_funcionario_atencion ), '') asesor 
			,tiempos.hora item ,  id_ficha % 2 color 
			, coalesce( (SELECT nombre  FROM public.funcionarios WHERE CAST( id_funcionario AS VARCHAR(10) ) = public.fichas.id_funcionario ), '') callcenter_nombre 
			from fichas , tiempos
			where id_sucursal = 6 
			and cupo in ( select row_number() over(order by id_box ) from boxes where estado = 1 order by id_box ) --control de boxes activos 
			and left( cast( fichas.hora as varchar(100)),5) in ( select t1.nombre from horarios t1 , turnos t2  where t1.id_turno = t2.id_turno and t1.estado = 1 and t2.estado = 1 )  --control de horario activos	
			and fecha = '$fecha' and estado in ( '1', '2') 
			AND tiempos.hora <= ( coalesce( fichas.tiempo , 0 ) / 0.5 )

			) tabla 
			ORDER BY fila , horario , cliente ;

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
		
	break;
	case 'modificar':
		$ficha = $_POST["ficha"]; 
		$sql = "
			select columna col, cupo fila, nombre cliente, servicio ,id_ficha ficha , hora horario , documento , celular , comentario, vehiculo , vin , tiempo , km as kilometraje , marca , modelo, color , reingreso , estado, contacto_preferido
				,LEFT( CAST( fichas.hora AS VARCHAR(100)), 5 )  || 'hs | ' || left(cast(fichas.hora + ( coalesce( fichas.tiempo , 0 ) / 0.5 )	* INTERVAL '30 minute' as varchar(100)),5) || 'hs' rango_horario 
			from fichas 
			where id_ficha = $ficha ;
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
		
	break;
	case 'modificarFicha':
		$ficha = $_POST["ficha"]; 
		parse_str( $_POST["serial"], $serial);
		
		$sql = "
			update fichas 
				set nombre =  '" . $serial["nombre"] . "' 
				,servicio  =  '" . $serial["servicio"] . "' 
				, documento = '" . $serial["documento"] . "' 
				, celular   = '" . $serial["celular"] . "' 
				, comentario= '" . $serial["comentario"] . "' 
				, vin=        '" . $serial["vin"] . "'
				, vehiculo=   '" . $serial["vehiculo"] . "' 
				, km=         '" . $serial["kilometraje"] . "' 
				, tiempo=      " . $serial["tiempo"] . " 
				, reingreso=   '" . $serial["reingreso"] . "' 

			where id_ficha = $ficha ;
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
	break;			
	case 'configBoxes':
		$sql = " select id_box , nombre , estado, ( select s.nombre from sucursales s where s.id_sucursal = boxes.id_sucursal ) sucursal, id_sucursal , orden from boxes  order by id_sucursal, orden ; ";
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
		
	break;
	
	case 'abmBoxes':
		$evento = $_POST["evento"];
		parse_str( $_POST["serial"], $serial);
		
		if ($evento == 1){ //1 es insertar  2 es modificar 
			$sql = "
					insert into boxes ( nombre , estado , id_sucursal ) values( '" . $serial["nombre"] . "', " . $serial["estado"] . ", " . $serial["sucursal"] . "); 
					
					update boxes 
					set orden = tabla1.ordenamiento   
					from ( 
						select row_number() over( partition by id_sucursal order by id_sucursal , id_box ) ordenamiento, id_box , id_sucursal 
						from boxes where estado = 1
					)tabla1 
					where tabla1.id_box = boxes.id_box 
					and tabla1.id_sucursal = " . $serial["sucursal"] . " ;
					
					";
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
				update boxes
					set nombre    =  '" . $serial['nombre'] . "' 
					, estado      = " . $serial['estado'] . "
					, id_sucursal = " . $serial['sucursal'] . "
					, orden       = " . $serial['orden'] . "
				where id_box = " . $serial['id_box'] . " ;
				
				update boxes 
				set orden = case when tabla1.ordenamiento >= " . $serial["orden"] . " then tabla1.ordenamiento + 1 else tabla1.ordenamiento end  
				from ( 
					select * , row_number() over( partition by id_sucursal order by id_sucursal , id_box ) ordenamiento 
					from boxes 
					where id_box <> " . $serial["id_box"] . " 
					and estado = 1 
				)tabla1 
				where tabla1.id_box = boxes.id_box 
				and tabla1.id_sucursal = " . $serial["sucursal"] . " 
				and exists ( select 1 from boxes where id_sucursal = " . $serial["sucursal"] . " group by orden having count(*)> 1 ) ;
				
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
		
	break;
	case 'configTurnos':
		$sql = " select id_turno id , nombre , estado , ( select s.nombre from sucursales s where s.id_sucursal = turnos.id_sucursal ) sucursal, id_sucursal from turnos order by id_sucursal , orden ; "; 
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
		
	break;
	case 'abmTurnos':
		$evento = $_POST["evento"];
		parse_str( $_POST["serial"], $serial);
		
		if ($evento == 1){ //1 es insertar  2 es modificar 
			$sql = "insert into turnos ( nombre , estado , id_sucursal , orden ) values( '" . $serial["nombre"] . "', " . $serial["estado"] . ", " . $serial["sucursal"] . ", (select count(*) + 1 from turnos where id_sucursal = " . $serial["sucursal"] . " ) ); ";
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
				update turnos
					set nombre    =  '" . $serial['nombre'] . "' 
					, estado      = " . $serial['estado'] . "
					, id_sucursal = " . $serial['sucursal'] . "
				where id_turno = " . $serial['id'] . " ;
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
	case 'configHorarios':
		$sql = " 
				select id_horario id , t1.nombre , t1.estado , t1.id_turno turno, t2.nombre turno_nombre , t1.orden , t3.nombre sucursal 
				from horarios t1 , turnos t2 , sucursales t3 
				WHERE t1.id_turno = t2.id_turno 
				AND t2.id_sucursal =t3.id_sucursal 
				order by t3.id_sucursal , t2.orden , t1.orden 
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
		
	break;
	case 'abmHorarios':
		$evento = $_POST["evento"];
		parse_str( $_POST["serial"], $serial);
		
		if ($evento == 1){ //1 es insertar  2 es modificar 
			$sql = "insert into horarios ( nombre , estado , id_turno ) values( '" . $serial["nombre"] . "', " . $serial["estado"] . "," . $serial["turno"] . "); 
			
				update horarios 
				set orden =  tabla1.ordenamiento 
				from ( 
					select * , row_number() over(partition by id_turno order by id_turno , id_horario ) ordenamiento 
					from horarios 
				)tabla1 
				where horarios.id_horario = tabla1.id_horario 
				and tabla1.id_turno = " . $serial["turno"] . " 
			";
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
				update Horarios
					set nombre   =  '" . $serial['nombre'] . "' 
					, estado     = " . $serial['estado'] . "
					, id_turno   = " . $serial['turno'] . "
					, orden      = " . $serial['orden'] . "
				where id_horario = " . $serial['id'] . " ; 
				
				update horarios 
				set orden = case when tabla1.ordenamiento >= " . $serial["orden"] . " then tabla1.ordenamiento + 1 else tabla1.ordenamiento end 
				from ( 
					select * , row_number() over(partition by id_turno order by id_turno , id_horario ) ordenamiento 
					from horarios where id_horario <> " . $serial["id"] . " 
				)tabla1 
				where horarios.id_horario = tabla1.id_horario 
				and tabla1.id_turno = " . $serial["turno"] . " 
				and exists ( select 1 from horarios where id_turno = " . $serial["turno"] . " group by orden having count(*)> 1 ) ;
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
		
	break;
	case 'configSucursales':
		$sql = " select id_sucursal id , nombre , estado  from sucursales order by 1 ; ";
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
		
	break;
	case 'abmSucursales':
		$evento = $_POST["evento"];
		parse_str( $_POST["serial"], $serial);
		
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
		
	break;
	case 'vistaSucursales':
		$sql = " select id_sucursal id , nombre , estado  from sucursales where estado = 1 order by 1 ; ";
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
		
	break;

	case 'configServicios':
		$sql = " select id_servicio id , nombre , estado  from servicios order by 1 ; ";
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
		
	break;
	case 'abmServicios':
		$evento = $_POST["evento"];
		parse_str( $_POST["serial"], $serial);
		
		if ($evento == 1){ //1 es insertar  2 es modificar 
			$sql = "insert into servicios ( nombre , estado ) values( '" . $serial["nombre"] . "', " . $serial["estado"] . "); ";
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
				update servicios
					set nombre    = '" . $serial['nombre'] . "' 
					, estado      = "  . $serial['estado'] . "
				where id_servicio = "  . $serial['id']     . " ;
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
		
	break;
	case 'configUsuarios':
		$sql = " select id_funcionario id , nombre , usuario, contrasena , privilegios , case privilegios  when '1' then 'administrador' when '2' then 'Callcenter' when '3' then 'Asesor' end tipo, estado  from funcionarios order by 1 ; ";
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
		
	break;

	case 'abmUsuarios':
		$evento = $_POST["evento"];
		parse_str( $_POST["serial"], $serial);
		
		if ($evento == 1){ //1 es insertar  2 es modificar 
			$sql = "insert into funcionarios ( nombre , usuario, contrasena, privilegios, estado , documento ) values( '" . $serial["nombre"] . "',  '" . $serial["usuario"] . "',  '" . $serial["password"] . "',  '" . $serial["tipousuario"] . "', " . $serial["estado"] . ", '123'); ";
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
				update funcionarios
					set nombre      = '" . $serial['nombre'] . "' 
						,usuario     = '" . $serial['usuario'] . "' 
						,contrasena  = '" . $serial['password'] . "' 
						,privilegios = '" . $serial['tipousuario'] . "' 
					, estado        = "  . $serial['estado'] . "
					,documento      = '123' 
				where id_funcionario = "  . $serial['id']    . " ;
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
		
	break;

	
	case 'vistaHorarios':
		$sucursal = $_POST["sucursal"];
        $sql = " SELECT '<th class=@collapse in ' || id_turno || '@>' || nombre ||'</th>' html FROM horarios where estado = 1 and id_turno in ( select id_turno from turnos where estado = 1 and id_sucursal = $sucursal ) ORDER BY id_turno , orden ; ";

        $exq = pg_query($con, $sql );
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
		
	break;
	case 'vistaHorarios2':
		$sucursal = $_POST["sucursal"];
        $sql = "  SELECT '<th class=@collapse in ' || id_turno || '@>' || nombre ||'</th>' html 
					FROM ( 
							SELECT orden , nombre , id_turno 
							FROM horarios t1 
							WHERE orden NOT IN ( 1 , 10 ,11, 19)
							AND t1.estado = 1  
							UNION ALL 
							SELECT orden , nombre , id_turno
							FROM horarios t2 
							WHERE t2.estado = 1 
							ORDER BY orden 
						)tabla 
					 where id_turno in ( select id_turno from turnos where estado = 1 ) ORDER BY id_turno , orden 
				";

        $exq = pg_query($con, $sql );
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
		
	break;
	case 'vistaTurnos':
		$sucursal = $_POST["sucursal"];
        $sql = "
            SELECT '<th colspan=@'|| count(*) ||'@ data-toggle=@collapse@ data-target=@.' || t1.id_turno || '@><span class=@label@>' || t1.nombre ||'</span></th>' html
            FROM turnos t1 inner join public.horarios t2 ON t1.id_turno = t2.id_turno 
			where t1.estado = 1 and t2.estado = 1 and id_sucursal = $sucursal
            GROUP BY t1.nombre , t1.id_turno  ORDER BY t1.orden ;
        ";

        $exq = pg_query($con, str_replace('@', '"', $sql ));
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
		
	break;
	case 'vistaTurnos2':
		$sucursal = $_POST["sucursal"];
        $sql = "
            SELECT '<th colspan=@'|| count(*) ||'@ data-toggle=@collapse@ data-target=@.' || t1.id_turno || '@><span class=@label@>' || t1.nombre ||'</span></th>' html
            FROM turnos t1 
            inner join ( 
						SELECT orden , nombre , id_turno , estado 
						FROM horarios t1 
						WHERE orden NOT IN ( 1 , 10 ,11, 19)
						AND t1.estado = 1  
						UNION ALL 
						SELECT orden , nombre , id_turno , estado 
						FROM horarios t2 
						WHERE t2.estado = 1 
						ORDER BY orden 
					)t2 ON t1.id_turno = t2.id_turno 
			where t1.estado = 1 and t2.estado = 1 and id_sucursal = $sucursal
            GROUP BY t1.nombre, t1.id_turno ORDER BY t1.orden;
        ";

        $exq = pg_query($con, str_replace('@', '"', $sql ));
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
		
	break;
	case 'vistaCupos':
		$sucursal = $_POST["sucursal"];
        $sql = "
                SELECT 
                CASE WHEN col = 1 THEN 
                    '<tr >' || 
                        '<td class=@f-asesor@>' || boxname || '</td>' ||
                        '<td id=@celda' || fila || col || '@' || ' onclick=@registro( ' || fila || ', ' || col || ', ' || fila ||', %'|| horname ||'%)@ hora=@' || horname || '@>' || ' <strong><br><br>LIBRE<br><br><br></strong> ' || '</td>'
                WHEN item = (SELECT COUNT(*) FROM boxes CROSS JOIN horarios where boxes.estado = 1 and horarios.estado = 1 ) THEN 
                        '<td id=@celda' || fila || col || '@' || ' onclick=@registro( ' || fila || ', ' || col || ', ' || fila ||', %'|| horname || '%)@ hora=@' || horname || '@ >' || ' <strong><br><br>LIBRE<br><br><br></strong> ' || '</td>' ||
                    '</tr>'
                ELSE 
                    '<td id=@celda' || fila || col || '@' || ' onclick=@registro( ' || fila || ', ' || col || ', ' || fila ||', %'|| horname || '%)@ hora=@' || horname || '@ >' || ' <strong><br><br>LIBRE<br><br><br></strong> ' || '</td>' ||
                    '</td>'
                END HTML 
                FROM (
						SELECT 
						ROW_NUMBER() OVER( PARTITION BY T2.id_horario ORDER BY T1.orden, t2.id_turno , T2.orden ) fila,
						ROW_NUMBER() OVER( PARTITION BY T1.id_box ORDER BY T1.orden , t2.id_turno , T2.orden ) col,
						ROW_NUMBER() OVER(ORDER BY T1.orden , t2.id_turno , t2.orden  ) item ,
						t1.nombre boxname , 
						t2.nombre horname
						FROM boxes T1,
						 public.horarios T2 
								where t1.estado = 1 and t2.estado = 1 and t2.id_turno in ( select id_turno from turnos where estado = 1 and turnos.id_sucursal = $sucursal )
								and t1.id_sucursal = $sucursal 
						ORDER BY T1.orden , t2.id_turno , T2.orden
                     )tabla 
        ";

        $exq = pg_query($con, str_replace('@', '"', $sql ) );
		if ( !$exq )
		{
			exit( "Error en la consulta SQL" );
		}
		$valor = array();
		while( $row = pg_fetch_array($exq) ){
			//$valor[] = str_replace('%', "'", $row['html'];
			$valor[] = $row;
		}
		echo json_encode( $valor ); //fco esta linea codifica para ser leido como json 	
		return ;
		
	break;
	case 'vistaCupos2':
		$sucursal = $_POST["sucursal"];
        $sql = "
            SELECT 
                CASE WHEN col = 1 THEN 
                    '<tr >' || 
                        '<td class=@btn-primary@>' || boxname || '</td>' ||
                        '<td colspan=2 id=@celda' || fila || col2 || '@' || ' onclick=@registro( ' || fila || ', ' || col || ', ' || fila ||', %'|| horname ||'%)@ hora=@' || horname || '@>' || ' <strong><br><br>LIBRE<br><br><br></strong> ' || '</td>'
                WHEN col = 33 THEN 
                        '<td colspan=2 id=@celda' || fila || col2 || '@' || ' onclick=@registro( ' || fila || ', ' || col2 || ', ' || fila ||', %'|| horname || '%)@ hora=@' || horname || '@ >' || ' <strong><br><br>LIBRE<br><br><br></strong> ' || '</td>' ||
                    '</tr>'
                ELSE 
                    '<td colspan=2 id=@celda' || fila || col2 || '@' || ' onclick=@registro( ' || fila || ', ' || col2 || ', ' || fila ||', %'|| horname || '%)@ hora=@' || horname || '@ >' || ' <strong><br><br>LIBRE<br><br><br></strong> ' || '</td>' 
                END HTML 
			FROM (                 
                	SELECT ROW_NUMBER() OVER( PARTITION BY fila ORDER BY fila ) col2 , *                 
                	FROM (
						SELECT 
						t1.orden fila , 
						--ROW_NUMBER() OVER( PARTITION BY T2.id_horario ORDER BY T1.orden, t2.id_turno , T2.orden ) fila,
						ROW_NUMBER() OVER( PARTITION BY T1.id_box ORDER BY T1.orden , t2.id_turno , T2.orden ) col,
						ROW_NUMBER() OVER(ORDER BY T1.orden , t2.id_turno , t2.orden  ) item ,
						t1.nombre boxname , 
						t2.nombre horname
						FROM boxes T1, 
							( 
								SELECT orden , nombre , id_turno , estado , id_horario 
								FROM horarios t1 
								WHERE orden NOT IN ( 1 , 10 ,11, 19)
								AND t1.estado = 1  
								UNION ALL 
								SELECT orden , nombre , id_turno , estado , id_horario 
								FROM horarios t2 
								WHERE t2.estado = 1 
								ORDER BY orden 
							) T2
								where t1.estado = 1 and t2.estado = 1 and t2.id_turno in ( select id_turno from turnos where estado = 1 and turnos.id_sucursal = $sucursal )
								and t1.id_sucursal = $sucursal 
						ORDER BY T1.orden , t2.id_turno , T2.orden
                     )tabla 
                     WHERE col % 2 <> 0 
                )tabla2 
        ";

        $exq = pg_query($con, str_replace('@', '"', $sql ) );
		if ( !$exq )
		{
			exit( "Error en la consulta SQL" );
		}
		$valor = array();
		while( $row = pg_fetch_array($exq) ){
			//$valor[] = str_replace('%', "'", $row['html'];
			$valor[] = $row;
		}
		echo json_encode( $valor ); //fco esta linea codifica para ser leido como json 	
		return ;
		
	break;
	case 'reagendar':
		$sucursal = $_POST["sucursal"]; 
		$sql = "
			select  replace(cast(fecha as varchar(100)),'-','-')fecha , nombre cliente, servicio ,id_ficha ficha , left(cast(hora as varchar(100)),5) turno, ( select nombre from boxes where orden = cupo and id_sucursal = $sucursal ) box , documento , celular , comentario , estado 
			from fichas 
			where id_sucursal = $sucursal 
			and cupo in ( select orden from boxes where estado = 1 and id_sucursal = $sucursal ) --control de boxes activos 
			and left( cast( hora as varchar(100)),5) in ( select t1.nombre from horarios t1 , turnos t2  where t1.id_turno = t2.id_turno and t1.estado = 1 and t2.estado = 1 )  --control de horario activos	
			and estado in( '1' , '2' , '3')  and fecha >= current_date - interval'1 month' and nombre not like '%*%' and lower(nombre) not like '%agendar%' ;
		";
		$exq = pg_query($con, $sql);
		if ( !$exq )
		{
			exit( "Error en la consulta SQL" );
		}
		$valor = array();
		while( $row = pg_fetch_array($exq) ){
			$valor[] = array_map('utf8_encode', $row);
		}
		echo json_encode( $valor ); //fco esta linea codifica para ser leido como json 	
		return ;
		
	break;
	case 'ConsultarCliente':
		if( isset($_POST['CodigoCliente']) ) {
		  $CodigoCliente = $_POST['CodigoCliente'];
		} else {
		  die("Solicitud no válida.");
		}

		//fco en esta consulta ulos campos deben ser iguales a las del form para que se pueda automatizar . 
		//fco sql server toma la '' como ' en la consulta a tener en cuenta cuando se quiere trabajar con las comillas por en php uso " para que no se solapen.. 
		//fco aqui ya armo el html para el retorno de la consulta de clientes para tener un codigo limpio en php y javascript

		$base = $_POST['base'];
			$consulta = 
			"
				select 
					case when hijo = 1 then 
						'<div class=%panel-heading%  data-toggle=%collapse% data-parent=%#accordion% href=%.' + customer + '% data-trigger=%focus% >' +
							'<span class=%glyphicon glyphicon-user%></span>&nbsp;' +customer+' - '+ custmrName +' - '+ isnull(telefono,'') +
						'</div>' +
						'<div class=%panel-collapse collapse list-group-item-'+ CASE when hijo % 2 = 0 then 'danger ' else 'info ' end + customer + '%>' +
							'<div class=%panel-body% id=%'+ itemCode +'% onclick=%AsignarCliente(@' + customer + '@,@' +custmrName+ '@,@' + isnull(telefono,'') + '@,@' + itemcode + '@,@'+ itemName +'@,@'+ color +'@,@'+ marca +'@,@'+ modelo +'@,@'+ mail +'@)% > ' +
								'<i class=%fa fa-car% aria-hidden=%true%></i>&nbsp;&nbsp;' + itemCode + ' - ' + itemName + 
							'</div>' +
						'</div>'	
					else 
						'<div class=% panel-collapse collapse list-group-item-'+ CASE when hijo % 2 = 0 then 'danger ' else 'info ' end + customer + '%>' +
							'<div class=%panel-body% id=%'+ itemCode +'% onclick=%AsignarCliente(@' + customer + '@,@' +custmrName+ '@,@' + isnull(telefono,'') + '@,@' + itemcode + '@,@'+ itemName +'@,@'+ color +'@,@'+ marca +'@,@'+ modelo +'@,@'+ mail +'@)%> ' +
								'<i class=%fa fa-car% aria-hidden=%true%></i>&nbsp;&nbsp;' + itemCode + ' - ' + itemName + 
							'</div>' +
						'</div>'	
					end html 
				from ( 

					select *,1 hijo 
					from (
						select 
						cli_codigo customer
						, cli_nombres as custmrName 
						,'' as itemCode
						,'' as itemName
						,cli_telefono telefono
						,cli_mail mail 
						,'' marca  
						,'' modelo 
						,'' color  
						,'' chassis  
					from  clientes 
					where cli_nombres like '%$CodigoCliente%'
					limit 20
					)Tabla1 
				order by customer , hijo 
			";

			$exq = pg_query($con2, $consulta);
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
	break;
	case 'historial':
		if( isset($_POST['chassis']) ) {
		  $chassis = $_POST['chassis'];
		} else {
		  die("Solicitud no válida.");
		}
		//fco en esta consulta ulos campos deben ser iguales a las del form para que se pueda automatizar . 
		//fco sql server toma la '' como ' en la consulta a tener en cuenta cuando se quiere trabajar con las comillas por en php uso " para que no se solapen.. 
		//fco aqui ya armo el html para el retorno de la consulta de clientes para tener un codigo limpio en php y javascript
		$consulta = 
				"
					select callid orden
						, CONVERT( VARCHAR(100) , createDate, 112) fecha
						, ISNULL(subject,'') servicio 
						, ISNULL(resolution,'') trabajo
						, isnull( u_kmEntrada, 0) kmEntrada
						, CASE STATUS  WHEN -3 THEN 'ABIERTO' WHEN 2 THEN 'IMPRESO' WHEN 3 THEN 'DISTRIBUIDO' WHEN 5 THEN 'CONCLUIDO' WHEN 1 THEN 'CANCELADO' WHEN -1 THEN 'CERRADO' ELSE 'OTROS' END estado
					from OSCL WITH(NOLOCK) Where	right( itemcode, 17) = '$chassis'
					order by createDate DESC 
				";
		$rs = odbc_exec( $conSap, $consulta );
		if ( !$rs )
		{
			exit( "Error en la consulta SQL" );
		}
		//fco resultado de varios registros en json 
		while ( $row = odbc_fetch_array($rs) )
		{
			$valor[] =  $row;	//array_map('utf8_encode', $row);
		}	
		echo json_encode( $valor ); //fco esta linea codifica para ser leido como json 
		return ;
	break;
	case 'estadoCasilla':
		if( isset($_POST['fila']) || isset($_POST['columna']) ) {
		  $fila    = $_POST['fila'];
		  $columna = $_POST['columna'];
		  $usuario = $_POST['usuario'];
		  $fecha   = $_POST['fecha'];
		} else {
		  die("Solicitud no válida.");
		}
		$sql = 
				"
					SELECT count(*) existe 
					FROM fichas_abiertas 
					WHERE cupo    = $fila 
						and columna = $columna
						and fecha = '$fecha' 
						and eliminado = 0 ;
				";
		$exq = pg_query($con, $sql);
		if ( !$exq )
		{
			exit( "Error en la consulta SQL" );
		}
		$valor = array();
		while( $row = pg_fetch_array($exq) ){
			$valor[] = array_map('utf8_encode', $row);
		}
		echo json_encode( $valor ); //fco esta linea codifica para ser leido como json 	
		return ;
	break;
	case 'estadoCasilla2':
		if( isset($_POST['fecha']) ) {
		  $fecha   = $_POST['fecha'];
		} else {
		  die("Solicitud no válida.");
		}
		$sql = 
				"
					SELECT cupo fila , usuario , columna
					FROM fichas_abiertas 
					WHERE fecha = '$fecha' 
					and eliminado = 0 ;
				";
		$exq = pg_query($con, $sql);
		if ( !$exq )
		{
			exit( "Error en la consulta SQL" );
		}
		$valor = array();
		while( $row = pg_fetch_array($exq) ){
			$valor[] = array_map('utf8_encode', $row);
		}
		echo json_encode( $valor ); //fco esta linea codifica para ser leido como json 	
		return ;
	break;
	case 'estadoTaller':
		$dia   = $_POST['dia'];
		$sucursal   = $_POST['sucursal'];
		$fecha   = $_POST['fecha'];

		$sql = 
				"
				SELECT 
					( 
						SELECT RIGHT( BOX , 5 ) || ' - ' ||LEFT( BOX,  char_length(box) - 5)  FROM ( 
						SELECT replace ( replace( nombre , '<br> <span class=badge>', '' ), '<span>', '' ) BOX , row_number() over(ORDER BY orden ) fila FROM boxes WHERE ESTADO = 1 and id_sucursal = 6 ORDER BY orden 
						) tabla1 where tabla1.fila = cupo 
					) boxes ,

					LEFT( CAST( hora AS VARCHAR(100)), 5 ) || '-'|| left(cast(hora + ( coalesce( tiempo , 0 ) / 0.5 )	* INTERVAL '30 minute' as varchar(100)),5) || ' hs' horarios, 	
					nombre cliente , 
					vehiculo,
					vin chassis,
					servicio || ' ' || km || 'km' servicio ,
					CASE 
						WHEN estado = '1' THEN 'AGENDADO'
						WHEN estado = '2' THEN 'ATENDIDO'
						WHEN estado = '0' THEN 'CANCELADO'
						WHEN estado = '3' THEN 'CONFIRMADO'
					END ESTADO 	
				  , 0 nro_ot 
				  , id_ficha ficha 
				  , left( cast( fecha  as varchar(100)) , 10 ) fecha
				  , (select nombre from funcionarios t1 where CAST( t1.id_funcionario AS VARCHAR(100)) = fichas.id_funcionario ) callcenter
				  FROM fichas WHERE fecha = '$fecha'
				AND estado = '3' -- cancelado no entra
				and id_sucursal = $sucursal -- 6 mientras para tema central
				ORDER BY  hora , boxes 
			";
			//				  FROM fichas WHERE fecha = CURRENT_DATE  + $dia 


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
	break;

	case 'ficha':
		$ficha   = $_POST['ficha'];
		$sql = "select * From fichas where id_ficha = $ficha ";
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
		return;
		break;

	case 'estadoCallcenter':
		$dia   = $_POST['dia'];

		$sql = 
				"
				SELECT 
					( 
						SELECT RIGHT( BOX , 5 ) || ' - ' ||LEFT( BOX,  char_length(box) - 5)  FROM ( 
						SELECT replace ( replace( nombre , '<br> <span class=badge>', '' ), '<span>', '' ) BOX , row_number() over(ORDER BY orden ) fila FROM boxes WHERE ESTADO = 1 ORDER BY orden 
						) tabla1 where tabla1.fila = cupo 
					) boxes ,

					LEFT( CAST( hora AS VARCHAR(100)), 5 ) || '-'|| left(cast(hora + ( coalesce( tiempo , 0 ) / 0.5 )	* INTERVAL '30 minute' as varchar(100)),5) || ' hs' horarios, 	
					nombre cliente , 
					vehiculo,
					vin chassis,
					servicio || ' ' || km || 'km' servicio ,
					CASE 
						WHEN estado = '1' THEN 'AGENDADO'
						WHEN estado = '2' THEN 'ATENDIDO'
						WHEN estado = '0' THEN 'CANCELADO'
					END ESTADO 	
				  , id_ficha ficha 
				  , left( cast( fecha  as varchar(100)) , 10 ) fecha
				FROM fichas WHERE fecha = CURRENT_DATE  + $dia 
				AND estado <> '0' -- cancelado no entra
				ORDER BY  hora , boxes 
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
	break;
	case 'otTurno':
		$consulta = 
				"select ot , usuario , id_turno ficha , convert( varchar(100), fecha, 105 ) fecha  
					from control_tema.dbo.ot_tablet where convert( varchar(100), fecha, 105 ) = convert( varchar(100), getdate() , 105 ) 
				";
		$rs = odbc_exec( $conSap, $consulta );
		if ( !$rs )
		{
			exit( "Error en la consulta SQL" );
		}
		//fco resultado de varios registros en json 
		while ( $row = odbc_fetch_array($rs) )
		{
			$valor[] = $row;
		}	
		echo json_encode( $valor ); //fco esta linea codifica para ser leido como json 
		return ;
	break;
	case 'autenticar2':

		$usuario 	= $_POST['usuario'];
		$contrasena = $_POST['contrasena'];
 		
		$consulta = "select * from funcionarios where usuario = '$usuario' and contrasena = '$contrasena'";	

		$rs = pg_query( $con, $consulta );
		if ( !$rs )
		{
			exit( "Error en la consulta SQL" );
		}
		//fco resultado de varios registros en json 
		while ( $row = pg_fetch_array($rs) )
		{
			$valor[] = $row;
		}	
		echo json_encode( $valor ); //fco esta linea codifica para ser leido como json 
		return ;
	break;
}

echo $retorna;

?>