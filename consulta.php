<?php

	//fco setear los parametros
	if( isset($_POST['fecha_i']) && isset($_POST['fecha_f']) && isset($_POST['sucu']) ) {
	  $fecha_i = $_POST['fecha_i'];
	  $fecha_f = $_POST['fecha_f'];
	  $sucu    = $_POST['sucu'];
	} else {
	  die("Solicitud no válida.");
	}
	
	// Microsoft SQL Server usando SQL Native Client 10.0 ODBC Driver - permite la conexión a SQL 7, 2000, 2005 y 2008
	$sever = "Garden";
	$database = "GardenKia";
	$user = "sa";
	$password = "1234567";

	//fco cadena de conexion mas adelante hacer de la forma correcta 
	$conexión = odbc_connect("Driver={SQL Server};Server=192.168.10.3;Database=GardenKia;", $user, $password);
	$consulta = "
		SELECT DISTINCT 
		SUCU.NAME SUCURSAL, 
		convert( varchar(100), OT.createDate ,111) FECHA, 
		DATEDIFF ( DAY, OT.createDate , ISNULL( OT.closeDate , GETDATE()) ) + 1 ANTIGUEDAD, 
		ISNULL( convert( varchar(100), OT.closeDate , 111 ),'') FECHA_CIERRE, 
		ISNULL( convert( varchar(100), VE.DOCDATE , 111 ),'') FECHA_FACT, 
		ASESOR.U_NAME ASESOR, 
		OT.CALLID CALLID, 
		OT.subject as MOTIVO,
		OT.custmrName as CLIENTE,
		CASE WHEN LEN(OT.ITEMCODE) < 10 THEN OT.internalSN ELSE OT.itemCode END VEHICULO, 
		ISNULL( ARTI.ItemName +' - '+ ISNULL(COLO.Name,'') +' - '+ ISNULL( ARTI.BuyUnitMsr , OT.STREET),'')  DESCRIPCION, 
		ISNULL( OT.Room,'') IDENTIFICADOR, 
		UPPER( case OT.U_Tipo 
				  when 1 then '1 - Cargo Cliente' 
				  when 2 then '2 - Pre - Entrega' 
				  when 3 then '3 - Garantia' 
				  when 4 then '4 - Rep. Usado vta' 
				  when 5 then '5 - Promoción' 
				  when 6 then '6 - Uso Taller/Garden' 
				  when 7 then '7 - Service en Casa' 
				end ) AS TIPO_SERVICIO,
		TIPO_CALL.Name TIPO_LLAMADA,  
		OT.DOCNUM , 
		ISNULL( OT.U_NroOT,'') NRO_OT, 
		CASE WHEN OT.STATUS = -3 THEN 'ABIERTO' 
			WHEN OT.STATUS =  2 THEN 'IMPRESO' 
			WHEN OT.STATUS =  3 THEN 'DISTRIBUIDO' 
			WHEN OT.STATUS =  5 THEN 'CONCLUIDO' 
			WHEN OT.STATUS =  1 THEN 'CANCELADO' 
			WHEN OT.STATUS = -1 THEN 'CERRADO' END  ESTADO, 
		CASE WHEN VE.CardCode IS NULL THEN 'NO' ELSE 'SI' END FACTURADO, 
		ISNULL( VE.U_ConceptoFactura , '' ) CONCEPTO
		FROM OSCL OT WITH(NOLOCK) LEFT OUTER JOIN OINV VE ON OT.customer = VE.CardCode AND OT.DocNum = VE.U_NroInterno AND VE.U_LIIV = 1 
		LEFT OUTER JOIN OSCT TIPO_CALL WITH(NOLOCK) ON OT.callType = TIPO_CALL.callTypeID 
		, OUSR ASESOR WITH(NOLOCK) 
		,[@SUCURSALES] SUCU WITH(NOLOCK) 
		, OITM ARTI WITH(NOLOCK) LEFT OUTER JOIN  [@COLOR] COLO ON ARTI.U_Color  = COLO.Code 
		WHERE OT.ASSIGNEE = ASESOR.USERID 
		AND OT.U_SUCURSAL = SUCU.CODE 
		AND OT.itemCode   = ARTI.ItemCode 
		AND OT.U_SUCURSAL IN ( $sucu )
		AND OT.status NOT IN ( 6) 
		AND OT.CREATEDATE >=  CONVERT( VARCHAR(100), CAST( '$fecha_i'  AS DATE ), 112)
		AND OT.CREATEDATE <=  CONVERT( VARCHAR(100), CAST( '$fecha_f' AS DATE), 112) 
		ORDER BY 1 ,2 , CASE WHEN LEN(OT.ITEMCODE) < 10 THEN OT.internalSN ELSE OT.itemCode END ";
	//fco array para el json .... 
	$jsondata = array();
	$rs = odbc_exec( $conexión, $consulta );
	if ( !$rs )
	{
		exit( "Error en la consulta SQL" );
	}
	
	odbc_result_all($rs, 'id="input"');
	echo $rs ;	

/*	
	//fco recuperar los datos en formato json para ajax	
	while( $row = odbc_fetch_array($rs) ) 
	{ 
		//echo print_r( $row); 
		echo json_encode( $row );
		//echo '{"consulta": [' . json_encode( $row ) . '] }';
		//return $row;
	} 
*/	
	odbc_close ( $conexion )
?>
